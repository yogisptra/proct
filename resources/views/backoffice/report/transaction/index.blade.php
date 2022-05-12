@extends('backoffice.layouts.master')

@section('content')
<!-- Captions start -->
<style>
    @media (min-width: 800px) {
    /* Styles */
        .inputsearch{
            width: 400px;
        }
    }
</style>
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Laporan Data Transaksi</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active"  > <a href="">Data Transaksi</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Content -->
    <div class="row">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="fa fa-thumbs-o-up"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Sukses!</strong> {{ $message }}.
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="fa fa-exclamation-triangle"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Gagal!</strong> {{ $message }}.
                </div>
            @endif

            @if ($message = Session::get('info'))
                <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="fa fa-exclamation"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Informasi!</strong> {{ $message }}.
                </div>
            @endif

            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12">
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
                <div class="col-xl-3 col-lg-6 col-12">
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
        
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="info">Rp{{number_format($summaryToday['sum-verified-transaction'],0,'.','.')}},-</h3>
                                        <span>Donasi Hari Ini</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-wallet info font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="warning">Rp{{number_format($summaryToday['sum-unverified-transaction'],0,'.','.')}},-</h3>
                                        <span>Prospek Donasi Hari Ini</span>
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

            <div class="card mt-2">
                <div class="card-header">
                    <h4 class="card-title">Laporan Transaksi</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Campaign</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">No. Telp</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($data as $key => $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->hasCampaignList->title }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->phone_number }}</td>
                                            <td>Rp{{ number_format($row->amount+$row->unique_code,0,'.','.') }},-</td>
                                            <td>
												@if ($row->transaction_status_id == 'VERIFIED')
												    <span class="badge badge-success">Verified</span>
												@elseif ($row->transaction_status_id == 'UNVERIFIED')
                                                    <span class="badge badge-warning">Unverified</span>
                                                @else
												    <span class="badge badge-danger">Cancel</span>
												@endif
											</td>
                                            <td>
                                                <a href="{{ route('laporan-transaction.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail Program">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty 
                                    <tr class="item-align-center">
                                        <td colspan="8" class="text-center">Data tidak ada</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $data->links('pagination.page') }}
            </div>
        </div>
    </div>
</div> 

@endsection
