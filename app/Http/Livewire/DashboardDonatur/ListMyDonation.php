<?php

namespace App\Http\Livewire\DashboardDonatur;

use App\Models\Transaction;
use Livewire\Component;
use Auth;

class ListMyDonation extends Component
{
    public $limitPerPage = 7;

    protected $listeners = [
        'post-data' => 'postData'
    ];
   
    public function postData()
    {
        $this->limitPerPage = $this->limitPerPage + 3;
    }

    public function render()
    {
        $data = Transaction::where('donatur_id', Auth::guard('member')->user()->id)
                ->paginate($this->limitPerPage);
        return view('livewire.dashboard-donatur.list-my-donation',[
            'data' => $data
        ]);
    }
}
