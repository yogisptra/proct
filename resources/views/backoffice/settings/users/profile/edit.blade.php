@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Edit Profile</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Profile</li>
                    <li class="breadcrumb-item active"  > <a href="">Edit Profile</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <form class="form form-horizontal" action="{{ route('sysprofile.update', $user->id) }}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        @method('PUT')  
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="userinput1">Nama</label>
                                                        <input type="text" class="form-control" placeholder="Nama" value="{{ $user->name }}" name="name">
                                                        @if ($errors->has('name'))
                                                            <small style="color: red;">{{ $errors->first('name') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="userinput2">Email</label>
                                                        <input type="email" class="form-control" placeholder="Email" value="{{ $user->email }}" name="email">
                                                        @if ($errors->has('email'))
                                                            <small style="color: red;">{{ $errors->first('email') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="userinput3">No. Telp</label>
                                                        <input type="text" class="form-control" placeholder="No. Telp" value="{{ $user->phone_number }}" name="phone_number">
                                                        @if ($errors->has('phone_number'))
                                                            <small style="color: red;">{{ $errors->first('phone_number') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="userinput4">Jenis Kelamin</label>
                                                        <select class="form-control" name="gender" id="gender">
                                                            <option value="">Pilih Jenis Kelamin</option>
                                                            <option value="L" {{ $user->gender == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                                            <option value="P" {{ $user->gender == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                            @if ($errors->has('gender'))
                                                                <small style="color: red;">{{ $errors->first('gender') }}</small>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <div class="form-group">
                                                <label for="userinput8">Alamat</label>
                                                <textarea rows="5" class="form-control" name="address" placeholder="Alamat">{{ $user->address }}</textarea>
                                                @if ($errors->has('address'))
                                                    <small style="color: red;">{{ $errors->first('address') }}</small>
                                                @endif
                                            </div>
                                    
                                            <div class="form-group">
                                                <label for="userinput5">Gambar</label>
                                                <input type="file" name="image" class="form-control"
                                                                value="{{ old('image') }}">
                                                @if ($errors->has('image'))
                                                    <small style="color: red;">{{ $errors->first('image') }}</small>
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