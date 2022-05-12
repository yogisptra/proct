
@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <livewire:dashboard-donatur.list-my-donation />
        
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
                                    <!-- IF: Jika status transaksi = Berhasil / Dibatalkan / Sedang Diverifikasi-->
                                    <div class="col-12"><a class="d-flex align-items-center link-base-light fw-medium" id="detailHref"><span>Lihat Detail</span></a>
                                    </div>
                                    <!-- END IF: Jika status transaksi = Berhasil / Dibatalkan / Sedang Diverifikasi-->
                                    <!-- IF: Jika status transaksi = Menunggu Pembayaran-->
                                    <div class="col-12"><a class="d-flex align-items-center link-base-light fw-medium" href="{{ route('dashboard-confirmation_manual') }}"><span>Konfirmasi Pembayaran</span></a>
                                    </div>

                                    <div class="col-12">
                                        <button class="d-flex align-items-center link-danger fw-medium" data-bs-dismiss="modal" type="button" data-bs-toggle="modal" data-bs-target="#modalDelete"><span>Batalkan Donasi</span>
                                        </button>
                                    </div>
                                    <!-- END IF: Jika status transaksi = Menunggu Pembayaran-->

                                    <!-- IF: Jika status transaksi = Konfirmasi Ulang
                                    <div class="col-12"><a class="d-flex align-items-center link-base-light fw-medium" href="confirmation.html"><span>Konfirmasi Ulang</span></a>
                                    </div>
                                    <div class="col-12">
                                        <button class="d-flex align-items-center link-danger fw-medium" data-bs-dismiss="modal" type="button" data-bs-toggle="modal" data-bs-target="#modalDelete"><span>Batalkan Donasi</span>
                                        </button>
                                    </div>
                                    END IF: Jika status transaksi = Konfirmasi Ulang-->
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
                                    <h4 class="h5">Batalkan Donasi?</h4>
                                    <p class="mt-2">Apakah yakin ingin membatalkan donasi?</p>
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
@livewireScripts
    <!-- WARNING! this scripts below used for this page only-->
    
    <script>
        window.onscroll = function (ev) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                window.livewire.emit('post-data');
            }
        };
        $(".modalLainnya").click(function() {
            let value = $(this).attr("data-id");
            var url = "{{ route('dashboard-myDonation.detail', ':id') }}";
            url = url.replace(':id', value);

            var urlEdit =  $('#detailHref').attr('href', url);

            var url2 = "{{ route('dashboard-myDonation.cancel', ':id') }}";
            url2 = url2.replace(':id', value);

            var urlDelete =  $('#deleteHref').attr('href', url2);
        });
    </script>
@endsection