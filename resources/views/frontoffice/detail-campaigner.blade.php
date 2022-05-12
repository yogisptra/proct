@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="{{ route('frontoffice') }}" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">{{ $title }}</span>
                </div>
                <div class="navbar__right d-flex align-items-center"></div>
            </div>
        </div>
    </nav>

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white pt-6 pb-8">
            <div class="container">
                @if($type == 'PERSONAL')
                <div class="d-flex align-items-center">
                    <div class="bg-skeleton overflow-hidden w-18 w-ss-20_5 h-18 h-ss-20_5 rounded-circle shadow">
                        <img class="w-full h-full object-cover" src="{{ asset('assets/images/donatur/'. $data->image) }}" alt="{{ $data->name }}">
                    </div>
                    <div class="ps-3 ps-ss-4 flex-1">
                        <div class="d-flex align-items-center">
                            <p class="text-base text-default text-ss-xl fw-medium line-clamp-1">{{ $data->name }}</p><i class="ms-1 text-primary rck ryd-verified-simple"></i>
                        </div>
                        <p class="text-xs text-ss-sm mt-2">{{ $data->address }} {{ $data->hasDistrict->name }}, {{ $data->hasArea->name }}, 
                            <br> {{ $data->hasCity->name }}, {{ $data->hasProvince->name }} {{ $data->codepos }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->facebook }}" aria-label="icon facebook">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-facebook.svg') }}">
                    </a>
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->instagram }}" aria-label="icon instagram">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-instagram.svg') }}">
                    </a>
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->twitter }}" aria-label="icon twitter">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-twitter.svg') }}">
                    </a>
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->linkedin }}" aria-label="icon linkedin">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-linkedin.svg') }}">
                    </a>
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->tiktok }}" aria-label="icon tiktok">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-tiktok.svg') }}">
                    </a>
                </div>
                @else
                <div class="d-flex align-items-center">
                    <div class="bg-skeleton overflow-hidden w-18 w-ss-20_5 h-18 h-ss-20_5 rounded-circle shadow">
                        <img class="w-full h-full object-cover" src="{{ asset('assets/images/corporate/'. $data->image) }}" alt="{{ $data->corporate_name }}">
                    </div>
                    <div class="ps-3 ps-ss-4 flex-1">
                        <div class="d-flex align-items-center">
                            <p class="text-base text-default text-ss-xl fw-medium line-clamp-1">{{ $data->corporate_name }}</p><i class="ms-1 text-primary rck ryd-verified-simple"></i>
                        </div>
                        <p class="text-xs text-ss-sm mt-2">{{ $data->corporate_address }} {{ $data->hasDistrict->name }}, {{ $data->hasArea->name }}, 
                            <br> {{ $data->hasCity->name }}, {{ $data->hasProvince->name }} {{ $data->corporate_codepos }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->facebook }}" aria-label="icon facebook">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-facebook.svg') }}">
                    </a>
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->instagram }}" aria-label="icon instagram">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-instagram.svg') }}">
                    </a>
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->twitter }}" aria-label="icon twitter">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-twitter.svg') }}">
                    </a>
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->linkedin }}" aria-label="icon linkedin">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-linkedin.svg') }}">
                    </a>
                    <a target="_blank" class="mt-4 bg-primary w-7 h-7 rounded-circle overflow-hidden mx-1 d-flex align-items-center justify-content-center hv-o" href="{{ $data->tiktok }}" aria-label="icon tiktok">
                        <img class="w-6" src="{{ asset('frontoffice/assets/img/icon/sns-tiktok.svg') }}">
                    </a>
                </div>
                @endif
                <div class="row mt-4 mt-ss-6 gy-3 gx-4">
                    <div class="col-12 col-ss-6">
                        <div class="text-base-light py-3 px-4 rounded-xs shadow-drop"><i class="text-xl text-primary rck ryd-heart"></i><span class="d-block text-sm line-clamp-1 mt-2">Dana Terkumpul</span>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="fw-bold text-base ns line-clamp-1 rp">{{ $campaign->sum('collected',0,'.','.') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-ss-6">
                        <div class="text-base-light py-3 px-4 rounded-xs shadow-drop"><i class="text-xl text-primary rck ryd-campaign"></i><span class="d-block text-sm line-clamp-1 mt-2">Total Campaign</span>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="fw-bold text-base ns line-clamp-1">{{ count($campaign) }} Campaign</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-2 bg-body mx-n8 my-6"></div>
                <div class="d-flex align-items-center"><i class="text-default me-2 rck ryd-info"></i><span class="fw-bold">Tentang Campaigner</span>
                </div>
                @if($type == 'PERSONAL')
                <div class="mt-2">
                    <p>{!! $data->bio !!}</p>
                </div>
                @else 
                <div class="mt-2">
                    <p>{!! $data->bio !!}</p>
                </div>
                @endif
                <div class="h-2 bg-body mx-n8 my-6"></div>
                <div class="d-flex align-items-center"><i class="text-default me-2 rck ryd-campaign"></i><span class="fw-bold">Total Campaign</span>
                </div>
                <div class="row gy-4 mt-2">
                    @if($type == 'PERSONAL')
                        @foreach($campaign as $row)
                        <div class="col-12">
                            <a class="user-select-none d-flex align-items-center" href="{{ route('frontoffice.campaignDetail', $row->slug) }}">
                                <div class="position-relative bg-skeleton w-29 w-ss-38 h-29 rounded-xs overflow-hidden shadow">
                                    <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $row->image) }}" alt="{{ $row->title }}">
                                </div>
                                <div class="ps-2 flex-1 text-xs"><span class="badge bg-secondary">{{ $row->hasCategory->name }}</span>
                                    <div class="d-flex align-items-center mt-2"><span class="h-4_5 d-block text-gray line-clamp-1">{{ $row->hasUser->name }}</span><i class="ms-1 mt-n0_25 text-primary rck ryd-verified-simple"></i>
                                    </div>
                                    <p class="text-base fw-medium line-clamp-2 h-9 mt-2" title="{{ $row->title }}">{{ $row->title }}</p>
                                    <p class="mt-2 fw-bold text-base-light">{{ $row->total_donatur ?? 0 }} Donatur</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @else
                        @foreach($campaign as $row)
                        <div class="col-12">
                            <a class="user-select-none d-flex align-items-center" href="{{ route('frontoffice.campaignDetail', $row->slug) }}">
                                <div class="position-relative bg-skeleton w-29 w-ss-38 h-29 rounded-xs overflow-hidden shadow">
                                    <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $row->image) }}" alt="{{ $row->title }}">
                                </div>
                                <div class="ps-2 flex-1 text-xs"><span class="badge bg-secondary">{{ $row->hasCategory->name }}</span>
                                    <div class="d-flex align-items-center mt-2"><span class="h-4_5 d-block text-gray line-clamp-1">{{ $row->hasUser->hasCorporate->corporate_name }}</span><i class="ms-1 mt-n0_25 text-primary rck ryd-verified-simple"></i>
                                    </div>
                                    <p class="text-base fw-medium line-clamp-2 h-9 mt-2" title="{{ $row->title }}">{{ $row->title }}</p>
                                    <p class="mt-2 fw-bold text-base-light">{{ $row->total_donatur ?? 0 }} Donatur</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    </main>
@endsection