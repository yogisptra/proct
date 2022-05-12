@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Reset Password</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Profile</li>
                    <li class="breadcrumb-item active"  > <a href="">Reset Password</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
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

            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <form class="form form-horizontal" action="{{ route('sysprofile.change-password', $user->id) }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('PUT')  
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label for="userinput8">Password Baru</label>
                                                <input type="password" rows="5" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password Baru">
                                                @if ($errors->has('password'))
                                                    <small style="color: red;">{{ $errors->first('password') }}</small>
                                                @endif
                                            </div>
                                    
                                            <div class="form-group">
                                                <label for="userinput2">Konfirmasi Password Baru</label>
                                                <input type="password" class="form-control" placeholder="Konfirmasi Password Baru" value="{{ old('confirm_password') }}" name="confirm_password">
                                                @if ($errors->has('confirm_password'))
                                                    <small style="color: red;">{{ $errors->first('confirm_password') }}</small>
                                                @endif
                                            </div>
                                    
                                            <div class="form-actions left">
                                                <button type="button" class="btn btn-warning mr-1 round">
                                                  Kembali
                                                </button>
                                                <button type="submit" class="btn btn-danger round">
                                                  Simpan
                                                </button>
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