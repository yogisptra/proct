@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="{{ route('frontoffice') }}" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">{{ @$title }}</span>
                </div>
                <div class="navbar__right d-flex align-items-center"><a class="link-base ms-4" href="{{ route('frontoffice.search') }}" aria-label="Search"><i class="text-2xl rck ryd-search"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT-->
    <main class="mt-18">
        <livewire:landingpage-list-campaign />
    </main>

@endsection

@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/filter.js') }}"></script>
    <script>
        $('.pill-category').click(function() {
            const thisCategory = $(this).next('span').text()
            $('[aria-label="Go Back"]').next('span').text(thisCategory)
        
            $('title').text(`${thisCategory} - Donasi.Co`);
        })
        
        function clickButtonEmit(ctx) {
            window.livewire.emit('switch', ctx)
            if(ctx == 'all') {
                window.livewire.emit('switch', ctx)
                $('.categoryAll').addClass('_selected')
                $('.category').removeClass('_selected')
            }else if(ctx) {
                window.livewire.emit('switch', ctx)
                $('.categoryAll').removeClass('_selected')
                $('.category').addClass('_selected')
            }
        }

        function clickButtonFilter(ctx) {
            if(ctx == 'all') {
                window.livewire.emit('sortBy', ctx)
                $('.sortASC').removeClass('link-base-light')
                $('.sortASC').addClass('link-primary')
                $('.sortDESC').removeClass('link-primary')
                $('.sortDESC').addClass('link-base-light')
            }else if(ctx) {
                window.livewire.emit('sortBy', ctx)
                $('.sortASC').removeClass('link-primary')
                $('.sortASC').addClass('link-base-light')
                $('.sortDESC').removeClass('link-base-light')
                $('.sortDESC').addClass('link-primary')
            }
        }
    </script>
    @livewireScripts
@endsection