
@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Profile Perusahaan</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Web Management</li>
                    <li class="breadcrumb-item active"  > <a href="">Profile Perusahaan</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($message = Session::get('success'))
				<div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
					<span class="alert-icon"><i class="fa fa-thumbs-o-up"></i></span>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>Sukses!</strong> {{ $message }}.
				</div>
			@endif

			@if ($message = Session::get('error'))
				<div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
					<span class="alert-icon"><i class="fa fa-exclamation-triangle"></i></span>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>Gagal!</strong> {{ $message }}.
				</div>
			@endif

			@if ($message = Session::get('info'))
				<div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
					<span class="alert-icon"><i class="fa fa-exclamation"></i></span>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<strong>Informasi!</strong> {{ $message }}.
				</div>
			@endif
                <div class="card-content collapse show">
                    <div class="card-body">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item mb-1">
                                <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">Profile</a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="pills-kontak-tab" data-toggle="pill" href="#pills-kontak" role="tab" aria-controls="pills-kontak" aria-selected="false">Kontak</a>
                            </li>
                            {{-- <li class="nav-item mb-1">
                                <a class="nav-link" id="pills-visi-misi-tab" data-toggle="pill" href="#pills-visi-misi" role="tab" aria-controls="pills-visi-misi" aria-selected="false">Visi Misi</a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="pills-legalitas-tab" data-toggle="pill" href="#pills-legalitas" role="tab" aria-controls="pills-legalitas" aria-selected="false">Legalitas</a>
                                </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="pills-sejarah-tab" data-toggle="pill" href="#pills-sejarah" role="tab" aria-controls="pills-sejarah" aria-selected="false">Sejarah</a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="pills-manajemen-tab" data-toggle="pill" href="#pills-manajemen" role="tab" aria-controls="pills-manajemen" aria-selected="false">Manajemen</a>
                            </li> --}}
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="pills-syarat-dan-ketentuan-tab" data-toggle="pill" href="#pills-syarat-dan-ketentuan" role="tab" aria-controls="pills-syarat-dan-ketentuan" aria-selected="false">Syarat dan Ketentuan</a>
                            </li>
                            <li class="nav-item mb-1">
                                <a class="nav-link" id="pills-kebijakan-tab" data-toggle="pill" href="#pills-kebijakan" role="tab" aria-controls="pills-kebijakan" aria-selected="false">Kebijakan</a>
                            </li>
                        </ul>
                        <form action="{{ @$data->id ? route('profile-yayasan.update', @$data->id) : route('profile-yayasan.store') }}" method="POST" class="form form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_method" value="{{ @$data->id ? 'PUT' : 'POST'}}">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="form-body">
                                        <h4 class="form-section"> Profile</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Profile</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="profile" id="description">{!! @$data->id ? $staticPage['profile']: old('profile') !!}</textarea>
                                                    <!--<textarea name="profile" id="description" class="form-control" placeholder="Profile Yayasan">{!! @$data->id ? $staticPage['profile']: old('profile') !!}</textarea>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-kontak" role="tabpanel" aria-labelledby="pills-kontak-tab">
                                    <h4 class="form-section"> Kontak</h4>
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nama Yayasan" value="{{ @$data->id ? $data->name: old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <input type="file" name="image_url" accept="image/*" class="form-control" value="{{ @$data->id ? $data->name: old('name') }}">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Alamat</label>
                                            <textarea class="form-control" name="address1" placeholder="Alamat Yayasan">{!! @$data->id ? $address['address1']: old('address1') !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>No Telp</label>
                                            <input class="form-control" name="phone_1" placeholder="No Telp Yayasan" value="{!! @$data->id ? $phone_number['phone_1']: old('phone_1') !!}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Email</label>
                                            <input class="form-control" name="email1" placeholder="Email Yayasan" value="{!! @$data->id ? $email['email1']: old('email1') !!}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label>Website</label>
                                            <input class="form-control" name="website1" placeholder="Website Yayasan" value="{!! @$data->id ? $website['website1']: old('website1') !!}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Facebook</label>
                                            <input class="form-control" name="facebook" placeholder="Facebook Yayasan" value="{!! @$data->id ? $social_media['facebook']: old('facebook') !!}">
                                            </div>
                                        <div class="form-group col-md-4">
                                            <label>Instagram</label>
                                            <input class="form-control" name="instagram" placeholder="Instagram Yayasan" value="{!! @$data->id ? $social_media['instagram']: old('instagram') !!}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Youtube</label>
                                            <input class="form-control" name="youtube" placeholder="Youtube Yayasan" value="{!! @$data->id ? $social_media['youtube']: old('youtube') !!}">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-visi-misi" role="tabpanel" aria-labelledby="pills-visi-misi-tab">
                                    <div class="form-body">
                                        <h4 class="form-section"> Visi Misi</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Visi</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="visi" id="description">{!! @$data->id ? $staticPage['visi']: old('visi') !!}</textarea>
                                                    <!--<textarea name="visimisi" id="description" class="form-control" placeholder="Visi Misi Yayasan">{!! @$data->id ? $staticPage['visi']: old('visi') !!}</textarea>-->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Misi</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="misi" id="description">{!! @$data->id ? $staticPage['misi']: old('misi') !!}</textarea>
                                                    <!--<textarea name="visimisi" id="description" class="form-control" placeholder="Visi Misi Yayasan">{!! @$data->id ? $staticPage['misi']: old('misi') !!}</textarea>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-legalitas" role="tabpanel" aria-labelledby="pills-legalitas-tab">
                                    <div class="form-body">
                                        <h4 class="form-section"> Legalitas</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Legalitas</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="legalitas" id="description">{!! @$data->id ? $staticPage['legalitas']: old('legalitas') !!}</textarea>
                                                    <!--<textarea name="legalitas" id="description" class="form-control" placeholder="Legalitas">{!! @$data->id ? $staticPage['legalitas']: old('legalitas') !!}</textarea>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-sejarah" role="tabpanel" aria-labelledby="pills-sejarah-tab">
                                    <div class="form-body">
                                        <h4 class="form-section"> Sejarah</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Sejarah</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="sejarah" id="description">{!! @$data->id ? $staticPage['sejarah']: old('sejarah') !!}</textarea>
                                                    <!--<textarea name="sejarah" id="description" class="form-control" placeholder="Sejarah Yayasan">{!! @$data->id ? $staticPage['sejarah']: old('sejarah') !!}</textarea>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-manajemen" role="tabpanel" aria-labelledby="pills-manajemen-tab">
                                    <div class="form-body">
                                        <h4 class="form-section"> Manajemen</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Manajemen</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="manajemen" id="description">{!! @$data->id ? $staticPage['manajemen']: old('manajemen') !!}</textarea>
                                                    <!--<textarea name="manajemen" id="description" class="form-control" placeholder="Manajemen Yayasan">{{ @$data->id ? $staticPage['manajemen']: old('manajemen') }}</textarea>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-syarat-dan-ketentuan" role="tabpanel" aria-labelledby="pills-syarat-dan-ketentuan-tab">
                                    <div class="form-body">
                                        <h4 class="form-section"> Syarat dan Ketentuan</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Syarat dan Ketentuan</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="termcondition" id="description">{!! @$data->id ? $staticPage['termcondition']: old('termcondition') !!}</textarea>
                                                    <!--<textarea name="termcondition" id="description" class="form-control" placeholder="Syarat dan Ketentuan Yayasan">{{ @$data->id ? $staticPage['termcondition']: old('termcondition') }}</textarea>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Syarat dan Ketentuan Fundraiser</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="termfundraiser" id="description">{!! @$data->id ? $staticPage['termfundraiser']: old('termfundraiser') !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Syarat dan Ketentuan Corporate</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="termcorporate" id="description">{!! @$data->id ? $staticPage['termcorporate']: old('termcorporate') !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Syarat dan Ketentuan Personal</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="termpersonal" id="description">{!! @$data->id ? $staticPage['termpersonal']: old('termpersonal') !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Syarat dan Ketentuan Campaigner Personal</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="termcampaignerpersonal" id="description">{!! @$data->id ? $staticPage['termcampaignerpersonal']: old('termcampaignerpersonal') !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Syarat dan Ketentuan Campaigner Corporate</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="termcampaignercorporate" id="description">{!! @$data->id ? $staticPage['termcampaignercorporate']: old('termcampaignercorporate') !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-kebijakan" role="tabpanel" aria-labelledby="pills-kebijakan-tab">
                                    <div class="form-body">
                                        <h4 class="form-section"> Kebijakan</h4>
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-lg-2">Kebijakan</label>
                                                <div class="col-lg-10">
                                                    <textarea class="form-control" name="privacy" id="description">{!! @$data->id ? $staticPage['privacy']: old('privacy') !!}</textarea>
                                                    <!--<textarea name="privacy" id="description" class="form-control" placeholder="Kebijakan">{{ @$data->id ? $staticPage['privacy']: old('privacy') }}</textarea>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <a href="{{ route('profile-yayasan.index') }}" type="button" class="btn btn-warning mr-1 round">
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-danger round">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('modal-scripts')
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.plugins.addExternal( 'justify', '/backoffice/assets/js/justify/', 'plugin.js' );
	CKEDITOR.replace( 'profile', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

	CKEDITOR.replace( 'visimisi', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

	CKEDITOR.replace( 'legalitas', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

	CKEDITOR.replace( 'sejarah', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

	CKEDITOR.replace( 'manajemen', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

	CKEDITOR.replace( 'termcondition', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

	CKEDITOR.replace( 'termfundraiser', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

    CKEDITOR.replace( 'termcorporate', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

    CKEDITOR.replace( 'termpersonal', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

    CKEDITOR.replace( 'termcampaignerpersonal', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

    CKEDITOR.replace( 'termcampaignercorporate', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

	CKEDITOR.replace( 'privacy', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('profile-yayasan.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});

</script>
@endpush

@endsection
