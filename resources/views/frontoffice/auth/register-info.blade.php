@extends('frontoffice.layouts.frontoffice-app')

@section('content')
@include('frontoffice.shared.header-user')

<main>
    <section class="maxview-full bg-white px-ss-2 pt-8 pb-8">
        <div class="container">
            <img class="w-full" src="{{ asset('frontoffice/assets/img/illust/regist.svg') }}" alt="Register Success Illustration">
            <h1 class="h4 text-center">Hi Kak, terimakasih sudah bergabung di Donasi.co</h1>
            <p class="text-center mt-4">Yuk mulai berdonasi untuk sodara kita yang membutuhkan :)</p><a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="{{ route('auth-user.login') }}"><span>Silahkan Login</span><i class="text-default ms-2 rck ryd-arrow-right"></i></a>
        </div>
    </section>
</main>

@endsection