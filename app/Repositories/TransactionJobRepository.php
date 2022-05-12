<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\Models\Donatur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionLog;
use App\Models\CQCall;
use App\Models\ReminderMail;
use App\Models\ProgramList;
use Illuminate\Support\Carbon;
use App\Mail\ReminderDonasiMonthlyMail;
use App\Models\CampaignList;
use App\Models\NotificationLog;
use Auth;

class TransactionJobRepository extends Apprepository{
    // private $_apiBca;
    protected $reminderMail, $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
        
        // $this->_apiBca = new BcaClass();
        
    }

     /*
    |--------------------------------------------------------------------------
    | REMINDER TRANSACTION
    |--------------------------------------------------------------------------
    |
    | cron untuk reminder transaksi campaign dan donation
    | cek transaksi
    |
    */
    public function reminderTransaction(){
        try{
            $checkTransaction = DB::select(DB::raw("SELECT
                                                *
                                            FROM
                                                dns_transactions
                                            WHERE
                                                date(
                                                    date_add(transaction_date, INTERVAL + 1 DAY)
                                                ) = date(now())
                                            AND transaction_status_id = 'UNVERIFIED'"));
            // dd($checkTransaction);
            foreach ($checkTransaction as $data)
            {
                $this->reminderProccess($data->id,$data);
            }

        } catch(\Throwable $exc) {
            return($exc);
            throw $exc;
        }
    }

    public function reminderProccess($transactionId, $data)
    {
        try{
            DB::beginTransaction();
            $campaign = CampaignList::where('id', $data->campaign_id)->first();
            $transactionLog = NotificationLog::where('object_id', $transactionId)->where('type', 'REMINDER_TRANSACTION')->first();

            if(empty($transactionLog)){
                $log = new NotificationLog;
                $log->id = $this->GenerateAutoNumber('sys_notification_logs');
                $log->object_id = $transactionId;
                $log->type = "REMINDER_TRANSACTION";
                $log->subject = "Reminder Komitmen Transaksi Program";
                $log->description = "Jangan lupa lakukan komitmen Anda pada program ".$campaign->title." pada tanggal " . \Carbon\Carbon::parse($data->transaction_date)->isoFormat('DD MMMM YYYY');
                $log->to = "System Donasico";
                $log->from = $data->phone_number;
                $log->is_read = 0;
                $log->save();

                $donatur = Transaction::where('id', $transactionId)->first();
                // Send Notification SMS|EMAIL
                if($donatur->email != null){
                    Mail::to($donatur->email)->send($this->sendEmailReminder($donatur));
                }

                Log::info('Reminder to: '. $data->email);
            }

            DB::commit();

            return true;
        } catch(\Exception $exc) {
            // dd($exc);
            DB::rollBack();
            throw $exc;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBATALAN TRANSACTION
    |--------------------------------------------------------------------------
    |
    | cron untuk pembatalan transaksi
    | cek transaksi dan log transaksi
    |
    */
    public function cancel(){
        $cancelTransaction = DB::select(DB::raw("SELECT
                                                *
                                            FROM
                                                dns_transactions
                                            WHERE
                                            date(
                                                date_add(transaction_date, INTERVAL + 2 DAY)
                                            ) = date(now())
                                            AND transaction_status_id = 'UNVERIFIED'"));
        foreach ($cancelTransaction as $data){
			$this->cancelTransaction($data->transaction_number, $data);
		}

    }

    public function cancelTransaction($transactionNumber, $data){
        try{
            // dd('masuk');
             DB::beginTransaction();
            $rawData  = array(
                'transaction_status_id' => 'CANCEL',
                'updated_at'         => date('Y-m-d H:i:s'),
                'updated_by'         => 'cron',
            );

            $affected = Transaction::where('transaction_number',$transactionNumber)->update($rawData);

            // Send Notif EMAIL|SMS
            $donatur = Transaction::where('transaction_number', $transactionNumber)->first();
            $this->cancelLog($donatur);

            // Send Notification SMS|EMAIL
            Mail::to($data->email)->send($this->sendEmailCancel($donatur));
            Log::info('Cancel Transaction: '. $transactionNumber);

            DB::commit();

            return true;
        } catch(\Throwable $exc) {
            DB::rollBack();
            dd($exc);
            throw $exc;
        }
    }


    public function cancelLog($transaction){
        $transactionLog = NotificationLog::where('object_id', $transaction->id)->where('type', 'CANCEL_TRANSACTION')->first();

        if(empty($transactionLog)) {
            $log = new NotificationLog;
            $log->id = $this->GenerateAutoNumber('sys_notification_logs');
            $log->object_id = $transaction->id;
            $log->type = "CANCEL_TRANSACTION";
            $log->subject = "Pembatalan Komitmen Transaksi Program";
            $log->description = "Transaksi Anda pada program ".$transaction->hasCampaign->title." pada tanggal " . \Carbon\Carbon::parse($transaction->transaction_date)->isoFormat('DD MMMM YYYY'). " Telah dibatalkan oleh system";
            $log->to = "System Donasico";
            $log->from = $transaction->phone_number;
            $log->is_read = 0;
            $log->save();
        }
    }

    // Generate Auto Number
    public function GenerateAutoNumber($tableName){
        $total_data_today = DB::table($tableName)->whereDate('created_at', date('Y-m-d'))->count();
        return date('Ymd').str_pad($total_data_today + 1, 3, "0", STR_PAD_LEFT);
    }

    // CANCEL
    public function sendEmailCancel($donatur) {
        return new \App\Mail\CancelTransaction($donatur);
    }

    // REMINDER
    public function sendEmailReminder($donatur){
        return new \App\Mail\ReminderTransactionMail($donatur);
    }
}