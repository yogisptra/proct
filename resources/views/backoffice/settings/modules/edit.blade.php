@extends('backoffice.layouts.master')
@section('content')
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Edit New Module</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-primary" href="{{ route('modules.index') }}"> Back</a>
			</div>
		</div>
	</div>

	@if (count($errors) > 0)
	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	<form action="{{ route('modules.update',$module->id) }}" method="POST">
		@csrf
		@method('PUT')

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Name:</strong>
				<input type="text" placeholder="Name" name="name" value="{{ old('name') ? old('name') : $module->name }}" class="form-control">
                @if ($errors->has('name'))
                    <small style="color: red;">{{ $errors->first('name') }}</small>
                @endif
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Description:</strong>
				<input type="text" placeholder="Description" name="description" value="{{ old('description') ? old('description') : $module->description }}" class="form-control">
                @if ($errors->has('description'))
                    <small style="color: red;">{{ $errors->first('description') }}</small>
                @endif
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Sequence:</strong>
				<input type="number" min="0" max="{{$modules + 1}}" placeholder="Sequence" name="sequence" value="{{ old('sequence') ? old('sequence') : $module->sequence }}" class="form-control">
                @if ($errors->has('sequence'))
                    <small style="color: red;">{{ $errors->first('sequence') }}</small>
                @endif
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Icon:</strong>
				<input type="text" placeholder="Icon" name="icon" value="{{ old('icon') ? old('icon') : $module->icon }}" class="form-control">
                @if ($errors->has('icon'))
                    <small style="color: red;">{{ $errors->first('icon') }}</small>
                @endif
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Enabled:</strong>
				<input type="number" min="0" max="1" placeholder="Enabled" name="enabled" value="{{ old('enabled') ? old('enabled') : $module->enabled }}" class="form-control">
                @if ($errors->has('enabled'))
                    <small style="color: red;">{{ $errors->first('enabled') }}</small>
                @endif
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
	<p class="text-center text-primary"><small>Tutorial by Tutsmake.com</small></p>
@endsection