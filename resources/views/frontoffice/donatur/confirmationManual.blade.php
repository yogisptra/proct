@extends('frontoffice.layouts.dashboard-app')

@section('top-resource')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/swiper.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/select2.min.css') }}">
@endsection

@section('content')

    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <div class="bg-warning bg-opacity-15 rounded rounded-xs p-3 mb-4">
                    <p>Lakukan konfirmasi pembayaran <strong>hanya jika</strong> pembayaran tidak otomatis terkonfirmasi.</p>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="user-select-none text-xs fw-medium mb-2">No. Transaksi
                        </label>
                        <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('transaction_number') ? 'text-danger' : 'text-primary' }}"></i>
                            @if($data)
                            <select class="select-with-search" name="transaction_number" id="invoiceNumber" required>
                                <option value="" selected disabled>Pilih Transaksi</option>
                                @foreach($data as $row)
                                    <option id="transactionNumber" value="{{ $row->transaction_number }}">{{ $row->transaction_number }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                        @if ($errors->has('transaction_number'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('transaction_number') }}</span>
                        @endif
                    </div>
                    <div class="d-flex border border-gray-light rounded-xs py-3 px-4 mt-4 d-none" id="confirmationCampaign">
                        <div class="bg-skeleton overflow-hidden w-15 h-15 rounded-xs" id="imgSrc">
                            <img class="w-full h-full object-cover">
                        </div>
                        <div class="ps-3 flex-1"><span class="text-xxs text-secondary" id="TransactionNumber"></span>
                            <p class="line-clamp-2 text-xs text-base fw-medium mt-1" id="titleCampaign"></p>
                        </div>
                    </div>
                    <div class="h-2 bg-body mx-n8 my-6"></div>
                    <div>
                        <label class="user-select-none text-xs fw-medium mb-2">Jumlah Transfer
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-rp text-2xl {{ $errors->has('amount') ? 'text-danger' : 'text-primary' }}" style="top: 0.6875rem !important;"></i>
                            <input class="input ps-12 text-end fw-bold text-primary text-default py-2_25" type="text" name="amount" placeholder="50.000" data-type="currency" id="confirmationNom" required>
                        </div>
                        @if ($errors->has('amount'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('amount') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Rekening Tujuan
                        </label>
                        <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('bank_account_id') ? 'text-danger' : 'text-primary' }}"></i>
                            <select class="select-with-search" name="bank_account_id" required>
                                <option selected disabled value="">Pilih Rekening Tujuan</option>
                                @foreach ($bank as $row)
                                    @if($row->type == 'TF')
                                    <option value="{{ $row->id }}">{{ $row->hasBank->name }} - {{ $row->account_number }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('bank_account_id'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('bank_account_id') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Tanggal Transfer
                        </label>
                        <div class="position-relative"><i class="position-absolute right-4 top-3_5 text-default rck ryd-calendar {{ $errors->has('confirmation_date') ? 'text-danger' : 'text-primary' }}"></i>
                            <input class="input pe-12 datepicker-input" name="confirmation_date" type="text" placeholder="TT/BB/TTTT" data-type="currency" autocomplete="off" id="datepicker" required>
                        </div>
                        @if ($errors->has('confirmation_date'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('confirmation_date') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Bukti Transfer<span class="d-inline-block text-xxs text-gray ms-1">(Max. 5MB, Jenis File JPG/PNG)</span>
                        </label>
                        <div class="position-relative">
                            <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                <input class="d-none" type="file" required name="image" id="uploadTransferProofBtn" accept="image/png, image/jpeg">
                                <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb text-primary text-default me-2"> </i><span class="text-xs">Unggah Bukti Transfer</span>
                                </div>
                                <img class="w-full cursor-pointer position-relative" id="uploadTransferProof" src="{{ asset('frontoffice/assets/img/upload-wrapper.webp') }}" alt="Background Upload Wrapper">
                            </label>
                        </div>
                        @if ($errors->has('image'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('image') }}</span>
                        @endif
                    </div>
                    <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Kirim">
                </form>
            </div>
        </section>
    </main>
@endsection
@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/vendor/select2.full.min.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/select2.set.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/vendor/datepicker.id.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/datepicker.set.js') }}"></script>
    <script>
        //- Upload Transfer Proof
          function readURL(input) {
              if (input.files && input.files[0]) {
              var reader = new FileReader();
          
              reader.onload = function (e) {
                  $('#uploadTransferProof').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
              }
          }
          
          $("#uploadTransferProofBtn").change(function(){
              readURL(this);
          });
          
          //- Simpan nilai nominal transfer pada var dibawah ini.
          const transferNominal = 400281
          
          // Select2 Invoice Number
        $('#invoiceNumber').on("select2:selecting", function(e) { 
            let id = $('#transactionNumber').val();
            var url = "{{ route('dashboard-dataConfirmation', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url   : url,
                    method: 'GET',
                    success: function(response){
                        let invoice = response[0].transaction_number;
                        let title = response[0].has_campaign.title;
                        let nomAmount = (response[0].amount*100 + response[0].unique_code*100) / 100;
                        let image = response[1];
                        $("#imgSrc").html(`<img class="w-full h-full object-cover" src="assets/images/campaign/${image}">`);
                        $("#TransactionNumber").html(invoice)
                        $("#titleCampaign").html(title)

                        $('#confirmationCampaign').removeClass('d-none')
                        $('#confirmationNom').val(nomAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."))
                        
                    }
                    
                });
        });
    </script>
@endsection