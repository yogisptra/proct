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
        <h3 class="content-header-title">Kelola Data Role</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Setting</li>
                    <li class="breadcrumb-item">Manage Role</li>
                    <li class="breadcrumb-item active"><a href="">Tambah</a></li>
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
								<form action="{{ route('roles.store') }}" method="POST" class="form form-horizontal">
									@csrf
									<div class="form-body">
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Nama Role</label>
												<div class="col-lg-10">
													<input type="text" name="name" id="name" class="form-control" placeholder="Nama Role	" >
												</div>
											</div>
										</div>
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Permission</label>
												<div class="col-lg-10">
													<div class="row">
														<table class="table">
															<thead>
																<tr>
																	<th>Menu</th>
																	<th class="text-center">Allow Read</th>
																	<th class="text-center">Allow Create</th>
																	<th class="text-center">Allow Update</th>
																	<th class="text-center">Allow Delete</th>
																</tr>
															</thead>
															<tbody>
																
																@for ($i = 0; $i < count($typePermissions); $i++)
																	<tr>
																		<th scope="row">{{ $typePermissions[$i]['type'] }}</th>
																		<td class="text-center">
																			<input type="checkbox" name="permission[]" value="{{ $lists[$i]['id'] }}">
																			<!--<label for="">{{ $lists[$i]['name'] }}</label>-->
																		</td>
																		<td class="text-center">
																			<input type="checkbox" name="permission[]" value="{{ $creates[$i]['id'] }}">
																			<!--<label for="">{{ $creates[$i]['name'] }}</label>-->
																		</td>
																		<td class="text-center">
																			<input type="checkbox" name="permission[]" value="{{ $updates[$i]['id'] }}">
																			<!--<label for="">{{ $updates[$i]['name'] }}</label>-->
																		</td>
																		<td class="text-center">
																			<input type="checkbox" name="permission[]" value="{{ $deletes[$i]['id'] }}">
																			<!--<label for="">{{ $deletes[$i]['name'] }}</label>-->
																		</td>
																	</tr>
																@endfor
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
								
										<div class="form-group">
											<div class="row">
												<label class="col-lg-2">Status<small style="color: red;">*</small></label>
												<div class="col-lg-10">
													<!--<input type="text" name="enabled" id="enabled" class="form-control" placeholder="Enabled" required>-->
													<input type="checkbox" id="enabled" name="enabled" class="switchery" data-color="info" checked/>
													@if ($errors->has('enabled'))
														<small style="color: red;">{{ $errors->first('enabled') }}</small>
													@endif
												</div>
											</div>
										</div>
								
										<div class="form-actions">
											<a href="{{ route('roles.index') }}" type="button" class="btn btn-warning round mr-1">
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