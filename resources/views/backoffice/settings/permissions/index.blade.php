@extends('backoffice.layouts.master')

@section('content')
<!-- Captions start -->
<div class="row">
    <div class="col-12">
		@if(count($hasPermissions) == 0)
			<a href="{{ route('permissions.create') }}" class="btn btn-danger modal-show" title="Create Permissions">
				<i class="fa fa-plus"></i> Tambah
			</a>
		@else
			@foreach ($hasPermissions as $permission)
				@if(strstr($permission->name, 'create'))
					@can($permission->name)
					<a href="{{ route('permissions.create') }}" class="btn btn-danger modal-show" title="Create Permissions">
						<i class="fa fa-plus"></i> Tambah
					</a>
					@endcan
				@endif
			@endforeach
		@endif

        <div class="card mt-2">
            <div class="card-header">
                <h4 class="card-title">Permissions Management</h4>
			</div>
            <div class="card-content collapse show">
                <div class="card-body">                    
                    <div class="table-responsive">
                        <table class="table">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">Name</th>
									<th scope="col">Guard</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								@php
								$i = 0;
								@endphp
								@foreach ($permissions as $key => $row)
									<tr>
										<td>{{ ++$i }}</td>
										<td>{{ $row->name }}</td>
										<td>{{ $row->guard_name }}</td>
										<td>
											<form action="{{ route('permissions.destroy', $row->id) }}" method="POST">
												{{-- <a href="#" class="btn btn-warning btn-sm btn-show" title="Hapus">
													<i class="fa fa-eye"></i>
												</a> --}}

												@if(count($hasPermissions) == 0)
													<a href="{{ route('permissions.edit', $row->id) }}" class="btn btn-info btn-sm edit modal-show" title="Edit Permissions">
														<i class="fa fa-pencil"></i>
													</a>

													@csrf
													@method('DELETE')
														<button type="submit" class="btn btn-danger btn-sm btn-delete" title="Permission">
															<i class="fa fa-trash"></i>
														</button>
												@else
													@foreach ($hasPermissions as $permission)
														@if(strstr($permission->name, 'edit'))
															@can($permission->name)
																<a href="{{ route('permissions.edit', $row->id) }}" class="btn btn-info btn-sm edit modal-show" title="Edit Permissions">
																	<i class="fa fa-pencil"></i>
																</a>
															@endcan
														@elseif(strstr($permission->name, 'delete'))
															@csrf
															@method('DELETE')
															@can($permission->name)
																<button type="submit" class="btn btn-danger btn-sm btn-delete" title="Permission">
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
			{{$permissions->links('pagination.page')}}
        </div>
    </div>
</div>
<!-- Captions end -->

@push('modal-scripts')
<script>
	// Show 
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
					swal({
						title: "Good job", 
						text: "You clicked the button!", 
						type: "success"
					},
						function(){ 
							location.reload();
						}
					);
				} 
				if(response.success == 'update'){
					form.trigger('reset');
					$('#modal').modal('hide');
					swal({
						title: "Good job", 
						text: "You clicked the button!", 
						type: "success"
					},
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

	// // Delete
// 	$('.btn-delete').on('click', function (event) {
//     event.preventDefault();

//     var me = $(this),
//         url = me.attr('href'),
//         title = me.attr('title'),
//         csrf_token = $('meta[name="csrf-token"]').attr('content');

//     swal({
//         title: 'Are you sure want to delete ' + title + ' ?',
//         text: 'You won\'t be able to revert this!',
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!',
//     }).then((willDelete) => {
//         if (willDelete) {
//             $.ajax({
//                 url: url,
//                 type: "POST",
//                 data: {
//                     '_method': 'DELETE',
//                     '_token': csrf_token
//                 },
//                 success: function (response) {
//                     swal({
// 						title: "Success", 
// 						text: "Data berhasil dihapus!", 
// 						type: "success"
// 					},
// 						function(){ 
// 							location.reload();
// 						}
// 					);
//                 },
//                 error: function (xhr) {
//                     swal({
//                         type: 'error',
//                         title: 'Oops...',
//                         text: 'Something went wrong!'
//                     });
//                 }
//             });
//         }
//     });
// });
</script>
@endpush

@endsection