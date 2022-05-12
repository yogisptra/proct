@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Kelola Data Campaign</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Report</li>
                    <li class="breadcrumb-item active">Data Campaign</li>
                    <li class="breadcrumb-item active"  > <a href="">Detail Campaign</a> </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
            <a href="{{ route('laporan-campaign.index') }}" type="button" class="btn btn-danger mr-1 round">
                Kembali
            </a>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box">
                                    <form class="form form-horizontal">
                                        <div class="form-body">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <img src="{{ asset('assets/images/campaign/'. $data->image) }}" class="img-thumbnail" width="100%">
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
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-header">
                        <h4 class="card-title" id="horz-layout-card-center">Data Campaign Donasi</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box">
                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Kategori</label>
                                                    <div class="col-lg-10">
                                                        <span>: {{ @$data->hasCategory->name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Campaigner</label>
                                                    <div class="col-lg-10">
                                                        <span>: {{ @$data->hasUser->name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Judul</label>
                                                    <div class="col-lg-10">
                                                        <span>: {{ $data->title }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">URL</label>
                                                    <div class="col-lg-10">
                                                        <span>: <a target="_blank" href="{{ config('app.url')}}/detail/{{ $data->slug ? ($data->slug) : '-' }}">{{ config('app.url') }}/detail/{{ $data->slug ? ($data->slug) : '-' }}</a> </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Target</label>
                                                    <div class="col-lg-10">
                                                        @if ($data->open_goal == 1)
                                                            : <span class="badge badge-success">Open Goal</span>
                                                        @else
                                                            : <span>Rp {{ number_format($data->target,0,'.','.') }},</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Terkumpul</label>
                                                    <div class="col-lg-10">
                                                            : <span>Rp {{ number_format($data->collected,0,'.','.') }},</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Sisa Hari</label>
                                                    <div class="col-lg-10">
                                                        @if ($data->open_goal == 1)
                                                            : <img src="{{ asset('backoffice/app-assets/images/logo/logo-dark-sm.png') }}" width="30px" alt="">
                                                        @else
                                                            : <span>{{ $data->selisih_validate }} Hari</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Donasi Pilihan</label>
                                                    <div class="col-lg-10">
                                                        @if ($data->main_program == 1)
                                                            : <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            : <span class="badge badge-danger">Tidak Aktif</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Status</label>
                                                    <div class="col-lg-10">
                                                        @if ($data->enabled == 1)
                                                            : <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            : <span class="badge badge-danger">Tidak Aktif</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Konten</label>
                                                    <div class="col-lg-10">
                                                        {!! $data->description !!}
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