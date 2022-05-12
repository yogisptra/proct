@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white pt-4 pb-6">
            <div class="container">
                @if($about['image_url'] != null)
                <img class="h-6 mb-4" src="{{ asset('assets/images/profileyayasan/'. $about['image_url']) }}" alt="Donasi.co Logo">
                @endif
                <article>
                   {!! $about['profile'] !!}
                </article>
            </div>
        </section>
    </main>
@endsection