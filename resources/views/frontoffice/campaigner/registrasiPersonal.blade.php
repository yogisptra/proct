
@extends('frontoffice.layouts.frontoffice-app')

@section('top-resource')
<link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/select2.min.css') }}">
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div class="container">
                <form action="{{ route('store-registrasiCampaigner', @Auth::guard('member')->user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type_campaigner" value="{{ $type }}">
                    <div>
                        <label class="user-select-none text-xs fw-medium mb-2">NIK<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-id-card {{ $errors->has('nik') ? 'text-danger' : 'text-primary' }}"></i>
                            <input class="input ps-12" maxlength="16" value="{{ old('nik') }}" name="nik" type="number" placeholder="32**************" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                        </div>
                        @if ($errors->has('nik'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('nik') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Nama Lengkap<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-user {{ $errors->has('name') ? 'text-danger' : 'text-primary' }}"></i>
                            <input class="input ps-12" name="name" type="text" placeholder="Nama Lengkap" value="{{ !empty(Auth::guard('member')->user()) ?  Auth::guard('member')->user()->name : old('name')}}" required>
                        </div>
                        @if ($errors->has('name'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Negara<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('country_id') ? 'text-danger' : 'text-primary' }}"></i>
                            <select class="select-with-search" name="country_id" id="country_id" required>
                                <option selected disabled>Pilih Negara</option>
                                @foreach ($country as $row)
                                    <option value="{{ $row->id }}" {{ @Auth::guard('member')->user()->country_id == $row->id ? 'selected' : "" }}>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                                <span class="mt-2 text-xs text-danger">{{ $errors->first('country_id') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Provinsi<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('province_id') ? 'text-danger' : 'text-primary' }}"></i>
                            <select class="select-with-search" name="province_id" id="province_id" required>
                                <option selected disabled>Pilih Provinsi</option>
                                @foreach ($province as $row)
                                    <option value="{{ $row->id }}" {{ @Auth::guard('member')->user()->province_id == $row->id ? 'selected' : "" }}>{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('province_id'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('province_id') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Kota/Kabupaten<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('city_id') ? 'text-danger' : 'text-primary' }}"></i>
                            @if(Auth::guard('member')->user()->city_id != NULL)
                            <select class="select-with-search" name="city_id" id="city_id" required>
                                <option value="{{ Auth::guard('member')->user()->city_id }}" {{ @Auth::guard('member')->user()->city_id == Auth::guard('member')->user()->city_id ? 'selected' : "" }}>{{ Auth::guard('member')->user()->hasCity->name }}</option>
                            </select>
                            @else
                            <select class="select-with-search" name="city_id" id="city_id" required>
                                <option selected disabled>Pilih Kota/Kabupaten</option>
                            </select>
                            @endif
                        </div>
                        @if ($errors->has('city_id'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('city_id') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Kecamatan<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('district_id') ? 'text-danger' : 'text-primary' }}"></i>
                            @if(Auth::guard('member')->user()->district_id != NULL)
                            <select class="select-with-search" name="district_id" id="district_id" required>
                                <option value="{{ Auth::guard('member')->user()->district_id }}" {{ @Auth::guard('member')->user()->district_id == Auth::guard('member')->user()->district_id ? 'selected' : "" }}>{{ Auth::guard('member')->user()->hasDistrict->name }}</option>
                            </select>
                            @else
                            <select class="select-with-search" name="district_id" id="district_id" required>
                                <option selected disabled>Pilih Kecamatan</option>
                            </select>
                            @endif
                        </div>
                        @if ($errors->has('district_id'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('district_id') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Kelurahan<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('area_id') ? 'text-danger' : 'text-primary' }}"></i>
                            @if(Auth::guard('member')->user()->area_id != NULL)
                            <select class="select-with-search" name="area_id" id="area_id" required>
                                <option value="{{ Auth::guard('member')->user()->area_id }}" {{ @Auth::guard('member')->user()->area_id == Auth::guard('member')->user()->area_id ? 'selected' : "" }}>{{ Auth::guard('member')->user()->hasArea->name }}</option>
                            </select>
                            @else
                            <select class="select-with-search" name="area_id" id="area_id" required>
                                <option selected disabled>Pilih Kelurahan</option>
                            </select>
                            @endif
                        </div>
                        @if ($errors->has('area_id'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('area_id') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Alamat<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-map {{ $errors->has('address') ? 'text-danger' : 'text-primary' }}"></i>
                            <textarea class="input ps-12" name="address" placeholder="Jl. Venus No. 1" required>{{ !empty(Auth::guard('member')->user()) ?  Auth::guard('member')->user()->address : old('address')}}</textarea>
                        </div>
                        @if ($errors->has('address'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Kode Pos<span class="mt-2 text-xs text-danger">*</span>
                        </label>
                        <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-postal {{ $errors->has('codepos') ? 'text-danger' : 'text-primary' }}"></i>
                            <input class="input ps-12" name="codepos" value="{{ !empty(Auth::guard('member')->user()) ?  Auth::guard('member')->user()->codepos : old('codepos')}}" type="number" placeholder="40000" required>
                        </div>
                        @if ($errors->has('codepos'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('codepos') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Unggah KTP<span class="mt-2 text-xs text-danger">*</span><span class="d-inline-block text-xxs text-gray ms-1">(Max. 1MB, Jenis File JPG/PNG)</span>
                        </label>
                        <div class="position-relative">
                            <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                <input class="d-none" name="image_ktp" type="file" id="uploadKTPBtn" accept="image/png, image/jpeg" required>
                                <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb {{ $errors->has('image_ktp') ? 'text-danger' : 'text-primary' }} text-default me-2"> </i><span class="text-xs">Unggah KTP</span>
                                </div>
                                <img class="w-full cursor-pointer position-relative" id="uploadKTP" src="{{ asset('frontoffice/assets/img/upload-wrapper.webp') }}" alt="Background Upload Wrapper">
                            </label>
                        </div>
                        @if ($errors->has('image_ktp'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('image_ktp') }}</span>
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Unggah KTP + Selfie<span class="mt-2 text-xs text-danger">*</span><span class="d-inline-block text-xxs text-gray ms-1">(Max. 1MB, Jenis File JPG/PNG)</span>
                        </label>
                        <div class="position-relative">
                            <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                <input class="d-none" name="image_selfie" type="file" id="uploadKTPSelfieBtn" accept="image/png, image/jpeg" required>
                                <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb {{ $errors->has('image_selfie') ? 'text-danger' : 'text-primary' }} text-default me-2"> </i><span class="text-xs">Unggah KTP + Selfie</span>
                                </div>
                                <img class="w-full cursor-pointer position-relative" id="uploadKTPSelfie" src="{{ asset('frontoffice/assets/img/upload-wrapper.webp') }}" alt="Background Upload Wrapper">
                            </label>
                        </div>
                        @if ($errors->has('image_selfie'))
                            <span class="mt-2 text-xs text-danger">{{ $errors->first('image_selfie') }}</span>
                        @endif
                    </div>
                    <div class="h-2 bg-body mx-n8 my-6"></div>
                    <div>
                        <label class="user-select-none text-xs fw-medium mb-2">Facebook
                        </label>
                        <div class="position-relative">
                            <input class="input" name="facebook" value="{{ old('facebook') }}" type="text" placeholder="https://www.facebook.com/[namaakun]">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Instagram
                        </label>
                        <div class="position-relative">
                            <input class="input" name="instagram" value="{{ old('instagram') }}" type="text" placeholder="https://www.instagram.com/[namaakun]">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">LinkedIn
                        </label>
                        <div class="position-relative">
                            <input class="input" name="linkedin" value="{{ old('linkedin') }}" type="text" placeholder="https://www.linkedin.com/company/[namaakun]">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Tiktok
                        </label>
                        <div class="position-relative">
                            <input class="input" name="tiktok" value="{{ old('tiktok') }}" type="text" placeholder="https://www.tiktok.com/[@namaakun]">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Twitter
                        </label>
                        <div class="position-relative">
                            <input class="input" name="twitter" value="{{ old('twitter') }}" type="text" placeholder="https://www.twitter.com/[@namaakun]">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="user-select-none text-xs fw-medium mb-2">Tentang Campaigner
                        </label>
                        <div class="position-relative">
                            <textarea class="input" name="bio" placeholder="">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                    <label class="cb mt-4">
                        <div class="cb__box" id="terms">
                            <input class="d-none" type="checkbox" name="snk" value="1">
                            <div></div>
                        </div><span class="user-select-none ms-3">Saya menyatakan bahwa segala data yang diberikan adalah benar.</span>
                    </label>
                    <input disabled class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8 submit" type="submit" value="Kirim">
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
@endsection