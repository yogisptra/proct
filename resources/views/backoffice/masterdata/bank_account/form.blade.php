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
        <h3 class="content-header-title">Kelola Data Akun Bank</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item">Akun Bank</li>
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
                            <form action="{{ @$data->id ? route('bank_accounts.update', @$data->id) : route('bank_accounts.store') }}" method="POST" class="form form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="{{ @$data->id ? 'PUT' : 'POST'}}">
                                <div class="form-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Bank<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="bank_id" id="bank_id" required>
                                                    <option value="">Pilih Bank</option>
                                                    @foreach ($bank as $row)
                                                    <option value="{{ $row->id }}" {{ @$data->bank_id == $row->id ? 'selected' : "" }}>{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('bank_id'))
                                                    <small style="color: red;">{{ $errors->first('bank_id') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2" for="type">Tipe<small style="color: red;">*</small></label>
                                        <div class="col-md-10" id="error">
                                            <select class="form-control type2" name="type" id="type" required>
                                                <option value="">Pilih Tipe</option>
                                                <option value="TF" {{ @$data->type == 'TF' ? 'selected' : "" }}>Bank Transfer</option>
                                                <option value="VA" {{ @$data->type == 'VA' ? 'selected' : "" }}>Akun Virtual</option>
                                                <option value="EW" {{ @$data->type == 'EW' ? 'selected' : "" }}>Dompet Digital</option>
                                                <option value="CC" {{ @$data->type == 'CC' ? 'selected' : "" }}>Kartu Kredit</option>
                                                <option value="RT" {{ @$data->type == 'RT' ? 'selected' : "" }}>Retail Outlet</option>
                                            </select>
                                            @if ($errors->has('type'))
                                                <small style="color: red;">{{ $errors->first('type') }}</small>
                                            @endif
                                        </div>
                                    </div>
                    
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Nama Akun<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <input type="text" name="account_name" value="{{ @$data->account_name ?? old('account_name') }}" id="account_name" class="form-control" placeholder="Nama Akun Bank" required>
                                                @if ($errors->has('account_name'))
                                                    <small style="color: red;">{{ $errors->first('account_name') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group {{ @$data->account_number ? '' : 'hidden'}}" id="accountNumber">
                                        <div class="row">
                                            <label class="col-lg-2">Nomor Akun<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <input type="number" name="account_number" value="{{ @$data->account_number ?? old('account_number') }}" id="account_number" class="form-control" placeholder="Nomor Akun Bank">
                                                @if ($errors->has('account_number'))
                                                    <small style="color: red;">{{ $errors->first('account_number') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Status</label>
                                            <div class="col-lg-10">
                                                <input type="checkbox" id="enabled" name="enabled" class="switchery" data-color="info" {{ @$data->enabled == 1 ? "checked" : "" }}/>
                                                @if ($errors->has('enabled'))
                                                    <small style="color: red;">{{ $errors->first('enabled') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-actions">
                                        <a href="{{ route('bank_accounts.index') }}" type="button" class="btn btn-warning mr-1 round">
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
@section('script')
<script>
    $( document ).ready(function() {
        // $("#accountNumber").hide();
        $("#type").change(function(){
            let data = $(this).val();
            if(data == 'TF') {
                $("#accountNumber").show();
                $('#accountNumber').removeClass('hidden')
                $("#account_number").attr("required", true);
            } else {
                $("#accountNumber").hide();
                $('#account_number').removeAttr('required');
            }
        });
    });
</script>
@endsection