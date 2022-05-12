<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\GenerateNumber;
use App\Models\CampaignUpdate;
use App\Models\CampaignList;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Auth;

class CampaignUpdateRepository extends Apprepository{
    protected $model;

    public function __construct(CampaignUpdate $model)
    {
        $this->model = $model;
    }

    protected function setDataPayload(Request $request)
    {
        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'campaign_id' => isset($request['campaign_id']) ? $request->input('campaign_id') : null,
            'title' 			=> isset($request['title']) ? $request->input('title') : null,
            'content'   => isset($request['content']) ? $request->input('content') : null,
            'created_by'    => isset($request['created_by']) ? $request->input('created_by') : null,
            'updated_by'    => isset($request['updated_by']) ? $request->input('updated_by') : null,
            'enabled' 	    => 1,
        ];
    }

    public function getDataByCampaign($id)
    {
        return $this->model->where('campaign_id', $id)->where('enabled', 1)->get();
    }

    public function paginate(Request $request)
    {
        $data = $this->model
                    ->when(request()->search, function($query) {
                        $query->where('title', 'like', '%'.request()->search.'%');
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($request->input('limit', 15))
                    ->appends(request()->query());
         
        return $data;
    }

    public function getTransactionByCampaign($id)
    {
        $data = Transaction::where('transaction_status_id', 'VERIFIED')
                        ->where('is_delete', 0)
                        ->where('campaign_id', $id)
                        ->distinct('email')
                        ->get(['email']);

        return $data;
    }

}
