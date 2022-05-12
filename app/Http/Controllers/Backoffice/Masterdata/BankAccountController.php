<?php

namespace App\Http\Controllers\Backoffice\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Spatie\Permission\Models\Permission;
use App\Repositories\BankAccountRepository;
use DB, File, Auth;

class BankAccountController extends BaseController
{

    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(BankAccountRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'data-bank_account-list%')
								->orWhere('name', 'LIKE', 'data-bank_account-create%')
								->orWhere('name', 'LIKE', 'data-bank_account-edit%')
								->orWhere('name', 'LIKE', 'data-bank_account-delete%')
								->get();
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
			$hasPermissions = Permission::where('name', 'LIKE', 'data-bank_account-%')->get();

			$data = $this->repository->paginate($request);

			return $this->makeView('backoffice.masterdata.bank_account.index', compact('data', 'hasPermissions'));
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
        $bank = $this->repository->getBank();

		return $this->makeView('backoffice.masterdata.bank_account.form', compact('bank'));
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

            $request['id'] = $this->GenerateAutoNumber('dns_bank_accounts');
            $request['created_by'] = Auth::guard('web')->user()->name;

			$data = $this->repository->store($request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('bank_accounts.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('bank_accounts.index')->with('success', 'Data berhasil ditambahkan');
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
        $id = $this->decodeHash($id);
        $data = $this->repository->show($id);
        $bank = $this->repository->getBank();

        if (!$data->exists) {
            return redirect()->route('bank_accounts.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
        }

        return $this->makeView('backoffice.masterdata.bank_account.form', compact('data', 'bank'));
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
            $request['updated_by'] = Auth::guard('web')->user()->name;

			$data = $this->repository->update($id, $request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('bank_accounts.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('bank_accounts.index')->with('success', 'Data berhasil ditambahkan');
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
            $id = $this->decodeHash($id);
			$activeNonActive = $this->repository->activeNonActive($id, $status);

            if (!$activeNonActive) {
                return redirect()->route('bank_accounts.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

			return redirect()->route('bank_accounts.index')->with('success', 'Data Berhasil diubah');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}

    private function validator(Request $request)
	{
        if($request->type == 'TF') {
            return Validator::make($request->all(), [
                'account_name' => 'required',
                'account_number' => 'required|regex:([0-9])|unique:dns_bank_accounts,account_number,'.$request->id,
                'bank_id' => 'required',
                'type'  => 'required',
            ],[
				'account_name.required' => ':attribute Wajib Diisi',
                'account_number.required' => ':attribute Wajib Diisi',
                'account_number.regex'	 	=> 'Format Penulisan :attribute Salah, [0-9]',
                'account_number.unique'		=> ':attribute Sudah Terdaftar',
                'bank_id' => ':attribute Wajib Diisi',
                'type' => ':attribute Wajib Diisi',
			],[
				'account_name' => 'Nama Akun',
                'account_number' => 'Nomor Akun',
                'bank_id'   => 'Bank',
                'type'   => 'Tipe'
			]);
        } else {
            return Validator::make($request->all(), [
                'account_name' => 'required',
                'bank_id' => 'required',
                'type'  => 'required',
            ],[
				'account_name.required' => ':attribute Wajib Diisi',
                'bank_id' => ':attribute Wajib Diisi',
                'type' => ':attribute Wajib Diisi',
			],[
				'account_name' => 'Nama Akun',
                'bank_id'   => 'Bank',
                'type'   => 'Tipe'
			]);
        }
		
	}
}
