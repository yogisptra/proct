<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;
use DB;

class ListFundraiser extends Component
{
    public $campaign_id;

    public $limitPerPage = 6;

    protected $listeners = [
        'post-data-fundraiser' => 'postData'
    ];
   
    public function postData()
    {
        $this->limitPerPage = $this->limitPerPage + 6;
    }

    public function render()
    {
        $data = Transaction::join('dns_campaigns', 'dns_campaigns.id', '=', 'dns_transactions.campaign_id')
                            ->select(
                                DB::raw('count(dns_transactions.id) as jumlahTransaksi'),
                                DB::raw('sum(dns_transactions.amount) as nominalTransaksi'),
                                DB::raw('sum(dns_transactions.unique_code) as uniqueCode'),
                                DB::raw('dns_transactions.fundraiser_id as fundraiser_id'),
                            )
                            ->where('dns_campaigns.id', $this->campaign_id)
                            ->whereNotNull('dns_transactions.fundraiser_id')
                            ->where('dns_transactions.transaction_status_id', 'VERIFIED')
                            ->where('dns_transactions.is_delete', 0)
                            ->groupBy('dns_transactions.fundraiser_id')
                            ->paginate($this->limitPerPage);
        return view('livewire.list-fundraiser',[
            'fundraiser' => $data
        ]);
    }
}
