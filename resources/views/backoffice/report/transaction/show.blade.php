@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Data Laporan Donasi</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Laporan Donasi</li>
                    <li class="breadcrumb-item">Data Laporan Donasi</li>
                    <li class="breadcrumb-item active"  > <a href="">Detail</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
            <a href="{{ route('laporan-transaction.index') }}" type="button" class="btn btn-danger mr-1 round">
                Kembali
            </a>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box">
                                    <form class="form form-horizontal">
                                        <div class="form-body">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <img src="{{ asset('assets/images/campaign/'. $data->hasCampaign->image) }}" class="img-thumbnail" width="100%">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <span><b> {{ $data->title ?? '-' }} </b></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-6">Target Donasi</label>
                                                    <div class="col-lg-6">
                                                        <span>: Rp{{ number_format($data->hasCampaignList->target,0,'.','.') }},-</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-6">Penerimaan Donasi</label>
                                                    <div class="col-lg-6">
                                                        <span>: Rp{{ number_format($data->hasCampaignList->collected,0,'.','.') }},-</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        @if ($data->open_goal == 1)
                                                            <span class="badge badge-success">Campaign Berlangsung</span>
                                                        @else
                                                            @if($data->selisih_validate < 0)
                                                                <span class="badge badge-danger">Campaign Berakhir</span>
                                                            @else
                                                                <span class="badge badge-success">Campaign Berlangsung</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <a href="{{ route('laporan-transaction.excel', $data->encodeHash($data->hasCampaign->id)) }}"><i class="fa fa-print"> Download Laporan</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mt-0">
                <form action="">
                    <select class="form-control" onchange="filter(this.value)">
                        <option value="ALL">Semua</option>
                        <option value="BULANAN">Bulanan</option>
                        <option value="MINGGUAN">Mingguan</option>
                        <option value="HARIAN">Harian</option>
                    </select>
                </form>
            </div>
            <div class="card mt-0" id="monthly">
                <div class="card-header">
                    <h4 class="card-title">Statistik Bulanan</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="row">
                        <div class="card-body">
                            <div id="statistik" class="height-350" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Bulan</th>
                                            <th scope="col">Prospek</th>
                                            <th scope="col">Penerimaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($dataTransactionYearly as $key => $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row['bulan'] }}</td>
                                            <td>Rp{{ number_format($row['prospek'],0,'.','.')  }},-</td>
                                            <td>Rp{{ number_format($row['total'],0,'.','.') }},-</td>
                                        </tr>
                                        
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-0" id="weekly">
                <div class="card-header">
                    <h4 class="card-title">Statistik Mingguan</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse" id="collapseWeekly">
                    <div class="row">
                        <div class="card-body">
                            <div id="statistikWeekly" class="height-350" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Hari</th>
                                            <th scope="col">Prospek</th>
                                            <th scope="col">Penerimaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach($dataTransactionWeekly as $key => $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row['day'] }}</td>
                                            <td>Rp{{ number_format($row['prospek'],0,'.','.')  }},-</td>
                                            <td>Rp{{ number_format($row['total'],0,'.','.') }},-</td>
                                        </tr>
                                        
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-0" id="daily">
                <div class="card-header">
                    <h4 class="card-title">Statistik Harian</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse" id="collapseDaily">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Prospek</th>
                                        <th scope="col">Penerimaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @foreach($dataTransactionDailyPaginate as $key => $row)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $row['date'] }}</td>
                                        <td>Rp{{ number_format($row['prospek'],0,'.','.')  }},-</td>
                                        <td>Rp{{ number_format($row['total'],0,'.','.') }},-</td>
                                    </tr>
                                    
                                    @endforeach
                                
                                </tbody>
                            </table>
                        </div>
                        {{ $dataTransactionDailyPaginate->links('pagination.page') }}
                    </div>
                </div>
            </div>

            <div class="card mt-0">
                <div class="card-header">
                    <h4 class="card-title">Donatur</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Tanggal Transaksi</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse($dataDonatur as $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->name ? ($row->name) : '-'  }}</td>
                                            <td>Rp{{ number_format($row->amount + $row->unique_code ? $row->amount + $row->unique_code : 0, "0",",",".") }},-</td>
                                            <td>{{ \Carbon\Carbon::parse($row->transaction_date)->format('l F Y')  }}</td>
                                            <td>
                                                @if ($row->transaction_status_id == "VERIFIED")
                                                    <span class="badge badge-success">Verified</span>
                                                @elseif ($row->transaction_status_id == "PROCESS")
                                                    <span class="badge badge-primary">Process</span>
                                                @elseif ($row->transaction_status_id == "UNVERIFIED")
                                                    <span class="badge badge-warning">Unverified</span>
                                                @else
                                                    <span class="badge badge-danger">Cancel</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    <tr class="item-align-center">
                                        <td colspan="6" class="text-center">Data tidak ada</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $dataDonatur->links('pagination.page') }}
                </div>
            </div>
		</div>
        
    </div>
    
</div>

@push('modal-scripts')
<script>
    function filter(val) {
		if(val == 'BULANAN') {
            $('#monthly').show();
            $('#weekly').hide();
            $('#collapseWeekly').removeClass('show');
            $('#daily').hide();
            $('#collapseDaily').removeClass('show');
        } else if (val == 'MINGGUAN') {
            $('#monthly').hide();
            $('#weekly').show();
            $('#collapseWeekly').addClass('show');
            $('#daily').hide();
            $('#collapseDaily').removeClass('show');
        } else if (val == 'HARIAN') {
            $('#monthly').hide();
            $('#weekly').hide();
            $('#collapseWeekly').removeClass('show');
            $('#daily').show();
            $('#collapseDaily').addClass('show');
        } else {
            $('#monthly').show();
            $('#weekly').show();
            $('#daily').show();
        }
	}

    Highcharts.chart('statistik', {
           chart: {
               type: 'column'
           },
           title: {
               text: ''
           },
           subtitle: {
               text: ''
           },
           xAxis: {
               categories: [
                   'Jan',
                   'Feb',
                   'Mar',
                   'Apr',
                   'Mei',
                   'Jun',
                   'Jul',
                   'Agu',
                   'Sep',
                   'Okt',
                   'Nov',
                   'Des'
               ],
               crosshair: true
           },
           yAxis: {
               min: 0,
               title: {
                   text: 'Rupiah'
               }
           },
           tooltip: {
               headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
               pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                   '<td style="padding:0"><b>Rp {point.y}</b></td></tr>',
               footerFormat: '</table>',
               shared: true,
               useHTML: true
           },
           plotOptions: {
               column: {
                   pointPadding: 0.2,
                   borderWidth: 0
               }
           },
           series: [{
               name: 'Prospek Donasi',
               data: {!! $chartUnverified !!},
               color: '#0168fa'
 
           }, {
               name: 'Donasi Diterima',
               data: {!! $chartVerified !!},
               color: '#008000'
 
           }]
    });

    Highcharts.chart('statistikWeekly', {
           chart: {
               type: 'column'
           },
           title: {
               text: ''
           },
           subtitle: {
               text: ''
           },
           xAxis: {
               categories: [
                   'Senin',
                   'Selasa',
                   'Rabu',
                   'Kamis',
                   'Jumat',
                   'Sabtu',
                   'Minggu'
               ],
               crosshair: true
           },
           yAxis: {
               min: 0,
               title: {
                   text: 'Rupiah'
               }
           },
           tooltip: {
               headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
               pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                   '<td style="padding:0"><b>Rp {point.y}</b></td></tr>',
               footerFormat: '</table>',
               shared: true,
               useHTML: true
           },
           plotOptions: {
               column: {
                   pointPadding: 0.2,
                   borderWidth: 0
               }
           },
           series: [{
               name: 'Prospek Donasi',
               data: {!! $chartUnverifiedWeekly !!},
               color: '#0168fa'
 
           }, {
               name: 'Donasi Diterima',
               data: {!! $chartVerifiedWeekly !!},
               color: '#008000'
 
           }]
       });
</script>
@endpush

@endsection