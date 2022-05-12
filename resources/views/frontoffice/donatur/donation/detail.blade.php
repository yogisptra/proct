
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
                <div class="d-flex align-items-center">
                    <div class="position-relative bg-skeleton w-22 h-18 rounded-xs overflow-hidden shadow">
                        <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $data->hasCampaign->image) }}" alt="{{ $data->hasCampaign->title }}">
                    </div>
                    <div class="ps-2 flex-1 text-xs">
                        @if($data->hasCampaign->hasUser->type_campaigner == 'PERSONAL')
                        <div class="d-flex align-items-center"><span class="h-4_5 d-block text-gray line-clamp-1">{{ $data->hasUser->name }}</span><i class="ms-1 mt-n0_25 text-primary rck ryd-verified-simple"></i>
                        </div>
                        @else
                        <div class="d-flex align-items-center"><span class="h-4_5 d-block text-gray line-clamp-1">{{ $data->hasUser->hasCorporate->corporate_name ?? '-' }}</span><i class="ms-1 mt-n0_25 text-primary rck ryd-verified-simple"></i>
                        </div>
                        @endif
                        <p class="text-base fw-medium line-clamp-2 h-9 mt-2" title="{{ $data->hasCampaign->title }}">{{ $data->hasCampaign->title }}</p>
                    </div>
                </div>
                <div class="border border-gray-light rounded-xs py-3 px-4 mt-6">
                    @if($data->transaction_status_id == 'VERIFIED')
                    <div class="badge text-success bg-success bg-opacity-15">Berhasil</div>
                    @elseif($data->transaction_status_id == 'UNVERIFIED')
                    <div class="badge text-warning bg-warning bg-opacity-15">Diproses</div>
                    @else
                    <div class="badge text-danger bg-danger bg-opacity-15">Dibatalkan</div>
                    @endif
                    <div class="border-bottom border-gray-light py-4"><span>No Invoice </span>
                        <div class="d-flex align-items-center justify-content-between mt-1"><span class="fw-medium text-base">{{ $data->transaction_number }} </span><span class="text-xs">{{ \Carbon\Carbon::parse($data->transaction_date)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="border-bottom border-gray-light py-4"><span>Kategori</span>
                        <div class="mt-1"><span class="fw-medium text-base">{{ $data->hasCampaign->hasCategory->name }}</span>
                        </div>
                    </div>
                    <div class="border-bottom border-gray-light py-4"><span>Pembayaran</span>
                        <div class="d-flex align-items-center mt-1">
                            <img class="object-cover h-4 w-6 rounded-xxs me-2" src="{{ asset('assets/images/bank/'. $data->hasBankAccount->hasBank->image) }}" alt="{{ $data->hasBankAccount->hasBank->name }} Logo">
                            @if($data->hasBankAccount->type == 'VA')
                            <span class="fw-medium text-base">Virtual Account {{ $data->hasBankAccount->hasBank->name }}</span>
                            @elseif($data->hasBankAccount->type == 'TF')
                            <span class="fw-medium text-base">Bank Transfer {{ $data->hasBankAccount->hasBank->name }}</span>
                            @elseif($data->hasBankAccount->type == 'EW')
                            <span class="fw-medium text-base">Dompet Digital {{ $data->hasBankAccount->hasBank->name }}</span>
                            @elseif($data->hasBankAccount->type == 'CC')
                            <span class="fw-medium text-base">Kartu Kredit {{ $data->hasBankAccount->hasBank->name }}</span>
                            @else
                            <span class="fw-medium text-base">Retail Outlet {{ $data->hasBankAccount->hasBank->name }}</span>
                            @endif
                        </div>
                        @if($data->hasBankAccount->type == 'TF')
                        <div class="d-flex align-items-center justify-content-between mt-2"><span class="fw-medium" id="accountNo">23267422332</span>
                            <button class="ctc link-primary fw-medium" data-clipboard-target="#accountNo">Salin</button>
                        </div>
                        @endif
                    </div>
                    <div class="border-bottom border-gray-light py-4"><span>Pemilik Rekening</span>
                        <div class="mt-1"><span class="fw-medium text-base">{{ $data->hasBankAccount->account_name }}</span>
                        </div>
                    </div>
                    <div class="border-bottom border-gray-light py-4"><span>Nominal Donasi</span>
                        <div class="mt-1"><span class="fw-medium text-secondary rp ns">{{ $data->amount + $data->unique_code }}</span>
                        </div>
                    </div>
                    <div class="py-4"><span>Doa Untuk Penerima Donasi</span>
                        <div class="mt-1"><span class="text-base">{{ $data->note }}</span>
                        </div>
                    </div>
                </div>
                @if($data->transaction_status_id == 'CANCEL')
                <div class="bg-danger bg-opacity-15 rounded rounded-xs p-3 mt-6">
                    <p>Donasi telah dibatalkan dikarenakan .... Jika terjadi kendala, silahkan <a href="https://wa.me/{{ $kontak }}" target="_blank">hubungi kami</a>.</p>
                </div>
                @endif
                @if($data->transaction_status_id == 'UNVERIFIED')
                <div class="bg-warning bg-opacity-15 rounded rounded-xs p-3 mt-6">
                    <p>Silahkan lakukan pembayaran sebelum <strong>{{ \Carbon\Carbon::parse($data->transaction_date)->addDays(2)->format('d F Y, H:i') }} WIB</strong>  <a href="https://wa.me/{{ $kontak }}" target="_blank">hubungi kami</a>.</p>
                </div>
                <a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="{{ route('dashboard-confirmation_manual') }}"> <span>Konfirmasi Pembayaran</span>
                </a>
                @endif

                <!-- IF: Jika status transaksi = Konfirmasi Ulang
                <div class="bg-warning bg-opacity-15 rounded rounded-xs p-3 mt-6">
                    <p>Konfirmasi anda tidak sesuai. Silahkan lakukan konfirmasi ulang atau <a href="https://wa.me/{{ $kontak }}" target="_blank">hubungi kami</a>.</p>
                </div>
                <a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="confirmation.html"> <span>Konfirmasi Ulang</span>
                </a>
                END IF: Jika status transaksi = Konfirmasi Ulang-->
                <a class="link-btn link-btn-primary-o h-12 w-full mt-4 rounded-xs fw-medium" href="{{ route('frontoffice.campaignList') }}"> <span>Lihat Campaign Lainnya</span><i class="text-default ms-2 rck ryd-arrow-right"></i>
                </a>
            </div>
        </section>
    </main>
@endsection

@section('bottom-resource')
<!-- WARNING! this scripts below used for this page only-->
<script src="{{ asset('frontoffice/assets/js/clipboard.init.js') }}"></script>
@endsection