
@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/select2.min.css') }}">
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <form action="{{ @$data->id ? route('update-bank-campaigner', @$data->id) : route('store-bank-campaigner') }}" method="POST" class="form form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="{{ @$data->id ? 'PUT' : 'POST'}}">
                    <div>
                        <label class="user-select-none text-xs fw-medium mb-2">Nama Pemilik Rekening
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-user {{ $errors->has('account_name') ? 'text-danger' : 'text-primary' }}"></i>
                            <input class="input ps-12" name="account_name" type="text" placeholder="Nama Pemilik Rekening" value="{{ @$data->account_name ?? old('account_name') }}" required>
                        </div>
                        @if ($errors->has('account_name'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('account_name') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Nama Bank
                        </label>
                        <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('name') ? 'text-danger' : 'text-primary' }}"></i>
                            <select class="select-with-search" name="bank_id" required>
                                <option selected disabled>Pilih Bank</option>
                                @foreach ($bank as $row)
                                <option value="{{ $row->id }}" {{ @$data->bank_id == $row->id ? 'selected' : "" }}>{{ $row->name }}</option>
                                @endforeach>
                            </select>
                        </div>
                        @if ($errors->has('bank_id'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('bank_id') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Nomor Rekening
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-wallet {{ $errors->has('account_number') ? 'text-danger' : 'text-primary' }}"></i>
                            <input class="input ps-12" name="account_number" type="number" placeholder="10*****" value="{{ @$data->account_number ?? old('account_number') }}" required>
                        </div>
                        @if ($errors->has('account_number'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('account_number') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Cabang Pembukaan
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-bank {{ $errors->has('description') ? 'text-danger' : 'text-primary' }}"></i>
                            <input class="input ps-12" name="description" type="text" placeholder="Bandung" value="{{ @$data->description ?? old('description') }}" required>
                        </div>
                        @if ($errors->has('description'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <button class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" type="submit"><span>Simpan</span>
                    </button>
                </form>
            </div>
        </section>
    </main>
@endsection

@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/vendor/select2.full.min.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/select2.set.js') }}"></script>
@endsection