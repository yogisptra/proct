<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CampaignList;
use App\Models\Category;

class LandingpageListCampaign extends Component
{
    public $edata = [];

    public $sortBy;
    public $categories;
    public $filter;
    
    public $limitPerPage = 5;

    protected $listeners = [
        'post-data' => 'postData'
    ];
   
    public function postData()
    {
        $this->limitPerPage = $this->limitPerPage + 6;
    }

    public function sortBy($val)
    {
        $this->sortBy = $val;
    }

    public function categories($val)
    {
        $this->categories = $val;
    }

    public function render()
    {
        if($this->sortBy == null){
            $sortBy = 'desc';
        }else{
            $sortBy = $this->sortBy;
        }
        $category = Category::where('enabled', 1)->get();
        $data = CampaignList::where('categories_id', 'like', '%' .$this->categories.'%')
                                ->where('enabled', 1)
                                ->where(function($query){
                                    $query->where('selisih_validate', '>=', 0);
                                    $query->orWhere('selisih_validate', null);
                                })
                            ->orderBy('created_at', $sortBy)
                            ->paginate($this->limitPerPage);
        return view('livewire.landingpage-list-campaign', [
            'data' => $data,
            'category' => $category,
            'sortBy' => $sortBy,
            'hasFilterCategory' => $this->categories,
        ]);
    }
}
