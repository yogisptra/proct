<?php

namespace App\Http\Controllers\Backoffice\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DigiBase\Controller\BaseController;
use App\Models\TransactionType;
use Spatie\Permission\Models\Permission;
use App\Repositories\TransactionTypeRepository;
use DB;

class TransactionTypeController extends BaseController
{

    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(TransactionTypeRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'data-transaksi-tipe-%')->get();
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
			$hasPermissions = Permission::where('name', 'LIKE', 'data-transaksi-tipe-%')->get();
			$data = $this->repository->paginate($request);

			return $this->makeView('backoffice.masterdata.transaction_types.index', compact('data', 'hasPermissions'));
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
		return $this->makeView('backoffice.masterdata.transaction_types.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->validator($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

            $request['id'] = str_replace(" ", "_", strtoupper($request->input('name')));
            $data = $this->repository->store($request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('transaction_types.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('transaction_types.index')->with('success', 'Data berhasil ditambahkan');
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
        //
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
                return redirect()->route('transaction_types.index')->with('error', 'Terjadi kesalahan coba ulangi lagi');
            }

            return $this->makeView('backoffice.masterdata.transaction_types.form', compact('data'));
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
    public function update(Request $request, $id)
    {
        try {
			$request['id'] = $id;

			$data = $this->repository->update($id, $request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('transaction_types.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('transaction_types.index')->with('success', 'Data berhasil diubah');
        } catch (\Exception $exc) {
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
			$activeNonActive = $this->repository->activeNonActive($id, $status);
            if (!$activeNonActive) {
                return redirect()->route('transaction_types.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

			return redirect()->route('transaction_types.index')->with('success', 'Data Berhasil diubah');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}

    private function validator(Request $request)
	{
		return Validator::make($request->all(), [
            'name' => 'required',
        ],[
            'name.required' => ':attribute Wajib Diisi',
        ],[
            'name' => 'Nama',
        ]);
	}
}
