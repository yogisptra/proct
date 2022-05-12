@extends('frontoffice.layouts.frontoffice-app')

@section('content')
@include('frontoffice.shared.header-user')

<!-- CONTENT-->
<main class="mt-18">
    <section class="maxview bg-white px-ss-2 pt-8 pb-8">
        <div class="container">
            <h1 class="h4 mb-4">Lupa Kata Sandi</h1>
            <p class="text-default mt-4">Masukan Email/Nomor telepon Kakak disini.</p>
            <form class="mt-6" action="{{ route('auth-user.sendForgotPassword') }}" method="POST">
                @csrf
                <div class="mt-4">
                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-message {{ Session::get('error') ? 'text-danger' : 'text-primary' }}"></i>
                        <input class="input ps-12" name="email" placeholder="Masukan Email/Nomor">
                    </div>
                    @if(Session::get('error'))
                        <span class="mt-2 text-xs text-danger">{{ Session::get('error') }}</span>
                    @endif
                </div>
                <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Reset Kata Sandi">
            </form>
        </div>
    </section>
</main>
@endsection
