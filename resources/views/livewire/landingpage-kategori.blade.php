<div>
    <div class="row gy-4 mt-6">
        @forelse($data->take(8) as $row)
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
        <div class="text-center py-4">
            <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-campaign text-12 text-primary"></i>
            </div>
            <div class="fw-medium mt-3">Belum Ada Campaign</div>
        </div>
        @endforelse
    </div>
    @if(count($data) > 0)
    <a class="link-btn link-btn-primary h-12 w-full mt-6 rounded-xs fw-medium" href="{{ route('frontoffice.campaignList') }}"> <span>Lihat Program Lainnya</span><i class="text-default ms-2 rck ryd-arrow-right"> </i>
    </a>
    @endif
</div>
