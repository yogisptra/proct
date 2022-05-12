@extends('frontoffice.layouts.dashboard-corporate')

@section('top-resource')
<link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/select2.min.css') }}">
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->

    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="mx-ss-n2">
                <ul class="row gx-0 w-full nav nav-tabs">
                    <li class="col-6">
                        <button class="fw-medium active" data-bs-target="#tab-corporate" data-bs-toggle="tab">Data Perusahaan</button>
                    </li>
                    <li class="col-6">
                        <button class="fw-medium" data-bs-target="#tab-responsible" data-bs-toggle="tab">Penanggung Jawab</button>
                    </li>
                </ul>
            </div>
            <div class="container">
                <form action="{{ route('update-campaignerCorporate', @$data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="tab-content mt-6">
                        <div class="tab-pane active" id="tab-corporate">
                            <div>
                                <label class="user-select-none text-xs fw-medium mb-2">NIB
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-id-card {{ $errors->has('name') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" type="number" placeholder="9120101******" name="nib" value="{{ $data->nib }}" required>
                                </div>
                                @if ($errors->has('nib'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('nib') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Nama Perusahaan / Yayasan / Organisasi
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-user {{ $errors->has('corporate_name') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" type="text" placeholder="Nama Perusahaan" name="corporate_name" value="{{ $data->corporate_name }}" required>
                                </div>
                                @if ($errors->has('corporate_name'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_name') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Email
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-mail {{ $errors->has('corporate_email') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" type="text" placeholder="Email Perusahaan" name="corporate_email" value="{{ $data->corporate_email }}" required>
                                </div>
                                @if ($errors->has('corporate_email'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_email') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Nomor Telepon
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-calling {{ $errors->has('corporate_phone_number') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" type="number" placeholder="Email Perusahaan" name="corporate_phone_number" value="{{ $data->corporate_phone_number }}" required>
                                </div>
                                @if ($errors->has('corporate_phone_number'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_phone_number') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Alamat
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-map {{ $errors->has('corporate_address') ? 'text-danger' : 'text-primary' }}"></i>
                                    <textarea class="input ps-12" placeholder="Jl. Venus No. 1" name="corporate_address" required>{!! $data->corporate_address !!}</textarea>
                                </div>
                                @if ($errors->has('corporate_address'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_address') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Negara
                                </label>
                                <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('corporate_country') ? 'text-danger' : 'text-primary' }}"></i>
                                    <select class="select-with-search" name="corporate_country" id="corporate_country">
                                        <option selected disabled>Pilih Negara</option>
                                        @foreach ($country as $row)
                                            <option value="{{ $row->id }}" {{ @$data->corporate_country == $data->corporate_country ? 'selected' : "" }}>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('corporate_country'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_country') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Provinsi
                                </label>
                                <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('corporate_province') ? 'text-danger' : 'text-primary' }}"></i>
                                    <select class="select-with-search" name="corporate_province" id="corporate_province" required>
                                        @foreach ($province as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('corporate_province'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_province') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Kota/Kabupaten
                                </label>
                                <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('corporate_city') ? 'text-danger' : 'text-primary' }}"></i>
                                    @if($data->corporate_city != NULL)
                                    <select class="select-with-search" name="corporate_city" id="corporate_city" required>
                                        <option value="{{ $data->corporate_city }}" {{ @$data->corporate_city == $data->corporate_city ? 'selected' : "" }}>{{ $data->hasCity->name }}</option>
                                    </select>
                                    @else
                                    <select class="select-with-search" name="corporate_city" id="corporate_city" required>
                                        <option selected disabled>Pilih Kota/Kabupaten</option>
                                    </select>
                                    @endif
                                    @if ($errors->has('corporate_city'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_city') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Kecamatan
                                </label>
                                <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('corporate_district') ? 'text-danger' : 'text-primary' }}"></i>
                                    @if($data->corporate_district != NULL)
                                    <select class="select-with-search" name="corporate_district" id="corporate_district" required>
                                        <option value="{{ $data->corporate_district }}" {{ @$data->corporate_district == $data->corporate_district ? 'selected' : "" }}>{{ $data->hasDistrict->name }}</option>
                                    </select>
                                    @else
                                    <select class="select-with-search" name="corporate_district" id="corporate_district" required>
                                        <option selected disabled>Pilih Kecamatan</option>
                                    </select>
                                    @endif
                                    @if ($errors->has('corporate_district'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_district') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Kelurahan
                                </label>
                                <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('corporate_area') ? 'text-danger' : 'text-primary' }}"></i>
                                    @if($data->corporate_area != NULL)
                                    <select class="select-with-search" name="corporate_area" id="corporate_area" required>
                                        <option value="{{ $data->corporate_area }}" {{ @$data->corporate_area == $data->corporate_area ? 'selected' : "" }}>{{ $data->hasArea->name }}</option>
                                    </select>
                                    @else
                                    <select class="select-with-search" name="corporate_area" id="corporate_area" required>
                                        <option selected disabled>Pilih Kelurahan</option>
                                    </select>
                                    @endif
                                    @if ($errors->has('corporate_area'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_area') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Kode Pos
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-postal {{ $errors->has('corporate_codepos') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" type="number" placeholder="40000" name="corporate_codepos" value="{{ $data->corporate_codepos }}" required>
                                </div>
                                @if ($errors->has('corporate_codepos'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('corporate_codepos') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Cover Legalitas Lembaga<span class="d-inline-block text-xxs text-gray ms-1">(Max. 1MB, Jenis File JPG/PNG)</span>
                                </label>
                                <div class="position-relative">
                                    <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                        <input class="d-none" name="file_akta" type="file" id="uploadCoverBtn" accept="image/png, image/jpeg">
                                        <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb text-primary text-default me-2"> </i><span class="text-xs">Cover Lembaga Legalitas</span>
                                        </div>
                                        <img class="w-full cursor-pointer position-relative" id="uploadCover" src="{{ asset('frontoffice/assets/img/upload-wrapper.webp') }}" alt="Background Upload Wrapper">
                                    </label>
                                </div>
                                @if ($errors->has('file_akta'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('file_akta') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Unggah Logo<span class="d-inline-block text-xxs text-gray ms-1">(Max. 5MB, Jenis File JPG/PNG)</span>
                                </label>
                                <div class="position-relative">
                                    <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                        <input class="d-none" name="image" type="file" id="uploadLogoBtn" required accept="image/png, image/jpeg">
                                        <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb text-primary text-default me-2"> </i><span class="text-xs">Unggah Logo</span>
                                        </div>
                                        <img class="w-full cursor-pointer position-relative" id="uploadLogo" src="{{ asset('frontoffice/assets/img/upload-wrapper.webp') }}" alt="Background Upload Wrapper">
                                    </label>
                                </div>
                                @if ($errors->has('image'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                            <div class="h-2 bg-body mx-n8 my-6"></div>
                            <div>
                                <label class="user-select-none text-xs fw-medium mb-2">Facebook
                                </label>
                                <div class="position-relative">
                                    <input class="input" name="facebook" value="{{ $data->facebook ?? '-' }}" type="text" placeholder="https://www.facebook.com/[namaakun]">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Instagram
                                </label>
                                <div class="position-relative">
                                    <input class="input" name="instagram" value="{{ $data->instagram ?? '-' }}" type="text" placeholder="https://www.instagram.com/[namaakun]">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">LinkedIn
                                </label>
                                <div class="position-relative">
                                    <input class="input" name="linkedin" value="{{ $data->linkedin ?? '-' }}" type="text" placeholder="https://www.linkedin.com/company/[namaakun]">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Tiktok
                                </label>
                                <div class="position-relative">
                                    <input class="input" name="tiktok" value="{{ $data->tiktok ?? '-' }}" type="text" placeholder="https://www.tiktok.com/[@namaakun]">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Twitter
                                </label>
                                <div class="position-relative">
                                    <input class="input" name="twitter" value="{{ $data->twitter ?? '-' }}" type="text" placeholder="https://www.twitter.com/[@namaakun]">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Tentang Campaigner
                                </label>
                                <div class="position-relative">
                                    <textarea class="input" name="bio" placeholder="">{{ $data->bio ?? '-' }}</textarea>
                                </div>
                            </div>
                            <a class="link-btn link-btn-primary h-12 w-full mt-8 rounded-xs fw-medium" data-button="next"><span>Selanjutnya</span><i class="text-default ms-2 rck ryd-arrow-right"></i></a>
                        </div>
                        <div class="tab-pane" id="tab-responsible">
                            <div>
                                <label class="user-select-none text-xs fw-medium mb-2">NIK
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-id-card {{ $errors->has('nik_pic') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" maxlength="16" name="nik_pic" type="number" placeholder="32**************" value="{{ $data->nik_pic }}" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                                @if ($errors->has('nik_pic'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('nik_pic') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Nama Lengkap
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-user {{ $errors->has('name_pic') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" name="name_pic" type="text" placeholder="Nama Lengkap" value="{{ $data->name_pic }}" required>
                                </div>
                                @if ($errors->has('name_pic'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('name_pic') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Email
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-mail {{ $errors->has('email_pic') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" name="email_pic" type="text" placeholder="Email" value="{{ $data->email_pic }}" required>
                                </div>
                                @if ($errors->has('email_pic'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('email_pic') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Nomor Telepon
                                </label>
                                <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-calling {{ $errors->has('phone_number_pic') ? 'text-danger' : 'text-primary' }}"></i>
                                    <input class="input ps-12" name="phone_number_pic" type="number" placeholder="Nomor Telepon" value="{{ $data->phone_number_pic }}" required>
                                </div>
                                @if ($errors->has('phone_number_pic'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('phone_number_pic') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Unggah KTP<span class="d-inline-block text-xxs text-gray ms-1">(Max. 5MB, Jenis File JPG/PNG)</span>
                                </label>
                                <div class="position-relative">
                                    <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                        <input class="d-none" name="ktp_pic" type="file" id="uploadKTPBtn" accept="image/png, image/jpeg" required>
                                        <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb {{ $errors->has('ktp_pic') ? 'text-danger' : 'text-primary' }} text-default me-2"> </i><span class="text-xs">Unggah KTP</span>
                                        </div>
                                        <img class="w-full cursor-pointer position-relative" id="uploadKTP" src="{{ asset('frontoffice/assets/img/upload-wrapper.webp') }}" alt="Background Upload Wrapper">
                                    </label>
                                </div>
                                @if ($errors->has('ktp_pic'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('ktp_pic') }}</span>
                                @endif
                            </div>
                            <div class="mt-4">
                                <label class="user-select-none text-xs fw-medium mb-2">Unggah KTP + Selfie<span class="d-inline-block text-xxs text-gray ms-1">(Max. 5MB, Jenis File JPG/PNG)</span>
                                </label>
                                <div class="position-relative">
                                    <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                        <input class="d-none" name="image_selfie_pic" type="file" id="uploadKTPSelfieBtn" accept="image/png, image/jpeg" required>
                                        <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb {{ $errors->has('image_selfie_pic') ? 'text-danger' : 'text-primary' }} text-default me-2"> </i><span class="text-xs">Unggah KTP + Selfie</span>
                                        </div>
                                        <img class="w-full cursor-pointer position-relative" id="uploadKTPSelfie" src="{{ asset('frontoffice/assets/img/upload-wrapper.webp') }}" alt="Background Upload Wrapper">
                                    </label>
                                </div>
                                @if ($errors->has('image_selfie_pic'))
                                    <span class="mt-2 text-xs text-danger">{{ $errors->first('image_selfie_pic') }}</span>
                                @endif
                            </div>
                            <label class="cb mt-4">
                                <div class="cb__box">
                                    <input class="d-none" type="checkbox" name="snk" value="1">
                                    <div></div>
                                </div><span class="user-select-none ms-3">Dengan ini anda setuju <a class="link-primary" href="{{ route('frontoffice.term') }}" target="_blank">Syarat & Ketentuan</a> yang berlaku</span>
                            </label>
                            <div class="row gx-4 mt-8">
                                <div class="col-6"><a class="link-btn link-btn-primary-o h-12 w-full rounded-xs fw-medium" data-button="prev"><span>Kembali</span></a>
                                </div>
                                <div class="col-6">
                                    <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium" type="submit" value="Kirim">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection

@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->

    <script src="{{ asset('frontoffice/assets/js/vendor/select2.full.min.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/select2.set.js') }}"></script>
    <script>
        //- Upload KTP
          function readURL(input) {
              if (input.files && input.files[0]) {
              var reader = new FileReader();
          
              reader.onload = function (e) {
                  $('#uploadKTP').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
              }
          }
          
          $("#uploadKTPBtn").change(function(){
              readURL(this);
          });
          
          //- Upload KTP Selfie
          function readURL2(input) {
              if (input.files && input.files[0]) {
              var reader = new FileReader();
          
              reader.onload = function (e) {
                  $('#uploadKTPSelfie').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
              }
          }
          
          $("#uploadKTPSelfieBtn").change(function(){
              readURL2(this);
          });
          
          //- Upload Logo
          function readURL3(input) {
              if (input.files && input.files[0]) {
              var reader = new FileReader();
          
              reader.onload = function (e) {
                  $('#uploadLogo').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
              }
          }
          
          $("#uploadLogoBtn").change(function(){
              readURL3(this);
          });

          function readURL4(input) {
              if (input.files && input.files[0]) {
              var reader = new FileReader();
          
              reader.onload = function (e) {
                  $('#uploadCover').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
              }
          }
          
          $("#uploadCoverBtn").change(function(){
              readURL4(this);
          });

        $('#corporate_province').on('change',function(e){

        var corporate_province = e.target.value;
        var url = "{{route('get-city', ':id')}}";
        url = url.replace(':id', corporate_province);
            $.get(url, function(data){
                $('#corporate_city').empty();
                $('#corporate_city').append('<option value="" selected disabled>Pilih Kota</option>');
                $.each(data, function(index, subcatObj){
                    $('#corporate_city').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
            });
        });

        $('#corporate_city').on('change',function(e){

        var corporate_city = e.target.value;
            var url = "{{route('get-district', ':id')}}";
            url = url.replace(':id', corporate_city);
            $.get(url, function(data){
                $('#corporate_district').empty();
                $('#corporate_district').append('<option value="" selected disabled>Pilih Kecamatan</option>');
                $.each(data, function(index, subcatObj){
                    $('#corporate_district').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
            });
        });

        $('#corporate_district').on('change',function(e){

        var corporate_district = e.target.value;
        var url = "{{route('get-area', ':id')}}";
        url = url.replace(':id', corporate_district);
            $.get(url, function(data){
                $('#corporate_area').empty();
                $('#corporate_area').append('<option value="" selected disabled>Pilih Kelurahan</option>');
                $.each(data, function(index, subcatObj){
                    $('#corporate_area').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
            });
        });

        $('#province_id').on('change',function(e){

        var province_id = e.target.value;
        var url = "{{route('get-city', ':id')}}";
        url = url.replace(':id', province_id);
            $.get(url, function(data){
                $('#city_id').empty();
                $('#city_id').append('<option value="" selected disabled>Pilih Kota</option>');
                $.each(data, function(index, subcatObj){
                    $('#city_id').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
            });
        });

        $('#city_id').on('change',function(e){

        var city_id = e.target.value;
            var url = "{{route('get-district', ':id')}}";
            url = url.replace(':id', city_id);
            $.get(url, function(data){
                $('#district_id').empty();
                $('#district_id').append('<option value="" selected disabled>Pilih Kecamatan</option>');
                $.each(data, function(index, subcatObj){
                    $('#district_id').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
            });
        });

        $('#district_id').on('change',function(e){

        var district_id = e.target.value;
        var url = "{{route('get-area', ':id')}}";
        url = url.replace(':id', district_id);
            $.get(url, function(data){
                $('#area_id').empty();
                $('#area_id').append('<option value="" selected disabled>Pilih Kelurahan</option>');
                $.each(data, function(index, subcatObj){
                    $('#area_id').append('<option value="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
            });
        });
    </script>
    <script>
        $('[data-button="next"]').click(function(){
              $('.nav-tabs li .active').parent().next().find('button').trigger('click');
          });
          
          $('[data-button="prev"]').click(function(){
              $('.nav-tabs li .active').parent().prev().find('button').trigger('click');
          });
    </script>
@endsection