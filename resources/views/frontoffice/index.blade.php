@extends('frontoffice.layouts.app')

<!-- Top Resource -->
@section('top-resource')
@endsection
<!-- End Top Resource -->

@section('content')
<!-- CONTENT-->
<main class="homepage mt-18">
    @if(count($slider) > 0)
    <header class="header bg-white py-6">
        <div class="header__slider position-relative">
            <div class="swiper-wrapper">
                @foreach($slider as $row)
                <div class="swiper-slide w-84p">
                    <a class="d-block position-relative bg-skeleton w-full wrap-ratio rounded-xs overflow-hidden" href="{{ $row->link }}">
                        <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/slider/'. $row->image) }}" alt="Protest for Black Lives Matter in Paris">
                        <div class="position-absolute w-full h-full bg-overlay"></div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="header__slider__pagination position-absolute bottom-2 left-half translate-x-nhalf z-100"></div>
        </div>
    </header>
    @endif
    
    @if(count($campaignMain) > 0)
    <section class="main-campaign bg-white py-4 mt-2">
        <div class="container">
            <h2 class="h4">Program Utama</h2>
        </div>
        <div class="main-campaign__lists mt-6">
            <div class="swiper-wrapper">
                @foreach($campaignMain as $row)
                <div class="swiper-slide w-84p">
                    <div class="user-select-none">
                        @if($row->hasUser->type_campaigner == 'PERSONAL')
                        <a class="text-base d-flex align-items-center px-4" href="{{ route('frontoffice.campaigner', ['type' => 'PERSONAL', 'id' => $row->encodeHash($row->hasCampaign->hasUser->id)]) }}">
                            <div class="bg-skeleton w-8 h-8 rounded-md overflow-hidden shadow">
                                <img class="w-full h-full object-cover" src="{{ isset($row->hasUser->image) ? asset('assets/images/donatur/'. $row->hasUser->image) : asset('frontoffice/assets/uploads/images/no-avatar-square.png') }}" alt="{{ $row->hasUser->name }}">
                            </div>
                            <div class="d-flex align-items-center ms-2 flex-1"><span class="fw-medium line-clamp-1">{{ $row->hasUser->name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i>
                            </div>
                        </a>
                        @else
                        <a class="text-base d-flex align-items-center px-4" href="{{ route('frontoffice.campaigner', ['type' => 'CORPORATE', 'id' => $row->encodeHash($row->hasCampaign->hasUser->hasCorporate->id)]) }}">
                            <div class="bg-skeleton w-8 h-8 rounded-md overflow-hidden shadow">
                                <img class="w-full h-full object-cover" src="{{ isset($row->hasUser->hasCorporate->image) ? asset('assets/images/corporate/'. @$row->hasUser->hasCorporate->image) : asset('frontoffice/assets/uploads/images/no-avatar-square.png') }}" alt="{{ @$row->hasUser->hasCorporate->corporate_name }}">
                            </div>
                            <div class="d-flex align-items-center ms-2 flex-1"><span class="fw-medium line-clamp-1">{{ @$row->hasUser->hasCorporate->corporate_name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i>
                            </div>
                        </a>
                        @endif
                        <div class="position-relative bg-skeleton w-full wrap-ratio mt-4">
                            <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $row->image) }}" alt="{{ $row->title }}">
                            <div class="position-absolute w-full h-full bg-overlay"></div>
                            <div class="position-absolute w-full d-flex justify-content-between align-items-end text-white px-6 pb-4 bottom-0 end-0">
                                <div><span class="d-block">Terkumpul</span>
                                    <p class="d-block fw-medium text-default rp ns line-clamp-1">{{ number_format($row->total_amount,0,'.','.') }}</p>
                                </div><a class="link-btn link-btn-primary h-10 w-31 rounded-xs fw-medium" href="{{ route('frontoffice.campaignDetail', ['slug' => $row->slug]) }}">Donasi</a>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="d-flex align-items-center justify-content-between"><span class="badge bg-secondary">{{ $row->hasCategory->name }}</span>
                                <button class="rck ryd-share text-default link-base modalShare" aria-label="share" data-bs-toggle="modal" data-bs-target="#modalShare" data-id="{{ $row->slug }}"></button>
                            </div>
                            <p class="text-base text-default fw-bold h-12 line-clamp-2 mt-2 titleCampaign" title="{{ $row->title }}">{{ $row->title }}</p>
                            <p class="mt-2 fw-bold">{{ $row->total_donatur ?? 0 }} Donatur</p>
                            <div class="mt-2 h-10_5 line-clamp-2">{!! $row->description !!}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(count($campaignNew) > 0)
    <section class="main-campaign bg-white py-4 mt-2">
        <div class="container">
            <h2 class="h4">Program Terbaru</h2>
        </div>
        <div class="main-campaign__lists mt-6">
            <div class="swiper-wrapper align-items-center">
                @foreach($campaignNew as $row)
                <div class="swiper-slide w-84p">
                    <div class="user-select-none">
                        @if($row->hasUser->type_campaigner == 'PERSONAL')
                        <a class="text-base d-flex align-items-center px-4" href="{{ route('frontoffice.campaigner', ['type' => 'PERSONAL', 'id' => $row->encodeHash($row->hasCampaign->hasUser->id)]) }}">
                            <div class="bg-skeleton w-8 h-8 rounded-md overflow-hidden shadow">
                                <img class="w-full h-full object-cover" src="{{ isset($row->hasUser->image) ? asset('assets/images/donatur/'. $row->hasUser->image) : asset('frontoffice/assets/uploads/images/no-avatar-square.png') }}" alt="{{ $row->hasUser->name }}">
                            </div>
                            <div class="d-flex align-items-center ms-2 flex-1"><span class="fw-medium line-clamp-1">{{ $row->hasUser->name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i>
                            </div>
                        </a>
                        @else
                        <a class="text-base d-flex align-items-center px-4" href="{{ route('frontoffice.campaigner', ['type' => 'CORPORATE', 'id' => $row->encodeHash($row->hasCampaign->hasUser->hasCorporate->id)]) }}">
                            <div class="bg-skeleton w-8 h-8 rounded-md overflow-hidden shadow">
                                <img class="w-full h-full object-cover" src="{{ isset($row->hasUser->hasCorporate->image) ? asset('assets/images/corporate/'. @$row->hasUser->hasCorporate->image) : asset('frontoffice/assets/uploads/images/no-avatar-square.png') }}" alt="{{ @$row->hasUser->hasCorporate->corporate_name }}">
                            </div>
                            <div class="d-flex align-items-center ms-2 flex-1"><span class="fw-medium line-clamp-1">{{ @$row->hasUser->hasCorporate->corporate_name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i>
                            </div>
                        </a>
                        @endif
                        <div class="position-relative bg-skeleton w-full wrap-ratio mt-4">
                            <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $row->image) }}" alt="{{ $row->title }}">
                            <div class="position-absolute w-full h-full bg-overlay"></div>
                            <div class="position-absolute w-full d-flex justify-content-between align-items-end text-white px-6 pb-4 bottom-0 end-0">
                                <div><span class="d-block">Terkumpul</span>
                                    <p class="d-block fw-medium text-default rp ns line-clamp-1">{{ number_format($row->total_amount,0,'.','.') }}</p>
                                </div><a class="link-btn link-btn-primary h-10 w-31 rounded-xs fw-medium" href="{{ route('frontoffice.campaignDetail', ['slug' => $row->slug]) }}">Donasi</a>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="d-flex align-items-center justify-content-between"><span class="badge bg-secondary">{{ $row->hasCategory->name }}</span>
                                <button class="rck ryd-share text-default link-base modalShare" aria-label="share" data-bs-toggle="modal" data-bs-target="#modalShare" data-id="{{ $row->slug }}"></button>
                            </div>
                            <p class="text-base text-default fw-bold h-12 line-clamp-2 mt-2 titleCampaign" title="{{ $row->title }}">{{ $row->title }}</p>
                            <p class="mt-2 fw-bold">{{ $row->total_donatur ?? 0 }} Donatur</p>
                            <div class="mt-2 h-10_5 line-clamp-2">{!! $row->description !!}</div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="swiper-slide w-half">
                    <div class="d-flex align-items-center justify-content-center w-full h-full">
                        <a class="link-primary text-center d-flex align-items-center justify-content-center flex-column me-4" href="{{ route('frontoffice.campaignList') }}">
                            <div class="d-flex align-items-center justify-content-center w-12 h-12 rounded-circle border border-3 border-primary"><i class="rck ryd-arrow-right text-3xl"></i>
                            </div><span class="text-xl fw-bold mt-4">Lihat Lainnya</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <section class="bg-white py-4 mt-2">
        <div class="container">
            <h2 class="h4">Kategori Pilihan</h2>
            <div class="tag-category mt-6">
                <div class="row gx-1 text-center">
                    <div class="col-3">
                        <button onclick="clickButtonEmit('all')" class="pill-category categoryAll _selected" name="cVirtual" value="cVirtualAll">
                            <div class="_wrap mx-auto d-flex align-items-center justify-content-center w-14 w-ss-16 h-14 h-ss-16 rounded-circle">
                                <img class="svg w-5 w-ss-6" src="{{ asset('frontoffice/assets/img/icon/donasico.svg') }}" alt="Icon Semua Kategori">
                            </div>
                        </button><span class="px-4 h-9 line-clamp-2 d-flex align-items-center justify-content-center text-xs text-base user-select-none mt-4">Semua Kategori</span>
                    </div>
                    @foreach($category->take(2) as $row)
                    <div class="col-3">
                        <button onclick="clickButtonEmit({{ $row->id }})" class="pill-category category" name="category" value="{{ $row->id }}">
                            <div class="_wrap mx-auto d-flex align-items-center justify-content-center w-14 w-ss-16 h-14 h-ss-16 rounded-circle">
                                <img class="svg w-5 w-ss-6" src="{{ asset('assets/images/category/'. $row->icon) }}" alt="Icon {{ $row->name }}">
                            </div>
                        </button><span class="px-4 h-9 line-clamp-2 d-flex align-items-center justify-content-center text-xs text-base user-select-none mt-4">{{ $row->name }}</span>
                    </div>
                    @endforeach
                    <div class="col-3">
                        <button class="pill-category-other" name="cVirtual" value="cVirtualOther" type="button" data-bs-toggle="modal" data-bs-target="#modalCategoryVirtual">
                            <div class="_wrap mx-auto d-flex align-items-center justify-content-center w-14 w-ss-16 h-14 h-ss-16 rounded-circle">
                                <img class="svg w-5 w-ss-6" src="{{ asset('frontoffice/assets/img/icon/category.svg') }}" alt="Icon Kategori Lainnya">
                            </div>
                        </button><span class="px-4 h-9 line-clamp-2 d-flex align-items-center justify-content-center text-xs text-base user-select-none mt-4">Kategori Lainnya</span>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" aria-labelledby="modalCategoryVirtualLabel" aria-hidden="true" id="modalCategoryVirtual">
                <div class="modal-dialog">
                    <div class="modal-content h-full">
                        <div class="modal-body align-center">
                            <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                                <div class="container">
                                    <h2 class="d-flex align-items-center">
                                        <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Kategori Lainnya</span>
                                    </h2>
                                </div>
                            </div>
                            <div class="modal-body__inner pt-4 pb-6 overflow-auto">
                                <div class="container">
                                    <div class="row gx-1 gy-4 text-center">
                                        <div class="col-3">
                                            <button onclick="clickButtonEmit('all')" class="pill-category _selected categoryAll" name="cVirtual" value="all" data-bs-dismiss="modal">
                                                <div class="_wrap mx-auto d-flex align-items-center justify-content-center w-14 w-ss-16 h-14 h-ss-16 rounded-circle">
                                                    <img class="svg w-5 w-ss-6" src="{{ asset('frontoffice/assets/img/icon/donasico.svg') }}" alt="Icon Semua Kategori">
                                                </div>
                                            </button><span class="px-4 h-9 line-clamp-2 d-flex align-items-center justify-content-center text-xs text-base user-select-none mt-4">Semua Kategori</span>
                                        </div>
                                        @foreach($category as $row)
                                        <div class="col-3">
                                            <button onclick="clickButtonEmit({{ $row->id }})" class="pill-category category" name="category" value="{{ $row->id }}" data-bs-dismiss="modal">
                                                <div class="_wrap mx-auto d-flex align-items-center justify-content-center w-14 w-ss-16 h-14 h-ss-16 rounded-circle">
                                                    <img class="svg w-5 w-ss-6" src="{{ asset('assets/images/category/'. $row->icon) }}" alt="Icon {{ $row->name }}">
                                                </div>
                                            </button><span class="px-4 h-9 line-clamp-2 d-flex align-items-center justify-content-center text-xs text-base user-select-none mt-4">{{ $row->name }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <livewire:landingpage-kategori />
        </div>
    </section>
    <div class="bg-white h-23"></div>
    <!-- Popup Share-->
    <div class="modal fade" tabindex="-1" aria-labelledby="modalShareLabel" aria-hidden="true" id="modalShare">
        <div class="modal-dialog d-flex align-items-end">
            <div class="modal-content mh-85h rounded-top-md">
                <div class="modal-body align-center">
                    <div class="modal-body__header d-flex align-items-center h-12 transition-all">
                        <div class="container">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-default me-4">Bagikan</h2>
                                <button class="text-xl" data-bs-dismiss="modal"><i class="rck ryd-close"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body__inner _sm pt-4 pb-6 overflow-auto">
                        <div class="container">
                            <div class="row gx-2">
                                <div class="col-4">
                                    <a class="d-block link-base mx-auto text-center w-max linkFacebook" target="_blank">
                                        <div class="bg-skeleton overflow-hidden w-10 h-10 rounded-xs mx-auto">
                                            <img class="w-full h-full object-cover" src="{{ asset('frontoffice/assets/img/icon/facebook.svg') }}" alt="icon Facebook">
                                        </div><span class="text-xs d-inline-block mt-2">Facebook</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block link-base mx-auto text-center w-max whatsapp" target="_blank">
                                        <div class="bg-skeleton overflow-hidden w-10 h-10 rounded-xs mx-auto">
                                            <img class="w-full h-full object-cover" src="{{ asset('frontoffice/assets/img/icon/whatsapp.svg') }}" alt="icon Whatsapp">
                                        </div><span class="text-xs d-inline-block mt-2">Whatsapp</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a class="d-block link-base mx-auto text-center w-max twitterLink" target="_blank">
                                        <div class="bg-skeleton overflow-hidden w-10 h-10 rounded-xs mx-auto">
                                            <img class="w-full h-full object-cover" src="{{ asset('frontoffice/assets/img/icon/twitter.svg') }}" alt="icon Twitter">
                                        </div><span class="text-xs d-inline-block mt-2">Twitter</span>
                                    </a>
                                </div>
                                {{-- <div class="col-3">
                                    <a class="d-block link-base mx-auto text-center w-max" href="#!" target="_blank">
                                        <div class="bg-skeleton overflow-hidden w-10 h-10 rounded-xs mx-auto">
                                            <img class="w-full h-full object-cover" src="{{ asset('frontoffice/assets/img/icon/telegram.svg') }}" alt="icon Telegram">
                                        </div><span class="text-xs d-inline-block mt-2">Telegram</span>
                                    </a>
                                </div> --}}
                            </div>
                            <div class="d-flex mt-8">
                                <div class="w-0 h-12 flex-1 d-flex align-items-center border border-gray-light rounded rounded-xs text-base px-4">
                                    <div class="user-select-all line-clamp-1 text-xs" id="link"></div>
                                </div>
                                <div class="w-16 ms-2">
                                    <button class="ctc link-btn link-btn-primary h-12 w-full rounded-xs fw-medium" data-bs-dismiss="modal" data-clipboard-target="#link"> <span>Salin</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('bottom-resource')
<script>
    // Swiper Settings
    const slider = new Swiper(".header__slider", {
        grabCursor: true,
        slidesPerView: "auto",
        spaceBetween: 16,
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 3200,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".header__slider__pagination",
        },
        
    });
    const campaignList = new Swiper(".main-campaign__lists", {
        grabCursor: true,
        slidesPerView: "auto",
        spaceBetween: 16,
        freeMode: true,
    });

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

    $(document).ready(function() {
        $('.modalShare').click(function() {
            let value = $(this).attr("data-id");
            let url = "{{ route('frontoffice.campaignDetail', ':id') }}";
            url = url.replace(':id', value);

            let slug =  $('#link').html(url);
            // Facebook
            let urlFacebook = 'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdonasi.co%2Fdetail%2F'+ value +'&amp;src=sdkpreparse'
                $('.linkFacebook').attr('href', urlFacebook);   

            // Whatsapp
            let titleCampaign = $('.titleCampaign').html();
                $('.whatsapp').attr('data-text', titleCampaign); 
                $('.whatsapp').attr('data-link', url);   

            // Twitter
            let urlTwitter = 'https://twitter.com/intent/tweet?url='+url+''
                $('.twitterLink').attr('href', urlTwitter);
                $('.twitterLink').attr('text', titleCampaign);
        });
    });

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(document).ready(function() {
        $('.whatsapp').on("click", function(e) {
            var title = $(this).attr("data-text");
            var weburl = $(this).attr("data-link");
            var whats_app_message = encodeURIComponent(title) + " - " + encodeURIComponent(weburl);
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {

                var whatsapp_url = "whatsapp://send?text=" + whats_app_message;
                window.location.href = whatsapp_url;
            } else {
                alert("Share ini hanya bisa dipakai di versi web mobile");
            }
        });
    })
   
    
</script>
@livewireScripts
@endsection