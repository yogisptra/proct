@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<h3 class="content-header-title">Kelola Data FAQ Deksripsi</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Masterdata</li>
					<li class="breadcrumb-item">Data FAQ Deksripsi</li>
                    <li class="breadcrumb-item active"  > <a href="">Lihat Data</a> </li>

                </ol>
            </div>
        </div>
	</div>
    <div class="content-header-right col-md-6 col-12">
    <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
        <a href="{{ route('faq_descriptions.index') }}" type="button" class="btn btn-danger mr-1 round">
            Kembali
        </a>
    </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <form class="form form-horizontal">
                                        <div class="form-body">

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">FAQ Kategori</label>
                                                    <div class="col-lg-9">
                                                        <span>: {{ $data->hasFaqCategory->name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Pertanyaan</label>
                                                    <div class="col-lg-9">
                                                        <span>: {{ $data->question }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Kata Kunci</label>
                                                    <div class="col-lg-9">
                                                        <span>: {{ $data->keyword ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Status</label>
                                                    <div class="col-lg-9">
                                                        @if ($data->enabled == 1)
                                                            : <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            : <span class="badge badge-danger">Tidak Aktif</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Jawaban</label>
                                                    <div class="col-lg-9">
                                                        {!! $data->answer !!}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
