
@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="javascript:history.go(-1)" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">{{ @$title }}</span>
                </div>
                <div class="navbar__right d-flex align-items-center"></div>
            </div>
        </div>
    </nav>

    <!-- CONTENT-->
    <main class="mt-18">
        <livewire:dashboard-list-campaign />
        
    </main>
@endsection

@section('bottom-resource')
@livewireScripts
    
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/filter.js') }}"></script>
    <script>
        window.onscroll = function (ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                window.livewire.emit('post-data');
            }
        };
        function clickButtonEmit(ctx) {
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

        $(document).ready(function(){
            $(".modalLainnya").click(function() {
                let value = $(this).attr("data-id");
                var url = "{{ route('edit-campaign', ':id') }}";
                url = url.replace(':id', value);

                var urlEdit =  $('#editHref').attr('href', url);

                var url2 = "{{ route('campaign-update.new', ':id') }}";
                url2 = url2.replace(':id', value);

                var urlDelete =  $('#addUpdateNew').attr('href', url2);

                let slug = $(this).attr("data-slug");
                var url3 = "{{ route('frontoffice.campaignDetail', ':id') }}";
                url3 = url3.replace(':id', slug);

                var urlPriview =  $('#detailHref').attr('href', url3);
            });
        });
    </script>
@endsection