@extends('backoffice.layouts.master')

@section('content')
<style>

    @media (min-width: 800px) {
    /* Styles */
        .inputsearch{
            width: 400px;
        }
    }
</style>
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Kelola Data Menu</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Setting</li>
                    <li class="breadcrumb-item">Manage Menu</li>
                    <li class="breadcrumb-item active"  > <a href="">Detail</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
            <a href="{{ route('menus.index') }}" type="button" class="btn btn-danger mr-1 round">
                Kembali
            </a>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Parent Menu</label>
                                                    <div class="col-lg-10">
                                                        <span>{{ $menu->hasParent($menu->parent_id) }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Nama Menu</label>
                                                    <div class="col-lg-10">
                                                        <span>{{ $menu->name }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Keterangan</label>
                                                    <div class="col-lg-10">
                                                        <span>{{ $menu->description ? ($menu->description) : '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Route</label>
                                                    <div class="col-lg-10">
                                                        <span>{{ $menu->route ? ($menu->route) : '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Urutan</label>
                                                    <div class="col-lg-10">
                                                        <span>{{ $menu->sequence ? ($menu->sequence) : '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Ikon</label>
                                                    <div class="col-lg-10">
                                                        <span>{{ $menu->icon ? ($menu->icon) : '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Shown</label>
                                                    <div class="col-lg-10">
                                                        <span>{{ $menu->shown ? ($menu->shown) : '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-lg-2">Status</label>
                                                    <div class="col-lg-10">
                                                        @if ($menu->enabled == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Not Active</span>
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