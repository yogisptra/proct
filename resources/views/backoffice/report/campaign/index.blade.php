@extends('backoffice.layouts.master')

@section('content')
<!-- Captions start -->
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
        <h3 class="content-header-title">Laporan Data Campaign</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active"  > <a href="">Data Campaign</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Content -->
    <div class="row">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert bg-success alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="fa fa-thumbs-o-up"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Sukses!</strong> {{ $message }}.
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="fa fa-exclamation-triangle"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Gagal!</strong> {{ $message }}.
                </div>
            @endif

            @if ($message = Session::get('info'))
                <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="fa fa-exclamation"></i></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Informasi!</strong> {{ $message }}.
                </div>
            @endif

            <div class="row">
                <div class="col-xl-4 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="danger">{{ count($data) ?? 0 }}</h3>
                                        <span>Total Campaign</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fa fa-inbox danger font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="success">Rp{{ number_format($data->sum('collected'),0,'.','.') }},-</h3>
                                        <span>Total Donasi</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-basket-loaded success font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h3 class="success">{{ number_format($data->sum('total_donatur')) ?? 0 }}</h3>
                                        <span>Total Donatur</span>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="icon-user info font-large-2 float-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header">
                    <h4 class="card-title">Laporan Campaign</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Open Goal</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($data as $key => $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->title }}</td>
                                            <td>{{ $row->hasCategory->name }}</td>
                                            <td>
                                                @if($row->open_goal == 1)
                                                    <span class="badge badge-success">Open Goal</span>
                                                @else
                                                    @if($row->selisih_validate < 0)
                                                        <span class="badge badge-danger">Campaign Berakhir</span>
                                                    @else
                                                        {{ $row->selisih_validate. ' Hari' ?? '-' }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($row->open_goal == 1)
                                                    <img src="{{ asset('backoffice/app-assets/images/logo/logo-dark-sm.png') }}" width="30px">
                                                @else
                                                    @if($row->target != null)
                                                        Rp{{ number_format($row->target,0,'.','.') }},-
                                                    @else
                                                    <div class="col-lg-10">
                                                        -
                                                    </div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($hasPermissions) == 0)
                                                    <a href="{{ route('laporan-campaign.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail Program">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    @if($row->main_program == 0)
                                                        <a href="{{ route('laporan-campaign.status', [$row->encodeHash($row->id), 1]) }}" class="btn btn-success btn-sm btn-show" title="Main Program">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('laporan-campaign.status', [$row->encodeHash($row->id), 0]) }}" class="btn btn-secondary btn-sm" title="Restore Program">
                                                            <i class="fa fa-minus"></i>
                                                        </a>
                                                    @endif
                                                @else
                                                    @foreach ($hasPermissions as $permission)
                                                        @if(strstr($permission->name, 'edit'))
                                                            @can($permission->name)
                                                                <a href="{{ route('laporan-campaign.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>

                                                                @if($row->main_program == 0)
                                                                    <a href="{{ route('laporan-campaign.status', [$row->encodeHash($row->id), 1]) }}" class="btn btn-primary btn-sm round btn-show" title="Main Program">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('laporan-campaign.status', [$row->encodeHash($row->id), 0]) }}" class="btn btn-secondary btn-sm round" title="Restore Program">
                                                                        <i class="fa fa-minus"></i>
                                                                    </a>
                                                                @endif
                                                            @endcan
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @empty 
                                    <tr class="item-align-center">
                                        <td colspan="8" class="text-center">Data tidak ada</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{ $data->links('pagination.page') }}
            </div>
        </div>
    </div>
</div> 

@endsection
