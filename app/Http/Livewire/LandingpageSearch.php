<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CampaignList;

class LandingpageSearch extends Component
{
    public $searchTerm;
    public $limitPerPage = 6;

    protected $listeners = [
        'post-data' => 'postData'
    ];
    public function postData()
    {
        $this->limitPerPage = $this->limitPerPage + 6;
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        if($searchTerm == '%%') {
            return view('livewire.landingpage-search',  [
                'data' => CampaignList::where('enabled', 1)
                            ->where(function($query){
                                $query->where('selisih_validate', '>=', 0);
                                $query->orWhere('selisih_validate', null);
                            })
                            ->orderBy('created_at', 'DESC')
                            ->paginate($this->limitPerPage) 
            ]);
        } else {
            return view('livewire.landingpage-search',  [
                'data' =>  CampaignList::where('enabled', 1)
                        ->where('title', 'like', $searchTerm)
                        ->where(function($query){
                            $query->where('selisih_validate', '>=', 0);
                            $query->orWhere('selisih_validate', null);
                        })
                        ->orderBy('created_at', 'DESC')
                        ->paginate($this->limitPerPage)
            ]);
        }
       
       
    }
}

