<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\AutoNumber;
use App\Models\Transaction;
use App\Models\ConfirmationManual;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Hash, Auth, DB, Cache;

class TransactionRepository extends Apprepository{
    use AutoNumber;

    protected $model, $confirmation;

    public function __construct(Transaction $model, ConfirmationManual $confirmation)
    {
        $this->model = $model;
        $this->confirmation = $confirmation;
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
            'campaign_id'           => isset($request['campaign_id']) ? $request->input('campaign_id') : null,
            'type_transaction_id'   => isset($request['type_transaction_id']) ? $request->input('type_transaction_id') : null,
            'donation_type'         => isset($request['donation_type']) ? $request->input('donation_type') : null,
            'donatur_id' 	        => isset($request['donatur_id']) ? $request->input('donatur_id') : null,
            'bank_account_id' 	    => isset($request['bank_account_id']) ? $request->input('bank_account_id') : null,
            'fundraiser_id' 	    => isset($request['fundraiser_id']) ? $request->input('fundraiser_id') : null,
            'transaction_number'    => isset($request['transaction_number']) ? $request->input('transaction_number') : null,
            'transaction_date' 	    => Carbon::now()->format('Y-m-d H:i:s'),
            'payment_date' 	        => isset($request['payment_date']) ? $request->input('payment_date') : null,
            'transaction_status_id' => 'UNVERIFIED',
            'unique_code' 	        => isset($request['unique_code']) ? $request->input('unique_code') : null,
            'amount' 	            => isset($request['amount']) ? str_replace('.', '', str_replace('Rp ', '', $request->input('amount'))) : null,
            'payment_method' 	    => isset($request['payment_method']) ? $request->input('payment_method') : null,
            // 'image' 	            => $image,
            'note' 	                => isset($request['note']) ? $request->input('note') : null,
            'name'                  => isset($request['name']) ? $request->input('name') : null,
            'email'                 => isset($request['email']) ? $request->input('email') : null,
            'phone_number'          => isset($request['phone_number']) ? $request->input('phone_number') : null,
            'referral'              => isset($request['referral']) ? $request->input('referral') : null,
            'transaction_via'       => 'ONLINE',
            'is_hamba_allah' 	    => $is_hamba_allah,
            'is_delete'             => '0',
            'va_number' 	        => isset($request['va_number']) ? $request->input('va_number') : null,
            'bill_key' 	            => isset($request['bill_key']) ? $request->input('bill_key') : null,
            'biller_code' 	        => isset($request['biller_code']) ? $request->input('biller_code') : null,
            'payment_code' 	        => isset($request['payment_code']) ? $request->input('payment_code') : null,
            'qr_code' 	            => isset($request['qr_code']) ? $request->input('qr_code') : null,
            'link' 	                => isset($request['link']) ? $request->input('link') : null,
            'expired_date' 	        => isset($request['expired_date']) ? $request->input('expired_date') : null,
        ];
    }

    public function paginate(Request $request)
    {
        $is_delete = 0;
        
        if($request->is_delete == TRUE ){
            $is_delete = 1;
        } else {
            $is_delete = 0;
        }

        $data = $this->model->where('transaction_number', 'LIKE', '%' . request()->transaction_number . '%')
                            ->when(request()->amount, function($query) {
                                $query->where('amount', request()->amount);
                            })
                            ->when(request()->donation_type, function($query) {
                                $query->where('donation_type', request()->donation_type);
                            })
                            ->when(request()->unique_code, function($query) {
                                $query->where('unique_code', request()->unique_code);
                            })
                            ->when(request()->name, function($query) {
                                $query->where('name', 'LIKE', '%' . request()->name . '%');
                            })
                            ->when(request()->phone, function($query) {
                                $query->where('phone_number', 'LIKE', '%' . request()->phone . '%');
                            })
                            ->when(request()->email, function($query) {
                                $query->where('email', 'LIKE', '%' . request()->email . '%');
                            })
                            ->when(request()->transaction_status_id, function($query) {
                                $query->where('transaction_status_id', request()->transaction_status_id);
                            })
                            ->when(request()->payment_date, function($query) {
                                $query->where('payment_date', request()->payment_date);
                            })
                            ->when(request()->is_delete, function($query) {
                                $query->where('is_delete', request()->is_delete);
                            })
                            ->when(request()->start_date && request()->end_date, function($query) {
                                $query->whereBetween('created_at', [request()->start_date, request()->end_date]);
                            })
                            ->where('is_delete', $is_delete)
                            ->orderBy('created_at', 'DESC')
                            ->paginate($request->input('limit', 10))
                            ->appends(request()->query());
         
        return $data;
    }

    public function approvalTransaction($id, $data){
        $approve = NULL;
        DB::beginTransaction();
        try {
            if ($data == 'VERIFIED') {
                $approve =  $this->model
                            ->where('id', $id)
                            ->update([ 'transaction_status_id' => $data,
                                        'payment_date' => Carbon::now()->format('Y-m-d H:i:s')]);
            }else{
                $approve =  $this->model
                            ->where('id', $id)
                            ->update([ 'transaction_status_id' => $data]);
            }

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $approve = $th;
        }
        return $approve;
    }

    public function updateApproval($id, $status)
    {
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->model
                         ->where('id', $id)
                         ->update([
                                'transaction_status_id' => $status,
                                'payment_date' => Carbon::now()->format('Y-m-d H:i:s'),
                            ]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }

    public function updateTransaction($request, $id)
    {
        $update = NULL;
        DB::beginTransaction();
        try {
            if(!empty($request->file('image'))){
                $image = time() . '.' .$request->file('image')->getClientOriginalExtension();
            }else if (isset($request['image'])){
                $image = $request['image'];
            }else {
                $image = null;
            }

            $update =  $this->model
                            ->where('transaction_number', $id)
                            ->update([
                                'amount' => str_replace('.', '', str_replace('Rp ', '', $request->input('amount'))),
                                'transaction_date' => Carbon::parse($request->input('transaction_date'))->format('Y-m-d H:i:s'),
                                'payment_date' => Carbon::parse($request->input('payment_date'))->format('Y-m-d H:i:s'),
                                'unique_code' 	        => $request->input('unique_code'),
                                'updated_by'    => Auth::guard('web')->user()->name
                            ]);     
            $updateImage =  $this->confirmation
                            ->where('transaction_number', $id)
                            ->update([
                                'image' => $image,
                            ]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $update = $th;
        }
        return $update;
    }

    public function getConfirmation($id)
    {
        $data = $this->confirmation
                        ->where('transaction_number', $id)
                        ->first();

        return $data;
    }

    public function getInvoice($id)
    {
        return $this->model->where('transaction_number', $id)->first();
    }

    public function getTransactionByStatus($status, $type)
    {
        $dataByStatus = $this->model
                            ->where('transaction_status_id', $status)
                            ->where('is_delete', 0);

        $dataAll = $this->model
                    ->where('is_delete', 0);

        if ($status == "ALL") {
            $fetchResult = $dataAll;
        } else {
            $fetchResult = $dataByStatus;
        }

        if ($type == "sum") {
            $amount = $fetchResult->sum('amount');
            $unique_code = $fetchResult->sum('unique_code');
            $summary = $amount + $unique_code;
        } elseif ($type == "count") {
            $summary = $fetchResult->count('amount');
        } else {
            $summary = 0;
        }
        return $summary;
    }

    public function getTransactionTodayByStatus($status, $type)
    {
        $dataByStatus = $this->model
                            ->where('transaction_status_id', $status)
                            ->whereDate('transaction_date', Carbon::now())
                            ->where('is_delete', 0);

        $dataAll = $this->model
                    ->where('is_delete', 0);

        if ($status == "ALL") {
            $fetchResult = $dataAll;
        } else {
            $fetchResult = $dataByStatus;
        }

        if ($type == "sum") {
            $amount = $fetchResult->sum('amount');
            $unique_code = $fetchResult->sum('unique_code');
            $summary = $amount + $unique_code;
        } elseif ($type == "count") {
            $summary = $fetchResult->count('amount');
        } else {
            $summary = 0;
        }
        return $summary;
    }

    
    public function getDonatur($id){
        return $this->model
                    ->where('campaign_id', $id)
                    ->where('is_delete',0)
                    ->where('transaction_status_id', 'VERIFIED')
                    ->orderBy('payment_date', 'DESC')
                    ->paginate(10);
    }

    public function getTransactionByCampaign($id) 
    {
        $dataVerified = $this->model
                ->where('campaign_id', $id)
                ->where('is_delete', 0)
                ->where('transaction_status_id', 'VERIFIED')
                ->whereDate('transaction_date', Carbon::now())
                ->get();

        $dataUnverified = $this->model
                ->where('campaign_id', $id)
                ->where('is_delete', 0)
                ->where('transaction_status_id', 'UNVERIFIED')
                ->whereDate('transaction_date', Carbon::now())
                ->get();
        
        $date = Carbon::now();

        $amountVerified = $dataVerified->sum('amount');
        $unique_codeVerified = $dataVerified->sum('unique_code');
        $summaryVerified = $amountVerified + $unique_codeVerified;

        $amountUnverified = $dataUnverified->sum('amount');
        $unique_codeUnverified = $dataUnverified->sum('unique_code');
        $summaryUnverified = $amountUnverified + $unique_codeUnverified;

        $data = [
            'tanggal' => $date->format('d-m-Y'),
            'prospek' => $summaryUnverified,
            'total' => $summaryVerified,
        ];
        
        return $data;
    }

    public function summaryTransactionTypeIdWeekly($id, $status, $type)
    {
        $transaction = $this->model
                        ->where('campaign_id', $id)
                        ->where('transaction_status_id', $status)
                        ->where('type_transaction_id', $type)
                        ->where('is_delete', 0)
                        ->whereBetween('transaction_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->groupBy(DB::raw('DAY(transaction_date)'))
                        ->whereMonth('transaction_date', date('m'))
                        ->get([DB::raw('DAY(transaction_date) AS day'), DB::raw('sum(amount) AS sum_amount'),DB::raw('sum(amount) AS sum_amount'), DB::raw('sum(unique_code) as unique_code')]);

        $summary = array();

        foreach ($transaction as $row) {
            $summary[] = $row->sum_amount + $row->unique_code;
        }

        for ($i = 0; $i < 7; $i++) {
            if (!array_key_exists($i, $summary)) {
                
                $summary[$i] = 0;
            }
        }

        ksort($summary);
            foreach ($summary as $key => $val) {
            $summary[$key] = $val;
        }
        return $summary;
    }


    public function summaryTransactionTypeIdYearly($id, $status, $type)
    {
        $transaction = $this->model
                        ->where('campaign_id', $id)
                        ->where('transaction_status_id', $status)
                        ->where('type_transaction_id', $type)
                        ->where('is_delete', 0)
                        ->groupBy(DB::raw('MONTH(transaction_date)'))
                        ->whereYear('transaction_date', date('Y'))
                        ->get([DB::raw('MONTH(transaction_date) as month'), DB::raw('sum(amount) AS sum_amount'), DB::raw('sum(unique_code) as unique_code')]);

        $summary = array();

        foreach ($transaction as $row) {
            $summary[$row->month - 1] = $row->sum_amount + $row->unique_code;
        }

        for ($i = 0; $i < 12; $i++) {
            if (!array_key_exists($i, $summary)) {
                $summary[$i] = 0;
            }
        }

        ksort($summary);
            foreach ($summary as $key => $val) {
            $summary[$key] = $val;
        }

        return $summary;
    }

    public function getDataTransactionTypeIdYearly($id, $type)
    {
        $data = $this->model
                    ->where('campaign_id', $id)
                    ->where('type_transaction_id', $type)
                    ->where('is_delete', 0)
                    ->groupBy(DB::raw('MONTH(transaction_date)'))
                    ->whereYear('transaction_date', date('Y'))
                    ->orderBy('transaction_date', 'ASC')
                    ->get([
                        DB::raw("SUM(CASE WHEN transaction_status_id = 'VERIFIED' THEN amount ELSE 0 END) AS sum_amount_verified"),
                        DB::raw("SUM(CASE WHEN transaction_status_id = 'UNVERIFIED' THEN amount ELSE 0 END) AS sum_amount_unverified"),
                        DB::raw("SUM(CASE WHEN transaction_status_id = 'VERIFIED' THEN unique_code ELSE 0 END) AS sum_unique_code_verified"),
                        DB::raw("SUM(CASE WHEN transaction_status_id = 'UNVERIFIED' THEN unique_code ELSE 0 END) AS sum_unique_code_unverified"),
                        DB::raw('MONTHNAME(transaction_date) as month'), 
                        DB::raw('transaction_status_id as transaction_status_id'),
                    ]);
    
        $summary = array();

        foreach ($data as $row) {
            if(!empty($row->month)){
                $summary[$row->month]['bulan'] = $row->month;
                $summary[$row->month]['prospek'] = $row->sum_amount_unverified + $row->sum_unique_code_unverified;
                $summary[$row->month]['total'] = $row->sum_amount_verified + $row->sum_unique_code_verified;
                
            }
        }
        return $summary;
    }

    public function getDataTransactionTypeIdWeekly($id, $type)
    {
        $data = $this->model
                    ->where('campaign_id', $id)
                    ->where('type_transaction_id', $type)
                    ->where('is_delete', 0)
                    ->whereBetween('transaction_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->groupBy(DB::raw('DAY(transaction_date)'))
                    ->orderBy('transaction_date', 'ASC')
                    ->get([
                        DB::raw("SUM(CASE WHEN transaction_status_id = 'VERIFIED' THEN amount ELSE 0 END) AS sum_amount_verified"),
                        DB::raw("SUM(CASE WHEN transaction_status_id = 'UNVERIFIED' THEN amount ELSE 0 END) AS sum_amount_unverified"),
                        DB::raw("SUM(CASE WHEN transaction_status_id = 'VERIFIED' THEN unique_code ELSE 0 END) AS sum_unique_code_verified"),
                        DB::raw("SUM(CASE WHEN transaction_status_id = 'UNVERIFIED' THEN unique_code ELSE 0 END) AS sum_unique_code_unverified"),
                        DB::raw('DAYNAME(transaction_date) as day'), 
                        DB::raw('transaction_status_id as transaction_status_id'),
                    ]);
    
        $summary = array();

        foreach ($data as $row) {
            if(!empty($row->day)){
                $summary[$row->day]['day'] = $row->day;
                $summary[$row->day]['prospek'] = $row->sum_amount_unverified + $row->sum_unique_code_unverified;
                $summary[$row->day]['total'] = $row->sum_amount_verified + $row->sum_unique_code_verified;
                
            }
        }
        
        return $summary;
    }

    public function getDataTransactionTypeIdToday($id, $type)
    {
 
        $data = $this->model
                        ->where('campaign_id', $id)
                        ->where('type_transaction_id', $type)
                        ->where('is_delete', 0)
                        ->groupBy(DB::raw('DAY(transaction_date)'))
                        ->orderBy('transaction_date', 'ASC')
                        ->get([
                            DB::raw("SUM(CASE WHEN transaction_status_id = 'VERIFIED' THEN amount ELSE 0 END) AS sum_amount_verified"),
                            DB::raw("SUM(CASE WHEN transaction_status_id = 'UNVERIFIED' THEN amount ELSE 0 END) AS sum_amount_unverified"),
                            DB::raw("SUM(CASE WHEN transaction_status_id = 'VERIFIED' THEN unique_code ELSE 0 END) AS sum_unique_code_verified"),
                            DB::raw("SUM(CASE WHEN transaction_status_id = 'UNVERIFIED' THEN unique_code ELSE 0 END) AS sum_unique_code_unverified"),
                            DB::raw('DATE(transaction_date) as date'), 
                            DB::raw('transaction_status_id as transaction_status_id'),
                        ]);

        $summary = array();

        foreach ($data as $row) {
            if(!empty($row->date)){
                $summary[$row->date]['date'] = $row->date;
                $summary[$row->date]['prospek'] = $row->sum_amount_unverified + $row->sum_unique_code_unverified;
                $summary[$row->date]['total'] = $row->sum_amount_verified + $row->sum_unique_code_verified;
                
            }
        }

        return $summary;
    }

    public function summaryTransactionYearly($status)
    {
        $summary = NULL;
        DB::beginTransaction();
        try {
            $data = $transaction = $this->model
                            ->where('transaction_status_id', $status)
                            ->where('is_delete', 0)
                            ->groupBy(DB::raw('MONTH(transaction_date)'))
                            ->whereYear('transaction_date', date('Y'))
                            ->get([DB::raw('MONTH(transaction_date) as month'), DB::raw('sum(amount) AS sum_amount'), DB::raw('sum(unique_code) as unique_code')]);

            $summary = array();

            foreach ($transaction as $row) {
                $summary[$row->month - 1] = $row->sum_amount + $row->unique_code;
            }

            for ($i = 0; $i < 12; $i++) {
                if (!array_key_exists($i, $summary)) {
                    $summary[$i] = 0;
                }
            }

            ksort($summary);
                foreach ($summary as $key => $val) {
                $summary[$key] = $val;
            }

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $summary = $th;
        }
        return $summary;
    }


}
