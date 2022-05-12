<?php

namespace App\Exports;

use App\Models\CampaignList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\DigiBase\Utilities\HashId;
use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;

class ListDonaturExport implements FromView, ShouldAutoSize, WithTitle
{
    use Exportable, HashId;
    protected $id;

      /**
     * The table repositories.
     *
     * @var CampaignRepository
     */


    private $counter = 1;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return CampaignList::all();
    // }

    public function view(): View
    {
        $id = $this->id;
        return view('backoffice.excel.donatur', [
            'data' => Transaction::where('campaign_id', $id)
            ->where('is_delete',0)
            ->where('transaction_status_id', 'VERIFIED')
            ->orderBy('transaction_date', 'DESC')
            ->get()
        ]);
    }

    public function title(): string
    {
        return 'Data Donatur';
    }
}
