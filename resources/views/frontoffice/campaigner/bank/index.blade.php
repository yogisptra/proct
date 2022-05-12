
@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- -->
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        @php
        $i = 0;
        @endphp
        @if(count($data) <= 0) 
        <section class="maxview bg-white px-ss-2 pt-6 pb-8 ">
            <div class="container">
                <div class="text-center py-4">
                    <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-bank text-12 text-primary"></i>
                    </div>
                    <div class="fw-medium mt-3">Akun bank kamu belum ditambahkan</div>
                    <p class="text-center mt-4">Yuk tambahkan akun bank untuk pencairan dana.</p>
                    <a class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" href="{{ route('create-bank-campaigner') }}">Tambah Bank</a>
                </div>
            </div>
        </section>
        @else
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <div class="d-flex aling-items-center justify-content-end mb-4"><a class="d-flex align-items-center link-primary fw-medium" href="{{ route('create-bank-campaigner') }}"><i class="rck ryd-plus me-1"></i><span>Tambah</span></a>
                </div>
                <div class="row g-4">
                    @foreach($data as $row)
                    <div class="col-12">
                        <div class="position-relative">
                            <div class="text-start text-base-light border border-gray-light rounded-xs py-3 px-3"><span class="fw-medium">{{ $row->account_name }}</span>
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-skeleton overflow-hidden h-4 w-6 rounded-xxs me-2">
                                            <img class="w-full h-full object-cover" src="{{ asset('assets/images/bank/'. $row->hasBank->image) }}" alt="BCA Logo">
                                        </div><span class="text-xs">{{ $row->hasBank->name }}</span>
                                    </div><span class="text-xs text-secondary">{{ $row->account_number }}</span>
                                </div>
                            </div>
                            <button class="position-absolute top-3 right-3 w-8 h-5 d-flex align-items-center justify-content-end modalLainnya" arial-label="More" type="button" data-bs-toggle="modal" data-bs-target="#modalMore" data-id={{ $row->encodeHash($row->id) }}><i class="rck ryd-more text-base-light"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
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
                                    <div class="col-12">
                                        <a class="d-flex align-items-center link-base-light fw-medium" id="editHref">
                                            <i class="rck ryd-edit me-2"> </i><span>Edit</span>
                                        </a>
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
                                    <h4 class="h5">Hapus Rekening?</h4>
                                    <p class="mt-2">Apakah yakin ingin menghapus rekening?</p>
                                </div>
                                <div class="row g-4 mt-4">
                                    <div class="col-6"><a class="link-btn link-btn-primary-o h-12 w-full rounded-xs fw-medium" id="deleteHref" >Yakin</a>
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
            var url = "{{ route('edit-bank-campaigner', ':id') }}";
            url = url.replace(':id', value);

            var urlEdit =  $('#editHref').attr('href', url);

            var url2 = "{{ route('delete-bank-campaigner', ':id') }}";
            url2 = url2.replace(':id', value);

            var urlDelete =  $('#deleteHref').attr('href', url2);
        });
    });
    </script>
@endsection