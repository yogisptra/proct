<table class="table table-hover">
	<tr>
		<th>Name</th>
		<th>Description</th>
		<th>Enabled</th>
	</tr>

	<tr>
		<td>
			{{ $data->name }}
		</td>
		<td>
			{{ $data->description }}
		</td>
		<td>
			{{ $data->enabled }}
		</td>
	</tr>
</table>

{{-- @extends('backoffice.layouts.master')

@section('content')
<!-- Captions start -->
<div class="row">
    <div class="col-6" style="margin: 0 auto;">
        <a href="{{ route('modules.index') }}" type="submit" class="btn btn-info">
            <i class="fa fa-undo"></i> Back
		</a>
		
        <div class="card mt-2">
            <div class="card-header">
                <h4 class="card-title">Module Show</h4>
			</div>
            <div class="card-content collapse show">
                <div class="card-body">                    
					<div class="form-group">
						<strong>Name :</strong>
						{{ $data->name }}
					</div>
				</div>
				
            </div>
        </div>
    </div>
</div>
<!-- Captions end -->

@endsection --}}