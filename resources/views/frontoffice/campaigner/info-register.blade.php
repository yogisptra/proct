@extends('frontoffice.layouts.frontoffice-app')

@section('content')
    <!-- CONTENT-->
    <main>
        <section class="maxview-full bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <img class="w-full" src="{{ asset('frontoffice/assets/img/illust/regist.svg') }}" alt="Register Success Illustration">
                <h1 class="h4 text-center">Hi kak, data Kakak sudah kami terima.</h1>
                <p class="text-center mt-4">Mohon tunggu informasi selanjutnya, data Kakak akan segera kami proses terlebih dahulu sebelum menjadi penggalang dana</p><a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="{{ route('dashboard-users') }}"><span>Kembali Ke Beranda</span><i class="text-default ms-2 rck ryd-arrow-right"></i></a>
            </div>
        </section>
    </main>

@endsection