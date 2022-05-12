<?php

namespace App\Http\Controllers\Frontoffice;

use App\Http\Controllers\Controller;
use App\DigiBase\Controller\BaseController;
use App\Repositories\LandingPageRepository;
use Auth, PDF, DB;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    protected $repository;

    function __construct(LandingPageRepository $repository)
	{
        $this->repository = $repository;
	}

    public function index(Request $request)
    {
        $slider = $this->repository->getSlider();
        $campaignMain = $this->repository->getCampaignMain();
        $campaignNew = $this->repository->getCampaignNew();
        $category = $this->repository->getCategory();

        return $this->makeView('frontoffice.index', compact('slider', 'category', 'campaignMain', 'campaignNew'));
    }

    public function campaignDetail($slug)
    {
        $data = $this->repository->campaignDetail($slug);
        $programUpdate = $this->repository->getCampaignUpdate($data->id);
        $donatur = $this->repository->getDonaturByCampaign($data->id);
        $fundraiser = $this->repository->getFundraiser($data->id);
        if (Auth::guard('member')->check() == false) {
            $cekFundraiser = null;
        } else {
            $cekFundraiser = Auth::guard('member')->user()->slug_token;
        }

        $title = $data->title;
        
        return $this->makeView('frontoffice.detail', compact('data', 'programUpdate', 'donatur', 'fundraiser', 'cekFundraiser', 'title'));
    }

    public function campaignList(Request $request)
    {
        $title = 'Semua Kategori';
        $category = $this->repository->getCategory();

        return $this->makeView('frontoffice.list-campaign', compact('title', 'category'));
    }

    public function faq()
    {
        $title = 'Bantuan';
        $noHp = $this->repository->getKontakWhatsapp();
        $phone = str_replace(" ","",$noHp);
        // kadang ada penulisan no hp (0274) 778787
        $phone = str_replace("(","",$noHp);
        // kadang ada penulisan no hp (0274) 778787
        $phone = str_replace(")","",$noHp);
        // kadang ada penulisan no hp 0811.239.345
        $phone = str_replace(".","",$noHp);
        if(!preg_match('/[^+0-9]/',trim($phone['phone']))){
            // cek apakah no hp karakter 1-3 adalah +62
            if(substr(trim($phone['phone']), 0, 1)=='0'){
                $kontak = '62'.substr(trim($phone['phone']), 1);
            }
        }
        $faq = $this->repository->getFaq();
        return $this->makeView('frontoffice.faq', compact('faq', 'title', 'kontak'));
    }

    public function term()
    {
        $title = 'Syarat & Ketentuan';
        $term = $this->repository->getTerm();

        return $this->makeView('frontoffice.terms', compact('term', 'title'));
    }

    public function termFundraiser()
    {
        $title = 'Syarat & Ketentuan Fundraiser';
        $term = $this->repository->getTermFundraiser();

        return $this->makeView('frontoffice.terms-fundraiser', compact('term', 'title'));
    }

    public function about()
    {
        $title = 'Tentang Donasi.co';
        $about = $this->repository->getAbout();

        return $this->makeView('frontoffice.about', compact('about', 'title'));
    }

    public function pageCampaigner($type, $id)
    {
        $id = $this->decodeHash($id);
        if($type == 'PERSONAL') {
            $data = $this->repository->getCampaignerDonatur($id);
            $campaign = $this->repository->getCampaign($data->id);
            $title = $data->name;

            return $this->makeView('frontoffice.detail-campaigner', compact('data', 'type', 'title', 'campaign'));
        } elseif($type == 'CORPORATE'){
            $data = $this->repository->getCampaignerCorporate($id);
            $campaign = $this->repository->getCampaign($data->hasUser->id);
            $title = $data->hasUser->hasCorporate->corporate_name;

            return $this->makeView('frontoffice.detail-campaigner', compact('data', 'type', 'title', 'campaign'));
        }
    }

    public function registerFundraiser(Request $request, $slug)
    {
        try {
            if(Auth::guard('member')->user()->slug_token == NULL){
                $fundraiser = $this->repository->updateTokenDonatur();
                return redirect()->route('frontoffice.fundraiser-register', $slug);
            }
            $campaign = $this->repository->campaignDetail($slug);
            $title = "Jadi Fundraiser Berhasil"; 
            return $this->makeView('frontoffice.fundraiser.index', compact('campaign', 'title'));
           
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function detailFundraiser($slug, $slug_token)
    {
        try {
            $data = $this->repository->campaignDetail($slug);
            $visitor = views($data)->record();
            $fundraiser = $this->repository->getSlugToken($slug_token);
            $donatur = $this->repository->getDonaturByCampaign($data->id);
            if($fundraiser == null){
                return redirect()->route('frontoffice.campaignDetail', $slug);
            }
            if ($data) {
                $allFundraiser = $this->repository->getFundraiser($data->id);
                $programUpdate = $this->repository->getCampaignUpdate($data->id);
    
                if (Auth::guard('member')->check() == false) {
                    $cekFundraiser = null;
                } else {
                    $cekFundraiser = $this->repository->getSlugToken($slug_token);
                }
                return $this->makeView('frontoffice.fundraiser.detail', compact('data', 'programUpdate', 'fundraiser', 'allFundraiser', 'cekFundraiser', 'donatur'));
            }
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    // public function checkLike($campaignerId, $campaignId)
    // {
    //     $checkLike = $this->repository->checkLike(Auth::guard('member')->user()->id, $campaignerId, $campaignId);
        
    //     if($checkLike == null){
    //         $like = "like";
    //     }else{
    //         $like = "unlike";
    //     }

    //     return json_encode(["data" => $like]);

    // }


    public function search(Request $request)
    {
        $title = 'Pencarian';

        return $this->makeView('frontoffice.list-search', compact('title'));
    }
}
