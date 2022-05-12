<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CampaignList;
use App\Models\Category;
use Auth;

class DashboardListCampaign extends Component
{
    public $edata = [];
    public $sortBy;
    public $categories;
    public $filter;
    
    public $limitPerPage = 6;

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

    public function filter($val)
    {
        $this->filter = $val;
    }

    public function render()
    {
        if($this->sortBy == null){
            $sortBy = 'desc';
        }else{
            $sortBy = $this->sortBy;
        }
        $category = Category::where('enabled', 1)->get();

        if($this->filter == "END"){
            $data = CampaignList::where('enabled', 1)
                    ->where('categories_id', 'like', '%' .$this->categories.'%')
                    ->where('selisih_validate', '<', '0')
                    ->where('user_id', Auth::guard('member')->user()->id)
                    ->orderBy('created_at', $sortBy)
                    ->paginate($this->limitPerPage);
        }else{
            $data = CampaignList::where('enabled', 1)
                    ->where('categories_id', 'like', '%' .$this->categories.'%')
                    ->where(function($query){
                        $query->where('selisih_validate', '>=', 0);
                        $query->orWhere('selisih_validate', null);
                    })
                    ->where('user_id', Auth::guard('member')->user()->id)
                    ->orderBy('created_at', $sortBy)
                    ->paginate($this->limitPerPage);
        }
        

        return view('livewire.dashboard-list-campaign', [
            'data' => $data,
            'category' => $category,
            'sortBy' => $sortBy,
            'hasFilterCategory' => $this->categories,
            'hasFilter' => $this->filter,
        ]);
    }
}
