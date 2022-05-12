@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<!-- Vendor style -->
<link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/quill.snow.css') }}">
@endsection

@section('content')
    <!-- NAVBAR-->
    <nav class="navbar transition-all position-fixed w-full top-0 left-0 z-1050 bg-white">
        <div class="container">
            <div class="h-18 d-flex justify-content-between align-items-center position-relative">
                <div class="navbar__left d-flex align-items-center"><a class="d-flex align-items-center link-base me-4" href="javascript:history.go(-1)" aria-label="Go Back"><i class="text-2xl rck ryd-arrow-left"></i></a><span class="line-clamp-1 text-base fw-medium text-default">{{ $title }}</span>
                </div>
                <div class="navbar__right d-flex align-items-center"></div>
            </div>
        </div>
    </nav>

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div>
                <div class="mx-ss-n2 d-none">
                    <ul class="nav nav-tabs">
                        <li>
                            <button class="fw-medium active" data-bs-target="#tab-step1" data-bs-toggle="tab"></button>
                        </li>
                        <li>
                            <button class="fw-medium" data-bs-target="#tab-step2" data-bs-toggle="tab"></button>
                        </li>
                    </ul>
                </div>
                <div class="container">
                    <div class="step-wizard mb-6"><span class="_disabled" id="sw1">1</span><span class="_active _disabled-line" id="sw2">2</span><span id="sw3">3</span>
                    </div>
                    <form action="{{ route('update-campaign', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="tab-content mt-6">
                            <div class="tab-pane active" id="tab-step1">
                                <div>
                                    <label class="user-select-none text-xs fw-medium mb-2">Judul Campaign
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-campaign {{ $errors->has('title') ? 'text-danger' : 'text-primary' }}"></i>
                                        <input class="input ps-12" name="title" value="{{ $data->title ?? old('title') }}" id="title" type="text" onkeyup="url()" placeholder="Bantuan Untuk Saudara Kita">
                                    </div>
                                    @if ($errors->has('title'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                                <div>
                                    <label class="user-select-none text-xs fw-medium mb-2">Slug
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-info {{ $errors->has('slug') ? 'text-danger' : 'text-primary' }}"></i>
                                        <input class="input ps-12" name="slug" value="{{ $data->slug ?? old('slug') }}" id="slug" type="text" placeholder="Link Slug">
                                    </div>
                                    @if ($errors->has('slug'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('slug') }}</span>
                                    @endif
                                </div>
                                <label class="cb mt-4 {{ $data->open_goal == 1 ? 'cb--checkbox' : '' }}" id="openGoal">
                                    <div class="cb__box">
                                        <input class="d-none" {{ $data->open_goal == 1 ? 'checked' : '' }} value="1" name="open_goal" type="checkbox">
                                        <div></div>
                                    </div>
                                    <span class="user-select-none ms-3">Jadikan Open Goal
                                        <i class="ms-1 text-primary position-relative top-0_25 rck ryd-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Tanggal &amp; target donasi kamu gak akan dibatasi."></i>
                                    </span>
                                </label>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Kategori Campaign
                                    </label>
                                    <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('categories_id') ? 'text-danger' : 'text-primary' }}"></i>
                                        <select class="select-with-search" name="categories_id">
                                            <option value="" selected disabled>Kategori Campaign</option>
                                            @foreach ($category as $row)
                                                <option value="{{ $row->id }}" {{ @$data->categories_id == $row->id ? 'selected' : "" }}>{{ $row->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    @if ($errors->has('categories_id'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('categories_id') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4 non-open-goal" style="{{ $data->open_goal == 1 ? 'display: none' : '' }}">
                                    <label class="user-select-none text-xs fw-medium mb-2">Waktu Berakhir Campaign
                                    </label>
                                    <div class="position-relative"><i class="position-absolute right-4 top-3_5 text-default rck ryd-calendar"></i>
                                        <input class="input pe-12 datepicker-input" name="valid_date" value="{{ $data->valid_date ?? old('valid_date') }}" type="text" placeholder="TT/BB/TTTT" inputmode="numeric" data-type="currency" autocomplete="off" id="datepicker">
                                    </div>
                                </div>
                                <div class="mt-4 non-open-goal" style="{{ $data->open_goal == 1 ? 'display: none' : '' }}">
                                    <label class="user-select-none text-xs fw-medium mb-2">Target Donasi
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-rp text-2xl text-primary" style="top: 0.6875rem !important;"></i>
                                        <input class="input ps-12 text-end fw-bold text-primary text-default py-2_25" name="target" value="{{ $data->target ?? old('target') }}" id="target" type="text" placeholder="50.000" inputmode="numeric" data-type="currency">
                                    </div>
                                    @if ($errors->has('target'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('target') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="user-select-none text-xs fw-medium mb-2" style="margin-bottom: 0 !important;">Nominal Khusus
                                        </label><span class="cursor-pointer text-primary fw-medium d-flex align-items-center user-select-none" id="customNominalBtn"><i class="rck ryd-plus text-xl"></i><span class="ms-0_5">Nominal</span></span>
                                    </div>
                                    <div class="row g-2" id="customNominal">
                                        @forelse($custom_amount as $row)
                                        <div class="col-12">
                                            <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-rp text-primary"></i>
                                                <input class="input ps-12 text-end fw-bold text-primary" name="custom_amount[]" value="{{ @$row ? $row : old('custom_amount') }}" type="text" placeholder="50.000" inputmode="numeric" data-type="currency">
                                            </div>
                                        </div>
                                        @empty 
                                        <div class="col-12">
                                            <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-rp text-primary"></i>
                                                <input class="input ps-12 text-end fw-bold text-primary" name="custom_amount[]" value="{{ old('custom_amount') }}" type="text" placeholder="50.000" inputmode="numeric" data-type="currency">
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Deskripsi
                                    </label>
                                    <div class="ql-wrapper rounded-xs overflow-hidden">
                                        <article id="editor"></article>
                                        <textarea name="description" value="" style="display:none" id="description"></textarea>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Unggah Cover Campaign<span class="d-inline-block text-xxs text-gray ms-1">(Max. 5MB, Jenis File JPG/PNG)</span>
                                    </label>
                                    <div class="position-relative">
                                        <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                            <input class="d-none" name="image" type="file" id="uploadThumbBtn" accept="image/png, image/jpeg">
                                            <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb text-primary text-default me-2"> </i><span class="text-xs">Unggah Cover</span>
                                            </div>
                                            <img class="w-full cursor-pointer position-relative" id="uploadThumb" src="{{ asset('assets/images/campaign/'. $data->image) }}" alt="Background Upload Wrapper">
                                        </label>
                                    </div>
                                </div>
                                <div class="row gx-4 mt-8">
                                    <div class="col-12"><a class="submit link-btn link-btn-primary h-12 w-full rounded-xs fw-medium" data-button="next"><span>Selanjutnya</span><i class="text-default ms-2 rck ryd-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab-step2">
                                <div>
                                    <label class="user-select-none text-xs fw-medium mb-2">Pixel ID
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-id text-primary"></i>
                                        <input class="input ps-12" name="fb_pixel" value="{{ $data->fb_pixel ?? old('fb_pixel') }}" type="text" placeholder="928**********">
                                    </div>
                                </div>
                                <div>
                                    <label class="user-select-none text-xs fw-medium mb-2">Google Tag Manager
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-google text-primary"></i>
                                        <input class="input ps-12" name="gtm" value="{{ $data->gtm ?? old('gtm') }}" type="text" placeholder="GTM-*********">
                                    </div>
                                </div>
                                <div class="row gx-4 mt-8">
                                    <div class="col-6"><a class="link-btn link-btn-primary-o h-12 w-full rounded-xs fw-medium" data-button="prev"><span>Kembali</span></a>
                                    </div>
                                    <div class="col-6">
                                        <button class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium" type="submit"><span>Ubah Campaign</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
    <script src="{{ asset('frontoffice/assets/js/vendor/quill.min.js') }}"></script>
    <script>
        //
        $('[data-button="next"]').click(function(){
            $('.nav-tabs li .active').parent().next().find('button').trigger('click');
        });
        
        $('[data-button="prev"]').click(function(){
            $('.nav-tabs li .active').parent().prev().find('button').trigger('click');
        });
        
        //
        $('[data-button="next"], [data-button="prev"]').click(function(){
            if ($("[data-bs-target='#tab-step1']").hasClass('active')) {
                $('.step-wizard span').removeClass('_active')
                $('.step-wizard #sw2').addClass('_active')
        
            } else if ($("[data-bs-target='#tab-step2']").hasClass('active')) {
                $('.step-wizard span').removeClass('_active')
                $('.step-wizard #sw2').addClass('_active')
                $('.step-wizard #sw3').addClass('_active')
            }
        });
    </script>
    <script>
         $('#customNominalBtn').click(function() {
              const countCustomNom = $('#customNominal').children().length
          
              if (countCustomNom < 6) {
                  $('#customNominal').append(`
                      <div class="col-12 custom-nominal-append">
                          <div class="d-flex">
                              <div class="position-relative flex-1">
                                  <i class="position-absolute left-4 top-3_5 text-default rck ryd-rp text-primary"></i>
                                  <input class="input ps-12 text-end fw-bold text-primary" type="text" placeholder="50.000" name="custom_amount[]" multiple="multiple" inputmode="numeric" data-type="currency">
                              </div>
                              <span class="_remove-btn cursor-pointer bg-primary bg-opacity-5 rounded-xs d-flex align-items-center justify-content-center w-12 ms-2 hv-o">
                                  <i class="rck ryd-delete link-primary text-xl"></i>
                              </span>
                          </div>
                      </div>
                  `)
                  
              }
              if (countCustomNom >= 5) {
                  $('#customNominalBtn').addClass(['text-gray-light', 'cursor-default']).removeClass(['text-primary', 'cursor-pointer'])
              }
          
          
              const customNominalAppend = document.querySelectorAll('.custom-nominal-append')
          
              customNominalAppend.forEach(function(e, i) {
                  document.querySelectorAll('._remove-btn')[i].addEventListener('click', function() {
                      customNominalAppend[i].remove()
                      if (countCustomNom >= 5) {
                          $('#customNominalBtn').removeClass(['text-gray-light', 'cursor-default']).addClass(['text-primary', 'cursor-pointer'])
                      }
                  })
              });
          
              function formatNumber(n) {
                  // format number 1000000 to 1,234,567
                  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
              }
          
              function formatCurrency(input, blur) {
                  // appends $ to value, validates decimal side
                  // and puts cursor back in right position.
          
                  // get input value
                  var input_val = input.val();
          
                  // don't validate empty input
                  if (input_val === "") { return; }
          
                  // original length
                  var original_len = input_val.length;
          
                  // initial caret position 
                  var caret_pos = input.prop("selectionStart");
          
                  // check for decimal
                  if (input_val.indexOf(",") >= 0) {
          
                      // get position of first decimal
                      // this prevents multiple decimals from
                      // being entered
                      var decimal_pos = input_val.indexOf(",");
          
                      // split number by decimal point
                      var left_side = input_val.substring(0, decimal_pos);
                      var right_side = input_val.substring(decimal_pos);
          
                      // add commas to left side of number
                      left_side = formatNumber(left_side);
          
                      // validate right side
                      right_side = formatNumber(right_side);
          
                      // On blur make sure 2 numbers after decimal
                      if (blur === "blur") {
                          right_side += "00";
                      }
          
                      // Limit decimal to only 2 digits
                      right_side = right_side.substring(0, 2);
          
                      // join number by .
                      // input_val = "Rp" + left_side + "," + right_side;
                      input_val = left_side + "," + right_side;
          
                  } else {
                      // no decimal entered
                      // add commas to number
                      // remove all non-digits
                      input_val = formatNumber(input_val);
                      // input_val = "Rp " + input_val;
                      input_val = input_val;
          
                      // final formatting
                      // if (blur === "blur") {
                      //     input_val += ".00";
                      // }
                  }
          
                  // send updated string to input
                  input.val(input_val);
          
                  // put caret back in the right position
                  var updated_len = input_val.length;
                  caret_pos = updated_len - original_len + caret_pos;
                  input[0].setSelectionRange(caret_pos, caret_pos);
              }
          })
          
          //- Upload Thumb
          function readURL(input) {
              if (input.files && input.files[0]) {
              var reader = new FileReader();
          
              reader.onload = function (e) {
                  $('#uploadThumb').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
              }
          }
          
          $("#uploadThumbBtn").change(function(){
              readURL(this);
          });
          
          var toolbarOptions = [
              ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
              ['blockquote', 'code-block'],
          
              //- [{ 'header': 1 }, { 'header': 2 }],               // custom button values
              [{ 'list': 'ordered'}, { 'list': 'bullet' }],
              [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
              //- [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
              //- [{ 'direction': 'rtl' }],                         // text direction
          
              //- [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
              //- [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
              [ 'link', 'image', 'video', 'formula' ],          // add's image support
              //- [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
              //- [{ 'font': [] }],
              [{ 'align': [] }],
          
              ['clean']                                         // remove formatting button
          ];
          const quill = new Quill('#editor', {
              modules: {
                  toolbar: toolbarOptions
              },
              theme: 'snow'
          });
          quill.root.innerHTML = @json($data->description);
          
        // Open Goal
        $('#openGoal input').click(function() {
              if ($(this).is(':checked')) {
                  $('.non-open-goal').hide();
              } else {
                  $('.non-open-goal').show();
              }
          })

            function url() {
                var judul = $('#title').val();
                $('#slug').val(membuatslug(judul));
            }

            function membuatslug(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-') // Replace spaces with -
                    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                    .replace(/\-\-+/g, '-') // Replace multiple - with single -
                    .replace(/^-+/, '') // Trim - from start of text
                    .replace(/-+$/, ''); // Trim - from end of text
            }

            quill.on('text-change', function(delta, oldDelta, source) {
                $('#description').val(quill.container.firstChild.innerHTML);
            });
    </script>
@endsection