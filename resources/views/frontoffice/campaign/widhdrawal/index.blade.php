@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- Vendor style -->
@endsection

@section('content')
    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="{{ route('list-campaign') }}" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">{{ $data->title }}</span>
                </div>
                <div class="navbar__right d-flex align-items-center"><a class="link-base ms-4" href="{{ route('edit-campaign', $data->encodeHash($data->id)) }}" aria-label="Edit"><i class="text-2xl rck ryd-edit"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                @if(Session::has('error'))
                <div class="bg-danger bg-opacity-15 rounded rounded-xs p-3 mb-4">
                    <p>{{Session::get('error')}}</p>
                </div>
                @endif
                <div class="d-flex align-items-center">
                    <div class="position-relative bg-skeleton w-22 h-18 rounded-xs overflow-hidden shadow">
                        <img class="position-absolute w-full h-full object-cover" src="{{ $data->image ? asset('assets/images/campaign/'. $data->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="{{ $data->title }}">
                    </div>
                    <div class="ps-2 flex-1 text-xs"><span class="badge bg-secondary">{{ $data->hasCategory->name }}</span>
                        <p class="text-base fw-medium line-clamp-2 h-9 mt-2" title="{{ $data->title }}">{{ $data->title }}</p>
                    </div>
                </div>
                <ul class="border border-gray-light rounded rounded-xs mt-6 text-base">
                    <li class="py-3 px-2 px-ss-4 d-flex justify-content-between border-bottom border-gray-light">
                        <div class="d-flex"><i class="rck ryd-calendar text-ss-default text-primary me-2 me-ss-4"></i><span class="text-xxs text-ss-xs">Waktu Campaign Berakhir</span>
                        </div>
                        <div class="text-xxs text-ss-xs text-end"> 
                            @if($data->open_goal == 1 || $data->selisih_validate == null)
                            <span>Open Goal</span>
                            @else
                                @if($data->selisih_validate >= 0)
                                <span>{{ $data->selisih_validate }} hari lagi</span>
                                @else
                                <span>Telah berakhir</span>
                                @endif
                            @endif
                        </div>
                    </li>
                    <li class="py-3 px-2 px-ss-4 d-flex justify-content-between border-bottom border-gray-light">
                        <div class="d-flex"><i class="rck ryd-user text-ss-default text-primary me-2 me-ss-4"></i><span class="text-xxs text-ss-xs">Donatur Berdonasi <span class="link-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalDonatur">(Lihat)</span></span>
                        </div>
                        <div class="text-xxs text-ss-xs text-end"> <span class="ns">{{ $data->total_donatur ?? 0 }}</span>
                        </div>
                    </li>
                    <li class="py-3 px-2 px-ss-4 d-flex justify-content-between border-bottom border-gray-light">
                        <div class="d-flex"><i class="rck ryd-donate text-ss-default text-primary me-2 me-ss-4"></i><span class="text-xxs text-ss-xs">Total Donasi</span>
                        </div>
                        <div class="text-xxs text-ss-xs text-end"> <span class="fw-bold text-secondary rp ns">{{ $data->collected ?? 0 }}</span>
                        </div>
                    </li>
                    <li class="py-3 px-2 px-ss-4 d-flex justify-content-between">
                        <div class="d-flex"><i class="rck ryd-target text-ss-default text-primary me-2 me-ss-4"></i><span class="text-xxs text-ss-xs">Target Donasi</span>
                        </div>
                        <div class="text-xxs text-ss-xs text-end"> <span class="rp ns">{{ $data->target ?? 0 }}</span>
                        </div>
                    </li>
                </ul><a class="link-primary d-flex align-items-center justify-content-center mt-4 py-2" href="{{ route('campaign-update.list', $data->encodeHash($data->id)) }}"><i class="text-default me-2 rck ryd-update"></i><span class="fw-medium">Atur Kabar Terbaru</span></a>
                <div class="h-2 bg-body mx-n8 my-6"></div>
                <div class="row mt-4 mt-ss-6 gy-3 gx-4">
                    <div class="col-12 col-ss-6">
                        <div class="text-base-light py-3 px-4 rounded-xs shadow-drop"><i class="text-xl text-primary rck ryd-heart"></i><span class="d-block text-sm line-clamp-1 mt-2">Belum Dicairkan</span>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="fw-bold text-base ns line-clamp-1 rp">{{ $data->collected ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-ss-6">
                        <div class="text-base-light py-3 px-4 rounded-xs shadow-drop"><i class="text-xl text-primary rck ryd-speaker"></i><span class="d-block text-sm line-clamp-1 mt-2">Pencairan Berhasil</span>
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <p class="fw-bold text-base ns line-clamp-1 rp">394264</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" href="{{ route('dashboard-widhdrawa.create', $data->slug) }}"> <span>Cairkan Dana</span><i class="text-default ms-2 rck ryd-arrow-right"></i>
                </a> --}}
                <button class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" data-bs-toggle="modal" data-bs-target="#modalPass"> <span>Cairkan Dana</span><i class="text-default ms-2 rck ryd-arrow-right"></i>
                </button>
                <button class="link-btn link-btn-primary-o h-12 w-full mt-4 rounded-xs fw-medium" type="button" data-bs-toggle="modal" data-bs-target="#modalHistory"><span>Riwayat Pencairan Dana</span><i class="text-default ms-2 rck ryd-history"></i>
                </button>
            </div>
        </section>
        <div class="modal fade" tabindex="-1" aria-labelledby="modalPassLabel" aria-hidden="true" id="modalPass">
            <div class="modal-dialog d-flex align-items-end">
                <div class="modal-content mh-85h rounded-top-md">
                    <div class="modal-body align-center">
                        <div class="modal-body__header d-flex align-items-center h-12 transition-all">
                            <div class="container">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h2 class="text-default me-4">Masukan Password</h2>
                                    <button class="text-xl" data-bs-dismiss="modal"><i class="rck ryd-close"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body__inner _sm pt-4 pb-6 overflow-auto">
                            <div class="container">
                                <form action="{{ route('dashboard-confirmation-password', $data->slug) }}" method="POST">
                                    @csrf
                                    <div class="mt-4">
                                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock text-primary"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                                            <input class="input px-12" name="password" type="password" placeholder="Kata Sandi">
                                        </div>
                                    </div>
                                    <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Cairkan Dana">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" aria-labelledby="modalDonaturLabel" aria-hidden="true" id="modalDonatur">
            <div class="modal-dialog">
                <div class="modal-content h-full">
                    <div class="modal-body align-center">
                        <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                            <div class="container">
                                <h2 class="d-flex align-items-center justify-content-between">
                                    <div>
                                    <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Donatur Berdonasi</span>
                                    </div>
                                    <a class="link-base ms-4" href="{{ route('dashboard-export_donatur', $data->id) }}" aria-label="Export"><i class="text-2xl rck ryd-download"></i></a>
                                </h2>
                            </div>
                        </div>
                        <livewire:dashboard-list-donatur :campaign_id="$data->id" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" aria-labelledby="modalHistoryLabel" aria-hidden="true" id="modalHistory">
            <div class="modal-dialog">
                <div class="modal-content h-full">
                    <div class="modal-body align-center">
                        <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                            <div class="container">
                                <h2 class="d-flex align-items-center">
                                    <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Riwayat Pencairan</span>
                                </h2>
                            </div>
                        </div>
                        <div class="modal-body__inner pt-4 pb-6 overflow-x-hidden overflow-y-auto">
                            <div class="container">
                                <div class="row g-8">
                                    @forelse($historyWidhdrawal as $row)
                                    <div class="col-12">
                                        <div>
                                            <div class="fw-medium line-clamp-1">{{ $row->hasUser->name }}</div>
                                            <div class="d-flex align-items-center justify-content-between text-xs mt-2"><span>{{ $row->hasBankAccount->hasBank->name }}</span><span>{{ \Carbon\Carbon::parse($row->request_date)->format('d/m/Y') }}</span>
                                            </div>
                                            @if($row->status == 'VERIFIED')
                                            <div class="d-flex align-items-center justify-content-between mt-2"><span class="text-xs">{{ $row->hasBankAccount->account_number }}</span><span class="rp ns text-default fw-medium text-success">{{ $row->amount }}</span>
                                            </div>
                                            <p class="mt-2">Pencairan telah berhasil.</p>
                                            @elseif($row->status == 'UNVERIFIED')
                                            <div class="d-flex align-items-center justify-content-between mt-2"><span class="text-xs">{{ $row->hasBankAccount->account_number }}</span><span class="rp ns text-default fw-medium text-warning">{{ $row->amount }}</span>
                                            </div>
                                            <p class="mt-2">Pencairan sedang di proses. Waktu pencairan memakan waktu 3 hari kerja</p>
                                            @else 
                                            <div class="d-flex align-items-center justify-content-between mt-2"><span class="text-xs">{{ $row->hasBankAccount->account_number }}</span><span class="rp ns text-default fw-medium text-danger">{{ $row->amount }}</span>
                                            </div>
                                            <p class="mt-2">Pencairan dana gagal dikarenakan nomor rekening tujuan salah.</p>
                                            @endif
                                        </div>
                                    </div>
                                    @empty 
                                    <div class="text-center py-4">
                                        <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-wallet text-12 text-primary"></i>
                                        </div>
                                        <div class="fw-medium mt-3">Belum Ada Pencairan</div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('bottom-script')
@livewireScripts
<script>
    // Trigger Scroll Down
    $('.modal-body__inner').scroll(function() {
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
   </script>
@endsection