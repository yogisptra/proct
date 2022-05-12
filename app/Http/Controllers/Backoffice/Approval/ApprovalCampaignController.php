<?php

namespace App\Http\Controllers\Backoffice\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use App\Repositories\CampaignRepository;
use App\Models\Campaign;
use Carbon\Carbon;
use App\Jobs\SendMailSuccessCampaignJob;
use App\Jobs\SendMailCancelCampaignJob;

class ApprovalCampaignController extends BaseController
{
    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(CampaignRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'approval-campaign-%')->get();
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
			$hasPermissions = Permission::where('name', 'LIKE', 'approval-campaign-%')->get();

            $data = $this->repository->paginateCampaign($request);
            
			return $this->makeView('backoffice.approval.campaign.index', compact('data', 'hasPermissions'));
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
            $data = $this->repository->showCampaign($id);

            return $this->makeView('backoffice.approval.campaign.show', compact('data'));
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
            $updateCampaigner = $this->repository->approvalCampaign($id, $params);
            if (!$updateCampaigner) {
                return redirect()->route('campaign-approval.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            if($params == 'VERIFIED') {
                $this->sendMail($data);
            } else if ($params == 'CANCEL') {
                $this->sendMailCancel($data);
            }
            
			return redirect()->route('campaign-approval.index');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function mainProgramStatus($id, $status)
	{
       	try {
            $id = $this->decodeHash($id);

            $cekCampaignMainProgram = Campaign::where('main_program', 1)->count('id');

            if($status == 0){
                $update = $this->repository->updateMainProgram($id, $status);
                if (!$update) {
                    return redirect()->route('campaign-approval.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
                }
                return redirect()->route('campaign-approval.index')->with('success', 'Program Pilihan berhasil diubah');

              
            }else{
                if($cekCampaignMainProgram >= 6){
                    return redirect()->route('campaign-approval.index')->with('error', 'Program Pilihan pada Campaign ini sudah mencapai maksimal ( 3 Program )');
    
                }else{
                    $update = $this->repository->updateMainProgram($id, $status);
                    if (!$update) {
                        return redirect()->route('campaign-approval.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
                    }
                    return redirect()->route('campaign-approval.index')->with('success', 'Program Pilihan berhasil diubah');

                }
            }
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }


    protected function sendMail($data)
    {
        // try {
        //     $email = new \App\Mail\SuccessCampaign($data);
        //     Mail::to($data->hasUser->email)->send($email);
        // } catch (\Exception $exc) {
        //     return $this->goTo500Page($exc);
        // }
        try {
            SendMailSuccessCampaignJob::dispatch($data)
                        ->delay(now()->addSeconds(5));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    protected function sendMailCancel($data)
    {
        // try {
        //     $email = new \App\Mail\CancelCampaign($data);
        //     Mail::to($data->hasUser->email)->send($email);
        // } catch (\Exception $exc) {
        //     return $this->goTo500Page($exc);
        // }
        try {
            SendMailCancelCampaignJob::dispatch($data)
                        ->delay(now()->addSeconds(5));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

}
