@extends('frontoffice.layouts.dashboard-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="position-relative bg-skeleton w-22 h-18 rounded-xs overflow-hidden shadow">
                        <img class="position-absolute w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $data->hasCampaign->image) }}" alt="{{ $data->hasCampaign->title }}">
                    </div>
                    <div class="ps-2 flex-1 text-xs"><span class="badge bg-secondary">{{ $data->hasCampaign->hasCategory->name }}</span>
                        <p class="text-base fw-medium line-clamp-2 h-9 mt-2" title="{{ $data->hasCampaign->title }}">{{ $data->hasCampaign->title }}</p>
                    </div>
                </div>
                <ul class="border border-gray-light rounded rounded-xs mt-6 text-base">
                    <li class="py-3 px-2 px-ss-4 d-flex justify-content-between border-bottom border-gray-light">
                        <div class="d-flex"><i class="rck ryd-click text-ss-default text-primary me-2 me-ss-4"></i><span class="text-xxs text-ss-xs">Link di klik</span>
                        </div>
                        <div class="text-xxs text-ss-xs text-end"> <span class="ns">{{ $countVisitor }}</span>
                        </div>
                    </li>
                    <li class="py-3 px-2 px-ss-4 d-flex justify-content-between border-bottom border-gray-light">
                        <div class="d-flex"><i class="rck ryd-user text-ss-default text-primary me-2 me-ss-4"></i><span class="text-xxs text-ss-xs">Donatur Berdonasi</span>
                        </div>
                        <div class="text-xxs text-ss-xs text-end"> <span class="ns">{{ $data->jumlahTransaksi ?? 0 }}</span>
                        </div>
                    </li>
                    <li class="py-3 px-2 px-ss-4 d-flex justify-content-between">
                        <div class="d-flex"><i class="rck ryd-donate text-ss-default text-primary me-2 me-ss-4"></i><span class="text-xxs text-ss-xs">Total Donasi</span>
                        </div>
                        <div class="text-xxs text-ss-xs text-end"> <span class="fw-bold text-secondary rp ns">{{ $data->nominalTransaksi+$data->uniqueCode ?? 0 }}</span>
                        </div>
                        
                    </li>
                </ul>
                <ul class="border border-gray-light rounded rounded-xs mt-6 text-base">
                    <div class="px-4 py-3"><span class="user-select-all line-clamp-1 text-xs overflow-hidden" id="reff">{{ url('/'. $data->hasCampaign->slug.'/reff='.Auth::guard('member')->user()->slug_token) }}</span>
                    </div>
                </ul>
                <button class="ctc link-btn link-btn-primary h-12 w-full mt-4 rounded-xs fw-medium" data-clipboard-target="#reff"> <span>Salin Link</span>
                </button>
            </div>
        </section>
    </main>

@endsection

@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/clipboard.init.js') }}"></script>
@endsection