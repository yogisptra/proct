<?php

namespace App\Http\Controllers\Backoffice\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use App\Repositories\WidhdrawalRepository;
use App\Repositories\TemplateMessageRepository;
use App\Models\Widhdrawal;
use Carbon\Carbon;
use App\Jobs\SendMailSuccessWidhdrawalJob;
use App\Jobs\SendMailCancelWidhdrawalJob;
use Config;

class ApprovalWidhdrawalController extends BaseController
{
    protected $repository, $templateMessage;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(WidhdrawalRepository $repository, TemplateMessageRepository $templateMessage)
	{
		$permission = Permission::where('name', 'LIKE', 'approval-widhdrawal-%')->get();
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
			$hasPermissions = Permission::where('name', 'LIKE', 'approval-widhdrawal-%')->get();

            $data = $this->repository->paginate($request);
            
			return $this->makeView('backoffice.approval.widhdrawal.index', compact('data', 'hasPermissions'));
		} catch (\Exception $exc) {
			return $this->goTo500Page($exc);
        }
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

            return $this->makeView('backoffice.approval.widhdrawal.show', compact('data'));
		} catch (\Exception $exc) {
			return $this->goTo500Page($exc);
        }
    }

    public function approvalProccess(Request $request)
	{
       	try {
            $id = $this->decodeHash($request->id);
            $data = $this->repository->show($id);
            $params = $request->input('status');
            // $updateWidhdrawal = $this->repository->approvalWidhdrawal($id, $params);
            // if (!$updateWidhdrawal) {
            //     return redirect()->route('widhdrawal-approval.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            // }

            if($params == 'VERIFIED') {
                // Email
                $dataMessage = $this->templateMessage->getDataById('SUKSES_PENCAIRAN_EMAIL');
                $note = $dataMessage->message;
                $note = str_replace('[NAME]', $data->hasUser->name, $note);
                $note = str_replace('[CAMPAIGN]', ($data->hasCampaign->title) ? : '-', $note);
                $note = str_replace('[DONASI]', $data->amount, $note);
                $note = str_replace('[DATE]', Carbon::parse($data->request_date)->format('d F Y'), $note);
                $note = str_replace('[BANK]', $data->hasBankAccount->hasBank->name ?? '-', $note);
                $note = str_replace('[ACCOUNT_REK]', $data->hasBankAccount->account_number, $note);
                $note = str_replace('[ACCOUNT_NAME]', $data->hasBankAccount->account_name, $note);

                $this->sendMail($data, $note);

                // Whatsapp
                $dataMessageWa = $this->templateMessage->getDataById('SUKSES_PENCAIRAN_WHATSAPP');
                $messageWa = $dataMessageWa->message;
                $messageWa = str_replace('[NAME]', $data->hasUser->name, $messageWa);
                $messageWa = str_replace('[CAMPAIGN]', ($data->hasCampaign->title) ? : '-', $messageWa);
                $messageWa = str_replace('[DONASI]', $data->amount, $messageWa);
                $messageWa = str_replace('[DATE]', Carbon::parse($data->request_date)->format('d F Y'), $messageWa);
                $messageWa = str_replace('[BANK]', $data->hasBankAccount->hasBank->name ?? '-', $messageWa);
                $messageWa = str_replace('[ACCOUNT_REK]', $data->hasBankAccount->account_number, $messageWa);
                $messageWa = str_replace('[ACCOUNT_NAME]', $data->hasBankAccount->account_name, $messageWa);

                $phone = $data->hasUser->phone_number;

                $message = ''.$messageWa.'';

                $this->sendWa($phone, $message);
            } else if ($params == 'CANCEL') {
                 // Email
                $dataMessage = $this->templateMessage->getDataById('CANCEL_PENCAIRAN_EMAIL');
                $note = $dataMessage->message;
                $note = str_replace('[NAME]', $data->hasUser->name, $note);
                $note = str_replace('[CAMPAIGN]', ($data->hasCampaign->title) ? : '-', $note);
                $note = str_replace('[DONASI]', $data->amount, $note);
                $note = str_replace('[DATE]', Carbon::parse($data->request_date)->format('d F Y'), $note);
                $note = str_replace('[BANK]', $data->hasBankAccount->hasBank->name ?? '-', $note);
                $note = str_replace('[ACCOUNT_REK]', $data->hasBankAccount->account_number, $note);
                $note = str_replace('[ACCOUNT_NAME]', $data->hasBankAccount->account_name, $note);

                $this->sendMailCancel($data, $note);

                // Whatsapp
                $dataMessageWa = $this->templateMessage->getDataById('CANCEL_PENCAIRAN_WHATSAPP');
                $messageWa = $dataMessageWa->message;
                $messageWa = str_replace('[NAME]', $data->hasUser->name, $messageWa);
                $messageWa = str_replace('[CAMPAIGN]', ($data->hasCampaign->title) ? : '-', $messageWa);
                $messageWa = str_replace('[DONASI]', $data->amount, $messageWa);
                $messageWa = str_replace('[DATE]', Carbon::parse($data->request_date)->format('d F Y'), $messageWa);
                $messageWa = str_replace('[BANK]', $data->hasBankAccount->hasBank->name ?? '-', $messageWa);
                $messageWa = str_replace('[ACCOUNT_REK]', $data->hasBankAccount->account_number, $messageWa);
                $messageWa = str_replace('[ACCOUNT_NAME]', $data->hasBankAccount->account_name, $messageWa);

                $phone = $data->hasUser->phone_number;

                $message = ''.$messageWa.'';

                $this->sendWa($phone, $message);
            }
            
			return redirect()->route('widhdrawal-approval.index');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }


    protected function sendMail($data, $note)
    {
        try {
            SendMailSuccessWidhdrawalJob::dispatch($data, $note)
                        ->delay(now()->addSeconds(5));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    protected function sendMailCancel($data, $note)
    {
        try {
            SendMailCancelWidhdrawalJob::dispatch($data, $note)
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
