@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Data Campaigner</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Approval</li>
                    <li class="breadcrumb-item">Data Campaigner</li>
                    <li class="breadcrumb-item active"  > <a href="">Detail</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
            <a href="{{ route('campaigner-approval.index') }}" type="button" class="btn btn-danger mr-1 round">
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
                        <img src="{{ ($data->image) ? asset('assets/images/donatur/'.$data->image) : asset('backoffice/app-assets/images/portrait/small/avatar-s-1.png') }}" class="rounded-circle  height-150" alt="Card image">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $data->name }}</h4>
                        <ul class="list-inline list-inline-pipe">
                            <li>{{ $data->email }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-header">
                        <h4 class="card-title" id="horz-layout-card-center">Data Campaigner</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Tipe Campaigner</label>
                                                    <div class="col-lg-9">
                                                        @if ($data->type_campaigner == 'PERSONAL')
                                                        : <span class="badge badge-success">Personal</span>
                                                        @else
                                                            : <span class="badge badge-success">Corporate</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">NIK</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->nik }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Nama Lengkap</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Email</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->email }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Nomor Telepon</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->phone_number }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Status Campaigner</label>
                                                    <div class="col-lg-9">
                                                        @if ($data->is_campaigner == 'VERIFIED')
                                                            : <span class="badge badge-success">Terverifikasi</span>
                                                        @else
                                                            : <span class="badge badge-danger">Tidak Terverifikasi</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Alamat</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->address }}, {{ $data->hasDistrict->name }}, {{ $data->hasArea->name }}, 
                                                            <br> {{ $data->hasCity->name }}, {{ $data->hasProvince->name }} {{ $data->codepos }} <span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Verifikasi KTP</label>
                                                    <div class="col-lg-9">
                                                        <img src="{{ asset('assets/image_ktp/donatur/ktp/'.$data->image_ktp) }}" width="200" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Foto Campaigner</label>
                                                    <div class="col-lg-9">
                                                        <img src="{{ asset('assets/image_selfie/donatur/ktp/'.$data->image_selfie) }}" width="200" />
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
@if($data->type_campaigner == 'CORPORATE')
<div class="content-body">
    <div class="row">
        <div class="col-xl-4 col-md-6 col-12">
            <div class="card profile-card-with-stats">
                <div class="text-center">
                    <div class="card-body">
                        <img src="{{ ($data->hasCorporate->image) ? asset('assets/images/corporate/'. $data->hasCorporate->image) : asset('backoffice/app-assets/images/portrait/small/avatar-s-1.png') }}" class="rounded-circle" width="100%" alt="Card image">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $data->hasCorporate->corporate_name }}</h4>
                        <ul class="list-inline list-inline-pipe">
                            <li>{{ $data->hasCorporate->corporate_email }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-header">
                        <h4 class="card-title" id="horz-layout-card-center">Data Corporate</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <form class="form form-horizontal">
                                        <div class="form-body">

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Nama Corporate</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->corporate_name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Email Corporate</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->corporate_email }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">No. Telepon Corporate</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->corporate_phone_number }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Alamat</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->corporate_address }}, {{ $data->hasCorporate->hasDistrict->name }}, {{ $data->hasCorporate->hasArea->name }}, 
                                                            <br> {{ $data->hasCorporate->hasCity->name }}, {{ $data->hasCorporate->hasProvince->name }} {{ $data->hasCorporate->corporate_codepos }} <span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">File Akta</label>
                                                    <div class="col-lg-9">
                                                        <img src="{{ asset('assets/file_akta/corporate/'.$data->hasCorporate->file_akta) }}" width="200" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">NIB</label>
                                                    <div class="col-lg-9">
                                                        <img src="{{ asset('assets/nib/corporate/'.$data->hasCorporate->nib) }}" width="200" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <hr>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">NIK Penanggung Jawab</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->nik_pic }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Nama Penanggung Jawab</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->name_pic }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Email Penanggung Jawab</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->email_pic }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">KTP Penanggung Jawab</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->ktp_pic }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Foto Penanggung Jawab</label>
                                                    <div class="col-lg-9">
                                                        : <span>{{ $data->hasCorporate->image_selfie_pic }}</span>
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
@endif

@endsection