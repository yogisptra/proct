@extends('frontoffice.layouts.dashboard-corporate')

@section('content')
<!-- NAVBAR-->
<nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
    <div class="container">
        <div class="h-18 d-flex justify-content-between align-items-center position-relative">
            <div class="navbar__left d-flex align-items-center"><a class="link-base me-4" href="javascript:history.go(-1)" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">{{ @$title }}</span>
            </div>
            <div class="navbar__right d-flex align-items-center"></div>
        </div>
    </div>
</nav>
<nav class="position-fixed bottom-4 left-0 w-full z-500">
    <div class="container h-full">
        <div class="shadow-drop rounded-full bg-white h-16 px-4">
            <ul class="d-flex h-full align-items-center justify-content-around">
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="/"><i class="d-block text-xl rck ryd-home"></i><span class="text-xxs">Beranda</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="{{ route('onboard-campaign') }}"><i class="d-block text-xl rck ryd-campaign"></i><span class="text-xxs">Galang Dana</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="{{ route('dashboard-myDonation) }}"><i class="d-block text-xl rck ryd-history"></i><span class="text-xxs">Riwayat</span></a>
                </li>
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-primary" href="{{ route('dashboard-users') }}"><i class="d-block text-xl rck ryd-profile"></i><span class="text-xxs">Akun</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="mt-18">
    <section class="maxview align-items-start bg-white pt-6 pb-30">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ route('setting-campaignerPersonal', Auth::guard('member')->user()->encodeHash(Auth::guard('member')->user()->id)) }}">
                    <div class="bg-skeleton overflow-hidden w-18 w-ss-20_5 h-18 h-ss-20_5 rounded-circle shadow">
                        <img class="w-full h-full object-cover" src="{{ Auth::guard('member')->user()->image ? asset('assets/images/donatur/'. Auth::guard('member')->user()->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="User Picture">
                    </div>
                </a>
                <div class="ps-3 ps-ss-4 flex-1">
                    <div class="d-flex align-items-center">
                        <p class="text-base text-default text-ss-xl fw-medium line-clamp-1">{{ Auth::guard('member')->user()->name }}</p>
                        <i class="ms-1 text-primary rck ryd-verified-simple"></i>
                    </div>
                    <p class="text-xs text-ss-sm line-clamp-1">{{ Auth::guard('member')->user()->email }}</p>
                    @if(Auth::guard('member')->user()->is_campaigner == NULL)
                        <span class="badge bg-warning min-w-24_5 mt-2 mt-ss-3">Donatur</span>
                    @elseif(Auth::guard('member')->user()->is_campaigner == 'UNVERIFIED')
                        <span class="badge bg-warning min-w-24_5 mt-2 mt-ss-3">Donatur</span>
                    @else
                        <span class="badge bg-primary min-w-24_5 mt-2 mt-ss-3">Penggalang Dana</span>
                    @endif
                </div>
            </div>
            <div class="row mt-4 mt-ss-6 gy-3 gx-4">
                <div class="col-12 col-ss-6"><a class="d-block text-base-light py-3 px-4 rounded-xs shadow-drop" href="{{ route('list-campaign') }}"><i class="text-xl text-primary rck ryd-heart"></i><span class="d-block text-sm line-clamp-1 mt-2">Dana Terkumpul</span>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                          <p class="fw-bold text-base ns line-clamp-1 rp">{{ $campaign->sum('collected',0,'.','.') }}</p>
                        </div></a>
                </div>
                <div class="col-12 col-ss-6"><a class="d-block text-base-light py-3 px-4 rounded-xs shadow-drop" href="{{ route('list-campaign') }}"><i class="text-xl text-primary rck ryd-speaker"></i><span class="d-block text-sm line-clamp-1 mt-2">Total Campaign</span>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                          <p class="fw-bold text-base ns line-clamp-1">{{ count($campaign) ?? '0' }} Campaign</p>
                        </div></a>
                </div>
            </div>
            <a class="link-btn link-btn-primary h-12 w-full mt-6 rounded-xs fw-medium" href="{{ route('onboard-campaign') }}"> <span>Buat Campaign</span><i class="text-default ms-2 rck ryd-arrow-right"></i>
            </a>
            
            <!-- Menu -->
            <div class="h-2 bg-body mx-n8 my-6"></div>
            <ul>
                <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('list-campaign') }}"><i class="rck ryd-campaign link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Campaign</span></a>
                </li>
                <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('bank-campaigner') }}"><i class="rck ryd-wallet link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Rekening Pencairan</span></a>
                </li>
                {{-- <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('setting-campaignerPersonal', Auth::guard('member')->user()->encodeHash(Auth::guard('member')->user()->id)) }}"><i class="rck ryd-setting link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Pengaturan</span></a>
                </li> --}}
                <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('dashboard-setting_users') }}"><i class="rck ryd-setting link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Pengaturan</span></a>
                </li>
            </ul>
            <div class="border-bottom border-gray-light mt-6"></div>
            <ul>
                <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('frontoffice.about') }}"><i class="rck ryd-donasico-outline link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Tentang Donasi.co</span></a>
                </li>
                <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('frontoffice.term') }}"><i class="rck ryd-confirmation link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Syarat &amp; Ketentuan</span></a>
                </li>
                <li class="mt-6"><a class="d-flex align-items-center" href="{{ route('frontoffice.faq') }}"><i class="rck ryd-help link-primary text-2xl me-4"></i><span class="link-base text-default fw-bold">Bantuan</span></a>
                </li>
            </ul>
        </div>
    </section>
</main>
@endsection