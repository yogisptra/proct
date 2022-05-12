<?php

namespace App\Http\Livewire;

use App\Models\Donatur;
use App\Models\Transaction;
use Livewire\Component;

class ListDoaDonatur extends Component
{
    public $campaign_id;

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
        $data = Transaction::where('campaign_id', $this->campaign_id)
                            ->where('is_delete', 0)
                            ->where('transaction_status_id', 'VERIFIED')
                            ->orderBy('payment_date', 'DESC')
                            ->paginate($this->limitPerPage);
        return view('livewire.list-doa-donatur', [
            'donatur' => $data
        ]);
    }
}
