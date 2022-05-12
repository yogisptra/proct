<div>
    <section class="maxview align-items-start bg-white pt-6 pb-8">
        <div>
            <div id="filter-wrapper"></div>
            <div id="filter">
                <div class="container bg-white">
                    <div class="row gx-0">
                        <div class="col-6">
                            <button class="w-full d-flex align-items-center justify-content-center p-4" type="button" data-bs-toggle="modal" data-bs-target="#modalCategoryVirtual"><i class="text-primary text-default rck ryd-category"></i><span class="ms-2 text-base">Kategori</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="w-full d-flex align-items-center justify-content-center p-4" type="button" data-bs-toggle="modal" data-bs-target="#modalSort"><i class="text-primary text-default rck ryd-sort"></i><span class="ms-2 text-base">Urutkan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row gy-4">
                    @forelse($data as $row)
                    <div class="col-12">
                        <a class="user-select-none d-flex align-items-center" href="{{ route('frontoffice.campaignDetail', $row->slug) }}">
                            <div class="position-relative bg-skeleton w-29 w-ss-38 h-29 rounded-xs overflow-hidden shadow">
                                <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $row->image) }}" alt="{{ $row->title }}">
                            </div>
                            <div class="ps-2 flex-1 text-xs"><span class="badge bg-secondary">{{ $row->hasCategory->name }}</span>
                                @if($row->hasUser->type_campaigner == 'PERSONAL')
                                <div class="d-flex align-items-center mt-2"><span class="h-4_5 d-block text-gray line-clamp-1">{{ $row->hasUser->name }}</span>
                                    <i class="ms-1 mt-n0_25 text-primary rck ryd-verified-simple"></i>
                                </div>
                                @else
                                <div class="d-flex align-items-center mt-2"><span class="h-4_5 d-block text-gray line-clamp-1">{{ $row->hasUser->hasCorporate->corporate_name }}</span>
                                    <i class="ms-1 mt-n0_25 text-primary rck ryd-verified-simple"></i>
                                </div>
                                @endif
                                <p class="text-base fw-medium line-clamp-2 h-9 mt-2" title="{{ $row->title }}">{{ $row->title }}</p>
                                <p class="mt-2 fw-bold text-base-light">{{ $row->total_donatur ?? 0 }} Donatur</p>
                            </div>
                        </a>
                    </div>
                    @empty 
                    <!-- <div class="text-center"><i class="rck ryd-sad text-30 text-primary"></i>
                        <h1 class="h4 text-center">Yah campaign yang anda cari tidak ditemukan :(</h1>
                        <p class="text-center mt-4">Campaign yang kamu cari tidak ditemukan, cari campaign lain dan sebarkan kebahagiaan untuk membantu saudara kita</p>
                    </div> -->
                    <div class="text-center py-4">
                        <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-campaign text-12 text-primary"></i>
                        </div>
                        <div class="fw-medium mt-3">Belum Ada Campaign</div>
                    </div>
                    @endforelse
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
</div>


