@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- CONTENT-->
    <main>
        <section class="maxview bg-white px-ss-2 pt-6 pb-8 ">
            <div class="container">
                <div class="text-center py-4">
                    <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-check text-12 text-primary"></i>
                    </div>
                    <h1 class="h4 text-center mt-3">Campaign telah berhasil diubah</h1>
                    <p class="text-center mt-4">Klik tombol dibawah untuk cek campaign kamu.</p><a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="{{ route('list-campaign') }}"><span>Lihat Campaign Saya</span><i class="text-default ms-2 rck ryd-arrow-right"></i></a>
                </div>
            </div>
        </section>
    </main>

@endsection