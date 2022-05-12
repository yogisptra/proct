@extends('backoffice.layouts.master')

@section('content')
<style>
        
    @media (min-width: 800px) {
    /* Styles */
        .inputsearch{
            width: 400px;
        }
    }
</style>
<!-- Captions start -->
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Kelola Data Menu</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Setting</li>
                    <li class="breadcrumb-item">Manage Menu</li>
                    <li class="breadcrumb-item active"><a href="">Ubah</a></li>
                </ol>
            </div>
        </div>
    </div>
    
</div>
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
    <div class="content-body"><!-- Basic form layout section start -->
        <section id="horizontal-form-layouts">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="card-body">
								<form action="{{ route('menus.update', $menu->id) }}" method="POST" class="form form-horizontal">
									@csrf
									@method('PUT')
									<div class="form-body">
										@if(count($menus) > 0)
											<div class="form-group">
												<div class="row">
													<label class="col-lg-2">Parent Menu</label>
													<div class="col-lg-10">
														<select class="form-control" name="parent_id" id="parent_id">
															<option value="">Pilih Parent Menu</option>
															@foreach ($menus as $row)
															<option value="{{$row->id}}"{{ $menu->parent_id == $row->id ? 'selected' : "" }}>{{$row->name}}</option>
															@endforeach
								
														</select>
															<small style="color: red;">[Boleh Tidak diisi]</small>
													</div>
												</div>
											</div>
										@endif
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Route</label>
												<div class="col-lg-10">
													<input type="text" name="route" id="route" class="form-control" placeholder="Route" value="{{ old('route') ? old('route') : $menu->route }}" >
													@if ($errors->has('route'))
														<small style="color: red;">{{ $errors->first('route') }}</small>
													@endif
												</div>
											</div>
										</div>
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Nama Menu<small style="color: red;">*</small></label>
												<div class="col-lg-10">
													<input type="text" name="name" id="name" class="form-control" placeholder="Nama Menu" value="{{ old('name') ? old('name') : $menu->name }}" required>
													@if ($errors->has('name'))
														<small style="color: red;">{{ $errors->first('name') }}</small>
													@endif
												</div>
											</div>
										</div>
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Keterangan<small style="color: red;">*</small></label>
												<div class="col-lg-10">
													<input type="text" name="description" id="description" class="form-control" placeholder="Keterangan" value="{{ old('description') ? old('description') : $menu->description }}" required >
													@if ($errors->has('description'))
														<small style="color: red;">{{ $errors->first('description') }}</small>
													@endif
												</div>
											</div>
										</div>
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Permission<small style="color: red;">*</small></label>
												<div class="col-lg-10">
													<select class="form-control" name="shown" id="shown" required>
														<option value="">Pilih Permission</option>
														<option value="with-authorize" {{$menu->shown != 'without-authorize' ? 'disabled' : ""}}>Dengan Perizinan</option>
														<option value="without-authorize" {{$menu->shown == 'without-authorize' ? 'selected' : ""}}>Tanpa Perizinan</option>
														@foreach ($permissions as $permission)
														<option style='backgroud-color: grey;' value="{{ $permission->name }}"{{ $menu->shown == $permission->name ? 'selected' : "" }} >{{ $permission->name }}</option>
														@endforeach
													</select>
													@if ($errors->has('shown'))
														<small style="color: red;">{{ $errors->first('shown') }}</small>
													@endif
												</div>
											</div>
										</div>
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Urutan<small style="color: red;">*</small></label>
												<div class="col-lg-10">
													<input type="text" name="sequence" id="sequence" class="form-control" placeholder="Urutan" value="{{ old('sequence') ? old('sequence') : $menu->sequence }}" required>
													@if ($errors->has('sequence'))
														<small style="color: red;">{{ $errors->first('sequence') }}</small>
													@endif
												</div>
											</div>
										</div>
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Ikon<small style="color: red;">*</small></label>
												<div class="col-lg-10">
													<input type="text" name="icon" id="icon" class="form-control" placeholder="Ikon" value="{{ old('icon') ? old('icon') : $menu->icon }}" required >
													@if ($errors->has('icon'))
														<small style="color: red;">{{ $errors->first('icon') }}</small>
													@endif
												</div>
											</div>
										</div>
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Status<small style="color: red;">*</small></label>
												<div class="col-lg-10">
													<!--<input type="text" name="enabled" id="enabled" class="form-control" placeholder="Enabled" value="{{ old('enabled') ? old('enabled') : $menu->enabled }}" required>-->
													<input type="checkbox" id="enabled" name="enabled" class="switchery" data-color="info" {{ $menu->enabled == 1 ? 'checked' : '' }}/>
													@if ($errors->has('enabled'))
														<small style="color: red;">{{ $errors->first('enabled') }}</small>
													@endif
												</div>
											</div>
										</div>
								
								
										<div class="form-actions">
											<a href="{{ route('menus.index') }}" type="button" class="btn btn-warning round mr-1">
												Kembali
											</a>
											<button type="submit" class="btn btn-danger round">
												Simpan
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