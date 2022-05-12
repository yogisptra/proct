<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheet implements WithMultipleSheets
{
    use Exportable;
    protected $id;

    // private $writerType = 'xlsx';

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function sheets(): array
    {
        return [
            'Summary Donasi' =>  new DonationExport(),
            'Data Donatur' =>  new DonaturExport($this->id),
        ];
    }
}

?>
