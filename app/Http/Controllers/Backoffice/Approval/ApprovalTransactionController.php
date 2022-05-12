<?php

namespace App\Http\Controllers\Backoffice\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use App\Repositories\TransactionRepository;
use App\Repositories\TemplateMessageRepository;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Jobs\SendMailSuccessTransactionJob;
use App\Jobs\SendMailCancelTransactionJob;
use Config;

class ApprovalTransactionController extends BaseController
{
    protected $repository, $templateMessage;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(TransactionRepository $repository, TemplateMessageRepository $templateMessage)
	{
		$permission = Permission::where('name', 'LIKE', 'approval-transaction-%')->get();
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
        $this->templateMessage = $templateMessage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
			$hasPermissions = Permission::where('name', 'LIKE', 'approval-transaction-%')->get();

            $data = $this->repository->paginate($request);
            
			return $this->makeView('backoffice.approval.transaction.index', compact('data', 'hasPermissions'));
		} catch (\Exception $exc) {
			return $this->goTo500Page($exc);
        }
    }

    public function update(Request $request, $id)
    {
        $transaction = $this->repository->getInvoice($id);
        $request['id'] = $transaction->id;

        if (!empty($request->file('image'))) {
            $data = $this->repository->getConfirmation($transaction->transaction_number);
            if (\File::exists(public_path('/assets/images/manualConfirmation/' . $data->image))) {
                \File::delete(public_path('/assets/images/manualConfirmation/' . $data->image));
            }
            $image = time() . '.' .$request->file('image')->getClientOriginalExtension();
            $destinationPath = public_path('/assets/images/manualConfirmation/');
            $request->file('image')->move($destinationPath, $image);
        }

        if(empty($request->file('image'))) {
            $data = $this->repository->getConfirmation($transaction->transaction_number);
            $request['image'] = $data->image;
        }
        $data = $this->repository->updateTransaction($request, $id);

        return redirect()->route('transaction-approval.show', [$request['id'] => $this->encodeHash($id)]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = $this->decodeHash($id);
            $data = $this->repository->show($id);
            $confirmation = $this->repository->getConfirmation($data->transaction_number);

            return $this->makeView('backoffice.approval.transaction.show', compact('data', 'confirmation'));
		} catch (\Exception $exc) {
			return $this->goTo500Page($exc);
        }
    }

    public function approvalProccess(Request $request)
	{
       	try {
            $id = $this->decodeHash($request->id);
            $data = $this->repository->show($id);
            $params = $request->input('transaction_status_id');
            $updateTransaction = $this->repository->approvalTransaction($id, $params);
            if (!$updateTransaction) {
                return redirect()->route('transaction-approval.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            if($params == 'VERIFIED') {
                // Email
                $dataMessage = $this->templateMessage->getDataById('SUKSES_TRANSACTION_EMAIL');
                $note = $dataMessage->message;
                $note = str_replace('[NAME]', $data->name, $note);
                $note = str_replace('[CAMPAIGN]', ($data->hasCampaign->title) ? : '-', $note);
                $note = str_replace('[DONASI]', $data->amount+$data->unique_code, $note);
                $note = str_replace('[DATE]', Carbon::parse($data->transaction_date)->format('d F Y'), $note);
                $note = str_replace('[INVOICE]', $data->transaction_number, $note);
                $this->sendMail($data, $note);

                // Whatsapp
                $dataMessageWa = $this->templateMessage->getDataById('SUKSES_TRANSACTION_WHATSAPP');
                $messageWa = $dataMessageWa->message;
                $messageWa = str_replace('[NAME]', $data->name, $messageWa);
                $messageWa = str_replace('[CAMPAIGN]', ($data->hasCampaign->title) ? : '-', $messageWa);
                $messageWa = str_replace('[DONASI]', $data->amount+$data->unique_code, $messageWa);
                $messageWa = str_replace('[DATE]', Carbon::parse($data->transaction_date)->format('d F Y'), $messageWa);
                $messageWa = str_replace('[INVOICE]', $data->transaction_number, $messageWa);
                $messageWa = str_replace('[PAYMENT]', $data->payment_method, $messageWa);
                $messageWa = str_replace('[BANK]', $data->hasBankAccount->hasBank->name ?? '-', $messageWa);
                $messageWa = str_replace('[ACCOUNT_REK]', $data->hasBankAccount->account_number, $messageWa);
                $messageWa = str_replace('[ACCOUNT_NAME]', $data->hasBankAccount->account_name, $messageWa);

                $phone = $data->phone_number;

                $message = ''.$messageWa.'';

                $this->sendWa($phone, $message);
            

            } else if ($params == 'CANCEL') {
                // Email
                $dataMessage = $this->templateMessage->getDataById('CANCEL_TRANSACTION_EMAIL');
                $note = $dataMessage->message;
                $note = str_replace('[NAME]', $data->name, $note);
                $note = str_replace('[CAMPAIGN]', ($data->hasCampaign->title) ? : '-', $note);
                $note = str_replace('[DONASI]', $data->amount+$data->unique_code, $note);
                $note = str_replace('[DATE]', Carbon::parse($data->transaction_date)->format('d F Y'), $note);
                $note = str_replace('[INVOICE]', $data->transaction_number, $note);
                $this->sendMailCancel($data, $note);

                // Whatsapp
                $dataMessageWa = $this->templateMessage->getDataById('SUKSES_TRANSACTION_WHATSAPP');
                $messageWa = $dataMessageWa->message;
                $messageWa = str_replace('[NAME]', $data->name, $messageWa);
                $messageWa = str_replace('[CAMPAIGN]', ($data->hasCampaign->title) ? : '-', $messageWa);
                $messageWa = str_replace('[DONASI]', $data->amount+$data->unique_code, $messageWa);
                $messageWa = str_replace('[DATE]', Carbon::parse($data->transaction_date)->format('d F Y'), $messageWa);
                $messageWa = str_replace('[INVOICE]', $data->transaction_number, $messageWa);
                $messageWa = str_replace('[PAYMENT]', $data->payment_method, $messageWa);
                $messageWa = str_replace('[BANK]', $data->hasBankAccount->hasBank->name ?? '-', $messageWa);
                $messageWa = str_replace('[ACCOUNT_REK]', $data->hasBankAccount->account_number, $messageWa);
                $messageWa = str_replace('[ACCOUNT_NAME]', $data->hasBankAccount->account_name, $messageWa);

                $phone = $data->phone_number;

                $message = ''.$messageWa.'';

                $this->sendWa($phone, $message);
            }
            
			return redirect()->route('transaction-approval.index');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function activeNonActive($id, $status)
	{
       	try {
            $id = $this->decodeHash($id);
			$activeNonActive = $this->repository->updateApproval($id, $status);

            if (!$activeNonActive) {
                return redirect()->route('transaction-approval.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
			
			return redirect()->route('transaction-approval.index')->with('success', 'Transaksi Berhasil diubah');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
	}


    protected function sendMail($data, $note)
    {
        try {
            SendMailSuccessTransactionJob::dispatch($data, $note)
                        ->delay(now()->addSeconds(5));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    protected function sendMailCancel($data, $note)
    {
        try {
            SendMailCancelTransactionJob::dispatch($data, $note)
                        ->delay(now()->addSeconds(5));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function sendWa($phone, $message)
    {
        $token = Config::get('app.tokenWA');
        $url = 'https://app.mesinwa.com/api/send-message.php';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT,30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'token'     => $token,
            'phone'     => $phone,
            'message'   => $message,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }

}
