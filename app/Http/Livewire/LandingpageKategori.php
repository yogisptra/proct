<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\CampaignList;

class LandingpageKategori extends Component
{
    public $edata = [];
    protected $listeners = [
        'switch'
    ];

    public function switch($id)
    {
        if($id == 'all') {
            $data = CampaignList::where('enabled', 1)
                                ->where(function($query){
                                    $query->where('selisih_validate', '>=', 0);
                                    $query->orWhere('selisih_validate', null);
                                })
                                ->orderBy('created_at', 'DESC')
                                ->get();
            $this->edata = $data;
        } else {
            $data = CampaignList::where('categories_id', $id)
                                ->where('enabled', 1)
                                ->where(function($query){
                                    $query->where('selisih_validate', '>=', 0);
                                    $query->orWhere('selisih_validate', null);
                                })
                                ->orderBy('created_at', 'DESC')
                                ->get();
            $this->edata = $data;
        }
    }
    public function mount()
    {
        $data = CampaignList::where('enabled', 1)
                            ->where(function($query){
                                $query->where('selisih_validate', '>=', 0);
                                $query->orWhere('selisih_validate', null);
                            })
                            ->orderBy('created_at', 'DESC')
                            ->get();
        $this->edata = $data;
    }

    public function render()
    {
        return view('livewire.landingpage-kategori', [
            'data' => $this->edata,
        ]);
    }
}
