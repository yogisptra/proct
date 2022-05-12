<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\GenerateNumber;
use App\Models\Slider;
use App\Models\BankAccount;
use App\Models\FAQDescription;
use App\Models\ProfileYayasan;
use App\Models\CampaignList;
use App\Models\Category;
use App\Models\CampaignUpdate;
use App\Models\Donatur;
use App\Models\Corporate;
use App\Models\Transaction;
use App\Models\Like;
use Illuminate\Http\Request;
use Auth, DB, Str;

class LandingPageRepository extends Apprepository{
    protected $model, $faqDescription, $profileRepository, $campaignList, $category, $bankAccount, $campaignUpdate, $donatur, $corporate, $transaction, $like;

    public function __construct(Slider $model, FAQDescription $faqDescription, ProfileYayasan $profileRepository, CampaignList $campaignList, Category $category, BankAccount $bankAccount, CampaignUpdate $campaignUpdate, Donatur $donatur, Corporate $corporate, Transaction $transaction, Like $like)
    {
        $this->model = $model;
        $this->faqDescription = $faqDescription;
        $this->profileRepository = $profileRepository;
        $this->campaignList = $campaignList;
        $this->category = $category;
        $this->bankAccount = $bankAccount;
        $this->campaignUpdate = $campaignUpdate;
        $this->donatur = $donatur;
        $this->corporate = $corporate;
        $this->transaction = $transaction;
        $this->like = $like;
    }

    public function getSlider()
    {
        return $this->model->where('enabled', 1)->get();
    }

    public function getBankAccount()
    {
        return $this->bankAccount->where('enabled', 1)->get();
    }

    public function campaignDetail($slug)
    {
        return $this->campaignList->where('slug', $slug)->where('enabled', 1)->first();
    }

    public function getCategory()
    {
        return $this->category->where('enabled', 1)->orderBy('sequence', 'ASC')->get();
    }

    public function getFaq()
    {
        return $this->faqDescription->where('enabled', 1)->where('type', 'UMUM')->get();
    }

    public function getTerm()
    {
        $data = $this->profileRepository->findOrFail('2020151001001');
        $staticPage = json_decode($data->description);
        return $staticPage = [
            'termcondition' => $staticPage->termcondition
        ];
    }

    public function getTermFundraiser()
    {
        $data = $this->profileRepository->findOrFail('2020151001001');
        $staticPage = json_decode($data->description);
        return $staticPage = [
            'termfundraiser' => $staticPage->termfundraiser
        ];
    }

    public function getCampaignMain()
    {
        return $this->campaignList
                    ->where('enabled', 1)
                    ->where('main_program', 1)
                    ->where(function($query){
                        $query->where('selisih_validate', '>=', 0);
                        $query->orWhere('selisih_validate', null);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->limit(5)
                    ->get();
    }

    public function getCampaignNew()
    {
        return $this->campaignList
                    ->where('enabled', 1)
                    ->where(function($query){
                        $query->where('selisih_validate', '>=', 0);
                        $query->orWhere('selisih_validate', null);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->limit(5)
                    ->get();
    }

    public function getAbout()
    {
        $data = $this->profileRepository->findOrFail('2020151001001');

        $staticPage = json_decode($data->description);
        return $staticPage = [
            'image_url' => $data->image_url,
            'profile' => $staticPage->profile
        ];
    }

    public function showCampaign($id)
    {
        return $this->campaignList->where('id', $id)->where('enabled', 1)->first();
    }

    public function getCampaignUpdate($id)
    {
        return $this->campaignUpdate->where('campaign_id', $id)->get();
        
    }

    public function getCampaignerDonatur($id)
    {
        return $this->donatur->where('id', $id)->first();
    }

    public function getCampaignerCorporate($id)
    {
        return $this->corporate->where('id', $id)->first();
    }

    public function getCampaign($id)
    {
        return $this->campaignList
                        ->where('enabled', 1)
                        ->where('user_id', $id)
                        ->where(function($query){
                            $query->where('selisih_validate', '>=', 0);
                            $query->orWhere('selisih_validate', null);
                        })
                        ->get();
    }

    public function getDonaturByCampaign($id)
    {
        return $this->transaction
                    ->where('campaign_id', $id)
                    ->where('is_delete', 0)
                    ->where('transaction_status_id', 'VERIFIED')
                    ->orderBy('payment_date', 'DESC')
                    ->get();
    }

    public function getFundraiser($id)
    {
        return $this->transaction
                    ->join('dns_campaigns', 'dns_campaigns.id', '=', 'dns_transactions.campaign_id')
                    ->select(
                        DB::raw('count(dns_transactions.id) as jumlahTransaksi'),
                        DB::raw('sum(dns_transactions.amount) as nominalTransaksi'),
                        DB::raw('sum(dns_transactions.unique_code) as uniqueCode'),
                        DB::raw('dns_transactions.fundraiser_id as fundraiser_id'),
                    )
                    ->where('dns_campaigns.id', $id)
                    ->whereNotNull('dns_transactions.fundraiser_id')
                    ->where('dns_transactions.transaction_status_id', 'VERIFIED')
                    ->where('dns_transactions.is_delete', 0)
                    ->groupBy('dns_transactions.fundraiser_id')
                    ->get();
    }

    public function updateTokenDonatur()
    {
        $data = $this->donatur->where('id', Auth::guard('member')->user()->id);
        $data->update([
            'slug_token' => Str::random(5),
        ]);

        return $data;
    }

    public function getSlugToken($id)
    {
        return $this->donatur->where('slug_token', $id)->first();
    }

    public function getKontakWhatsapp()
    {
        $data = $this->profileRepository->findOrFail('2020151001001');
        $staticPage = json_decode($data->phone_number);
        return $staticPage = [
            'phone' => $staticPage->phone_1
        ];
    }

    public function getTermCampaignerPersonal()
    {
        $data = $this->profileRepository->findOrFail('2020151001001');
        $staticPage = json_decode($data->description);
        return $staticPage = [
            'termcampaignerpersonal' => $staticPage->termcampaignerpersonal
        ];
    }

    public function getTermCampaignerCorporate()
    {
        $data = $this->profileRepository->findOrFail('2020151001001');
        $staticPage = json_decode($data->description);
        return $staticPage = [
            'termcampaignercorporate' => $staticPage->termcampaignercorporate
        ];
    }

    // public function checkLike($id, $campaignerId, $campaignId)
    // {
    //     $data = $this->like
    //                 ->where('user_id', $id)
    //                 ->where('campaigner_id', $campaignerId)
    //                 ->where('campaign_id', $campaignId)
    //                 ->first();
    //     return $data;   
    // }

}
