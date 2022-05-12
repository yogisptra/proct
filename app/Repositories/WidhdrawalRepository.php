<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\AutoNumber;
use App\Models\Widhdrawal;
use App\Models\BankAccountCampaigner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Hash, Auth, DB, Cache;

class WidhdrawalRepository extends Apprepository{
    use AutoNumber;

    protected $model, $bankAccount;

    public function __construct(Widhdrawal $model, BankAccountCampaigner $bankAccount)
    {
        $this->model = $model;
        $this->bankAccount = $bankAccount;
    }

    protected function setDataPayload(Request $request)
    {
        $is_hamba_allah = 0;
        
        if($request->is_hamba_allah == 1 ){
            $is_hamba_allah = 1;
        } else {
            $is_hamba_allah = 0;
        }

        return [
            'id' 			        => isset($request['id']) ? $request->input('id') : null,
            'user_id'               => isset($request['user_id']) ? $request->input('user_id') : null,
            'campaign_id'           => isset($request['campaign_id']) ? $request->input('campaign_id') : null,
            'bank_account_id'       => isset($request['bank_account_id']) ? $request->input('bank_account_id') : null,
            'request_date'          => isset($request['request_date']) ? $request->input('request_date') : null,
            'amount' 	            => isset($request['amount']) ? str_replace('.', '', str_replace('Rp ', '', $request->input('amount'))) : null,
            'total_amount' 	        => isset($request['total_amount']) ? str_replace('.', '', str_replace('Rp ', '', $request->input('total_amount'))) : null,
            'percentage'            => isset($request['percentage']) ? $request->input('percentage') : null,
            'description'           => isset($request['description']) ? $request->input('description') : null,
            'approval_date'         => isset($request['approval_date']) ? $request->input('approval_date') : null,
            'status'                => isset($request['status']) ? $request->input('status') : null,
          
        ];
    }

    public function paginate(Request $request)
    {
        $data = $this->model->orderBy('created_at', 'DESC')
                            ->paginate($request->input('limit', 10))
                            ->appends(request()->query());
         
        return $data;
    }

    public function approvalWidhdrawal($id, $data){
        $approve = NULL;
        DB::beginTransaction();
        try {
            if ($data == 'VERIFIED') {
                $approve =  $this->model
                            ->where('id', $id)
                            ->update([ 'status' => $data,
                                        'approval_date' => Carbon::now()->format('Y-m-d H:i:s')]);
            }else{
                $approve =  $this->model
                            ->where('id', $id)
                            ->update([ 'status' => $data]);
            }

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $approve = $th;
        }
        return $approve;
    }

    public function getBankCampaigner()
    {
        return $this->bankAccount::where('user_id', Auth::guard('member')->user()->id)->get();
    }

    public function getDataByCampaign($id)
    {
        return $this->model->where('campaign_id', $id)->get();
    }
}
