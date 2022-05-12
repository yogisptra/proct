@extends('backoffice.layouts.master')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Template Pesan</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Template Pesan</li>
                    <li class="breadcrumb-item active"  > <a href="">{{ @$data ? 'Edit' : 'Create' }}</a> </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
	<!-- Basic form layout section start -->
	<section id="horizontal-form-layouts">
		<div class="row">
			<div class="col-md-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger mt-2">
                        <p>{{ $message }}</p>
                    </div>
                @endif
				<div class="card">
					<div class="card-content collapse show">
						<div class="card-body">
							<form action="{{ @$data->id ? route('template_messages.update', @$data->id) : route('template_messages.store') }}" method="POST" class="form form-horizontal" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="_method" value="{{ @$data->id ? 'PUT' : 'POST'}}">
								<div class="form-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Nama Pesan<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <input type="text" name="name" value="{{ @$data->name ?? old('name') }}" id="name" class="form-control" placeholder="Contoh: Register atau Transaksi" required>
                                                @if ($errors->has('name'))
                                                    <small style="color: red;">{{ $errors->first('name') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

									<div class="form-group">
										<div class="row">
											<label class="col-lg-2"> Tipe Pesan<small style="color: red;">*</small></label>
											<div class="col-lg-10">
												<select name="type" class="form-control" required>
                                                    <option value="">Silahkan Pilih</option>
													<option value="email" {{ @$data->type == "email" ? "selected" : "" }}>Email</option>
													<option value="whatsapp" {{ @$data->type == "whatsapp" ? "selected" : "" }}>Whatsapp</option>
												</select>
												@if ($errors->has('type'))
													<small style="color: red;">{{ $errors->first('type') }}</small>
												@endif
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<label class="col-lg-2"> Pesan<small style="color: red;">*</small></label>
											<div class="col-lg-10">
												<textarea name="message" id="message" class="form-control" rows="4" placeholder="Contoh : Hi [NAME] [DONASI]">{{ @$data->message ? $data->message : "" }}</textarea>
                                                @if ($errors->has('message'))
													<small style="color: red;">{{ $errors->first('message') }}</small>
												@endif
												<br/>
												Variabel yang support :<br/>
												- [NAME] (Mengambil nama)<br/> - [EMAIL] (Mengambil email)
                                                | [TELP] (Mengambil no. telp)<br/> - [DONASI] (Nominal donasi)
                                                | [CAMPAIGN] (Mengambil campaign)<br/> - [DATE] (Mengambil tanggal)
												| [INVOICE] (Mengambil nomor transaksi)<br/> - [BANK] (Mengambil nama bank)
												| [PAYMENT] (Mengambil metode Pembayaran)<br/> - [ACCOUNT_REK] (Mengambil nomor rekening)
												| [ACCOUNT_NAME] (Mengambil nama rekening)
											</div>
										</div>
									</div>

                                    <div class="form-group">
										<div class="row">
											<label class="col-lg-2"> Keterangan</label>
											<div class="col-lg-10">
                                                <textarea name="description" rows="4" class="form-control" placeholder="Masukkan Deskripsi">{{ @$data->description ? $data->description : "" }}</textarea>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											<label class="col-lg-2">Status</label>
											<div class="col-lg-10">
												<input type="checkbox" id="enable" name="enabled" class="switchery" data-color="info" {{@$data->enabled == 1 ? 'checked' : ''}}/>
												@if ($errors->has('enabled'))
													<small style="color: red;">{{ $errors->first('enable') }}</small>
												@endif
											</div>
										</div>
									</div>

									<div class="form-actions">
										<a href="{{ route('template_messages.index') }}" type="button" class="btn btn-warning round mr-1">
										    Kembali
										</a>
										<button type="submit" class="btn btn-danger round">
										{{ @$data->id ? 'Ubah' : 'Simpan'}}
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<!-- // Basic form layout section end -->
</div>
@endsection

@push('modal-scripts')
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script>
	CKEDITOR.plugins.addExternal( 'justify', '/backoffice/assets/js/justify/', 'plugin.js' );

	CKEDITOR.replace( 'message', {
		extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('template_messages.upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});
</script>
@endpush