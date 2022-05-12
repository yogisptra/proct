
@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

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

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="bg-white px-ss-2 py-6">
            <div class="container">
                <img class="w-full" src="{{ asset('frontoffice/assets/img/illust/campaign.svg') }}" alt="Galang Dana Illustration">
                <h1 class="h4 text-center">Mulai membantu sesama sekarang</h1>
                <p class="text-center mt-4">Jadilah simpul kebersamaan bagi yang membutuhkan</p><a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="{{ route('create-campaign') }}"><span>Galang Dana Sekarang</span><i class="text-default ms-2 rck ryd-arrow-right"></i></a>
                <a
                class="link-btn link-btn-primary-o h-12 w-full mt-4 rounded-xs fw-medium" href="https://wa.me/{{ $kontak }}" target="_blank"><span>Tanya Galang Dana</span><i class="text-default ms-2 rck ryd-chat"></i>
                    </a>
            </div>
        </section>
        <section class="bg-white mt-2 pt-4 pb-6">
            <div class="container">
                <h4 class="text-base fw-medium text-default mb-3"> FAQ</h4>
                <div class="accordion" id="FAQ">
                    @forelse($faq as $key => $row)
                    <div class="accordion-item mt-2 rounded-xs overflow-hidden">
                        <h2 class="accordion-header" id="heading{{ $key }}">
                            <button class="accordion-button fw-medium {{ $key == 0 ? '' : 'collapsed'}} d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $key }}" aria-expanded="true" aria-controls="faq{{ $key }}"><span class="pe-2">{{ $row->question }}</span><i class="rck ryd-chevron-down text-primary"></i></button>
                        </h2>
                        <div class="accordion-collapse collapse {{ $key == 0 ? 'show' : ''}}" id="faq{{ $key }}" aria-labelledby="heading{{ $key }}" data-bs-parent="#FAQ">
                            <div class="accordion-body bg-gray-light bg-opacity-20">
                                {!! $row->answer !!}
                            </div>
                        </div>
                    </div>
                    @empty

                    @endforelse
                </div>
            </div>
        </section>
    </main>

@endsection