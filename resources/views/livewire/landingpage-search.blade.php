
<div>
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="javascript:history.go(-1)" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a>
                </div>
                <div class="navbar__right d-flex align-items-center">
                    <div id="search">
                        <div class="position-relative"><i class="position-absolute right-4 top-3_5 text-default rck ryd-search text-base"></i>
                            <input wire:model="searchTerm" class="input pe-12" type="search" placeholder="Cari campaign dan bantu mereka yuk!">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white pt-6 pb-8">
            <div class="container">
                <div class="row gy-4">
                    @forelse($data as $row)
                    <div class="col-12">
                        <a class="user-select-none d-flex align-items-center" href="{{ route('frontoffice.campaignDetail', $row->slug) }}">
                            <div class="position-relative bg-skeleton w-29 w-ss-38 h-29 rounded-xs overflow-hidden shadow">
                                <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $row->image) }}" alt="{{ $row->title }}">
                            </div>
                            <div class="ps-2 flex-1 text-xs"><span class="badge bg-secondary">{{ $row->hasCategory->name }}</span>
                                <div class="d-flex align-items-center mt-2">
                                    @if($row->hasUser->type_campaigner == 'PERSONAL')
                                    <span class="h-4_5 d-block text-gray line-clamp-1">{{ $row->hasUser->name }}</span>
                                    @else
                                    <span class="h-4_5 d-block text-gray line-clamp-1">{{ $row->hasUser->hasCorporate->corporate_name }}</span>
                                    @endif
                                    <i class="ms-1 mt-n0_25 text-primary rck ryd-verified-simple"></i>
                                </div>
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
        </section>
    </main>
</div>
