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
                <div class="accordion" id="FAQ">
                    @forelse($faq as $key => $row)
                    <div class="accordion-item mt-2 rounded-xs overflow-hidden">
                        <h2 class="accordion-header" id="heading{{ $key }}">
                            <button class="accordion-button fw-medium {{ $key == 0 ? '' : 'collapsed'}} d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $key }}" aria-expanded="true" aria-controls="fa{{ $key }}"><span class="pe-2">{{ $row->question }}</span><i class="rck ryd-chevron-down text-primary"></i></button>
                        </h2>
                        <div class="accordion-collapse collapse  {{ $key == 0 ? 'show' : ''}}" id="faq{{ $key }}" aria-labelledby="heading{{ $key }}" data-bs-parent="#FAQ">
                            <div class="accordion-body bg-gray-light bg-opacity-20">
                               {!! $row->answer !!}
                            </div>
                        </div>
                    </div>
                    @empty

                    @endforelse
                </div>
                <a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="https://wa.me/{{ $kontak }}" target="_blank"><span>Hubungi Kami</span><i class="text-default ms-2 rck ryd-chat"></i></a>
            </div>
        </section>
    </main>
@endsection