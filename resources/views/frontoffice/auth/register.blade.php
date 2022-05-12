@extends('frontoffice.layouts.frontoffice-app')

@section('content')
<!-- NAVBAR-->
@include('frontoffice.shared.header-user')

<!-- CONTENT-->
<main class="mt-18">
    <section class="maxview bg-white px-ss-2 pt-8 pb-8">
        <div class="container">
            <img class="logo svg h-5_5" src="{{ asset('frontoffice/assets/img/logo.svg') }}" alt="Donasi.Co Logo">
            <p class="text-default mt-4">Sebarkan kebahagiaan dan wujudkan perjalanan kebaikan kakak disini</p>
            <a class="link-btn link-btn-gg h-12 w-full rounded-xs fw-medium mt-6" href="{{ url('auth/google') }}">
                <img class="w-5 h-5 me-4 position-absolute left-4 top-half translate-y-nhalf" src="{{ asset('frontoffice/assets/img/icon/gg.svg') }}" alt="Google"><span>Masuk Dengan Google</span>
            </a>
            <div class="position-relative text-center border-bottom border-gray-light my-10"><span class="bg-white px-4 position-absolute left-half top-half translate-nhalf text-base">Atau</span>
            </div>
            <form class="mt-6" action="{{ route('auth-user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-user {{ $errors->has('name') ? 'text-danger' : 'text-primary' }}"></i>
                        <input class="input ps-12" name="name" value="{{ old('name') }}" type="text" placeholder="Nama Lengkap">
                    </div>
                    @if ($errors->has('name'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-mail {{ $errors->has('email') ? 'text-danger' : 'text-primary' }}"></i>
                        <input class="input ps-12" name="email" value="{{ old('email') }}" type="email" placeholder="Email">
                    </div>
                    @if ($errors->has('email'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-calling {{ $errors->has('phone_number') ? 'text-danger' : 'text-primary' }}"></i>
                        <input class="input ps-12" name="phone_number" value="{{ old('phone_number') }}" type="number" placeholder="Nomor Telepon">
                    </div>
                    @if ($errors->has('phone_number'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('phone_number') }}</span>
                    @endif
                </div>
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock {{ $errors->has('password') ? 'text-danger' : 'text-primary' }}"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                        <input class="input px-12" name="password" type="password" value="{{ old('password') }}" placeholder="Buat Kata Sandi">
                    </div>
                    @if ($errors->has('password'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock {{ $errors->has('confirm_password') ? 'text-danger' : 'text-primary' }}"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                        <input class="input px-12" name="confirm_password" type="password" value="{{ old('confirm_password') }}" placeholder="Ulangi Kata Sandi">
                    </div>
                    @if ($errors->has('confirm_password'))
                        <span class="mt-2 text-xs text-danger">{{ $errors->first('confirm_password') }}</span>
                    @endif
                </div>
                <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Daftar">
            </form>
            <div class="mt-6 text-center"><span>Sudah punya akun? <a class="link-primary" href="{{ route('auth-user.onboardLogin') }}">Masuk</a></span>
            </div>
        </div>
    </section>
</main>
@endsection