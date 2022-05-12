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
        <h3 class="content-header-title">Kelola Data Transaksi Tipe</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item">Transaksi Tipe</li>
                    <li class="breadcrumb-item active"  > <a href="">{{ @$data ? 'Ubah' : 'Tambah' }}</a> </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <!-- Basic form layout section start -->
    <section id="horizontal-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form action="{{ @$data->id ? route('transaction_types.update', @$data->id) : route('transaction_types.store') }}" method="POST" class="form form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="{{ @$data->id ? 'PUT' : 'POST'}}">
                                <div class="form-body">
                    
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Nama<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <input type="text" name="name" value="{{ @$data->name ?? old('name') }}" id="name" class="form-control" placeholder="Nama Kategori" required>
                                                @if ($errors->has('name'))
                                                    <small style="color: red;">{{ $errors->first('name') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Keterangan</label>
                                            <div class="col-lg-10">
                                                <textarea name="description" id="description" class="form-control" rows="3">{{ @$data->description ?? old('description') }}</textarea>
                                                @if ($errors->has('description'))
                                                    <small style="color: red;">{{ $errors->first('description') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Status</label>
                                            <div class="col-lg-10">
                                                <!--<input type="text" name="enabled" id="enabled" class="form-control" placeholder="Enabled" required>-->
                                                <input type="checkbox" id="enabled" name="enabled" class="switchery" data-color="info" {{ @$data->enabled == 1 ? "checked" : "" }}/>
                                                @if ($errors->has('enabled'))
                                                    <small style="color: red;">{{ $errors->first('enabled') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-actions">
                                        <a href="{{ route('transaction_types.index') }}" type="button" class="btn btn-warning mr-1 round">
                                            Kembali
                                        </a>
                                        <button type="submit" class="btn btn-danger round">
                                            {{ @$data->id ? 'Ubah' : 'Simpan'}}
                                        </button>
                                    </div>
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