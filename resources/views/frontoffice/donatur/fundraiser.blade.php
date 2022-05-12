@extends('frontoffice.layouts.dashboard-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <livewire:dashboard-list-fundraiser />
    </main>

@endsection

@section('bottom-resource')

    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/filter.js') }}"></script>
    <script>
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
        window.onscroll = function (ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                window.livewire.emit('post-data');
            }
        };

        function clickButtonSort(ctx) {
            if(ctx == 'asc') {
                window.livewire.emit('sortBy', ctx)
                $('.sortASC').removeClass('link-base-light')
                $('.sortASC').addClass('link-primary')
                $('.sortDESC').removeClass('link-primary')
                $('.sortDESC').addClass('link-base-light')
            }else {
                window.livewire.emit('sortBy', ctx)
                $('.sortASC').removeClass('link-primary')
                $('.sortASC').addClass('link-base-light')
                $('.sortDESC').removeClass('link-base-light')
                $('.sortDESC').addClass('link-primary')
            }
        }

        function clickButtonFilter(ctx) {
            if(ctx == 'all') {
                window.livewire.emit('filter', ctx)
                $('.filterAll').removeClass('link-base-light')
                $('.filterAll').addClass('link-primary')
                $('.filterEnd').removeClass('link-primary')
                $('.filterEnd').addClass('link-base-light')
            }else if(ctx) {
                window.livewire.emit('filter', ctx)
                $('.filterAll').removeClass('link-primary')
                $('.filterAll').addClass('link-base-light')
                $('.filterEnd').removeClass('link-base-light')
                $('.filterEnd').addClass('link-primary')
            }
        }
    </script>
    @livewireScripts
    <!-- FOOTER-->
@endsection