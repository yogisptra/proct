

<form action="{{ @$data->id ? route('modules.update', @$data->id) : route('modules.store') }}" method="POST" class="form form-horizontal">
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

		<div class="form-group row">
			<label class="col-md-2" for="description">Description</label>
			<div class="col-md-10" id="error">
				<input type="text" id="description" class="form-control" value="{{ @$data->id ? $data->description: old('description') }}" placeholder="Description" name="description">
				@if ($errors->has('description'))
					<small style="color: red;">{{ $errors->first('description') }}</small>
				@endif
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-2" for="sequence">Sequence</label>
			<div class="col-md-10" id="error">
				<input type="number" min="0" max="{{ @$modules+1 }}" id="sequence" class="form-control" value="{{ @$data->id ? $data->sequence: old('sequence') }}" placeholder="Sequence" name="sequence">
				@if ($errors->has('sequence'))
					<small style="color: red;">{{ $errors->first('sequence') }}</small>
				@endif
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-2" for="icon">Icon</label>
			<div class="col-md-10" id="error">
				<input type="text" id="icon" class="form-control" value="{{ @$data->id ? $data->icon: old('icon') }}" placeholder="Icon" name="icon">
				@if ($errors->has('icon'))
					<small style="color: red;">{{ $errors->first('icon') }}</small>
				@endif
			</div>
		</div>

		<div class="form-group row">
			<label class="col-md-2" for="enabled">Enabled</label>
			<div class="col-md-10" id="error">
				<input type="text" id="enabled" class="form-control" value="{{ @$data->id ? $data->enabled: old('enabled') }}" placeholder="Enabled" name="enabled">
				@if ($errors->has('enabled'))
					<small style="color: red;">{{ $errors->first('enabled') }}</small>
				@endif
			</div>
		</div>
	</div>
</form>