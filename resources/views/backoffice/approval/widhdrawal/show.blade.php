@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Data Pencairan</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Approval</li>
                    <li class="breadcrumb-item">Data Pencairan</li>
                    <li class="breadcrumb-item active"  > <a href="">Detail</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
            <a href="{{ route('widhdrawal-approval.index') }}" type="button" class="btn btn-danger mr-1 round">
                Kembali
            </a>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-xl-4 col-md-6 col-12">
            <div class="card profile-card-with-stats">
                <div class="text-center">
                    <div class="card-body">
                        <img src="{{ ($data->hasCampaign) ? asset('assets/images/campaign/'.$data->hasCampaign->image) : asset('backoffice/app-assets/images/portrait/small/avatar-s-1.png') }}" class="rounded-circle  height-150" alt="Card image">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $data->hasCampaign->title }}</h4>
                        <ul class="list-inline list-inline-pipe">
                            <li>{{ $data->hasUser->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-header">
                        <h4 class="card-title" id="horz-layout-card-center">Data Pencairan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Campaign</label>
                                                    <div class="col-lg-9">
                                                       : <span>{{ $data->hasCampaign->title }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Nominal</label>
                                                    <div class="col-lg-9">
                                                       : <span>Rp{{ number_format($data->amount,0,'.','.') }},-</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Diajaukan oleh</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasUser->name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">No. Rek pengajuan</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasBankAccount->hasBank->name }} - {{ $data->hasBankAccount->account_number }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Pengajuan</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ \Carbon\Carbon::parse($data->request_date)->format('l F Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($data->status == 'VERIFIED')
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Pengajuan disetujui</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ \Carbon\Carbon::parse($data->approval_date)->format('l F Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Status Pencairan</label>
                                                    <div class="col-lg-9">
                                                        @if ($data->status == 'VERIFIED')
                                                            : <span class="badge badge-success">Terverifikasi</span>
                                                        @elseif($data->status == 'UNVERIFIED')
                                                            : <span class="badge badge-warning">Belum Terverifikasi</span>
                                                        @else
                                                            : <span class="badge badge-danger">Tidak Terverifikasi</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Keterangan</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->description ?? 0 }}</span>
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
    </div>
</div>

@endsection