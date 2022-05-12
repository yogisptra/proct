@extends('frontoffice.layouts.dashboard-app')

@section('top-resource')
<link rel="stylesheet" type="text/css" href="{{ asset('frontoffice/assets/css/vendor/select2.min.css') }}">
@endsection

@section('content')
    <!-- NAVBAR-->
    @include('frontoffice.shared.header-user')

    <!-- CONTENT-->
    <main class="mt-18">
        <section class="maxview align-items-start bg-white px-ss-2 pt-6 pb-8">
            <div>
                <div class="mx-ss-n2">
                    <ul class="row gx-0 w-full nav nav-tabs">
                        <li class="col-6">
                            <button class="fw-medium" data-bs-target="#tab-bio" data-bs-toggle="tab">Data Diri</button>
                        </li>
                        <li class="col-6">
                            <button class="fw-medium" data-bs-target="#tab-password" data-bs-toggle="tab">Kata Sandi</button>
                        </li>
                    </ul>
                </div>
                <div class="container">
                    <div class="tab-content mt-6">
                        <div class="tab-pane" id="tab-bio">
                            <form action="{{ route('dashboard-editProfile', Auth::guard('member')->user()->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <label class="user-select-none text-xs fw-medium mb-2">Nama Lengkap
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-user {{ $errors->has('name') ? 'text-danger' : 'text-primary' }}"></i>
                                        <input class="input ps-12" name="name" type="text" placeholder="Nama Lengkap" value="{{ @Auth::guard('member')->user()->name ?? old('name') }}">
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Email
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-message {{ $errors->has('email') ? 'text-danger' : 'text-primary' }}"></i>
                                        <input class="input ps-12" name="email" type="email" placeholder="email@example.com" value="{{ @Auth::guard('member')->user()->email ?? old('email') }}">
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Nomor Telepon
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-calling {{ $errors->has('phone_number') ? 'text-danger' : 'text-primary' }}"></i>
                                        <input class="input ps-12" name="phone_number" type="number" placeholder="08**********" value="{{ @Auth::guard('member')->user()->phone_number ?? old('phone_number') }}">
                                    </div>
                                    @if ($errors->has('phone_number'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('phone_number') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Negara
                                    </label>
                                    <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('province_id') ? 'text-danger' : 'text-primary' }}"></i>
                                        <select class="select-with-search" name="country_id" id="country_id" required>
                                            <option selected disabled>Pilih Negara</option>
                                            @foreach ($country as $row)
                                                <option value="{{ $row->id }}" {{ @Auth::guard('member')->user()->country_id == $row->id ? 'selected' : "" }}>{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('country_id'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('country_id') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Provinsi
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
                                    <label class="user-select-none text-xs fw-medium mb-2">Kota/Kabupaten
                                    </label>
                                    <div class="position-relative h-11"><i class="position-absolute right-4 top-3_5 text-default rck ryd-chevron-down z-1 {{ $errors->has('city_id') ? 'text-danger' : 'text-primary' }}"></i>
                                        <select class="select-with-search" name="city_id" id="city_id" required>
                                            <option selected disabled>Pilih Kota/Kabupaten</option>
                                            @foreach ($city as $row)
                                                <option value="{{ $row->id }}" {{ @Auth::guard('member')->user()->city_id == $row->id ? 'selected' : "" }}>{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('city_id'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('city_id') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Kecamatan
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
                                    <label class="user-select-none text-xs fw-medium mb-2">Kelurahan
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
                                    <label class="user-select-none text-xs fw-medium mb-2">Alamat
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-map {{ $errors->has('address') ? 'text-danger' : 'text-primary' }}"></i>
                                        <textarea class="input ps-12" name="address" placeholder="Jl. Venus No. 1" required>{{ !empty(Auth::guard('member')->user()) ?  Auth::guard('member')->user()->address : old('address')}}</textarea>
                                    </div>
                                    @if ($errors->has('address'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Kode Pos
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-postal {{ $errors->has('codepos') ? 'text-danger' : 'text-primary' }}"></i>
                                        <input class="input ps-12" name="codepos" value="{{ @Auth::guard('member')->user()->codepos ?? old('codepos') }}" type="number" placeholder="40000">
                                    </div>
                                    @if ($errors->has('codepos'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('codepos') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Unggah Foto Profil<span class="d-inline-block text-xxs text-gray ms-1">(Max. 5MB, Jenis File JPG/PNG)</span>
                                    </label>
                                    <div class="position-relative">
                                        <label class="upload-img d-block bg-gray-light bg-opacity-30 rounded-xs overflow-hidden position-relative">
                                            <input class="d-none" name="image" type="file" id="uploadAvatarBtn" accept="image/png, image/jpeg">
                                            <div class="upload-img__label position-absolute d-flex align-items-center top-half left-half translate-nhalf user-select-none cursor-pointer"><i class="rck ryd-thumb text-primary text-default me-2"> </i><span class="text-xs">Unggah Foto Profil</span>
                                            </div>
                                            <img class="w-full cursor-pointer position-relative" id="uploadAvatar" src="{{ Auth::guard('member')->user()->image ? asset('assets/images/donatur/'. Auth::guard('member')->user()->image) : asset('frontoffice/assets/img/upload-wrapper.webp') }}" alt="Background Upload Wrapper">
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
                                        <input class="input" name="facebook" value="{{ Auth::guard('member')->user()->facebook ?? '-' }}" type="text" placeholder="https://www.facebook.com/[namaakun]">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Instagram
                                    </label>
                                    <div class="position-relative">
                                        <input class="input" name="instagram" value="{{ Auth::guard('member')->user()->instagram ?? '-' }}" type="text" placeholder="https://www.instagram.com/[namaakun]">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">LinkedIn
                                    </label>
                                    <div class="position-relative">
                                        <input class="input" name="linkedin" value="{{ Auth::guard('member')->user()->linkedin ?? '-' }}" type="text" placeholder="https://www.linkedin.com/company/[namaakun]">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Tiktok
                                    </label>
                                    <div class="position-relative">
                                        <input class="input" name="tiktok" value="{{ Auth::guard('member')->user()->tiktok ?? '-' }}" type="text" placeholder="https://www.tiktok.com/[@namaakun]">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Twitter
                                    </label>
                                    <div class="position-relative">
                                        <input class="input" name="twitter" value="{{ Auth::guard('member')->user()->twitter ?? '-' }}" type="text" placeholder="https://www.twitter.com/[@namaakun]">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Tentang Campaigner
                                    </label>
                                    <div class="position-relative">
                                        <textarea class="input" name="bio" placeholder="">{{ Auth::guard('member')->user()->bio ?? '-' }}</textarea>
                                    </div>
                                </div>
                                <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Simpan">
                            </form>
                        </div>
                        <div class="tab-pane" id="tab-password">
                            @if(Session::has('error'))
                            <div class="bg-danger bg-opacity-15 rounded rounded-xs p-3 mb-4">
                                <p>{{Session::get('error')}}</p>
                            </div>
                            @endif

                            @if(Session::has('success'))
                            <div class="bg-success bg-opacity-15 rounded rounded-xs p-3 mb-4">
                                <p>{{Session::get('success')}}</p>
                            </div>
                            @endif
                            <form action="{{ route('dashboard-editPassword', Auth::guard('member')->user()->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <label class="user-select-none text-xs fw-medium mb-2">Kata Sandi Lama
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock text-primary"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                                        <input class="input px-12" name="passwordLama" type="password" placeholder="********">
                                    </div>
                                    @if ($errors->has('passwordLama'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('passwordLama') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Kata Sandi Baru
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock text-primary"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                                        <input class="input px-12" name="passwordBaru" type="password" placeholder="********">
                                    </div>
                                    @if ($errors->has('passwordBaru'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('passwordBaru') }}</span>
                                    @endif
                                </div>
                                <div class="mt-4">
                                    <label class="user-select-none text-xs fw-medium mb-2">Ulangi Kata Sandi Baru
                                    </label>
                                    <div class="position-relative"><i class="position-absolute left-4 top-3_5 text-default rck ryd-lock text-primary"></i><i class="position-absolute right-4 top-3_5 text-default rck ryd-eye text-primary cursor-pointer togglePassword"></i>
                                        <input class="input px-12" name="passwordConfirm" type="password" placeholder="********">
                                    </div>
                                    @if ($errors->has('passwordConfirm'))
                                        <span class="mt-2 text-xs text-danger">{{ $errors->first('passwordConfirm') }}</span>
                                    @endif
                                </div>
                                <input class="link-btn link-btn-primary h-12 w-full rounded-xs fw-medium mt-8" type="submit" value="Simpan">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

@section('bottom-resource')
    <!-- WARNING! this scripts below used for this page only-->
    <script src="{{ asset('frontoffice/assets/js/vendor/select2.full.min.js') }}"></script>
    <script src="{{ asset('frontoffice/assets/js/select2.set.js') }}"></script>
    <script>
        $('button[data-bs-toggle="tab"]').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        $('button[data-bs-toggle="tab"]').on("shown.bs.tab", function (e) {
            var id = $(e.target).attr("data-bs-target");
            console.log(id);
            localStorage.setItem('selectedTab', id)
        });

        var selectedTab = localStorage.getItem('selectedTab');
        console.log(selectedTab)
        if (selectedTab == "#tab-password") {
            $('#tab-password').attr('class', 'tab-pane active');
            $('#tab-bio').attr('class', 'tab-pane');
            $('button[data-bs-target="#tab-password"]').attr("class", "fw-medium active");
            $('button[data-bs-target="#tab-bio"]').attr("class", "fw-medium");
            // $('#tab-password').attr("class", "tab-pane active");
        }else{
            $('#tab-password').attr('class', 'tab-pane');
            $('#tab-bio').attr('class', 'tab-pane active');
            $('button[data-bs-target="#tab-bio"]').attr("class", "fw-medium active");
            $('button[data-bs-target="#tab-password"]').attr("class", "fw-medium");
        }       
        //- Upload KTP
        function readURL(input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
        
            reader.onload = function (e) {
                $('#uploadAvatar').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#uploadAvatarBtn").change(function(){
            readURL(this);
        });

        $('#province_id').on('change',function(e){

        var province_id = e.target.value;
        var url = "{{route('users.get-city', ':id')}}";
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
            var url = "{{route('users.get-district', ':id')}}";
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
        var url = "{{route('users.get-area', ':id')}}";
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