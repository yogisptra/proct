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
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;

class DonationExport implements FromView, ShouldAutoSize, WithTitle
{
    use Exportable, HashId;

      /**
     * The table repositories.
     *
     * @var CampaignRepository
     */


    private $counter = 1;



    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return ProgramList::all();
    // }

    public function view(): View
    {
        $dataId = request('id');
        $id = $this->decodeHash($dataId);
        return view('backoffice.excel.campaign', [
            'data' => CampaignList::where('id', $id)->first()
        ]);
    }

    public function title(): string
    {
        return 'Summary Donasi';
    }
}
