@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- Vendor style -->
<link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/select2.min.css') }}">
@endsection

@section('content')

    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="javascript:history.go(-1)" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">Cairkan Dana</span>
                </div>
                <div class="navbar__right d-flex align-items-center"></div>
            </div>
        </div>
    </nav>

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                @if(Session::has('error'))
                <div class="bg-danger bg-opacity-15 rounded rounded-xs p-3 mb-4">
                    <p>{{Session::get('error')}}</p>
                </div>
                @endif
                <form action="{{ route('dashboard-widhdrawal-store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $data->id }}">
                    <input type="hidden" name="collected" id="collected" value="{{ number_format($data->collected,0,'.','.') }}">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="user-select-none text-xs fw-medium mb-2" style="margin-bottom: 0 !important;">Jumlah Pencairan
                            </label><span class="cursor-pointer text-xs" id="withdrawAll">Cairkan semua: <span class="link-primary fw-medium rp ns" id="allBalance">{{ $data->collected }}</span></span>
                        </div>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-rp text-2xl text-primary" style="top: 0.6875rem !important;"></i>
                            <input class="input ps-12 text-end fw-bold text-primary text-default py-2_25" onkeyup="myAmount(this.value)" name="amount" type="text" placeholder="50.000" inputmode="numeric" data-type="currency" id="withdrawNom" value="{{ old('amount') }}">
                        </div>
                        @if ($errors->has('amount'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('amount') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="user-select-none text-xs fw-medium mb-2" style="margin-bottom: 0 !important;">Rekening Tujuan
                            </label><a class="cursor-pointer text-primary fw-medium d-flex align-items-center user-select-none" href="{{ route('bank-campaigner') }}"><i class="rck ryd-edit text-xl"></i><span class="ms-0_5">Atur Rekening</span></a>
                        </div>
                        <div class="position-relative"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 text-primary"></i>
                            <select class="select-with-search" name="bank_account_id">
                                <option value="" selected disabled>Pilih Rekening</option>
                                @foreach($bank as $row)
                                <option value="{{ $row->id }}">{{ $row->hasBank->name }} - {{ $row->account_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('bank_account_id'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('bank_account_id') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Tujuan Pencairan
                        </label>
                        <div class="position-relative">
                            <textarea class="input" name="description" placeholder="Contoh: Penyaluran tahap 1">{{ old('description') }}</textarea>
                        </div>
                        @if ($errors->has('description'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="bg-warning bg-opacity-15 rounded-xs py-3 px-4 mt-8"><strong>Perhatian: </strong>Proses pencairan memakan waktu 3 hari kerja</div>
                    <button class="link-btn link-btn-primary h-12 w-full mt-4 rounded-xs fw-medium btnWidhdraw" type="submit"><span>Cairkan Dana</span>
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
    <script>
        $('#withdrawAll').click(function() {
            const allBalance = $('#allBalance').text()
            $('#withdrawNom').val(allBalance)
        })

        function myAmount(val){
            const allBalance = $('#collected').val();
            const totalBalance = allBalance.split('.').join("")
            console.log(totalBalance)
            const amount = val.split('.').join("")
            if(parseInt(amount) < parseInt(50000) ){
                $('.btnWidhdraw').hide();
            }else if(parseInt(amount) > totalBalance) {
                $('.btnWidhdraw').hide();
            } else if(parseInt(amount) == totalBalance) {
                $('.btnWidhdraw').show();
            } else {
                $('.btnWidhdraw').show();
            }
        }

    </script>
@endsection