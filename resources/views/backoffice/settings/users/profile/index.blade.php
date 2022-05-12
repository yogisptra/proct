@extends('backoffice.layouts.master')

@section('content')
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
        <h3 class="content-header-title">Profile User</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Profile</li>
                    <li class="breadcrumb-item active"  > <a href="">Profile User</a> </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
            <a href="{{ route('users.index') }}" type="button" class="btn btn-danger mr-1 round">
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
                        <img src="{{ (Auth::user()->image) ? asset('assets/images/admin/'.Auth::user()->image) : asset('backoffice/app-assets/images/portrait/small/avatar-s-1.png') }}" class="rounded-circle  height-150" alt="Card image">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $user->name }}</h4>
                        <ul class="list-inline list-inline-pipe">
                            <li>{{ $user->email }}</li>
                        </ul>
                    </div>
                    <div class="btn-group" role="group" aria-label="Profile example">
                      <!-- Html -->
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">Informasi Akun</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="box">
                                        <form class="form form-horizontal">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-3">Nama</label>
                                                        <div class="col-lg-9">
                                                            <span>: {{ $user->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-3">Email</label>
                                                        <div class="col-lg-9">
                                                            <span>: {{ $user->email }}</span>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-3">Nomor Telepon</label>
                                                        <div class="col-lg-9">
                                                            <span>: {{ $user->phone_number ? ($user->phone_number) : '-' }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-3">Jenis Kelamin</label>
                                                        <div class="col-lg-9">
                                                            <span>: {{ @$user->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-3">Alamat</label>
                                                        <div class="col-lg-9">
                                                            <span>: {{ $user->address ? ($user->address) : '-' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
        
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-lg-3">Status Akun</label>
                                                        <div class="col-lg-9">
                                                            @if ($user->enabled == 1)
                                                                : <span class="badge badge-success">Aktif</span>
                                                            @else
                                                                : <span class="badge badge-danger">Tidak Aktif</span>
                                                            @endif
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
</div>

@endsection
