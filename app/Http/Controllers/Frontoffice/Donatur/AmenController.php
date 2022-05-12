<?php

namespace App\Http\Controllers\Frontoffice\Donatur;

use App\Http\Controllers\Controller;
use App\DigiBase\Controller\BaseController;
use App\Models\Like;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\Validator;
use App\Repositories\DonaturRepository;
use App\Repositories\ConfirmationManualRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth, PDF;

class AmenController extends BaseController
{
    protected $repository, $confirmationRepository;

    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(TransactionRepository $repository, ConfirmationManualRepository $confirmationRepository)
	{
        $this->repository = $repository;
        $this->confirmationRepository = $confirmationRepository;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($transactionId, $value)
    {
        try {
            $checkLike = Like::where('transaction_id', $transactionId)->where('donatur_id', Auth::guard('member')->user()->id)->first();
            if($checkLike == null){
                if($value == 1){
                
                    $data = new Like();
                    $data->transaction_id = $transactionId;
                    $data->donatur_id = Auth::guard('member')->user()->id;
                    $data->save();
    
                    $transaction = $this->repository->show($transactionId);
                    $transactionLog = NotificationLog::where('object_id', $transaction->id)->where('type', 'AMEN')->where('to', Auth::guard('member')->user()->phone_number)->first();
    
                    if(empty($transactionLog)) {
                        $log = new NotificationLog();
                        $log->id = $this->GenerateAutoNumber('sys_notification_logs');
                        $log->object_id = $transaction->id;
                        $log->type = "AMEN";
                        $log->subject = "Aminkan Do'a";
                        $log->description = "Doa Anda pada program ".$transaction->hasCampaign->title." pada tanggal " . \Carbon\Carbon::parse($transaction->transaction_date)->isoFormat('DD MMMM YYYY'). " Di Aminkan oleh ".Auth::guard('member')->user()->name;
                        $log->to = Auth::guard('member')->user()->id;
                        $log->from = $transaction->phone_number;
                        $log->is_read = 0;
                        $log->save();
                    }
                 }else{
                    $data = Like::where('transaction_id', $transactionId)->where('donatur_id', Auth::guard('member')->user()->id)->delete();
                 }
            }else{
                $data = Like::where('transaction_id', $transactionId)->where('donatur_id', Auth::guard('member')->user()->id)->delete();
            }
             

            return response()->json('success');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
       
    }
}
