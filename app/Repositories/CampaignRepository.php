<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\GenerateNumber;
use App\Models\FAQDescription;
use App\Models\Corporate;
use App\Models\ProfileYayasan;
use App\Models\Donatur;
use App\Models\Campaign;
use App\Models\CampaignList;
use App\Models\Category;
use Illuminate\Http\Request;
use Auth, DB, Cache;

class CampaignRepository extends Apprepository{
    protected $model, $corporate, $donatur, $faqDescription, $profileRepository, $campaignList, $category;

    public function __construct(Campaign $model, Corporate $corporate, Donatur $donatur, FAQDescription $faqDescription, ProfileYayasan $profileRepository, CampaignList $campaignList, Category $category)
    {
        $this->model = $model;
        $this->corporate = $corporate;
        $this->donatur = $donatur;
        $this->faqDescription = $faqDescription;
        $this->profileRepository = $profileRepository;
        $this->campaignList = $campaignList;
        $this->category = $category;
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

        if(!empty($request->file('background'))){
			$background = time() . '.' .$request->file('background')->getClientOriginalExtension();
		}else if (isset($request['background'])){
			$background = $request['background'];
		}else {
			$background = null;
        }

        if($request->open_goal == 1) {
            $target = null;
            $valid_date = null;
        }else{
            $target = isset($request['target']) ? str_replace(".", "", $request->input('target')) : null;
            $valid_date = isset($request['valid_date']) ? $request->input('valid_date') : null;
            // $valid_date = isset($request['valid_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('valid_date'))->format('Y-m-d') : null;
        }
 

        $enabled = 0;
        if($request['enabled'] == true){
            $enabled = 1;
        }

        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'categories_id' 	=> isset($request['categories_id']) ? $request->input('categories_id') : null,
            'user_id' => isset($request['user_id']) ? $request->input('user_id') : null,
            'title'       => isset($request['title']) ? $request->input('title') : null,
            'target'    => $target,
            'custom_amount' 	=> isset($request['custom_amount']) ? json_encode($request->input('custom_amount')) : null,
            'valid_date'       => $valid_date,
            'open_goal'    => isset($request['open_goal']) ? $request->input('open_goal') : null,
            'description'    => isset($request['description']) ? $request->input('description') : null,
            'image' => $image,
            'background'       => $background,
            'slug'    => isset($request['slug']) ? $request->input('slug') : null,
            'main_program'    => isset($request['main_program']) ? $request->input('main_program') : null,
            'status'    => isset($request['status']) ? $request->input('status') : null,
            'fb_pixel' => isset($request['fb_pixel']) ? $request->input('fb_pixel') : null,
            'gtm'       => isset($request['gtm']) ? $request->input('gtm') : null,
            'enabled' 	    => $enabled,
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

    public function paginateCampaign(Request $request)
    {
        $data = $this->campaignList
                    ->when(request()->search, function($query) {
                        $query->where('name', 'like', '%'.request()->search.'%');
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($request->input('limit', 15))
                    ->appends(request()->query());
         
        return $data;
    }

    public function approvalCampaign($id, $data){
        $approve = NULL;
        DB::beginTransaction();
        try {
            if ($data == 'VERIFIED') {
                $approve =  $this->model
                            ->where('id', $id)
                            ->update([ 
                                'status' => $data,
                            ]);
            }else{
                $approve =  $this->model
                            ->where('id', $id)
                            ->update([ 
                                'status' => $data,
                            ]);
            }

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $approve = $th;
        }
        return $approve;
    }

    public function updateMainProgram($id, $status)
    {
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->model->findOrFail($id);
            $data->update([
                'main_program' => $status,
                        ]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }

    public function getCorporate(){
        return $this->corporate
                ->where('user_id', '=', Auth::guard('member')->user()->id)
                ->first();
    }

    public function getCampaignByUser()
    {
        $data = $this->campaignList
                ->where('user_id', Auth::guard('member')->user()->id)
                ->get();
        return $data;
        
    }

    public function showCorporate($id){
        return $this->corporate
                ->where('id', '=', $id)
                ->first();
    }

    public function showCampaign($id){
        return $this->campaignList
                ->where('id', '=', $id)
                ->first();
    }

    public function campaignDetail($slug)
    {
        return $this->campaignList->where('user_id', Auth::guard('member')->user()->id)
                                ->where('slug', $slug)->where('enabled', 1)
                                ->first();
    }

    public function getFaq()
    {
        return $this->faqDescription->where('type', 'GALANGDANA')->where('enabled', 1)->get();
    }

    public function getTerm()
    {
        $data = $this->profileRepository->findOrFail('2020151001001');
        $staticPage = json_decode($data->description);
        return $staticPage = [
            'termcorporate' => $staticPage->termcorporate
        ];
    }

    public function getCategory()
    {
        return $this->category->where('enabled', 1)->get();
    }

}
