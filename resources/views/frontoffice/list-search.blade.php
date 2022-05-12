@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    
    <livewire:landingpage-search />

    <!-- FOOTER-->
@endsection
@section('bottom-resource')
@livewireScripts
<script>
    window.onscroll = function (ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                window.livewire.emit('post-data');
            }
        };
</script>
<!-- -->
@endsection