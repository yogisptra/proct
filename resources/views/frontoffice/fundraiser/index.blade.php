@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- CONTENT-->
    <main>
        <section class="maxview-full bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <img class="w-full" src="{{ asset('frontoffice/assets/img/illust/thanks.svg') }}" alt="Register Success Illustration">
                <h1 class="h4 text-center">Yeay! Selamat.</h1>
                <p class="text-center mt-4">Kamu udah jadi fundraiser untuk campaign <span class="fw-medium text-secondary">{{ $campaign->title }}</span>.</p>
                <p class="text-center mt-2">Silahkan salin link dibawah untuk di sebarkan ya.</p>
                <ul class="border border-gray-light rounded rounded-xs mt-6 text-base">
                    <div class="px-4 py-3"><span class="user-select-all line-clamp-1 text-xs overflow-hidden" id="reff">{{ url('/'. $campaign->slug.'/reff='.Auth::guard('member')->user()->slug_token) }}</span>
                    </div>
                </ul>
                <button class="ctc link-btn link-btn-primary h-12 w-full mt-4 rounded-xs fw-medium" data-clipboard-target="#reff"> <span>Salin Link</span>
                </button><a class="link-btn link-btn-primary-o h-12 w-full mt-10 rounded-xs fw-medium" href="{{ route('frontoffice.campaignDetail', $campaign->slug) }}"><span>Kembali Ke Campaign</span><i class="text-default ms-2 rck ryd-arrow-right"></i></a>
            </div>
        </section>
    </main>
@endsection

@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/clipboard.init.js') }}"></script>
@endsection