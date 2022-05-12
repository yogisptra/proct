@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- Vendor style -->

@endsection

@section('content')
    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="{{ route('dashboard-widhdrawal', $campaign->slug) }}" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">{{ $title }}</span>
                </div>
                <div class="navbar__right d-flex align-items-center"></div>
            </div>
        </div>
    </nav>

    <!-- CONTENT-->
    <main class="mt-18">
        @if(count($data) <= 0)
        <section class="maxview bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <div class="text-center py-4">
                    <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-wallet text-12 text-primary"></i>
                    </div>
                    <div class="h4 text-center mt-3">Belum ada update.</div>
                    <a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="{{ route('campaign-update.new', $campaign->encodeHash($campaign->id)) }}">Tambah Update</a>
                </div>
            </div>
        </section>
        @else
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <div class="d-flex aling-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center"><i class="text-default me-2 rck ryd-update"></i><span class="fw-bold">Kabar Terbaru</span>
                    </div><a class="d-flex align-items-center link-primary fw-medium" href="{{ route('campaign-update.new', $campaign->encodeHash($campaign->id)) }}"><i class="rck ryd-plus me-1"></i><span>Tambah</span></a>
                </div>
                <div class="row g-4">
                    @foreach($data as $row)
                    <div class="col-12">
                        <div class="position-relative">
                            <button class="text-start w-full text-base-light border border-gray-light rounded-xs py-4 px-3 modalDetail" type="button" data-bs-toggle="modal" data-bs-target="#modalDetail" data-id="{{ $row }}">
                                <div class="text-base d-flex align-items-center mb-4">
                                    @if($row->hasCampaign->hasUser->type_campaigner == 'PERSONAL')
                                    <div class="bg-skeleton w-10 h-10 rounded-md overflow-hidden shadow" href="">
                                        <img class="w-full h-full object-cover image" src="{{ $row->hasCampaign->hasUser->image ? asset('assets/images/donatur/'. $row->hasCampaign->hasUser->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="{{ $row->hasCampaign->hasUser->name }}">
                                    </div>
                                    <div class="ms-3"><a class="link-base d-flex align-items-center flex-1" href="{{ route('frontoffice.campaigner', ['type' => 'PERSONAL', 'id' => $row->encodeHash($row->hasCampaign->hasUser->id)]) }}"><span class="fw-medium line-clamp-1 name">{{ $row->hasCampaign->hasUser->name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i></a>
                                        <time class="text-secondary fw-medium text-xs dateTime">{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}</time>
                                    </div>
                                    @else
                                    <div class="bg-skeleton w-10 h-10 rounded-md overflow-hidden shadow" href="">
                                        <img class="w-full h-full object-cover image" src="{{ asset('assets/images/corporate/'. $row->hasCampaign->hasUser->hasCorporate->image) }}" alt="{{ $row->hasCampaign->hasUser->hasCorporate->corporate_name }}">
                                    </div>
                                    <div class="ms-3"><a class="link-base d-flex align-items-center flex-1" href="{{ route('frontoffice.campaigner', ['type' => 'CORPORATE', 'id' => $row->encodeHash($row->hasCampaign->hasUser->hasCorporate->id)]) }}"><span class="fw-medium line-clamp-1 name">{{ $row->hasCampaign->hasUser->hasCorporate->corporate_name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i></a>
                                        <time class="text-secondary fw-medium text-xs dateTime">{{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}</time>
                                    </div>
                                    @endif
                                </div>
                                <p class="line-clamp-3">{!! $row->content !!}</p>
                            </button>
                            <button class="position-absolute top-4 right-3 w-8 h-5 d-flex align-items-center justify-content-end modalLainnya" arial-label="More" type="button" data-bs-toggle="modal" data-bs-target="#modalMore" data-id={{ $row->encodeHash($row->id) }}><i class="rck ryd-more text-base-light"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        <div class="modal fade" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true" id="modalDetail">
            <div class="modal-dialog">
                <div class="modal-content h-full">
                    <div class="modal-body align-center">
                        <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                            <div class="container">
                                <h2 class="d-flex align-items-center">
                                    <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Detail</span>
                                </h2>
                            </div>
                        </div>
                        <div class="modal-body__inner pt-4 pb-6 overflow-x-hidden overflow-y-auto">
                            <div class="container">
                                <div class="text-base d-flex align-items-center mb-4">
                                    <div class="bg-skeleton w-10 h-10 rounded-md overflow-hidden shadow">
                                        <img class="w-full h-full object-cover" id="image">
                                    </div>
                                    <div class="ms-3"><a class="link-base d-flex align-items-center flex-1" id="hrefDetail"><span class="fw-medium line-clamp-1" id="name"></span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i></a>
                                        <time class="text-secondary fw-medium text-xs" id="date"></time>
                                    </div>
                                </div>
                                <article id="content"></article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" aria-labelledby="modalMoreLabel" aria-hidden="true" id="modalMore">
            <div class="modal-dialog d-flex align-items-end">
                <div class="modal-content mh-85h rounded-top-md">
                    <div class="modal-body align-center">
                        <div class="modal-body__header d-flex align-items-center h-12 transition-all">
                            <div class="container">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2 class="text-default me-4">Lainnya</h2>
                                    <button class="text-xl" data-bs-dismiss="modal"><i class="rck ryd-close"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body__inner _sm pt-4 pb-6 overflow-auto">
                            <div class="container">
                                <div class="row g-4">
                                    <div class="col-12"><a class="d-flex align-items-center link-base-light fw-medium" id="editHref"><i class="rck ryd-edit me-2"> </i><span>Edit</span></a>
                                    </div>
                                    <div class="col-12">
                                        <button class="d-flex align-items-center link-danger fw-medium" data-bs-dismiss="modal" type="button" data-bs-toggle="modal" data-bs-target="#modalDelete"><i class="rck ryd-delete me-2"></i><span>Hapus</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog d-flex align-items-center px-4 px-ss-6">
                <div class="modal-content mh-85h rounded-md">
                    <div class="modal-body align-center">
                        <div class="modal-body__header d-flex align-items-center h-12 transition-all">
                            <div class="container">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2 class="text-default me-4"></h2>
                                    <button class="text-xl" data-bs-dismiss="modal"><i class="rck ryd-close"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body__inner _sm pt-4 pb-6 overflow-auto">
                            <div class="container">
                                <div class="text-center">
                                    <h4 class="h5">Hapus Kabar Terbaru?</h4>
                                    <p class="mt-2">Apakah yakin ingin menghapus kabar terbaru?</p>
                                </div>
                                <div class="row g-4 mt-4">
                                    <div class="col-6"><a class="link-btn link-btn-primary-o h-12 w-full rounded-xs fw-medium" id="deleteHref">Yakin</a>
                                    </div>
                                    <div class="col-6">
                                        <button class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium" data-bs-dismiss="modal">Tidak</button>
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
    <!-- WARNING! this scripts below used for this page only-->
    <script>
        $(document).ready(function(){
            $(".modalLainnya").click(function() {
                let value = $(this).attr("data-id");
                var url = "{{ route('campaign-update.edit', ':id') }}";
                url = url.replace(':id', value);

                var urlEdit =  $('#editHref').attr('href', url);

                var url2 = "{{ route('campaign-update.delete', ':id') }}";
                url2 = url2.replace(':id', value);

                var urlDelete =  $('#deleteHref').attr('href', url2);
            });

            $(".modalDetail").click(function() {
                let value = $(this).attr("data-id");
                let dateTime = $(this).find('.dateTime').html();
                let image = $(this).find('.image').attr('src');
                let name = $(this).find('.name').html();
                let data = JSON.parse(value)
                    $('#content').html(data.content)
                    $('#date').html(dateTime)
                    $('#image').attr('src', image)
                    $('#name').html(name)

            });
        });
    </script>
@endsection