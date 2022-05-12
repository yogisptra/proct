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
        <h3 class="content-header-title">Kelola Data Akun Bank</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Masterdata</li>
                    <li class="breadcrumb-item active"  > <a href="">Data Akun Bank</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
        <form action="{{ route('bank_accounts.index') }}" class="mr-1">
            <input class="form-control round inputsearch"  placeholder="Cari disini" name="search">
        </form>
            @if(count($hasPermissions) == 0)
                <a href="{{ route('bank_accounts.create') }}" type="submit" class="btn btn-danger round btn-min-width mr-1 mb-1 modal-show">
                    <i class="fa fa-plus"></i> Tambah
                </a>
            @else
                @foreach ($hasPermissions as $permission)
                    @if(strstr($permission->name, 'create'))
                        @can($permission->name)
                            <a href="{{ route('bank_accounts.create') }}" type="submit" class="btn btn-danger round btn-min-width mr-1 mb-1 modal-show">
                                <i class="fa fa-plus"></i> Tambah
                            </a>
                        @endcan
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
<div class="content-body">
<!-- Content -->
	<div class="row">
		<div class="col-12">
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
			<div class="card mt-0">
				<div class="card-content collapse show">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">No</th>
										<th scope="col">Bank</th>
										<th scope="col">Nama</th>
                                        <th scope="col">Nomor Akun</th>
										<th scope="col">Status</th>
										<th scope="col">Aksi</th>
									</tr>
								</thead>
								<tbody>
									@php
									$i = 0;
									@endphp
									@forelse ($data as $key => $row)
										<tr>
											<td>{{ ++$i }}</td>
                                            <td>{{ $row->hasBank->name ?? '-' }}</td>
                                            <td>{{ $row->account_name }}</td>
											<td>{{ $row->account_number ?? '-' }}</td>
											<td>
												@if ($row->enabled == 1)
												<span class="badge badge-success">Aktif</span>
												@else
												<span class="badge badge-danger">Tidak Aktif</span>
												@endif
											</td>
											<td>
												@if(count($hasPermissions) == 0)
													<a href="{{ route('bank_accounts.edit', $row->encodeHash($row->id)) }}" class="btn btn-info btn-sm round" title="Edit Data">
														<i class="fa fa-pencil"></i>
													</a>
	
													@if($row->enabled == 1)
														<a href="{{ route('bank_accounts.active_nonactive', [$row->encodeHash($row->id), 0]) }}" class="btn btn-danger btn-sm round" title="Delete Data">
															<i class="fa fa-trash"></i>
														</a>
													@else
														<a href="{{ route('bank_accounts.active_nonactive', [$row->encodeHash($row->id), 1]) }}" class="btn btn-secondary btn-sm round" title="Restore Data">
															<i class="fa fa-undo"></i>
														</a>
													@endif
												@else
													@foreach ($hasPermissions as $permission)
														@if(strstr($permission->name, 'edit'))
															@can($permission->name)
																<a href="{{ route('bank_accounts.edit', $row->encodeHash($row->id)) }}" class="btn btn-info btn-sm round" title="Edit Data">
																	<i class="fa fa-pencil"></i>
																</a>
															@endcan
														@elseif(strstr($permission->name, 'delete'))
															@can($permission->name)
																@if($row->enabled == 1)
																	<a href="{{ route('bank_accounts.active_nonactive', [$row->encodeHash($row->id), 0]) }}" class="btn btn-danger btn-sm round" title="Delete Data">
																		<i class="fa fa-trash"></i>
																	</a>
																@else
																	<a href="{{ route('bank_accounts.active_nonactive', [$row->encodeHash($row->id), 1]) }}" class="btn btn-secondary btn-sm round" title="Restore Data {{ $row->name }}">
																		<i class="fa fa-undo"></i>
																	</a>
																@endif
															@endcan
														@endif
													@endforeach
												@endif
											</td>
										</tr>
									@empty
										<tr class="item-align-center">
											<td colspan="8" class="text-center">Data tidak ada</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
				{{$data->links('pagination.page')}}
			</div>
		</div>
	</div>
</div>

@endsection
