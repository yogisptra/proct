@extends('frontoffice.layouts.dashboard-app')

@section('content')
<!-- NAVBAR-->
<nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
    <div class="container">
        <div class="h-18 d-flex justify-content-between align-items-center position-relative">
            <div class="navbar__left d-flex align-items-center"><span class="line-clamp-1 text-base fw-medium text-default">{{ @$title }}</span>
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
                <li class="position-relative"><a class="cursor-pointer d-block text-center text-base-light" href="{{ route('dashboard-myDonation') }}"><i class="d-block text-xl rck ryd-history"></i><span class="text-xxs">Riwayat</span></a>
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
                <a href="{{ route('dashboard-setting_users') }}">
                    <div class="bg-skeleton overflow-hidden w-18 w-ss-20_5 h-18 h-ss-20_5 rounded-circle shadow">
                        <img class="w-full h-full object-cover" src="{{ Auth::guard('member')->user()->image ? asset('assets/images/donatur/'. Auth::guard('member')->user()->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="User Picture">
                    </div>
                </a>
                <div class="ps-3 ps-ss-4 flex-1">
                    <div class="d-flex align-items-center">
                        <p class="text-base text-default text-ss-xl fw-medium line-clamp-1">{{ Auth::guard('member')->user()->name }}</p>
                    </div>
                    <p class="text-xs text-ss-default line-clamp-1">{{ Auth::guard('member')->user()->email }}</p>
                    @if(Auth::guard('member')->user()->is_campaigner == NULL)
                        <span class="badge bg-warning min-w-24_5 mt-2 mt-ss-3">Donatur</span>
                    @elseif(Auth::guard('member')->user()->is_campaigner == 'UNVERIFIED')
                        <span class="badge bg-warning min-w-24_5 mt-2 mt-ss-3">Donatur</span>
                    @else
                        <span class="badge bg-primary min-w-24_5 mt-2 mt-ss-3">Penggalang Dana</span>
                    @endif
                </div>
            </div>
            @if(Auth::guard('member')->user()->is_campaigner == 'VERIFIED')
                @if(Auth::guard('member')->user()->type_campaigner == 'PERSONAL')
                <a class="d-flex align-items-center justify-content-between link-base border border-gray-light rounded-xs p-2_5 mt-6" href="{{ route('dashboard-personal-campaign') }}"><span class="fw-medium">Personal Campaigner</span><i class="link-primary rck ryd-chevron-down rotate-90m"></i>
                </a>
                @else
                <a class="d-flex align-items-center justify-content-between link-base border border-gray-light rounded-xs p-2_5 mt-6" href="{{ route('dashboard-campaign') }}"><span class="fw-medium">Corporate Campaigner</span><i class="link-primary rck ryd-chevron-down rotate-90m"></i>
                </a>
                @endif
            @endif
            <div class="row mt-4 mt-ss-6 gy-3 gx-4">
                <div class="col-12 col-ss-6"><a class="d-block text-base-light py-3 px-4 rounded-xs shadow-drop" href="{{ route('dashboard-myDonation') }}"><i class="text-xl text-primary rck ryd-heart"></i><span class="d-block text-sm line-clamp-1 mt-2">Total Donasi</span>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                          <p class="fw-bold text-base ns line-clamp-1 rp">{{ $data->sum('amount')+$data->sum('unique_code') ?? 0 }}</p><i class="rck ryd-arrow-right text-default text-primary ms-1"></i>
                        </div></a>
                </div>
                <div class="col-12 col-ss-6"><a class="d-block text-base-light py-3 px-4 rounded-xs shadow-drop" href="{{ route('dashboard-fundraiser') }}"><i class="text-xl text-primary rck ryd-speaker"></i><span class="d-block text-sm line-clamp-1 mt-2">Total Fundraising</span>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                          <p class="fw-bold text-base ns line-clamp-1">{{ count($dataFundraiser ?? 0) }} Campaign</p><i class="rck ryd-arrow-right text-default text-primary ms-1"></i>
                        </div></a>
                </div>
            </div>
            @if(Auth::guard('member')->user()->is_campaigner == NULL)
            <a class="link-btn link-btn-primary h-12 w-full mt-6 rounded-xs fw-medium" href="{{ route('registrasi-campaign') }}"> 
                <span>Galang Dana Sekarang</span>
                <i class="text-default ms-2 rck ryd-arrow-right"></i>
            </a>
            @elseif(Auth::guard('member')->user()->is_campaigner == 'UNVERIFIED')
            <a class="link-btn link-btn-primary h-12 w-full mt-6 rounded-xs fw-medium" href="{{ route('success-pageCampaigner') }}"> 
                <span>Pengajuan Sedang Diproses</span>
                <i class="text-default ms-2 rck ryd-arrow-right"></i>
            </a>
            @endif
            
            <!-- Menu -->
            @include('frontoffice.shared.menu')
        </div>
    </section>
</main>
@endsection