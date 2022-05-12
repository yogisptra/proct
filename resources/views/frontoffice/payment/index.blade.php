@extends('frontoffice.layouts.frontoffice-app')

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
                    <div class="bg-skeleton overflow-hidden w-21_5 h-17_5 rounded-xs shadow">
                        <img class="w-full h-full object-cover" src="{{ asset('assets/images/campaign/'. $data->image) }}" alt="{{ $data->title }}">
                    </div>
                    <div class="flex-1 ps-2">
                        <div class="d-flex align-items-center">
                            @if($data->hasUser->type_campaigner == 'PERSONAL')
                            <span class="h-4_5 d-block text-gray line-clamp-1">{{ $data->hasUser->name }}</span>
                            @else
                            <span class="h-4_5 d-block text-gray line-clamp-1">{{ $data->hasUser->hasCorporate->corporate_name }}</span>
                            @endif
                            <i class="ms-1 mt-0_5 text-primary rck ryd-verified-simple"></i>
                        </div>
                        <p class="text-base fw-medium line-clamp-2 mt-2" title="{{ $data->title }}">{{ $data->title }}</p>
                    </div>
                </div>
                <div class="h-2 bg-body mx-n8 my-6"></div>
                <form action="{{ route('frontoffice.paymentTransaction') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <input hidden name="slug" value="{{ @$data->slug }}">
                        <input hidden name="fundraiser_id" value="{{ ($fundraiser->id) ?? '' }}" />
                        @if(Auth::guard('member')->user())
                        <label class="user-select-none text-xs fw-medium mb-2">Nama Lengkap
                        </label>
                        <div class="d-flex align-items-center"><i class="text-xl text-primary rck ryd-user me-2"> </i>
                            <span class="fw-medium text-base text-default" id="donaturName">{{ Auth::guard('member')->user()->name }}</span>
                        </div>
                        @else
                        <div>
                            <label class="user-select-none text-xs fw-medium mb-2">Nama Lengkap
                            </label>
                            <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-user {{ $errors->has('name') ? 'text-danger' : 'text-primary' }}"></i>
                                <input class="input ps-12" name="name" type="text" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="user-select-none text-xs fw-medium mb-2">Email
                            </label>
                            <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-message {{ $errors->has('email') ? 'text-danger' : 'text-primary' }}"></i>
                                <input class="input ps-12" name="email" type="email" placeholder="email@example.com" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="user-select-none text-xs fw-medium mb-2">Nomor Telepon
                            </label>
                            <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-calling {{ $errors->has('phone_number') ? 'text-danger' : 'text-primary' }}"></i>
                                <input class="input ps-12" name="phone_number" type="number" placeholder="08**********" value="{{ old('phone_number') }}" required>
                                @if ($errors->has('phone_number'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('phone_number') }}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    <label class="cb mt-4">
                        <div class="cb__box">
                            <input class="d-none" name="is_hamba_allah" value="1" type="checkbox" id="donaturNameToggle">
                            <div></div>
                        </div><span class="user-select-none ms-3">Donasi sebagai anonim.</span>
                    </label>
                    <div class="input-hightlight mt-6 position-relative">
                        <div class="input-hightlight__overlay position-fixed bg-black bg-opacity-50 top-0 left-0 w-full h-full transition-all invisible opacity-0"></div>
                        <div>
                            <label class="user-select-none text-xs fw-medium mb-2 position-relative">Nominal Donasi
                            </label>
                            <div class="position-relative bg-white rounded-xs"><i class="position-absolute left-4 top-3_5 text-default rck ryd-rp text-2xl {{ $errors->has('amount') ? 'text-danger' : 'text-primary' }}" style="top: 0.6875rem !important;"></i>
                                <input class="input ps-12 text-end fw-bold text-primary text-default py-2_25 input__hightlight" name="amount" type="text" placeholder="50.000" inputmode="numeric" data-type="currency" value="{{ old('amount') }}">
                                <div class="text-end ms-auto pe-4 py-2 text-xs text-danger fw-medium input__hightlight__error d-none"></div>
                                @if ($errors->has('amount'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('amount') }}</span>
                                @endif
                            </div>
                            @if($dataCustomMin != null)
                            <div class="position-absolute w-full rounded-xs p-4 bg-white mt-2 d-none" id="nomOpt">
                                <div class="text-xs mb-2 fw-medium">Atau Pilih Nominal</div>
                                <div class="nom-opt-list row g-2">
                                    @foreach($dataCustomMin as $row)
                                    <div class="col-6" onclick="changeAmount({{ $row}})">
                                        <div class="nom-opt-item cursor-pointer transition-all rp ns text-center text-xs rounded-xs py-3 px-4 fw-medium border border-gray-light bg-gray-light bg-opacity-30 text-base">{{ $row }}</div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Metode Pembayaran
                        </label>
                        <input hidden name="bank_account_id" id="val-payment-method"></span>
                        <div class="position-relative"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down rotate-90m {{ $errors->has('bank_account_id') ? 'text-danger' : 'text-primary' }}"></i>
                            <button class="input text-start pe-12 d-flex align-items-center" type="button" data-bs-toggle="modal" data-bs-target="#modalPaymentMethod" id="paymentMethodBtn">
                                <img class="w-6 h-4 object-cover rounded-xxs me-2 d-none" src="" alt="Logo"><span>Metode Pembayaran</span>
                            </button>
                        </div>
                        @if ($errors->has('bank_account_id'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('bank_account_id') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Doa untuk penerima donasi
                        </label>
                        <div class="position-relative">
                            <textarea class="input" name="note" placeholder="Contoh: Semoga banyak yang membantu dan segera diberikan bantuan dan dimudahkan">{{ old('note') }}</textarea>
                        </div>
                    </div>
                    <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8 d-none" type="submit" value="Donasi">
                </form>
                <div class="modal fade" tabindex="-1" aria-labelledby="modalPaymentMethodLabel" aria-hidden="true" id="modalPaymentMethod">
                        <div class="modal-dialog">
                            <div class="modal-content h-full">
                                <div class="modal-body align-center">
                                    <div class="modal-body__header d-flex align-items-center h-18 transition-all">
                                        <div class="container">
                                            <h2 class="d-flex align-items-center">
                                                <button class="text-2xl h-6 mt-n2" data-bs-dismiss="modal"><i class="rck ryd-arrow-left"></i></button><span class="text-default ms-4">Metode Pembayaran</span>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="modal-body__inner pt-4 pb-6 overflow-x-hidden overflow-y-auto">
                                        <div class="container">
                                            <div class="payment-method-group d-none">
                                                <label class="user-select-none text-xs fw-medium mb-2">E-Wallet
                                                </label>
                                                <div class="row g-2">
                                                    @foreach($bank as $row)
                                                        @if($row->type == 'EW')
                                                        <div class="col-12">
                                                            <div class="position-relative">
                                                                <label class="payment-method d-block" data-bs-dismiss="modal">
                                                                    <input class="d-none payment-method-pay" type="radio" value="{{ $row }}">
                                                                    <div class="position-relative py-3 px-4 rounded-xs pe-12 d-flex align-items-center">
                                                                        <img class="w-6 h-4 object-cover rounded-xxs me-2" src="{{ asset('assets/images/bank/'. $row->hasBank->image) }}" alt="Logo {{ $row->hasBank->name }}"><span class="text-xs">{{ $row->hasBank->name }}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="h-2 bg-body mx-n8 my-6 d-none"></div>
                                            <div class="payment-method-group d-none">
                                                <label class="user-select-none text-xs fw-medium mb-2">Virtual Account
                                                </label>
                                                <div class="row g-2">
                                                    @foreach($bank as $row)
                                                        @if($row->type == 'VA')
                                                        <div class="col-12">
                                                            <div class="position-relative">
                                                                <label class="payment-method d-block" data-bs-dismiss="modal">
                                                                    <input class="d-none payment-method-pay" type="radio" value="{{ $row }}">
                                                                    <div class="position-relative py-3 px-4 rounded-xs pe-12 d-flex align-items-center">
                                                                        <img class="w-6 h-4 object-cover rounded-xxs me-2" src="{{ asset('assets/images/bank/'. $row->hasBank->image) }}" alt="Logo {{ $row->hasBank->name }}"><span class="text-xs">{{ $row->hasBank->name }}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="h-2 bg-body mx-n8 my-6 d-none"></div>
                                            <div class="payment-method-group">
                                                <label class="user-select-none text-xs fw-medium mb-2">Transfer Bank<span class="d-inline-block text-xxs text-gray ms-1">(Konfirmasi Manual)</span>
                                                </label>
                                                <div class="row g-2">
                                                    @foreach($bank as $row)
                                                        @if($row->type == 'TF')
                                                        <div class="col-12">
                                                            <div class="position-relative">
                                                                <label class="payment-method d-block" data-bs-dismiss="modal">
                                                                    <input class="d-none payment-method-pay" type="radio" value="{{ $row }}">
                                                                    <div class="position-relative py-3 px-4 rounded-xs pe-12 d-flex align-items-center">
                                                                        <img class="w-6 h-4 object-cover rounded-xxs me-2" src="{{ asset('assets/images/bank/'. $row->hasBank->image) }}" alt="Logo {{ $row->hasBank->name }}"><span class="text-xs">{{ $row->hasBank->name }}</span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
    </main>

@endsection

@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->
    <script>
        function changeAmount(val){
                    $("input[name='amount']").val(number_format(val,0,'.','.'));
                    $('.input__hightlight__error').text('').addClass('d-none')
                    $('.link-btn').removeClass('d-none');
                }
        $(document).ready(function() {
            number_format = function (number, decimals, dec_point, thousands_sep) {
                number = number.toFixed(decimals);

                var nstr = number.toString();
                nstr += '';
                x = nstr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? dec_point + x[1] : '';
                var rgx = /(\d+)(\d{3})/;

                while (rgx.test(x1))
                    x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

                return x1 + x2;
            }
              //- Anomin Donatur Toggle
              const donaturName = $('#donaturName').text();
              const donaturNameFirstL = donaturName.slice(0, 1);
              const donaturNameLastL = donaturName.slice(-1);
              const donaturNameHide = donaturNameFirstL+'*****'+donaturNameLastL;
          
              $('#donaturNameToggle').click(function() {
                  if ($(this).is(':checked')) {
                      $('#donaturName').text(donaturNameHide);
                  } else {
                      $('#donaturName').text(donaturName);
                  }
              });
          
              // Input Hightlight
          
              //== check if .nom-opt items is odd or not
              const nomOptAmount = $('.nom-opt-list').children().length
              if (nomOptAmount % 2 !== 0) {
                  $('.nom-opt-list').children(':last-child').removeClass('col-6').addClass('col-12')
              }
          
              //==
              $('.input-hightlight input').click(function() {
                  const mainParent = $(this).parents('.input-hightlight');
                  mainParent.addClass('z-2000');
                  mainParent.children('.input-hightlight__overlay').removeClass('invisible').removeClass('opacity-0');
                  mainParent.find('label').addClass('text-white');
                  mainParent.find('#nomOpt').removeClass('d-none');
              });
          
              $('.input-hightlight__overlay, .nom-opt-item').click(function() {
                  const mainParent = $(this).parents('.input-hightlight');
                  mainParent.removeClass('z-2000');
                  mainParent.find('.input-hightlight__overlay').addClass('invisible').addClass('opacity-0');
                  mainParent.find('label').removeClass('text-white');
                  mainParent.find('#nomOpt').addClass('d-none');
              });
          
              //==
              $('.nom-opt-item').click(function() {
                  const mainParent = $(this).parents('.input-hightlight');
                  mainParent.find('.nom-opt-item').removeClass(['border-primary', 'bg-primary', 'text-white']).addClass(['border-gray-light', 'bg-gray-light', 'bg-opacity-30', 'text-base'])
                  $(this).addClass(['border-primary', 'bg-primary', 'text-white']).removeClass(['border-gray-light', 'bg-gray-light', 'bg-opacity-30', 'text-base'])
          
                  mainParent.find('.input__hightlight').val($(this).text())
              });
          
              //==
            //==
            $('.input__hightlight').keyup(function() {
                  const mainParent = $(this).parents('.input-hightlight');
          
                  mainParent.find('.nom-opt-item').removeClass(['border-primary', 'bg-primary', 'text-white']).addClass(['border-gray-light', 'bg-gray-light', 'bg-opacity-30', 'text-base'])
          
          
                  //- setTimeout(function() { 
                      const thisVal = $('.input__hightlight').val();
                      const thisValNum = thisVal.split('.').join("")
                    //   console.log(thisValNum)

          
                      if (thisValNum < 10000) {
                          $('.input__hightlight__error').text('Minimal Donasi adalah Rp 10.000').removeClass('d-none')
                          $('.link-btn').addClass('d-none');
                      } else {
                          $('.input__hightlight__error').text('').addClass('d-none')
                          $('.link-btn').removeClass('d-none');
                      }
                  //- }, 500);
          
              });
          
              // Payment Method
              $('.payment-method').click(function() {
                  const getImg = $(this).find('img').attr('src')
                  const getLabel = $(this).find('span').text()

                  $('#paymentMethodBtn').find('img').attr('src', getImg).removeClass('d-none')
                  $('#paymentMethodBtn').find('span').text(getLabel)
              })

                $(".payment-method-pay").click(function() {
                    let value = $(this).val();
                    data = JSON.parse(value);

                    $('#val-payment-method').val(data.id);
                });

                

                
          });
    </script>
@endsection