@extends('backoffice.layouts.master')

@section('content')
<div class="content-header row">
	<div class="content-header-left col-md-6 col-12 mb-2">
		<h3 class="content-header-title">Data Tipe Pesan</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Setting</li>
					<li class="breadcrumb-item">Data Tipe Pesan</li>
                    <li class="breadcrumb-item active"  > <a href="">Detail</a> </li>

                </ol>
            </div>
        </div>
	</div>
    <div class="content-header-right col-md-6 col-12">
    <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
        <a href="{{ route('template_messages.index') }}" type="button" class="btn btn-danger mr-1 round">
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
                                                    <label class="col-lg-3">Nama Pesan</label>
                                                    <div class="col-lg-9">
                                                        <span>: {{ ucfirst(strtolower($data->name)) }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Tipe Pesan</label>
                                                    <div class="col-lg-9">
                                                        <span>: {{ $data->type == 'email' ? 'Email' : 'Whatsapp' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-3">Keterangan</label>
                                                    <div class="col-lg-9">
                                                        <span>: {{ $data->description }}</span>
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
                                                    <label class="col-lg-3">Pesan</label>
                                                    <div class="col-lg-9">
                                                        {!! $data->message !!}
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
