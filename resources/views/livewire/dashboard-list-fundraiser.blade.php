<div>
    <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
        <div>
            <div id="filter-wrapper"></div>
            <div id="filter">
                <div class="container bg-white">
                    <div class="row gx-0">
                        <div class="col-4">
                            <button class="w-full d-flex align-items-center justify-content-center p-4" type="button" data-bs-toggle="modal" data-bs-target="#modalCategoryVirtual"><i class="text-primary text-default rck ryd-category"></i><span class="ms-2 text-base">Kategori</span>
                            </button>
                        </div>
                        <div class="col-4">
                            <button class="w-full d-flex align-items-center justify-content-center p-4" type="button" data-bs-toggle="modal" data-bs-target="#modalSort"><i class="text-primary text-default rck ryd-sort"></i><span class="ms-2 text-base">Urutkan</span>
                            </button>
                        </div>
                        <div class="col-4">
                            <button class="w-full d-flex align-items-center justify-content-center p-4" type="button" data-bs-toggle="modal" data-bs-target="#modalFilter"><i class="text-primary text-default rck ryd-filter"></i><span class="ms-2 text-base">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($data) <= 0)
            <div class="container">
                <div class="text-center py-4">
                    <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-speaker text-12 text-primary"></i>
                    </div>
                    <div class="fw-medium mt-3">Kamu belum menjadi fundraiser</div>
                    <p class="text-center mt-4">Ajak temanmu sebarkan program yang sudah ada ke sahabat atau sosial media supaya orang lain tahu tentang kegiatan kamu.</p><a class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" href="{{ route('frontoffice.campaignList') }}">Cari Campaign</a>
                </div>
            </div>
            @endif
            <div class="container">
                <div class="row g-6">
                    @foreach($data as $row)
                    <div class="col-12">
                        <div class="position-relative">
                            <a class="user-select-none d-flex align-items-center" href="{{ route('dashboard-fundraiserDetail', $row->encodeHash($row->campaign_id)) }}">
                                <div class="position-relative bg-skeleton w-16 h-16 rounded-xs overflow-hidden shadow">
                                    <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $row->hasCampaign->image) }}" alt="{{ $row->hasCampaign->title }}">
                                </div>
                                <div class="ps-2 flex-1 text-xs">
                                    <div class="d-flex align-items-center">
                                        @if($row->hasCampaign->hasUser->type_campaigner == 'PERSONAL')
                                        <span class="h-4_5 d-block text-gray line-clamp-1">{{ $row->hasCampaign->hasUser->name }}</span>
                                        @else
                                        <span class="h-4_5 d-block text-gray line-clamp-1">{{ $row->hasCampaign->hasUser->hasCorporate->corporate_name }}</span>
                                        @endif
                                        <i class="ms-1 mt-n0_25 text-primary rck ryd-verified-simple"></i>
                                    </div>
                                    <p class="text-base fw-medium line-clamp-1 pe-8 mt-1" title="{{ $row->hasCampaign->title }}">{{ $row->hasCampaign->title }}</p>
                                    <div class="d-flex align-items-center justify-content-between mt-1"><span class="text-base-light">{{ $row->total_donatur ?? 0 }} Donatur</span><span class="text-secondary fw-medium rp ns">{{ number_format($row->sum('amount')+$row->sum('unique_code'),0,'.','.') }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" tabindex="-1" aria-labelledby="modalCategoryVirtualLabel" aria-hidden="true" id="modalCategoryVirtual">
        <div class="modal-dialog">
            <div class="modal-content h-full">
                <div class="modal-body align-center">
                    <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                        <div class="container">
                            <h2 class="d-flex align-items-center">
                                <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button>
                                <span class="text-default ms-4">Kategori</span>
                            </h2>
                        </div>
                    </div>
                    <div class="modal-body__inner pt-4 pb-6 overflow-x-hidden overflow-y-auto">
                        <div class="container">
                            <div class="row gx-1 gy-4 text-center">
                                <div class="col-3">
                                    <button wire:click="categories('')" class="pill-category categoryAll {{ ($hasFilterCategory == null) ? '_selected' : '' }}" name="cVirtual" value="cVirtualAll" data-bs-dismiss="modal">
                                        <div class="_wrap mx-auto d-flex align-items-center justify-content-center w-14 w-ss-16 h-14 h-ss-16 rounded-circle">
                                            <img class="svg w-5 w-ss-6" src="{{ asset('frontoffice/assets/img/icon/donasico.svg') }}" alt="Icon Semua Kategori">
                                        </div>
                                    </button><span class="px-4 h-9 line-clamp-2 d-flex align-items-center justify-content-center text-xs text-base user-select-none mt-4">Semua Kategori</span>
                                </div>
                                @foreach($category as $row)
                                <div class="col-3">
                                    <button wire:click="categories({{$row->id}})" class="pill-category category {{ ($hasFilterCategory == $row->id) ? '_selected' : '' }}" name="category" value="{{ $row->id }}" data-bs-dismiss="modal">
                                        <div class="_wrap mx-auto d-flex align-items-center justify-content-center w-14 w-ss-16 h-14 h-ss-16 rounded-circle">
                                            <img class="svg w-5 w-ss-6" src="{{ asset('assets/images/category/'. $row->icon) }}" alt="{{ $row->name }}">
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
    <div class="modal fade" tabindex="-1" aria-labelledby="modalSortLabel" aria-hidden="true" id="modalSort">
        <div class="modal-dialog d-flex align-items-end">
            <div class="modal-content mh-85h rounded-top-md">
                <div class="modal-body align-center">
                    <div class="modal-body__header d-flex align-items-center h-12 transition-all">
                        <div class="container">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-default me-4">Urutkan</h2>
                                <button class="text-xl" data-bs-dismiss="modal"><i class="rck ryd-close"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body__inner _sm pt-4 pb-6 overflow-auto">
                        <div class="container">
                            <div class="row g-4">
                                <div class="col-12">
                                    <button wire:click="sortBy('asc')" class="d-flex align-items-center  {{ ($sortBy == 'asc') ? 'link-primary':'link-base-light' }} fw-medium" data-bs-dismiss="modal" type="button"><span>Terbaru</span>
                                    </button>
                                </div>
                                <div class="col-12">
                                    <button wire:click="sortBy('desc')" class="d-flex align-items-center {{ ($sortBy == 'desc') ? 'link-primary':'link-base-light' }} fw-medium" data-bs-dismiss="modal" type="button"><span>Terlama</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" aria-labelledby="modalFilterLabel" aria-hidden="true" id="modalFilter">
        <div class="modal-dialog d-flex align-items-end">
            <div class="modal-content mh-85h rounded-top-md">
                <div class="modal-body align-center">
                    <div class="modal-body__header d-flex align-items-center h-12 transition-all">
                        <div class="container">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="text-default me-4">Filter</h2>
                                <button class="text-xl" data-bs-dismiss="modal"><i class="rck ryd-close"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body__inner _sm pt-4 pb-6 overflow-auto">
                        <div class="container">
                            <div class="row g-4">
                                <div class="col-12">
                                    <button wire:click="filter('ALL')" class="d-flex align-items-center {{ ($hasFilter == 'ALL') ? 'link-primary' : 'link-base-light'}}  fw-medium filterAll" data-bs-dismiss="modal" type="button"><span>Semua Campaign</span>
                                    </button>
                                </div>
                                <div class="col-12">
                                    <button wire:click="filter('END')" class="d-flex align-items-center {{ ($hasFilter == 'END') ? 'link-primary' : 'link-base-light'}} fw-medium filterEnd" data-bs-dismiss="modal" type="button"><span>Campaign Selesai</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

