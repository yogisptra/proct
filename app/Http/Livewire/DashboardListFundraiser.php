<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Transaction;
use Auth;

class DashboardListFundraiser extends Component
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

    // public function switch($id)
    // {
    //     if($id == 'all') {
    //         $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
    //                             ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
    //                             ->where(function ($query){
    //                                 $query->where('ch_v_program_list.selisih_validate', '>=', 0)
    //                                 ->orWhere('ch_v_program_list.selisih_validate', null);
    //                             })
    //                             ->where('transaction_status_id', 'VERIFIED')
    //                             ->groupBy('campaign_id')
    //                             ->paginate(6);
    //         $this->edata = $data;
    //     } else {
    //         $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
    //                             ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
    //                             ->where(function ($query){
    //                                 $query->where('ch_v_program_list.selisih_validate', '>=', 0)
    //                                 ->orWhere('ch_v_program_list.selisih_validate', null);
    //                             })
    //                             ->where('transaction_status_id', 'VERIFIED')
    //                             ->where('ch_v_program_list.categories_id', $id)
    //                             ->groupBy('campaign_id')
    //                             ->paginate(6);
    //         $this->edata = $data;
    //     }
    // }

    // public function sortBy($id)
    // {
    //     if($id == 'asc') {
    //         $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
    //                             ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
    //                             ->where(function ($query){
    //                                 $query->where('ch_v_program_list.selisih_validate', '>=', 0)
    //                                 ->orWhere('ch_v_program_list.selisih_validate', null);
    //                             })
    //                             ->where('transaction_status_id', 'VERIFIED')
    //                             ->groupBy('campaign_id')
    //                             ->orderBy('created_at', 'asc')
    //                             ->paginate(6);
    //         $this->edata = $data;
    //     } else {
    //         $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
    //                             ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
    //                             ->where(function ($query){
    //                                 $query->where('ch_v_program_list.selisih_validate', '>=', 0)
    //                                 ->orWhere('ch_v_program_list.selisih_validate', null);
    //                             })
    //                             ->where('transaction_status_id', 'VERIFIED')
    //                             ->groupBy('campaign_id')
    //                             ->orderBy('created_at', 'desc')
    //                             ->paginate(6);
    //         $this->edata = $data;
    //     }
    // }

    // public function filter($id)
    // {
    //     if($id == 'all') {
    //         $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
    //                             ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
    //                             ->where(function ($query){
    //                                 $query->where('ch_v_program_list.selisih_validate', '>=', 0)
    //                                 ->orWhere('ch_v_program_list.selisih_validate', null);
    //                             })
    //                             ->where('transaction_status_id', 'VERIFIED')
    //                             ->groupBy('campaign_id')
    //                             ->paginate(6);
    //         $this->edata = $data;
    //     } else {
    //         $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
    //                             ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
    //                             ->where(function ($query){
    //                                 $query->where('ch_v_program_list.selisih_validate', '<', 0);
    //                             })
    //                             ->where('transaction_status_id', 'VERIFIED')
    //                             ->groupBy('campaign_id')
    //                             ->paginate(6);
    //         $this->edata = $data;
    //     }
    // }

    // public function mount()
    // {
    //     $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
    //                             ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
    //                             ->where(function ($query){
    //                                 $query->where('ch_v_program_list.selisih_validate', '>=', 0)
    //                                 ->orWhere('ch_v_program_list.selisih_validate', null);
    //                             })
    //                             ->where('transaction_status_id', 'VERIFIED')
    //                             ->groupBy('campaign_id')
    //                             ->get();
    //     $this->edata = $data;
    // }

    public function render()
    {
        if($this->sortBy == null){
            $sortBy = 'desc';
        }else{
            $sortBy = $this->sortBy;
        }

        $category = Category::where('enabled', 1)->get();
        if($this->filter == "END"){
            $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
                            ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
                            ->where(function ($query){
                                $query->where('ch_v_program_list.selisih_validate', '<', 0);
                            })
                            ->where('ch_v_program_list.categories_id', 'like', '%' .$this->categories.'%')
                            ->where('transaction_status_id', 'VERIFIED')
                            ->groupBy('campaign_id')
                            ->orderBy('ch_v_program_list.created_at', $sortBy)
                            ->paginate($this->limitPerPage);

        }else{
            $data = Transaction::where('fundraiser_id', Auth::guard('member')->user()->id)
                                ->join("ch_v_program_list","ch_v_program_list.id","=","dns_transactions.campaign_id")
                                ->where(function ($query){
                                    $query->where('ch_v_program_list.selisih_validate', '>=', 0)
                                    ->orWhere('ch_v_program_list.selisih_validate', null);
                                })
                                ->where('ch_v_program_list.categories_id', 'like', '%' .$this->categories.'%')
                                ->where('transaction_status_id', 'VERIFIED')
                                ->groupBy('campaign_id')
                                ->orderBy('ch_v_program_list.created_at', $sortBy)
                                ->paginate($this->limitPerPage);
        }
        
        return view('livewire.dashboard-list-fundraiser', [
            'data' => $data,
            'category' => $category,
            'sortBy' => $sortBy,
            'hasFilterCategory' => $this->categories,
            'hasFilter' => $this->filter,
        ]);
    }
}
