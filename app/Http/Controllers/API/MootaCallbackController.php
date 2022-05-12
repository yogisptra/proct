<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use App\Models\BankAccount;
use App\Models\BankMutation;
use App\Models\Transaction;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Carbon;
use Auth, DB, Log;


class MootaCallbackController extends BaseController
{
    function __construct(CategoryRepository $categoryRepo)
	{
        $this->categoryRepo = $categoryRepo;
	}

    public function moota(Request $request)
    {
        try {
            // Handle data from moota callback
            $notifications = file_get_contents("php://input");
            $datas = json_decode($notifications, true);
            // apiToken
            // dd($datas);
            Log::info('start-callback-moota');

            Log::info($datas);

            $secret = '5Uf4Nkzm';

            // payload is the array passed to the `payload` method of the webhook
            // secret is the string given to the `signUsingSecret` method on the webhook.
            $signature = hash_hmac('sha256', $notifications, $secret);
            foreach($datas as $data){
                if($data) { 

                    $accountNumber	= $data['account_number'];
                    $description	= $data['description'];
                    $amount			= $data['amount'];
                    $type 			= $data['type'];
                    $balance 		= $data['balance'];
                    $mutationId 	= ($data['mutation_id'])??'-';
                    $date 			= $data['date'];
                    $bankType 		= ($data['bank']['bank_type']) ??'-';
                    $bankId 		= $data['bank_id'];
                    $now            = date('Y-m-d');

                    $checkBankAccount = BankAccount::where('account_number', $accountNumber)->first();
                    if($checkBankAccount) {
                        $bankAccountId = $checkBankAccount->id;
                    } else {
                        $bankAccountId = null;
                    }
                    // insert to log transaction (callback by Moota System) [sys_bank_mutations]
                    $check = BankMutation::where('mutation_id', $mutationId)->first();
                        
                    if($check == null) {
                        $data = new BankMutation();
                        $data->id = $this->GenerateAutoNumber('dns_histories');
                        $data->vendor = 'MOOTA';
                        $data->mutation_id = $mutationId;
                        $data->bank_id = $bankId;
                        $data->bank_type = $bankType;
                        $data->account_number = $accountNumber;
                        $data->type = $type;
                        $data->date = $date;
                        $data->description = $description . ' - ' . $mutationId . ' - ' . $bankType . ' - ' . $bankId; 
                        $data->amount = $amount;
                        $data->balance = $balance;
                        $data->save();

                        // Update invoice status to verified and detail [dns_transactions]
                        $transaction = Transaction::where('transaction_status_id', '=', 'UNVERIFIED') 
                                                    ->where(DB::raw('amount+unique_code'), $amount) 
                                                    ->where('payment_method', 'BANKTRANSFER')
                                                    ->orderBy('transaction_date', 'DESC')
                                                    ->first();

                        if($transaction != null) { 
                            $transaction->transaction_status_id = "VERIFIED";
                            $transaction->payment_date = Carbon::now()->format('Y-m-d H:i:s');
                            $transaction->updated_by = "system";
                            $transaction->save();
                        }
                    }
                    Log::info('finish-callback-moota');
                } else {
                    Log::info('transaction-not-processed-callback-moota');
                    return response()->json(['status' => '000', 'message' => 'Transaction Not Processed [PD]']);
                }
            }
            return response()->json(['status' => '200', 'message' => 'Transaction Success [PD]']);


        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    // SUCCESS
    public function sendEmailSuccess($member)
    {
        return new \App\Mail\SuccessTransaction($member);
    }

}
