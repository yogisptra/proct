@extends('backoffice.layouts.master')
@section('content')
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Edit Permission</h2>
			</div>
			<div class="pull-right">
				<a class="btn btn-primary" href="{{ route('permissions.index') }}"> Back</a>
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

	{!! Form::model($permission, ['method' => 'PATCH','route' => ['permissions.update', $permission->id]]) !!}
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="form-group">
				<strong>Name:</strong>
				<input type="text" placeholder="Name" name="name" value="{{ old('name') ? old('name') : $permission->name }}" class="form-control">
                @if ($errors->has('name'))
                    <small style="color: red;">{{ $errors->first('name') }}</small>
                @endif
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</div>
	{!! Form::close() !!}
	<p class="text-center text-primary"><small>Tutorial by Tutsmake.com</small></p>
@endsection