<div class="form-body">   
    <div class="form-group row">
        <label class="col-md-2 label-control" for="name">Name</label>
        <div class="col-md-9">
            <input type="text" name="name" disabled id="name" value="{{ $user->name }}" class="form-control">
            @if ($errors->has('name'))
                <small style="color: red;">{{ $errors->first('name') }}</small>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-2 label-control" for="email">E-mail</label>
        <div class="col-md-9">
            <input type="email" name="email" disabled id="email" value="{{ $user->email }}" class="form-control">
            @if ($errors->has('email'))
                <small style="color: red;">{{ $errors->first('email') }}</small>
            @endif
        </div>
    </div>


    <div class="form-group row">
        <label class="col-md-2 label-control" for="projectinput6">Role</label>
        <div class="col-md-9">
			@if(!empty($user->getRoleNames()))
			@foreach($user->getRoleNames() as $row)
				<input type="roles" name="roles" disabled id="roles" value="{{ $row }}" class="form-control">
			@endforeach
			@endif
            @if ($errors->has('roles'))
                <small style="color: red;">{{ $errors->first('roles') }}</small>
            @endif
        </div>
    </div>
</div>