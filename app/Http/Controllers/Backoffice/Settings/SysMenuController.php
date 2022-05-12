<?php
namespace App\Http\Controllers\Backoffice\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\SysMenuRequest;
use App\DigiBase\Controller\BaseController;
use App\Models\SysMenu;
use App\Models\RoleHasPermission;
use App\Models\SysRole;
use App\Models\SysPermission;
use App\Repositories\SysMenuRepository;
use App\Repositories\PermissionRepository;
use DB, Auth;

class SysMenuController extends BaseController
{
	protected $repository, $permission_repo;

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(SysMenuRepository $repository, PermissionRepository $permission_repo)
	{
		$permissions = SysPermission::where('name', 'LIKE', 'menu-%')->get();
		for($i = 0; $i < count($permissions); $i++){
			if(strstr($permissions[$i]['name'], 'list')){
				$this->middleware('permission:'.$permissions[$i]['name'], ['only' => ['index','show']]);
			}elseif(strstr($permissions[$i]['name'], 'create')){
				$this->middleware('permission:'.$permissions[$i]['name'], ['only' => ['create','store']]);
			}elseif(strstr($permissions[$i]['name'], 'edit')){
				$this->middleware('permission:'.$permissions[$i]['name'], ['only' => ['edit','update']]);
			}elseif(strstr($permissions[$i]['name'], 'delete')){
				$this->middleware('permission:'.$permissions[$i]['name'], ['only' => ['destroy']]);
			}
		}

        $this->repository = $repository;
        $this->permission_repo = $permission_repo;
	}

	private function createPermission( Request $request){
		$name = [
				str_replace(" ", "-", strtolower($request['name']).'-list'),
				str_replace(" ", "-", strtolower($request['name']).'-create'),
				str_replace(" ", "-", strtolower($request['name']).'-edit'),
				str_replace(" ", "-", strtolower($request['name']).'-delete')
			];
		$permissions = SysPermission::where('name', 'LIKE', '%'.str_replace(" ", "-", strtolower($request['name'])).'%')->get();
		for($i = 0; $i < count($permissions); $i++){
			if (($key = array_search($permissions[$i]['name'], $name)) !== false) {
				unset($name[$key]);
			}
		}

		$newName = [];
		foreach ($name as $value) {
			$newName[] = $value;
		}

		$id = [];
		$input = [];
	    $newId = $this->GenerateAutoNumber('permissions');
		$newId = (int)$newId;
		for($i = 0; $i < count($newName); $i++){
			$id[$i] = $newId++;
			$input[$i] = array('id' => $id[$i], 'name' => $newName[$i], 'type' => $request['name'] );
		}
		for($i = 0; $i < count($input); $i++){
			SysPermission::create($input[$i]);
		}

		$role = SysRole::findOrFail('2020151101001');
		$permissions = SysPermission::where('name', 'LIKE', '%'.str_replace(" ", "-", strtolower($request['name'])).'%')->get();
		$inputPermissionRole = [];
		for($i = 0; $i < count($permissions); $i++){
			$inputPermissionRole[$i] = array('permission_id' => $permissions[$i]['id'], 'role_id' => $role['id'] );
		}

		for($i = 0; $i < count($inputPermissionRole); $i++){
			$permissionRole = RoleHasPermission::where('permission_id', $inputPermissionRole[$i]['permission_id'])->first();
			if($permissionRole == null){
				RoleHasPermission::create($inputPermissionRole[$i]);
			}elseif($inputPermissionRole[$i]['permission_id'] != $permissionRole['permission_id']){
				RoleHasPermission::create($inputPermissionRole[$i]);
			}
		}
	}

	private function deletePermission($id){
		$menu = $this->repository->show($id);
		$param = substr($menu->shown, 0, -5);
		$delete = SysPermission::where('name', 'LIKE', '%'.$param.'%')->delete();
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(Request $request)
	{
        try {
			$hasPermissions = SysPermission::where('name', 'LIKE', 'menu-%')->get();

			$menus = $this->repository->paginate($request);

			if (!empty($request)) {
				$menus = SysMenu::filter($request->only('search'))->paginate($request->input('limit', 15));
			}
			//dd($menus);
			return $this->makeView('backoffice.settings.menus.index', compact('menus', 'hasPermissions'));
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
			$menus = $this->repository->getAll();
			return $this->makeView('backoffice.settings.menus.create', compact('menus'));
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
	public function store(SysMenuRequest $request)
	{
         try {
            $request['id'] = $this->GenerateAutoNumber('sys_menus');

			$parent_menu = SysMenu::where('id', $request['parent_id'])->first();

			$data = $this->repository->store($request);

			if($data != null && $request['shown'] == 'with-authorize'){
				$this->createPermission($request);
			}

		 	if ($data->errorInfo != null || !$data->exists) {
		 		return redirect()->route('menus.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
		 	}
		 	return redirect()->route('menus.index')->with('success', 'Menu Berhasil ditambahkan');
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
			$menu = $this->repository->show($id);
			return $this->makeView('backoffice.settings.menus.show', compact('menu'));
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
			$menus = $this->repository->getAll();
            $menu = $this->repository->show($id);

			$permissions = SysPermission::where('name', $menu->shown)->get();

            if (!$menu->exists) {
                return redirect()->route('menus.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.menus.edit', compact('menu', 'permissions', 'menus'));
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
	public function update(SysMenuRequest $request, $id)
	{
       	try {
			// $id = $this->decodeHash($id);
			$request['id'] = $id;
			if($request['shown'] == 'without-authorize'){
				$this->deletePermission($id);
			}

			$data = $this->repository->update($id, $request);

			if($data->exists && $request['shown'] == 'with-authorize'){
				$this->createPermission($request);
			}


		 	if ($data->errorInfo != null || !$data->exists) {
		 		return redirect()->route('menus.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
		 	}

			return redirect()->route('menus.index')->with('success', 'Menu Berhasil diubah');
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

			if (!$activeNonActive) {
                return redirect()->route('menus.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

			return redirect()->route('menus.index')->with('success', 'Menu Berhasil diubah');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}
}