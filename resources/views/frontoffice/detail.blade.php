@extends('frontoffice.layouts.frontoffice-app')

@section('fb-opengraph')
<meta property="og:url" content="{{ url('/') }}" />
<meta property="og:title" content="{{ $data->title }}" />
<meta property="og:type" content="website" />
<meta property="og:image" content="{{ url('assets/images/campaign/'. $data->image) }}" />
<meta property="og:description" content="{{ config('app.description', 'Web-Description') }}" />
<meta property="og:keyword" content="{{ config('app.keyword', 'Web-Description') }}" />
<meta name="description" content="{{ config('app.description', 'Web-Description') }}">
@endsection

@section('top-resource')
<!-- Google Tag Manager -->
<script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer',{{ @$data->gtm }});
</script>
<!-- End Google Tag Manager -->

<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', {{ @$data->fb_pixel }});
    fbq('track', 'PageView');
    fbq('track', 'AddToCart');
    fbq('track', 'Donate');
    fbq('track', 'Purchase', {value: 0.00, currency: 'USD'});
    fbq('track', 'Lead');
    fbq('track', 'ViewContent');
</script>
@endsection

@section('content')
    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 navbar--transparent">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center text-white me-4 transition-all" href="javascript:history.go(-1)" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default transition-all opacity-0 invisible">{{ @$title }}</span>
                </div>
                <div class="navbar__right d-flex align-items-center">
                    <button class="link-base transition-all opacity-0 invisible ms-4" aria-label="Share" data-bs-toggle="modal" data-bs-target="#modalShare"><i class="text-2xl rck ryd-share"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id={{ @$data->gtm }}"
    height="0" width="0" style="display:none;visibility:hidden">
        </iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ @$data->fb_pixel }}&ev=PageView&noscript=1"/>
    </noscript>
    <!-- CONTENT-->
    <main class="campaign-detail">
        <section class="bg-white pb-6">
            <div class="position-relative bg-skeleton w-full">
                <img class="w-full" src="{{ asset('assets/images/campaign/'. $data->image) }}" alt="{{ $data->title }}">
                <div class="position-absolute top-0 w-full h-full bg-overlay rotate-180"></div>
            </div>
            <div class="container">
                <div class="pt-4">
                    <div class="d-flex align-items-center justify-content-between"><span class="badge bg-secondary">{{ $data->hasCategory->name }}</span>
                        <button class="rck ryd-share text-default link-base" aria-label="share" data-bs-toggle="modal" data-bs-target="#modalShare"></button>
                    </div>
                    <p class="campaign-detail__title text-base text-default fw-bold mt-4" title="{{ $data->title }}">{{ $data->title }}</p>
                    <p class="mt-2 fw-bold">{{ $data->total_donatur ?? 0 }} Donatur</p>
                    <div class="d-flex align-items-center justify-content-between mt-4"><span>Terkumpul </span>
                        <div class="d-flex align-items-center">
                            @if($data->open_goal == 1)
                            <img src="{{ asset('frontoffice/assets/img/infinity.png') }}" class="lh-1 text-xs ms-2" width="20px">
                            @else
                            <i class="mt-n0_75 rck ryd-time text-default text-primary"></i>
                            <span class="lh-1 text-xs ms-2">{{ ($data->selisih_validate > 0) ? $data->selisih_validate : '0' }} hari lagi</span>
                            @endif
                        </div>
                    </div>
                    <div class="progress mt-2">
                        @if($data->open_goal == 1)
                        <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="{{ number_format('100','2') }}" aria-valuemin="0" aria-valuemax="100"></div>
                        @else
                        <div class="progress-bar" role="progressbar" style="width:{{ $data->percentage }}%" aria-valuenow="{{ number_format($data->percentage,'2') }}" aria-valuemin="0" aria-valuemax="100"></div>
                        @endif
                    </div>
                    <div class="d-flex align-items-center justify-content-between text-default mt-2"> 
                        <span class="rp ns fw-medium text-secondary">{{ number_format($data->total_amount,0,'.','.') }}</span>
                        @if($data->open_goal == 1)
                        <span class="fw-bold">Open Goal</span>
                        @else
                        <span class="rp ns fw-bold">{{ number_format($data->target,0,'.','.') }}</span>
                        @endif
                    </div>
                    <a class="campaign-detail__main-cta link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" href="{{ route('frontoffice.payment', ['slug' => $data->slug]) }}"> <span>Donasi Sekarang</span><i class="text-default ms-2 rck ryd-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
        <div class="floating-btn floating-btn--hide z-100">
            <div class="container bg-white pb-4"><a class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium" href="{{ route('frontoffice.payment', ['slug' => $data->slug]) }}"><span>Donasi Sekarang</span><i class="text-default ms-2 rck ryd-arrow-right"> </i></a>
            </div>
        </div>
        <section class="bg-white py-4 mt-2">
            <div class="container">
                <div class="d-flex align-items-center mb-4"><i class="text-default me-2 rck ryd-info"></i><span class="fw-bold">Penggalang Dana</span>
                </div>
                @if($data->hasUser->type_campaigner == 'PERSONAL')
                <a class="text-base d-flex align-items-center" href="{{ route('frontoffice.campaigner', ['type' => 'PERSONAL', 'id' => $data->encodeHash($data->hasCampaign->hasUser->id)]) }}">
                    <div class="bg-skeleton w-8 h-8 rounded-md overflow-hidden shadow">
                        <img class="w-full h-full object-cover" src="{{ $data->hasUser->image ? asset('assets/images/donatur/'. $data->hasUser->image) : asset('frontoffice/assets/uploads/images/no-avatar-square.png') }}" alt="{{ $data->hasUser->name }}">
                    </div>
                    <div class="d-flex align-items-center ms-2 flex-1">
                        <span class="fw-medium line-clamp-1">{{ $data->hasUser->name }}</span>
                        <i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i>
                    </div>
                </a>
                @else
                <a class="text-base d-flex align-items-center" href="{{ route('frontoffice.campaigner', ['type' => 'CORPORATE', 'id' => $data->encodeHash($data->hasUser->hasCorporate->id)]) }}">
                    <div class="bg-skeleton w-8 h-8 rounded-md overflow-hidden shadow">
                        <img class="w-full h-full object-cover" src="{{ isset($data->hasUser->hasCorporate->image) ? asset('assets/images/corporate/'. @$data->hasUser->hasCorporate->image) : asset('frontoffice/assets/uploads/images/no-avatar-square.png') }}" alt="{{ @$data->hasUser->hasCorporate->corporate_name }}">
                    </div>
                    <div class="d-flex align-items-center ms-2 flex-1">
                        <span class="fw-medium line-clamp-1">{{ @$data->hasUser->hasCorporate->corporate_name }}</span>
                        <i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i>
                    </div>
                </a>
                @endif
            </div>
        </section>
        <section class="bg-white py-4 mt-2">
            <div class="container">
                <div class="d-flex align-items-center mb-4"><span class="fw-bold">Deskripsi</span>
                </div>
                <article class="line-clamp-3">
                    <p>{!! $data->description !!}</p>
                </article>
                <button class="campaign-detail__more-btn fw-medium text-primary w-full" type="button" data-bs-toggle="modal" data-bs-target="#modalDescription">Selengkapnya</button>
                <div class="modal fade" tabindex="-1" aria-labelledby="modalDescriptionLabel" aria-hidden="true" id="modalDescription">
                    <div class="modal-dialog">
                        <div class="modal-content h-full">
                            <div class="modal-body align-center">
                                <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                                    <div class="container">
                                        <h2 class="d-flex align-items-center">
                                            <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Deskripsi</span>
                                        </h2>
                                    </div>
                                </div>
                                <div class="modal-body__inner pt-4 pb-6 overflow-x-hidden overflow-y-auto">
                                    <div class="container">
                                        <article>
                                           {!! $data->description !!}
                                        </article>
                                        <div class="bg-gray-light bg-opacity-40 rounded-xs py-3 px-4 mt-6"> <strong>Disclaimer:  </strong>Informasi, opini dan foto yang ada di halaman galang dana ini adalah milik dan tanggung jawab penggalang dana. Jika ada masalah/kecurigaan silakan <a class="fw-medium" href="http://wa.me/6289666905702"
                                            target="_blank">lapor kepada kami disini</a>.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white py-4 mt-2">
            <div class="container">
                <div class="d-flex align-items-center mb-4"><i class="text-default me-2 rck ryd-update"></i><span class="fw-bold">Kabar Terbaru</span>
                </div>
                @if(count($programUpdate) <= 0)
                <!-- IF EMPTY STATE-->
                <div class="text-center py-4">
                    <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-update text-12 text-primary"></i>
                    </div>
                    <div class="fw-medium mt-3">Belum ada kabar terbaru</div>
                </div>
                @else
                <!-- END IF-->
                <ul class="campaign-detail__updates h-60 overflow-hidden">
                    <li>
                        @foreach($programUpdate->take(1) as $row)
                        <div class="text-base d-flex align-items-center mb-4">
                            @if($row->hasCampaign->hasUser->type_campaigner == 'PERSONAL')
                            <div class="bg-skeleton w-10 h-10 rounded-md overflow-hidden shadow">
                                <img class="w-full h-full object-cover" src="{{ $row->hasCampaign->hasUser->image ? asset('assets/images/donatur/'. $row->hasCampaign->hasUser->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="{{ $row->hasCampaign->hasUser->name }}">
                            </div>
                            <div class="ms-3"><a class="link-base d-flex align-items-center flex-1" href="{{ route('frontoffice.campaigner', ['type' => 'PERSONAL', 'id' => $data->encodeHash($data->hasCampaign->hasUser->id)]) }}"><span class="fw-medium line-clamp-1">{{ $row->hasCampaign->hasUser->name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i></a>
                                <time class="text-secondary fw-medium text-xs">{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}</time>
                            </div>
                            @else
                            <div class="bg-skeleton w-10 h-10 rounded-md overflow-hidden shadow">
                                <img class="w-full h-full object-cover" src="{{ asset('assets/images/corporate/'. $row->hasCampaign->hasUser->hasCorporate->image) }}" alt="{{ $row->hasCampaign->hasUser->hasCorporate->corporate_name }}">
                            </div>
                            <div class="ms-3"><a class="link-base d-flex align-items-center flex-1" href="{{ route('frontoffice.campaigner', ['type' => 'CORPORATE', 'id' => $data->encodeHash($data->hasCampaign->hasUser->id)]) }}"><span class="fw-medium line-clamp-1">{{ $row->hasCampaign->hasUser->hasCorporate->corporate_name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i></a>
                                <time class="text-secondary fw-medium text-xs">{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}</time>
                            </div>
                            @endif
                        </div>
                        <article>
                           {!! $row->content !!}
                        </article>
                        @endforeach
                    </li>
                </ul>
                <button class="campaign-detail__more-btn fw-medium text-primary w-full" type="button" data-bs-toggle="modal" data-bs-target="#modalUpdates">
                    <div class="d-flex align-items-center justify-content-center"><span>Lihat Lebih Banyak</span><i class="rck ryd-chevron-down ms-2 text-default"></i>
                    </div>
                </button>
                @endif
                <div class="modal fade" tabindex="-1" aria-labelledby="modalUpdatesLabel" aria-hidden="true" id="modalUpdates">
                    <div class="modal-dialog">
                        <div class="modal-content h-full">
                            <div class="modal-body align-center">
                                <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                                    <div class="container">
                                        <h2 class="d-flex align-items-center">
                                            <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Kabar Terbaru</span>
                                        </h2>
                                    </div>
                                </div>
                                <div class="modal-body__inner pt-4 pb-6 overflow-x-hidden overflow-y-auto">
                                    <div class="container">
                                        <ul class="campaign-detail__updates">
                                            @foreach($programUpdate as $row)
                                            <li>
                                                @if($row->hasCampaign->hasUser->type_campaigner == 'PERSONAL')
                                                <div class="text-base d-flex align-items-center mb-4">
                                                    <div class="bg-skeleton w-10 h-10 rounded-md overflow-hidden shadow">
                                                        <img class="w-full h-full object-cover" src="{{ $row->hasCampaign->hasUser->image ? asset('assets/images/donatur/'. $row->hasCampaign->hasUser->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="{{ $row->hasCampaign->hasUser->name }}">
                                                    </div>
                                                    <div class="ms-3"><a class="link-base d-flex align-items-center flex-1" href="{{ route('frontoffice.campaigner', ['type' => 'PERSONAL', 'id' => $data->encodeHash($data->hasCampaign->hasUser->id)]) }}"><span class="fw-medium line-clamp-1">{{ $row->hasCampaign->hasUser->name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i></a>
                                                        <time class="text-secondary fw-medium text-xs">{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}</time>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="text-base d-flex align-items-center mb-4">
                                                    <div class="bg-skeleton w-10 h-10 rounded-md overflow-hidden shadow">
                                                        <img class="w-full h-full object-cover" src="{{ asset('assets/images/corporate/'. $row->hasCampaign->hasUser->hasCorporate->image) }}" alt="{{ $row->hasCampaign->hasUser->hasCorporate->corporate_name }}">
                                                    </div>
                                                    <div class="ms-3"><a class="link-base d-flex align-items-center flex-1" href="{{ route('frontoffice.campaigner', ['type' => 'CORPORATE', 'id' => $data->encodeHash($data->hasUser->hasCorporate->id)]) }}"><span class="fw-medium line-clamp-1">{{ $row->hasCampaign->hasUser->hasCorporate->corporate_name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i></a>
                                                        <time class="text-secondary fw-medium text-xs">{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}</time>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <article>
                                                   {!! $row->content !!}
                                                </article>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white py-4 mt-2">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center"><i class="text-default me-2 rck ryd-speaker"></i><span class="fw-bold">Fundraiser</span>
                    </div><span class="text-end">{{ count($fundraiser ?? 0) }} Fundraiser</span>
                </div>
                @if($cekFundraiser != null) 
                <div class="border border-gray-light rounded-xs p-4">
                    <p>Bagikan Campaign ini.</p><a class="campaign-detail__main-cta link-btn link-btn-primary h-10 w-full rounded-xs fw-medium mt-4" href="{{ route('frontoffice.fundraiser-register', [ 'slug' => $data->slug]) }}"><span>Salin Link</span></a>
                </div>
                @else
                <div class="border border-gray-light rounded-xs p-4">
                    <p>Mulai perjalanan kebaikan sebagai fundraiser Campaign ini.</p>
                    <button class="campaign-detail__main-cta link-btn link-btn-primary h-10 w-full rounded-xs fw-medium mt-4" type="button" data-bs-toggle="modal" data-bs-target="#modalFundraise"><span>Jadi Fundraiser</span>
                    </button>
                </div>
                @endif
                @if(isset($fundraiser))
                <ul class="campaign-detail__fundraiser my-4">
                    @foreach($fundraiser->take(2) as $row)
                    <li class="border border-gray-light rounded-xs p-4">
                        <div class="d-flex">
                            <div class="bg-skeleton w-12 h-12 rounded-circle overflow-hidden shadow">
                                <img class="w-full h-full object-cover" src="{{ isset($row->hasFundraiser->image) ? asset('assets/images/donatur/'. $row->hasFundraiser->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="{{ $row->hasFundraiser->name }}">
                            </div>
                            <div class="flex-1 ms-3 mt-0_75"><span class="text-base d-flex align-items-center flex-1"><span class="fw-medium line-clamp-1">{{ $row->hasFundraiser->name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i>
                                </span>
                                <time class="text-secondary fw-medium text-default rp ns">{{ $row->nominalTransaksi + $row->uniqueCode }}</time>
                                <p class="mt-2">Berhasil mengajak {{ $row->jumlahTransaksi ?? 0 }} orang memulai perjalanan kebaikan</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
                @if(count($fundraiser) > 0)
                <button class="campaign-detail__more-btn fw-medium text-primary w-full" type="button" data-bs-toggle="modal" data-bs-target="#modalFundraiser">
                    <div class="d-flex align-items-center justify-content-center"><span>Lihat Lebih Banyak</span><i class="rck ryd-chevron-down ms-2 text-default"></i>
                    </div>
                </button>
                @endif
                <div class="modal fade" tabindex="-1" aria-labelledby="modalFundraiserLabel" aria-hidden="true" id="modalFundraiser">
                    <div class="modal-dialog">
                        <div class="modal-content h-full">
                            <div class="modal-body align-center">
                                <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                                    <div class="container">
                                        <h2 class="d-flex align-items-center">
                                            <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Fundraiser</span>
                                        </h2>
                                    </div>
                                </div>
                                
                                <livewire:list-fundraiser :campaign_id="$data->id" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white py-4 mt-2">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center"><i class="text-default me-2 rck ryd-user"></i><span class="fw-bold">Total Donatur</span>
                    </div><span class="text-end">{{ count($donatur) ?? 0 }} Donatur</span>
                </div>
                @if(count($donatur) <= 0)
                <!-- IF EMPTY STATE-->
                <div class="text-center py-4">
                    <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-user text-12 text-primary"></i>
                    </div>
                    <div class="fw-medium mt-3">Belum ada donatur</div>
                </div>
                <!-- END IF-->
                @else
                <ul class="campaign-detail__fundraiser my-4">
                    @foreach($donatur->take(1) as $row)
                    <li class="border border-gray-light rounded-xs p-4">
                        <div class="d-flex">
                            <div class="bg-skeleton w-12 h-12 rounded-circle overflow-hidden shadow">
                                <img class="w-full h-full object-cover" src="{{ isset($row->hasUser->image) ? asset('assets/images/donatur/'. $row->hasUser->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="{{ $row->name }}">
                            </div>
                            <div class="flex-1 ms-3 mt-0_75">
                                <span class="text-base d-flex align-items-center flex-1">
                                    <span class="fw-medium line-clamp-1">
                                        @if($row->is_hamba_allah == 0)
                                        {{ $row->name }}
                                        @else
                                        Hamba Allah
                                        @endif
                                    </span>
                                </span>
                                <time class="text-secondary fw-medium text-default rp ns">{{ $row->amount+$row->unique_code }}</time>
                                <p class="mt-2">{{ $row->note }}</p>
                                @if(auth()->guard('member')->user())
                                    @if(count($row->hasLikes->where('donatur_id', auth()->guard('member')->user()->id)) > 0)
                                        @foreach($row->hasLikes->where('donatur_id', auth()->guard('member')->user()->id) as $likes)
                                            <button class="love-btn d-flex align-items-center mt-2 link-base-light " value="{{ $row->id }}" onclick="amen(this.value, {{ ($likes->donatur_id == auth()->guard('member')->user()->id) ? 0 : 1 }})">
                                                <i class="transition-all rck ryd-heart like {{ ($likes->donatur_id == auth()->guard('member')->user()->id) ? 'link-primary ryd-heart-fill' : '' }} "></i>
                                                <span class="ms-2 text-xxs">Aminkan doa</span>
                                            </button>
                                        @endforeach
                                    @else
                                    <button class="love-btn d-flex align-items-center mt-2 link-base-light " value="{{ $row->id }}" onclick="amen(this.value, 1)">
                                        <i class="transition-all rck ryd-heart like"></i>
                                        <span class="ms-2 text-xxs">Aminkan doa</span>
                                    </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <button class="campaign-detail__more-btn fw-medium text-primary w-full" type="button" data-bs-toggle="modal" data-bs-target="#modalDonatur">
                    <div class="d-flex align-items-center justify-content-center"><span>Lihat Lebih Banyak</span><i class="rck ryd-chevron-down ms-2 text-default"></i>
                    </div>
                </button>
                @endif
                <div class="modal fade" aria-labelledby="modalDonaturLabel" aria-hidden="true" id="modalDonatur">
                    <div class="modal-dialog">
                        <div class="modal-content h-full">
                            <div class="modal-body align-center">
                                <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                                    <div class="container">
                                        <h2 class="d-flex align-items-center">
                                            <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Total Donatur</span>
                                        </h2>
                                    </div>
                                </div>
                                <livewire:list-doa-donatur :campaign_id="$data->id" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="bg-white h-16"></div>
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
                                        <a class="d-block link-base mx-auto text-center w-max" href="{{'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdonasi.co%2Fdetail%2F'.$data->slug.'&amp;src=sdkpreparse'}}" target="_blank">
                                            <div class="bg-skeleton overflow-hidden w-10 h-10 rounded-xs mx-auto">
                                                <img class="w-full h-full object-cover" src="{{ asset('frontoffice/assets/img/icon/facebook.svg') }}" alt="icon Facebook">
                                            </div><span class="text-xs d-inline-block mt-2">Facebook</span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="d-block link-base mx-auto text-center w-max whatsapp" data-text="{{ $data->title }}" data-link="{{ route('frontoffice.campaignDetail',['slug' => $data->slug]) }}" target="_blank">
                                            <div class="bg-skeleton overflow-hidden w-10 h-10 rounded-xs mx-auto">
                                                <img class="w-full h-full object-cover" src="{{ asset('frontoffice/assets/img/icon/whatsapp.svg') }}" alt="icon Whatsapp">
                                            </div><span class="text-xs d-inline-block mt-2">Whatsapp</span>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="d-block link-base mx-auto text-center w-max" href="https://twitter.com/intent/tweet?url={{ route('frontoffice.campaignDetail',['slug' => $data->slug]) }}"&text="{{ $data->title }}" target="_blank">
                                            <div class="bg-skeleton overflow-hidden w-10 h-10 rounded-xs mx-auto">
                                                <img class="w-full h-full object-cover" src="{{ asset('frontoffice/assets/img/icon/twitter.svg') }}" alt="icon Twitter">
                                            </div><span class="text-xs d-inline-block mt-2">Twitter</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex mt-8">
                                    <div class="w-0 h-12 flex-1 d-flex align-items-center border border-gray-light rounded rounded-xs text-base px-4">
                                        <div class="user-select-all line-clamp-1 text-xs" id="link">{{ Request::url() }}</div>
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
        <!-- Register Fundraiser-->
        <div class="modal fade" tabindex="-1" aria-labelledby="modalFundraiseLabel" aria-hidden="true" id="modalFundraise" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog d-flex align-items-center px-4 px-ss-6">
                <div class="modal-content mh-85h rounded-md">
                    <div class="modal-body align-center">
                        <div class="modal-body__header d-flex align-items-center h-12 transition-all">
                            <div class="container">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2 class="text-default me-4">Jadi Fundraiser</h2>
                                    <button class="text-xl" data-bs-dismiss="modal"><i class="rck ryd-close"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body__inner _sm pt-4 pb-6 overflow-auto">
                            <div class="container">
                                <form method="GET" action="{{ route('frontoffice.fundraiser-register',[ 'slug' => $data->slug]) }}">
                                    <div class="text-center"><i class="rck ryd-speaker text-30 text-primary"></i>
                                        <h1 class="h4 text-center mt-2">Halo, Kak.</h1>
                                        <p class="text-center mt-4">Sebelum jadi fundraiser untuk campaign <span class="fw-medium text-secondary">{{ $data->title }}</span>, kamu harus menyetujui Syarat & Ketentuan yang berlaku.</p>
                                    </div>
                                    <label class="cb mt-8">
                                        <div class="cb__box" id="terms">
                                            <input class="d-none" type="checkbox">
                                            <div></div>
                                        </div><span class="user-select-none ms-3">Saya menyetujui <a class="link-primary fw-medium" href="{{ route('frontoffice.term-fundraiser') }}" target="_blank">Syarat & Ketentuan</a> yang berlaku.</span>
                                    </label>
                                    <button href="{{ route('frontoffice.fundraiser-register',[ 'slug' => $data->slug ])}}" class="submit link-btn link-btn-primary h-12 w-full mt-4 rounded-xs fw-medium" type="submit" disabled><span>Jadi Fundraiser</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
    
@section('bottom-resource')

@livewireScripts
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/vendor/swiper-bundle.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/clipboard.init.js') }}"></script>
    <script type="text/javascript">
        // window.onscroll = function (ev) {
        //     if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        //         window.livewire.emit('post-data');
        //     }
        // };


        // $('.modalScrollable').on("scroll", function() {      
        //     if ((window.innerHeight + window.scrollY) >= $(this)[0].offsetHeight) {
        //         window.livewire.emit('post-data');
        //     }
        //     //     window.livewire.emit('post-data');
        //     // console.log($(this))
        // });

        $('.listDonatur').scroll(function() {
              const thisScrollHeight = $(this).prop('scrollHeight')
              const thisScrollTop = $(this).scrollTop()
              const thisHeight = $(this).height()
              const spanSpacing = 40
          
              //- console.log(thisScrollHeight)
              //- console.log(thisHeight + thisScrollTop + spanSpacing
          
              if (thisScrollHeight === (thisHeight + thisScrollTop + spanSpacing)) {
                  // eksekusi kode loadmore disini
                window.livewire.emit('post-data');
              }
          })

          $('.listFundraiser').scroll(function() {
              const thisScrollHeight = $(this).prop('scrollHeight')
              const thisScrollTop = $(this).scrollTop()
              const thisHeight = $(this).height()
              const spanSpacing = 40
          
              //- console.log(thisScrollHeight)
              //- console.log(thisHeight + thisScrollTop + spanSpacing
          
              if (thisScrollHeight === (thisHeight + thisScrollTop + spanSpacing)) {
                  // eksekusi kode loadmore disini
                window.livewire.emit('post-data-fundraiser');
              }
          })
    </script>
    <script>
        function amen(transactionId, val){
          
            var url = "{{ route('frontoffice.amen') }}" + '/' + transactionId + '/' + val;
                $.ajax({
                    url   : url,
                    method: 'GET',
                    success: function(response){
                        console.log(response);
                    }
                });
                    
        }
    </script>
    <script>
        $(window).scroll(function() {
            var campaignDetailTitle = $('.campaign-detail__title').offset().top
            var campaignDetailMainCTA = $('.campaign-detail__main-cta').offset().top
        
            if ($(this).scrollTop() > campaignDetailTitle - 48) {
                $('.navbar--transparent .navbar__left span').removeClass('opacity-0').removeClass('invisible');
                $('.navbar--transparent .navbar__right button').removeClass('opacity-0').removeClass('invisible');
            } else {
                $('.navbar--transparent .navbar__left span').addClass('opacity-0').addClass('invisible');
                $('.navbar--transparent .navbar__right button').addClass('opacity-0').addClass('invisible');
            }
        
            if ($(this).scrollTop() > campaignDetailMainCTA - 48) {
                $('.floating-btn').removeClass('floating-btn--hide');
            } else {
                $('.floating-btn').addClass('floating-btn--hide');
            }
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

        // $.ajax({
        //     url: "/checkLike/" + campaignerId + '/' + campaignId,
        //     method: 'GET',
        //     data: {
        //         campaignerId: campaignerId,
        //         campaignId: campaignId
        //     },
        //     success: function (data) {
        //         var data = JSON.parse(data);
        //         console.log(data)
        //         // if(data.data == "like"){
        //         //     $(".like").addClass('link-primary ryd-heart-fill');
        //         // }else{
        //         //     $(".like").removeClass('link-primary ryd-heart-fill');
        //         // }
        //     }
        // });

    </script>
@endsection