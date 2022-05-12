@extends('frontoffice.layouts.frontoffice-app')

@section('content')
<!-- NAVBAR-->
@include('frontoffice.shared.header-user_')

<!-- CONTENT-->
<main class="mt-18">
    <section class="maxview align-items-start bg-white pt-6 pb-30">
        <div class="container">
            <img class="logo svg h-5_5" src="{{ asset('frontoffice/assets/img/logo.svg') }}" alt="Donasi.Co Logo">
            <p class="text-default mt-4">Masuk dan mulai perjalanan kebaikan kakak dengan fitur terbaik dalam berdonasi.</p>
            <a class="link-btn link-btn-primary h-12 w-full mt-6 rounded-xs fw-medium" href="{{ route('auth-user.login') }}"> 
                <span>Masuk Sekarang</span><i class="text-default ms-2 rck ryd-arrow-right"> </i>
            </a>
            <div class="mt-6 text-center"><span>Belum punya akun? <a class="link-primary" href="{{ route('auth-user.register') }}">Daftar</a></span>
            </div>
            <div class="h-2 bg-body mx-n8 my-6"></div>
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