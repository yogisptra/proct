<?php
namespace App\Http\Controllers\Backoffice\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\SysUserRequest;
use App\DigiBase\Controller\BaseController;
use App\Models\User;
use App\Models\ModelHasRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\SysUserRepository;
use App\Repositories\PasswordRessetRepository;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Arr;

class SysUserController extends BaseController
{
	protected $repository;
	protected $tokenRepository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(SysUserRepository $repository, PasswordRessetRepository $tokenRepository)
	{
		$permission = Permission::where('name', 'LIKE', '%user-%')->get();
		// dd($permission);
		for($i = 0; $i < count($permission); $i++){
			if(strstr($permission[$i]['name'], 'list')){
				$this->middleware('permission:'.$permission[$i]['name'], ['only' => ['index','show']]);
			}elseif(strstr($permission[$i]['name'], 'create')){
				$this->middleware('permission:'.$permission[$i]['name'], ['only' => ['create','store']]);
			}elseif(strstr($permission[$i]['name'], 'edit')){
				$this->middleware('permission:'.$permission[$i]['name'], ['only' => ['edit','update']]);
			}elseif(strstr($permission[$i]['name'], 'delete')){
				$this->middleware('permission:'.$permission[$i]['name'], ['only' => ['destroy']]);
			}
		}

		$this->repository = $repository;
		$this->tokenRepository = $tokenRepository;
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
        try {
			$hasPermissions = Permission::where('name', 'LIKE', '%user-%')->get();
			$data = $this->repository->paginate($request);
			$roles = $this->repository->roleWithoutSuperAdmin();

			return $this->makeView('backoffice.settings.users.index', compact('data', 'roles', 'hasPermissions'));
		} catch (\Exception $exc) {
			 return $this->goTo500Page($exc);
        }
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
        try {
			$roles = $this->repository->getRole();
			return $this->makeView('backoffice.settings.users.create', compact('roles'));
		} catch (\Exception $exc) {
			 return $this->goTo500Page($exc);
		}

	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(SysUserRequest $request)
	{
        try {
            $request['id'] = $this->GenerateAutoNumber('users');
            $request['password'] = Str::random(10);
			$user = $this->repository->store($request);
			$user = $this->repository->show($request['id']);
			$user->assignRole($request->input('roles'));


		 	if ($user->errorInfo != null || !$user->exists) {
		 		return redirect()->route('users.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
			}
			// Mail::to($request->email)->send(new VerificationMail($user, $request->password));
			$storeToken = $this->tokenRepository->store($request);
			if(isset($storeToken)){
				$token = $this->tokenRepository->getByEmail($request->email);
				Mail::to($request->email)->send(new VerificationMail($token, $request->password));
			}
		 	return redirect()->route('users.index')->with('success', 'User Berhasil ditambahkan');
		 } catch (\Exception $exc) {
		 	 return $this->goTo500Page($exc);
		 }
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
        try {
			$id = $this->decodeHash($id);
			$user = $this->repository->show($id);
			return $this->makeView('backoffice.settings.users.show', compact('user'));
		} catch (\Exception $exc) {
			 return $this->goTo500Page($exc);
        }
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
       try {
			$id = $this->decodeHash($id);
            $user = $this->repository->show($id);
			$roles = $this->repository->getRole();
			$roleWithoutSuperAdmin = $this->repository->roleWithoutSuperAdmin();

			//$roles = Role::pluck('name','name')->all();
			//$userRole = $user->roles->pluck('name','name')->all();
			$userRole = ModelHasRole::where('model_id', $user->id)->first();
			//dd($roles);
			
            if (!$user->exists) {
                return redirect()->route('users.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.users.edit', compact('roles', 'roleWithoutSuperAdmin', 'user', 'userRole'));
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(SysUserRequest $request, $id)
	{
       	try {
			$user = $this->repository->show($id);
			$request['id'] = $id;
			$request['password'] = $user->password;
			$user = $this->repository->update($id, $request);


			DB::table('model_has_roles')->where('model_id',$id)->delete();
			$user->assignRole($request->input('roles'));

		 	if ($user->errorInfo != null || !$user->exists) {
		 		return redirect()->route('users.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
			}

			return redirect()->route('users.index')->with('success', 'Data berhasil diubah');
        } catch (\Exception $exc) {
			//dd($exc);
             return $this->goTo500Page($exc);
        }
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id)
	{
       //
	}

	public function activeNonActive($id, $status)
	{
       	try {
			$id = $this->decodeHash($id);
			$status = $this->decodeHash($status);
			$activeNonActive = $this->repository->activeNonActive($id, $status);
			//dd($activeNonActive);
			if (!$activeNonActive) {
                return redirect()->route('users.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

			return redirect()->route('users.index')->with('success', 'User Berhasil diubah');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}

	public function search(Request $request)
	{
		//
	}

}