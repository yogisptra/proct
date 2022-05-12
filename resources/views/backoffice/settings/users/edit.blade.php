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
                    <li class="breadcrumb-item active"><a href="">Ubah</a></li>
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
								<form action="{{ route('users.update',  @$user->id) }}" method="POST" class="form form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-body">   
                                        <input type="hidden" name="id" value="{{ $user->id }}" id="id_data">
                                        <div class="form-group row">
                                            <label class="col-md-2" for="name">Name</label>
                                            <div class="col-md-10">
                                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
                                                @if ($errors->has('name'))
                                                    <small style="color: red;">{{ $errors->first('name') }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2" for="email">E-mail</label>
                                            <div class="col-md-10">
                                                <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control">
                                                @if ($errors->has('email'))
                                                    <small style="color: red;">{{ $errors->first('email') }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2" for="projectinput6">Role</label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="roles" id="roles" required>
                                                    <option value="">Pilih Nama Role</option>
                                                    @if($user->id == '2020151101001')
                                                        <option value="{{ $roles->first()->id }}"{{ $userRole->role_id == $roles->first()->id ? 'selected' : "" }}>{{ $roles->first()->name }}</option>
                                                    @else
                                                        @foreach ($roleWithoutSuperAdmin as $row)
                                                            @if($userRole == null)
                                                                <option value="{{$row->id}}">{{$row->name}}</option>
                                                            @else
                                                                <option value="{{$row->id}}"{{ $userRole->role_id == $row->id ? 'selected' : "" }}>{{$row->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('roles'))
                                                    <small style="color: red;">{{ $errors->first('roles') }}</small>
                                                @endif
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