@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <div class="bg-warning bg-opacity-15 rounded-xs p-3">
                    <p><strong class="text-warning">PENTING: </strong>Silahkan transfer sesuai nominal dibawah ini hingga digit terakhir agar proses verifikasi lebih mudah</p>
                </div>
                <div class="d-flex align-items-center justify-content-between pb-4 mt-4_5 border-bottom border-gray-light">
                    <div class="rp text-xxl fw-bold text-primary"><span class="ns">{{number_format($data->amount + $data->unique_code,0,'.','.')}}</span>
                    </div>
                    <button class="ctc link-primary text-end fw-medium" data-clipboard-text="{{number_format($data->amount + $data->unique_code,0,'.','.')}}">Salin Nominal</button>
                </div>
                <div class="my-12">
                    <!-- Format set tanggal berakhir: (TAHUN)-(BULAN)-(TANGGAL)T(JAM):(MENIT):(DETIK)+0700-->
                    <!-- Contoh: 2022-01-12T11:00:00+0700-->
                    <time>{{ $time }}</time>
                </div>
                <p class="text-center">Transfer ke rekening di bawah ini , sebelum <strong class="text-base">{{ \Carbon\Carbon::parse($data->transaction_date)->addDays(2)->format('d F Y, H:i') }} WIB</strong> atau donasi anda akan otomatis dibatalkan sistem</p>
                <div class="mt-6">
                    <div><span>Nomor Invoice</span>
                        <div class="text-base text-default fw-bold">{{ $data->transaction_number }}</div>
                    </div>
                    @if($data->hasBankAccount->type == 'TF')
                    <div><span>No Rekening</span>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <div class="text-base text-default fw-bold" id="accountNumber">{{ $data->hasBankAccount->account_number }}</div>
                            <button class="ctc link-primary text-end fw-medium" data-clipboard-target="#accountNumber">Salin</button>
                        </div>
                    </div>
                    @endif
                    <div class="mt-2"><span>Nama Bank</span>
                        <div class="text-base text-default fw-bold">{{ $data->hasBankAccount->hasBank->name }}</div>
                    </div>
                    <div class="mt-2"><span>Pemilik Rekening</span>
                        <div class="text-base text-default fw-bold">{{ $data->hasBankAccount->account_name }}</div>
                    </div>
                    <div class="mt-4"><span>Status Pembayaran</span>
                        <div class="mt-1">
                            @if($data->transaction_status_id == 'UNVERIFIED')
                            <div class="badge text-warning bg-warning bg-opacity-15">Menunggu Pembayaran</div>
                            @elseif($data->transaction_status_id == 'VERIFIED')
                            <div class="badge text-success bg-success bg-opacity-15">Berhasil</div>
                            @elseif($data->transaction_status_id == 'CANCEL')
                            <div class="badge text-danger bg-danger bg-opacity-15">Dibatalkan</div>
                            @endif
                        </div>
                    </div>
                </div>
                <a class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" id="reloadPage">Cek Status Pembayaran</a>
            </div>
        </section>
    </main>

@endsection
@section('bottom-resource')

    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/clipboard.init.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/vendor/jquery.countdown.js') }}"></script>
    <script>
        //- $("#countdown").countdown("2017/01/01", function(event) {
          //-     $(this).text(
          //-         event.strftime('%D days %H:%M:%S')
          //-     );
          //- });
          
          window.jQuery(function ($) {
              "use strict";
          
              $('time').countDown({
                  with_separators: false
              });
          
              $('.label-dd').text('hari')
          });

          $('#reloadPage').click(function() {
                location.reload();
            });
    </script>
    
@endsection