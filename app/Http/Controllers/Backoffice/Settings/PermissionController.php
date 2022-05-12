<?php
namespace App\Http\Controllers\Backoffice\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\PermissionRequest;
use App\DigiBase\Controller\BaseController;
use Spatie\Permission\Models\Permission;
use App\Models\SysMenu;
use App\Repositories\PermissionRepository;
use DB;

class PermissionController extends BaseController
{
	protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(PermissionRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'permission-%')->get();
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
			$hasPermissions = Permission::where('name', 'LIKE', 'permission-%')->get();

			$permissions = $this->repository->paginate($request);
			return $this->makeView('backoffice.settings.permissions.index', compact('permissions', 'hasPermissions'));
		} catch (\Exception $exc) {
			return $exc;
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
			return $this->makeView('backoffice.settings.permissions.form');
		} catch (\Exception $exc) {
			return $exc;
		}
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(PermissionRequest $request)
	{
        try {
            $request['id'] = $this->GenerateAutoNumber('permissions');
			$data = $this->repository->store($request);

		 	if ($data->errorInfo != null) {
		 		return redirect()->route('permissions.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
		 	}
			return response()->json([
				'response' => $data,
				'success' => 'berhasil'

			]);
		 } catch (\Exception $exc) {
		 	return $exc;
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
            $data = $this->repository->show($id);

            if (!$data->exists) {
                return redirect()->route('permissions.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.permissions.form', compact('data'));
        } catch (\Exception $exc) {
            return $exc;
        }
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(PermissionRequest $request, $id)
	{
       	try {
			$request['id'] = $id;
			$data = $this->repository->show($id);

			if($data->exists){
				$menu = SysMenu::where('shown', $data->name)->first();

				$data = $this->repository->update($id, $request);
				if($menu != NULL){
					$menu->update([
							'shown' => $data->name
						]);
				}
			}

		 	if (!$data->exists) {
		 		return redirect()->route('permissions.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
		 	}

			return response()->json([
				'response' => $data,
				'success' => 'update'

			]);
        } catch (\Exception $exc) {
            return $exc;
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
       	try {
			$data = $this->repository->show($id);

			if($data->exists){
				$menu = SysMenu::where('shown', $data->name)->first();

				$delete = $this->repository->delete($id);
				if($menu != NULL){
					$menu->update([
							'shown' => 'without-authorize'
						]);
				}
			}

			return redirect()->route('permissions.index')->with('success', 'Permission Berhasil dihapus');
        } catch (\Exception $exc) {
            return $exc;
        }
	}
}
