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
<!-- Captions start -->
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Kelola Data User</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Setting</li>
                    <li class="breadcrumb-item">Manage User</li>
                    <li class="breadcrumb-item active"><a href="">Tambah</a></li>
                </ol>
            </div>
        </div>
    </div>
    
</div>
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
    <div class="content-body"><!-- Basic form layout section start -->
        <section id="horizontal-form-layouts">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
								<form action="{{ route('users.store') }}" method="POST" class="form form-horizontal">
                                    @csrf
                                    <div class="form-body">
                                        <div class="form-group row">
                                            <label class="col-md-2" for="name">Nama Lengkap</label>
                                            <div class="col-md-10">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama Lengkap" >
                                            </div>
                                        </div>
                                
                                        <div class="form-group row">
                                            <label class="col-md-2" for="email">Email</label>
                                            <div class="col-md-10">
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                
                                        <div class="form-group row">
                                            <label class="col-md-2" for="projectinput4">Password</label>
                                            <div class="col-md-10">
                                                <input type="password" id="password" class="form-control" placeholder="Password" name="password">
                                            </div>
                                        </div>
                                
                                        <div class="form-group row">
                                            <label class="col-md-2" for="confirm-password">Konfirmasi Password</label>
                                            <div class="col-md-10">
                                                <input type="password" id="confirm-password" class="form-control" placeholder="Konfirmasi Password" name="confirm-password">
                                            </div>
                                        </div>
                                
                                        <div class="form-group row">
                                            <label class="col-md-2" for="projectinput6">Role</label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="roles" id="roles" required>
                                                    <option value="">Pilih Nama Role</option>
                                                    @foreach ($roles as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="form-actions">
                                        <button type="button" class="btn btn-warning mr-1 round">
                                           Kembali
                                        </button>
                                        <button type="submit" class="btn btn-danger round">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic form layout section end -->
    </div>
@endsection