@extends('backoffice.layouts.master')
@section('content')
<!-- Captions start -->
<style>

    @media (min-width: 800px) {
    /* Styles */
        .inputsearch{
            width: 400px;
        }
    }
</style>
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Kelola Data FAQ Deskripsi</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item">FAQ Deskripsi</li>
                    <li class="breadcrumb-item active"  > <a href="">{{ @$data ? 'Ubah' : 'Tambah' }}</a> </li>
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
                <div class="card">
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <form action="{{ @$data->id ? route('faq_descriptions.update', @$data->id) : route('faq_descriptions.store') }}" method="POST" class="form form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="{{ @$data->id ? 'PUT' : 'POST'}}">
                                <div class="form-body">

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">FAQ Kategori<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="faq_categories_id" id="faq_categories_id" required>
                                                    <option value="">Pilih FAQ Kategori</option>
                                                    @foreach ($faqCategory as $row)
                                                    <option value="{{ $row->id }}" {{ @$data->faq_categories_id == $row->id ? 'selected' : "" }}>{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('faq_categories_id'))
                                                    <small style="color: red;">{{ $errors->first('faq_categories_id') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Tipe<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="type" id="type" required>
                                                    <option value="">Pilih Tipe</option>
                                                    <option value="GALANGDANA" {{ @$data->type == 'GALANGDANA' ? 'selected' : "" }}>Galang Dana</option>
                                                    <option value="UMUM" {{ @$data->type == 'UMUM' ? 'selected' : "" }}>Umum</option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <small style="color: red;">{{ $errors->first('type') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Pertanyaan<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <input type="text" name="question" value="{{ @$data->question ?? old('question') }}" id="question" class="form-control" placeholder="Pertanyaan" required>
                                                @if ($errors->has('question'))
                                                    <small style="color: red;">{{ $errors->first('question') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Kata Kunci<small style="color: red;">*</small></label>
                                            <div class="col-lg-10">
                                                <input type="text" name="keyword" value="{{ @$data->keyword ?? old('keyword') }}" id="keyword" class="form-control" placeholder="Kata Kunci" required>
                                                @if ($errors->has('keyword'))
                                                    <small style="color: red;">{{ $errors->first('keyword') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
										<div class="row">
											<label class="col-lg-2">Jawaban <small style="color: red;">*</small></label>
											<div class="col-lg-10">
												<textarea name="answer" id="answer" class="form-control">{!! @$data->id ? $data->answer: old('answer') !!}</textarea>
												@if ($errors->has('answer'))
													<small style="color: red;">{{ $errors->first('answer') }}</small>
												@endif
											</div>
										</div>
									</div>

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-lg-2">Status</label>
                                            <div class="col-lg-10">
                                                <input type="checkbox" id="enabled" name="enabled" class="switchery" data-color="info" {{ @$data->enabled == 1 ? "checked" : "" }}/>
                                                @if ($errors->has('enabled'))
                                                    <small style="color: red;">{{ $errors->first('enabled') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-actions">
                                        <a href="{{ route('bank_accounts.index') }}" type="button" class="btn btn-warning mr-1 round">
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

@section('script')
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.plugins.addExternal( 'justify', '/backoffice/assets/js/justify/', 'plugin.js' );

    CKEDITOR.replace( 'answer', {
        extraPlugins: 'justify',
		filebrowserUploadUrl: "{{route('upload_faq-description', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});
</script>

@endsection