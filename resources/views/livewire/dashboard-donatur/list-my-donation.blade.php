<div>
    @if(count($data) == 0)
    <section class="maxview bg-white px-ss-2 pt-6 pb-8">
        <div class="container">
            <div class="text-center py-4">
                <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-campaign text-12 text-primary"></i>
                </div>
                <div class="fw-medium mt-3">Tidak ada history donasi</div>
                <p class="text-center mt-4">Yuk mulai bantu sesama sekarang.</p><a class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" href="{{ route('frontoffice.campaignList') }}">Donasi Sekarang</a>
            </div>
        </div>
    </section>
    @else
    <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
        <div class="container">
            <div class="row g-6">
                @foreach($data as $row)
                <div class="col-12">
                    <div class="position-relative">
                        <a class="user-select-none d-flex align-items-center" href="{{ route('frontoffice.campaignDetail', $row->hasCampaign->slug) }}">
                            <div class="position-relative bg-skeleton w-16 h-16 rounded-xs overflow-hidden shadow">
                                <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $row->hasCampaign->image) }}" alt="{{ $row->hasCampaign->title }}">
                            </div>
                            <div class="ps-2 flex-1 text-xs">
                                @if($row->transaction_status_id == 'VERIFIED')
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="badge text-success bg-success bg-opacity-15">Berhasil</div><span class="text-base-light pe-4">{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</span>
                                </div>
                                @elseif($row->transaction_status_id == 'UNVERIFIED')
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="badge text-info bg-info bg-opacity-15">Sedang Diverifikasi</div><span class="text-base-light pe-4">{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</span>
                                </div>
                                @else
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="badge text-danger bg-danger bg-opacity-15">Dibatalkan</div><span class="text-base-light pe-4">{{ \Carbon\Carbon::parse($row->transaction_date)->format('d/m/Y') }}</span>
                                </div>
                                @endif
                                <div class="d-flex align-items-end justify-content-between mt-2">
                                    <p class="flex-1 text-base fw-medium line-clamp-2 h-9 pe-8" title="{{ $row->hasCampaign->title }}">{{ $row->hasCampaign->title }}</p><span class="text-secondary fw-medium rp ns">{{ number_format($row->amount+$row->unique_code,0,'.','.') }}</span>
                                </div>
                            </div>
                        </a>
                        <button class="position-absolute top-0 right-0 w-8 h-5 d-flex align-items-center justify-content-end modalLainnya" arial-label="More" type="button" data-bs-toggle="modal" data-bs-target="#modalMore" data-id={{ $row->encodeHash($row->id) }}><i class="rck ryd-more text-base-light"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
