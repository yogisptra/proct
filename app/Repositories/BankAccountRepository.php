<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\GenerateNumber;
use App\Models\BankAccount;
use App\Models\BankAccountCampaigner;
use App\Models\Bank;
use Illuminate\Http\Request;
use Auth, DB, Cache;

class BankAccountRepository extends Apprepository{
    protected $model, $bank, $bankAccountCampaigner;

    public function __construct(BankAccount $model, Bank $bank, BankAccountCampaigner $bankAccountCampaigner)
    {
        $this->model = $model;
        $this->bank = $bank;
        $this->bankAccountCampaigner = $bankAccountCampaigner;
    }

    protected function setDataPayload(Request $request)
    {
        $enabled = 0;
        if($request['enabled'] == true){
            $enabled = 1;
        }

        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'bank_id'       => isset($request['bank_id']) ? $request->input('bank_id') : null,
            'type'          => isset($request['type']) ? $request->input('type') : null,
            'account_name' 	=> isset($request['account_name']) ? $request->input('account_name') : null,
            'account_number'=> isset($request['account_number']) ? $request->input('account_number') : null,
            'created_by'    => isset($request['created_by']) ? $request->input('created_by') : null,
            'updated_by'    => isset($request['updated_by']) ? $request->input('updated_by') : null,
            'enabled' 	    => $enabled,
        ];
    }

    // Payload for multiplePost with Relation
    // protected function setDataPayloadMultiple(Request $request)
    // {
    //  $enabled = 0;
    //  if($request['enabled'] == true){
    //      $enabled = 1;
    //  }

    //  return [
    //        'id' 			=> isset($request['id']) ? $request->input('id') : null,
    //        'name' 			=> isset($request['name']) ? $request->input('name') : null,
    //        'description'   => isset($request['description']) ? $request->input('description') : null,
    //        'created_by'    => isset($request['created_by']) ? $request->input('created_by') : null,
    //       'updated_by'    => isset($request['updated_by']) ? $request->input('updated_by') : null,
    //        'enabled' 	    => $enabled,
    //    ];
    // }

    public function paginate(Request $request)
    {
        $data = $this->model
                    ->when(request()->search, function($query) {
                        $query->where('account_name', 'like', '%'.request()->search.'%');
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($request->input('limit', 15))
                    ->appends(request()->query());
         
        return $data;
    }

    public function getBank()
    {
        return $this->bank->where('enabled', 1)->orderBy('created_at', 'DESC')->get();
    }

    public function storeBankCampaigner(Request $request)
    {
        $data = NULL;
        DB::beginTransaction();
        try {

            $data = $this->bankAccountCampaigner->create([
                'id'             => isset($request['id']) ? $request->input('id') : null,
                'user_id'        => isset($request['user_id']) ? $request->input('user_id') : null,
                'bank_id'        => isset($request['bank_id']) ? $request->input('bank_id') : null,
                'account_name'   => isset($request['account_name']) ? $request->input('account_name') : null,
                'account_number' => isset($request['account_number']) ? $request->input('account_number') : null,
                'description'    => isset($request['description']) ? $request->input('description') : null,
            ]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
    }

    public function updateBankCampaigner($id, Request $request)
    {
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->showBankAccount($id);

            $data->update([
                'user_id'        => isset($request['user_id']) ? $request->input('user_id') : null,
                'bank_id'        => isset($request['bank_id']) ? $request->input('bank_id') : null,
                'account_name'   => isset($request['account_name']) ? $request->input('account_name') : null,
                'account_number' => isset($request['account_number']) ? $request->input('account_number') : null,
                'description'    => isset($request['description']) ? $request->input('description') : null,
            ]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
    }

    public function deleteBankCampaigner($id)
    {
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->bankAccountCampaigner->findOrFail($id);

            $data->destroy($id);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
    }

    public function getBankCampaigner()
    {
        return $this->bankAccountCampaigner->where('user_id', Auth::guard('member')->user()->id)->orderBy('created_at', 'DESC')->get();
    }

    public function showBankAccount($id)
    {
        return $this->bankAccountCampaigner->where('id', $id)->first();
    }


}
