<table class="table table-striped">
    <tfoot>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Laporan Donasi</b></td>
            <td align="left"><b></b></td>
        </tr>
        <tr>
            <td colspan="1"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Campaigner</b></td>
            <td align="left" class="gray">
                @if($data->hasUser->type_campaigner == 'PERSONAL')
                Personal
                @else
                Corporate
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Nama Campaign</b></td>
            <td align="left" class="gray">{{ $data->title }}</td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Penggalang Dana</b></td>
            @if($data->hasUser->type_campaigner == 'PERSONAL')
            <td align="left" class="gray">{{ $data->hasUser->name }}</td>
            @else
            <td align="left" class="gray">{{ $data->hasUser->hasCorporate->corporate_name }}</td>
            @endif
        </tr>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Kategori</b></td>
            <td align="left" class="gray">{{ $data->hasCategory->name }}</td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Tanggal Campaign</b></td>
            <td align="left" class="gray">{{ Carbon\Carbon::parse($data->valid_date)->format('l, F Y') }} - Selesai</td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Target Donasi</b></td>
            <td align="left" class="gray">Rp{{ number_format($data->target,0,'.','.') }},-</td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Penerimaan Donasi</b></td>
            <td align="left" class="gray">Rp{{ number_format($data->collected,0,'.','.') }},-</td>
        </tr>
        <tr>
            <td colspan="1"></td>
        </tr>
        <tr>
            <td colspan="1"></td>
            <td align="left"><b>Per Tanggal</b></td>
            <td align="left" class="gray">{{ Carbon\Carbon::now()->format('l, F Y') }}</td>
        </tr>
    </tfoot>
</table>
