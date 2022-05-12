<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

	<!--<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>-->
</head>

<body>
@if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
        </div>
        @endif

 		<form method="POST" action="{{route('admin.store')}}" enctype="multipart/form-data" >
  
            {{ csrf_field() }}
  
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name">
				</br>
                @if ($errors->has('name'))
                    <small style="color: red;">{{ $errors->first('name') }}</small>
                @endif
            </div>
    
            <div class="form-group">
                <strong>Email:</strong>
                <input type="text" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
				</br>
                @if ($errors->has('email'))
                    <small style="color: red;">{{ $errors->first('email') }}</small>
                @endif
            </div>
   
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="Password">
				</br>
                @if ($errors->has('password'))
                    <small style="color: red;">{{ $errors->first('password') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" placeholder="Phone">
				</br>
                @if ($errors->has('phone_number'))
                    <small style="color: red;">{{ $errors->first('phone_number') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" value="{{ old('image') }}" placeholder="Gambar">
				</br>
                @if ($errors->has('image'))
                    <small style="color: red;">{{ $errors->first('image') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <input type="text" name="gender" class="form-control" value="{{ old('gender') }}" placeholder="Gender">
				</br>
                @if ($errors->has('gender'))
                    <small style="color: red;">{{ $errors->first('gender') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label>Address:</label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Address">
				</br>
                @if ($errors->has('address'))
                    <small style="color: red;">{{ $errors->first('address') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label>Status:</label>
                <input type="text" name="enabled" class="form-control" value="{{ old('enabled') }}" placeholder="Status">
				</br>
                @if ($errors->has('enabled'))
                    <small style="color: red;">{{ $errors->first('enabled') }}</small>
                @endif
            </div>

			<!--<textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor"></textarea>-->
   
            <div class="form-group">
                <button class="btn btn-success btn-submit">Submit</button>
            </div>
        </form>
</body>
<!--<script>
	CKEDITOR.replace( 'summary-ckeditor', {
		filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
		filebrowserUploadMethod: 'form'
	});
</script>-->
</html>