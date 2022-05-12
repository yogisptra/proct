@extends('backoffice.layouts.master')

@section('content')
<!-- Captions start -->
<div class="row">
    <div class="col-12">
		@if(count($hasPermissions) == 0)
			<a href="{{ route('modules.create') }}" class="btn btn-info modal-show" title="Create Menu">
				<i class="fa fa-plus"></i> Tambah
			</a>
		@else
			@foreach ($hasPermissions as $permission)
				@if(strstr($permission->name, 'create'))
					@can($permission->name)
						<a href="{{ route('modules.create') }}" class="btn btn-info modal-show" title="Create Module">
							<i class="fa fa-plus"></i> Tambah
						</a>
					@endcan
				@endif
			@endforeach
		@endif

        @if ($message = Session::get('success'))
			<div class="alert alert-success mt-2">
				<p>{{ $message }}</p>
			</div>
		@endif
        <div class="card mt-2">
            <div class="card-header">
                <h4 class="card-title">Module Management</h4>
			</div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Name</th>
									<th scope="col">Description</th>
									<th scope="col">Sequence</th>
									<th scope="col">Enabled</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								@php
								$i = 1;
								@endphp
								@foreach ($modules as $key => $row)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $row->name }}</td>
										<td>{{ $row->description }}</td>
										<td>{{ $row->sequence }}</td>
										<td>
											@if ($row->enabled == 1)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Not Active</span>
                                            @endif
										</td>
										<td>
											<form action="{{ route('modules.destroy', $row->id) }}" method="POST">
												<a href="{{ route('modules.show', $row->id) }}" class="btn btn-warning btn-sm btn-show" title="Detail Modules">
													<i class="fa fa-eye"></i>
												</a>
												@if(count($hasPermissions) == 0)
													<a href="{{ route('modules.edit', $row->id) }}" class="btn btn-info btn-sm edit modal-show" title="Edit Modules">
														<i class="fa fa-pencil"></i>
													</a>

													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-danger btn-sm">
														<i class="fa fa-trash"></i>
													</button>
												@else
													@foreach ($hasPermissions as $permission)
														@if(strstr($permission->name, 'edit'))
															@can($permission->name)
															<a href="{{ route('modules.edit', $row->id) }}" class="btn btn-info btn-sm edit modal-show" title="Edit Modules">
																<i class="fa fa-pencil"></i>
															</a>
															@endcan
														@elseif(strstr($permission->name, 'delete'))
															@csrf
															@method('DELETE')
															@can($permission->name)
															<button type="submit" class="btn btn-danger btn-sm">
																<i class="fa fa-trash"></i>
															</button>
															@endcan
														@endif
													@endforeach
												@endif
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
                        </table>
                    </div>
                </div>
            </div>
			{{$modules->links('pagination.page')}}
        </div>
    </div>
</div>
<!-- Captions end -->

@push('modal-scripts')
<script>
	// Show Modal
	$('.modal-show').on('click', function(event){
		event.preventDefault();

		var me = $(this),
			url = me.attr('href'),
			title = me.attr('title');

		$('#modal-title').text(title);
		$('#modal-btn-save').removeClass('hidden')
    	.text(me.hasClass('edit') ? 'Update' : 'Create');

		$.ajax({
			url: url,
			dataType: 'html',
			success: function(response){
				$('#modal-body').html(response);
			}
		});

		$('#modal').modal('show');
	});

	// Show Module
	$('.row').on('click', '.btn-show', function(event){
		event.preventDefault();

		var me = $(this),
			url = me.attr('href'),
			title = me.attr('title');

		$('#modal-title').text(title);
		$('#modal-btn-save').addClass('hidden');

		$.ajax({
			url: url,
			dataType: 'html',
			success: function(response){
				$('#modal-body').html(response);
			}
		});

		$('#modal').modal('show');
	});

	// Prosess Create
	$('#modal-btn-save').on('click', function(event){
		event.preventDefault();

		var form = $('#modal-body form'),
			url = form.attr('action');
			// url_index = "{{ route('permissions.index') }}";
		// Hapus Validasi
		form.find('.help-block').remove();
		form.find('.form-group row').removeClass('has-error');

		$.ajax({
			url: url,
			method: 'POST',
			data: form.serialize(),
			success: function(response){
				// console.log(response);
				if(response.success == 'berhasil'){
					form.trigger('reset');
					$('#modal').modal('hide');
					swal({title: "Good job", text: "You clicked the button!", type: "success"},
						function(){
							location.reload();
						}
					);
				}
				if(response.success == 'update'){
					form.trigger('reset');
					$('#modal').modal('hide');
					swal({title: "Good job", text: "You clicked the button!", type: "success"},
						function(){
							location.reload();
						}
					);
				}

			},
			error: function(xhr){
				var res = xhr.responseJSON;
				if  ($.isEmptyObject(res) == false){
					$.each(res.errors, function (key, value){
						$('#' + key)
							.closest('#error')
							.addClass('has-error')
							.append('<small style="color: red;" class="help-block">'+ value + '</small>')
					})
				}
			}
		});
	});
</script>
@endpush

@endsection
