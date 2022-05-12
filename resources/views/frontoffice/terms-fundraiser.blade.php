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
                <article>
                  {!! $term['termfundraiser'] !!}
                </article>
            </div>
        </section>
    </main>
    
@endsection