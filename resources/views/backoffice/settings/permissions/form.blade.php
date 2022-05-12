
	<form action="{{ @$data->id ? route('permissions.update', @$data->id) : route('permissions.store') }}" method="POST" class="form form-horizontal">
		@csrf
		<input type="hidden" name="_method" value="{{ @$data->id ? 'PUT' : 'POST'}}">
		<div class="form-body">
			<div class="form-group row">
				<label class="col-md-2" for="name">Name</label>
				<div class="col-md-10" id="error">
					<input type="text" id="name" class="form-control" value="{{ @$data->id ? $data->name: old('name') }}" placeholder="Name" name="name">
					@if ($errors->has('name'))
						<small style="color: red;">{{ $errors->first('name') }}</small>
					@endif
				</div>
			</div>
		</div>
	</form>