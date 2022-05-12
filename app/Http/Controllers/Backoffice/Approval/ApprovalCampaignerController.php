<?php

namespace App\Http\Controllers\Backoffice\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use App\Repositories\DonaturRepository;
use App\Repositories\TemplateMessageRepository;
use Carbon\Carbon;
use App\Jobs\SendMailSuccessCampaignerJob;
use App\Jobs\SendMailCancelCampaignerJob;
use Config;

class ApprovalCampaignerController extends BaseController
{
    protected $repository, $templateMessage;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(DonaturRepository $repository, TemplateMessageRepository $templateMessage)
	{
		$permission = Permission::where('name', 'LIKE', 'approval-campaigner-%')->get();
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
			$hasPermissions = Permission::where('name', 'LIKE', 'approval-campaigner-%')->get();

            $data = $this->repository->paginateCampaigner($request);
            
			return $this->makeView('backoffice.approval.campaigner.index', compact('data', 'hasPermissions'));
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

            return $this->makeView('backoffice.approval.campaigner.show', compact('data'));
		} catch (\Exception $exc) {
			return $this->goTo500Page($exc);
        }
    }

    public function approvalProccess(Request $request)
	{
       	try {
            $id = $this->decodeHash($request->id);
            $data = $this->repository->show($id);
            $params = $request->input('is_campaigner');
            $updateCampaigner = $this->repository->approvalCampaigner($id, $params);
            if (!$updateCampaigner) {
                return redirect()->route('campaigner-approval.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            if($params == 'VERIFIED') {
                // Email
                $dataMessage = $this->templateMessage->getDataById('SUKSES_CAMPAIGNER_EMAIL');
                $note = $dataMessage->message;
				$note = str_replace('[NAME]', $data->name, $note);
                $this->sendMailSuccess($data, $note);

                // Whatsapp
                $dataMessageWa = $this->templateMessage->getDataById('SUKSES_CAMPAIGNER_WHATSAPP');
                $messageWa = $dataMessageWa->message;
                $phone = $data->phone_number;
                $message = 'Hi, Kak '.$data['name'].',
'.$messageWa.'';
                $this->sendWa($phone, $message);
            } else if ($params == 'CANCEL') {
                // Email
                $dataMessage = $this->templateMessage->getDataById('CANCEL_CAMPAIGNER_EMAIL');
                $note = $dataMessage->message;
				$note = str_replace('[NAME]', $data->name, $note);
                $this->sendMailCancel($data, $request->comment, $note);

                // Whatsapp
                $dataMessageWa = $this->templateMessage->getDataById('CANCEL_CAMPAIGNER_WHATSAPP');
                $messageWa = $dataMessageWa->message;
                $phone = $data->phone_number;
                $message = 'Hi, Kak '.$data['name'].',
'.$messageWa.',
                ◾ Catatan : '.$request->comment.'';
                $this->sendWa($phone, $message);
            }
            
			return redirect()->route('campaigner-approval.index');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    protected function sendMailSuccess($data, $note)
    {
        try {
            SendMailSuccessCampaignerJob::dispatch($data, $note)
                        ->delay(now()->addSeconds(5));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    protected function sendMailCancel($data, $comment, $note)
    {
        try {
            SendMailCancelCampaignerJob::dispatch($data, $comment, $note)
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
