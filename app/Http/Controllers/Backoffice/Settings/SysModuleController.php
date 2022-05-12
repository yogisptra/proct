<?php
namespace App\Http\Controllers\Backoffice\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\SysModuleRequest;
use App\DigiBase\Controller\BaseController;
use App\Models\SysModule;
use Spatie\Permission\Models\Permission;
use App\Repositories\SysModuleRepository;
use DB;

class SysModuleController extends BaseController
{
	protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(SysModuleRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'module-%')->get();
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
			$hasPermissions = Permission::where('name', 'LIKE', 'module-%')->get();

			$modules = $this->repository->paginate($request);
			return $this->makeView('backoffice.settings.modules.index', compact('modules', 'hasPermissions'));
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
			$data = $this->repository->getAll();
			$data = count($data);
			return $this->makeView('backoffice.settings.modules.form', compact('data'));
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
	public function store(SysModuleRequest $request)
	{
         try {
            $request['id'] = $this->GenerateAutoNumber('sys_modules');

			$data = $this->repository->store($request);
		 	if ($data->errorInfo != null) {
		 		return redirect()->route('modules.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
			 }

			return response()->json([
				'response' => $data,
				'success' => 'berhasil'
				
			]);
		 	// return redirect()->route('modules.index')->with('success', 'Module Berhasil ditambahkan');
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
        try {
			$data = $this->repository->show($id);
			return $this->makeView('backoffice.settings.modules.show', compact('data'));
		} catch (\Exception $exc) {
			return $exc;
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
            $data = $this->repository->show($id);
			$modules = $this->repository->getAll();
			$modules = count($modules);

            if (!$data->exists) {
                return redirect()->route('modules.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.modules.form', compact('data','modules'));
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
	public function update(SysModuleRequest $request, $id)
	{
       	try {
			$request['id'] = $id;
			$data = $this->repository->update($id, $request);

		 	if ($data->errorInfo != null) {
		 		return redirect()->route('modules.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
		 	}
			return response()->json([
				'response' => $data,
				'success' => 'berhasil'
				
			]);
			// return redirect()->route('modules.index')->with('success', 'Module Berhasil diubah');
        } catch (\Exception $exc) {
			//dd($exc);
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
			$delete = $this->repository->delete($id);

			return redirect()->route('modules.index')->with('success', 'Module Berhasil dihapus');
        } catch (\Exception $exc) {
            return $exc;
        }
	}
}