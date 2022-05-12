<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\Models\TransactionDetail;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use Auth;

class TransactionDetailRepository extends Apprepository{
    protected $model, $transactionType;

    public function __construct(TransactionDetail $model, TransactionType $transactionType)
    {
        $this->model = $model;
        $this->transactionType = $transactionType;
    }

    protected function setDataPayload(Request $request)
    {
        $enabled = 0;
        if($request['enabled'] == true){
            $enabled = 1;
        }
        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'type_transaction_id' => isset($request['type_transaction_id']) ? $request->input('type_transaction_id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'description' 	=> isset($request['description']) ? $request->input('description') : null,
            'created_by' 	=> isset($request['created_by']) ? $request->input('created_by') : null,
            'updated_by' 	=> isset($request['updated_by']) ? $request->input('updated_by') : null,
            'enabled' 		=> $enabled,
        ];
    }

    public function paginate(Request $request)
    {
        $data = $this->model
                    ->when(request()->search, function($query) {
                        $query->where('name', 'like', '%'.request()->search.'%');
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($request->input('limit', 15))
                    ->appends(request()->query());
         
        return $data;
    }

    public function getTransactionType()
    {
        return $this->transactionType->where('enabled', '1')->orderBy('created_at','DESC')->get();
    }


}
