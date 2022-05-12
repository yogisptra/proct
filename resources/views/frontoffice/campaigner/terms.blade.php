
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
                <form action="{{ route('registrasi-tipeCampaign', ['type' => $type]) }}" method="GET">
                    <h4 class="text-base fw-medium text-default mb-3">Syarat & Ketentuan</h4>
                    @if($type == 'PERSONAL')
                    <article class="bg-primary bg-opacity-5 rounded-xs py-3 px-4 h-80 overflow-auto">
                        {!! $term['termcampaignerpersonal'] ?? '-' !!}
                    </article>
                    @else
                    <article class="bg-primary bg-opacity-5 rounded-xs py-3 px-4 h-80 overflow-auto">
                        {!! $term['termcampaignercorporate'] ?? '-' !!}
                    </article>
                    @endif
                    <label class="cb mt-4">
                        <div class="cb__box" id="terms">
                            <input class="d-none" type="checkbox">
                            <div></div>
                        </div><span class="user-select-none ms-3">Dengan ini anda setuju <b class="link-primary">Syarat & Ketentuan</b> yang berlaku</span>
                    </label>
                    <button class="submit link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" type="submit" disabled><span>Selanjutnya</span><i class="text-default ms-2 rck ryd-arrow-right"></i>
                    </button>
                </form>
            </div>
        </section>
    </main>
@endsection

@section('bottom-resource')
<!-- -->
@endsection