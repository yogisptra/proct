@extends('frontoffice.layouts.frontoffice-app')

@section('content')
<!-- NAVBAR-->
@include('frontoffice.shared.header-user')

<!-- CONTENT-->
<main class="mt-18">
    <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
        <div class="container">
            <div class="row g-4">
                <div class="col-12">
                    <a class="d-flex align-items-center justify-content-between text-base-light bg-primary bg-opacity-5 rounded-xs py-3 px-4 hv-o" href="{{ route('terms-campaign', ['type' => 'PERSONAL']) }}">
                        <div class="me-2 flex-1"><span class="d-block text-defaut fw-bold text-primary">Sebagai Perorangan</span>
                            <p class="mt-2">Penggalangan dana oleh pribadi/perorangan</p>
                        </div><i class="rck ryd-chevron-down rotate-90m text-default text-primary"></i>
                    </a>
                </div>
                <div class="col-12">
                    <a class="d-flex align-items-center justify-content-between text-base-light bg-primary bg-opacity-5 rounded-xs py-3 px-4 hv-o" href="{{ route('terms-campaign', ['type' => 'CORPORATE']) }}">
                        <div class="me-2 flex-1"><span class="d-block text-defaut fw-bold text-primary">Sebagai Perusahaan</span>
                            <p class="mt-2">Penggalangan dana oleh Perusahaan, Yayasan dan Organisasi/Komunitas</p>
                        </div><i class="rck ryd-chevron-down rotate-90m text-default text-primary"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection