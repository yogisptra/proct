<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\Models\ConfirmationManual;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Auth, DB, Cache;

class ConfirmationManualRepository extends Apprepository{
    protected $model;

    public function __construct(ConfirmationManual $model)
    {
        $this->model = $model;
    }

    protected function setDataPayload(Request $request)
    {
        if(!empty($request->file('image'))){
			$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
		}else if (isset($request['image'])){
			$image = $request['image'];
		}else {
			$image = null;
        }

        return [
            'id' 			  => isset($request['id']) ? $request->input('id') : null,
            'transaction_number' => isset($request['transaction_number']) ? $request->input('transaction_number') : null,
            'amount' 	      => isset($request['amount']) ? str_replace('.', '', str_replace('Rp ', '', $request->input('amount'))) : null,
            'confirmation_date' => isset($request['confirmation_date']) ? $request->input('confirmation_date') : null,
            'image' 	      => $image,
            'bank_account_id' => isset($request['bank_account_id']) ? $request->input('bank_account_id') : null,
        ];
    }
}
