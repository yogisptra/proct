@extends('frontoffice.layouts.frontoffice-app')

@section('content')
<!-- NAVBAR-->
@include('frontoffice.shared.header-user')

<!-- CONTENT-->
<main class="mt-18">
    <section class="maxview bg-white px-ss-2 pt-8 pb-8">
        <div class="container">
            
            <img class="logo svg h-5_5" src="{{ asset('frontoffice/assets/img/logo.svg') }}" alt="Donasi.Co Logo">
            <p class="text-default mt-4">Sebarkan kebahagiaan dan wujudkan perjalan kebaikan anda disini</p>
            <a class="link-btn link-btn-gg h-12 w-full rounded-xs fw-medium mt-6" href="{{ url('auth/google') }}">
                <img class="w-5 h-5 me-4 position-absolute left-4 top-half translate-y-nhalf" src="{{ asset('frontoffice/assets/img/icon/gg.svg') }}" alt="Google"><span>Masuk Dengan Google</span>
            </a>
            <div class="position-relative text-center border-bottom border-gray-light my-10"><span class="bg-white px-4 position-absolute left-half top-half translate-nhalf text-base">Atau</span>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p style="color: green">{{ $message }}</p>
                </div>
            @elseif ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p style="color: red">{{ $message }}</p>
                </div>
            @endif
            <form class="mt-6" action="{{ route('auth-user.loginProcess') }}" method="POST">
                {{ csrf_field() }}
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-message text-primary"></i>
                        <input class="input ps-12" name="email" type="text" placeholder="Email/No. Telp">
                    </div>
                    @if ($errors->has('email'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock text-primary"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                        <input class="input px-12" name="password" type="password" placeholder="Kata Sandi">
                    </div>
                    @if ($errors->has('password'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mt-4 text-end"><a class="text-sm link-primary" href="{{ route('auth-user.forgotPassword') }}">Lupa Kata Sandi?</a>
                </div>
                <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Masuk">
            </form>
            <div class="mt-6 text-center"><span>Belum punya akun? <a class="link-primary" href="{{ route('auth-user.register') }}">Daftar</a></span>
            </div>
        </div>
    </section>
</main>
@endsection