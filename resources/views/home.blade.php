@extends('backoffice.layouts.master')
@section('content')

<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Dashboard</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active"  > <a href="">Statistik</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <!--data stats-->
    <div class="row">
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="danger">Rp{{number_format($summary['sum-verified-transaction'],0,'.','.')}},-</h3>
                                <span>Total Donasi Diterima</span>
                            </div>
                            <div class="align-self-center">
                                <i class="icon-wallet danger font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="success">
                                    <h3 class="success">Rp{{number_format($summary['sum-unverified-transaction'],0,'.','.')}},-</h3>
                                <span>Total Prospek Donasi</span>
                            </div>
                            <div class="align-self-center">
                                <i class="icon-graph success font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="warning">Rp{{number_format($summary['sum-cancel-transaction'],0,'.','.')}},-</h3>
                                <span>Jumlah Dibatalkan</span>
                            </div>
                            <div class="align-self-center">
                                <i class="icon-graph warning font-large-2 float-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--data stats-->  

    <!-- statistik charts -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Statistik Donasi</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body"> 
                        <div id="container" class="height-350" style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>      
    <!-- end statistik charts --> 
</div>
@endsection

@push('modal-scripts')
<script>
    Highcharts.chart('container', {
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
                  'May',
                  'Jun',
                  'Jul',
                  'Aug',
                  'Sep',
                  'Oct',
                  'Nov',
                  'Dec'
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
              name: 'Sukses',
              data: {{ $verifiedTransaction }},
              color: '#0168fa'

          }, {
              name: 'Batal',
              data: {{ $cancelTransaction }},
              color: '#f10075'

          }]
    });

</script>
@endpush

