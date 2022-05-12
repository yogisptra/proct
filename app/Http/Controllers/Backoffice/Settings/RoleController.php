<?php
namespace App\Http\Controllers\Backoffice\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\DigiBase\Controller\BaseController;
use App\Models\SysRole;
use App\Models\SysPermission;
use Spatie\Permission\Models\Permission;
use App\Repositories\RoleRepository;
use DB;

class RoleController extends BaseController
{
	protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(RoleRepository $repository)
	{
		$permission = SysPermission::where('name', 'LIKE', 'role-%')->get();
		//dd($permission);
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
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
        try {
			$hasPermissions = SysPermission::where('name', 'LIKE', 'role-%')->get();
			$roles = $this->repository->paginate($request);

			return $this->makeView('backoffice.settings.roles.index', compact('roles', 'hasPermissions'));
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
			$typePermissions = SysPermission::orderBy('type', 'ASC')->groupBy('type')->get();
			$lists = SysPermission::where('name', 'like', '%list%')->orderBy('type', 'ASC')->get();
			$creates = SysPermission::where('name', 'like', '%create%')->orderBy('type', 'ASC')->get();
			$updates = SysPermission::where('name', 'like', '%edit%')->orderBy('type', 'ASC')->get();
			$deletes = SysPermission::where('name', 'like', '%delete%')->orderBy('type', 'ASC')->get();

			return $this->makeView('backoffice.settings.roles.create', compact('typePermissions', 'lists', 'creates', 'updates', 'deletes'));
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
	public function store(RoleRequest $request)
	{
         try {
			$role = $this->repository->store($request);
			$role->syncPermissions($request->input('permission'));

		 	if ($role->errorInfo != null || !$role->existsl) {
		 		return redirect()->route('roles.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
		 	}
		 	return redirect()->route('roles.index')->with('success', 'Role Berhasil ditambahkan');
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
			$role = $this->repository->show($id);
			$rolePermissions = SysPermission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
											->where("role_has_permissions.role_id",$id)
											->get();

			return $this->makeView('backoffice.settings.roles.show', compact('role', 'rolePermissions'));
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
			$role = $this->repository->show($id);

			$typePermissions = SysPermission::orderBy('type', 'ASC')->groupBy('type')->get();
			$lists = SysPermission::where('name', 'like', '%list%')->orderBy('type', 'ASC')->get();
			$creates = SysPermission::where('name', 'like', '%create%')->orderBy('type', 'ASC')->get();
			$updates = SysPermission::where('name', 'like', '%edit%')->orderBy('type', 'ASC')->get();
			$deletes = SysPermission::where('name', 'like', '%delete%')->orderBy('type', 'ASC')->get();

			$rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
				->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
				->all();
			//dd($rolePermissions);
            if (!$role->exists) {
                return redirect()->route('roles.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.roles.edit', compact('role', 'typePermissions', 'lists', 'creates', 'updates', 'deletes', 'rolePermissions'));
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
	public function update(RoleRequest $request, $id)
	{
       	try {
			$request['id'] = $id;
			$role = $this->repository->update($id, $request);
			$role->syncPermissions($request->input('permission'));
			
		 	if ($role->errorInfo != null || !$role->exists) {
		 		return redirect()->route('roles.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
		 	}

			return redirect()->route('roles.index')->with('success', 'Role Berhasil diubah');
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
       	// try {
		// 	$id = $this->decodeHash($id);
		// 	$delete = $this->repository->delete($id);

		// 	return redirect()->route('roles.index')->with('success', 'Role Berhasil dihapus');
        // } catch (\Exception $exc) {
        //      return $this->goTo500Page($exc);
        // }
	}

	public function activeNonActive($id, $status)
	{
       	try {
            $id = $this->decodeHash($id);
            $activeNonActive = $this->repository->activeNonActive($id, $status);
			//dd($activeNonActive);
			if (!$activeNonActive) {
                return redirect()->route('roles.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

			return redirect()->route('roles.index')->with('success', 'Role Berhasil diubah');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
    }
}
