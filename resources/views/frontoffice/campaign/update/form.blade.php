@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- Vendor style -->
<link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/quill.snow.css') }}">
@endsection

@section('content')
    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="javascript:history.go(-1)" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">{{ $title }}</span>
                </div>
                <div class="navbar__right d-flex align-items-center"></div>
            </div>
        </div>
    </nav>

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <form action="{{ route('campaign-update.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $data->id }}">
                    <div>
                        <label class="user-select-none text-xs fw-medium mb-2">Judul
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-campaign {{ $errors->has('title') ? 'text-danger' : 'text-primary' }}"></i>
                            <input class="input ps-12" name="title" value="{{ old('title') }}" id="title" type="text" placeholder="Bantuan Telah Disalurkan" required>
                        </div>
                        @if ($errors->has('title'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div>
                        <label class="user-select-none text-xs fw-medium mb-2">Kabar Terbaru
                        </label>
                        <div class="ql-wrapper rounded-xs overflow-hidden">
                            <article id="editor"></article>
                            <textarea name="content" style="display:none" id="content"></textarea>
                        </div>
                        @if ($errors->has('content'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                    <button class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" type="submit"><span>Simpan</span><i class="text-default ms-2 rck ryd-arrow-right"></i>
                    </button>
                </form>
            </div>
        </section>
    </main>

@endsection

@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/vendor/quill.min.js') }}"></script>
    <script>
        //- Quill
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        quill.on('text-change', function(delta, oldDelta, source) {
            $('#content').val(quill.container.firstChild.innerHTML);
        });

    </script>
@endsection