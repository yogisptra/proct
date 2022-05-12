

@extends('backoffice.layouts.master')

@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
            <div class="content-body">
            <!-- Content -->
                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <a href="{{ route('roles.index') }}" type="button" class="btn btn-danger round mb-2">
                            <i class="fa fa-undo"></i> Kembali
                        </a>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="horz-layout-card-center">Detail Role</h4>
                            </div>
                            <div class="card-content collpase show">
                                <div class="card-body">
                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Nama</label>
                                                    <div class="col-lg-10">
                                                        <input type="text" readonly class="form-control" value="{{ $role->name }}">
                                                    </div>
                                                </div>
                                            </div>
                                        
                
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Permission</label>
                                                    <div class="col-lg-10">
                                                        @if(!empty($rolePermissions))
                                                            @foreach($rolePermissions as $v)
                                                            <label class="label label-success">{{ $v->name }},</label>
                                                            @endforeach
                                                        @endif
                                                        
                                                    </div>
                                                </div>
                                            </div>
                
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection