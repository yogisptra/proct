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
        <h3 class="content-header-title">Tipe Pesan</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Tipe Pesan</li>
                    <li class="breadcrumb-item active"  > <a href="">Setting</a> </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
            <a href="{{ route('template_messages.create') }}" type="button" class="btn btn-danger mr-1 round">
                <i class="fa fa-plus"></i> Tambah
            </a>
        </div>
    </div>
</div>
<div class="content-body">
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
            <div class="card">
                <div class="card-content collapse show" style="">
                    <div class="card-header">
                        {{-- <h4 class="card-title" id="horz-layout-card-center">Riwayat Caller</h4> --}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Pesan</th>
                                            <th>Tipe</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @forelse ($data as $row)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{!! Str::limit($row->message, 10) !!}</td>
                                                <td>{{ $row->type == 'email' ? 'Email' : 'Whatsapp' }}</td>
                                                <td>{{ $row->created_by }}</td>
                                                <td>
                                                    @if(count($hasPermissions) == 0)
                                                    
                                                    <a href="{{ route('template_messages.show', $row->id) }}" class="btn btn-warning btn-sm edit modal-show round" title="Edit Data Tipe Pesan">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('template_messages.edit', $row->id) }}" class="btn btn-info btn-sm edit modal-show round" title="Edit Data Tipe Pesan">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    
													@else
														@foreach ($hasPermissions as $permission)
															@if(strstr($permission->name, 'edit'))
																@can($permission->name)
                                                                    <a href="{{ route('template_messages.edit', $row->id) }}" class="btn btn-info btn-sm edit modal-show round" title="Edit Data Tipe Pesan">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
            													@endcan
															@elseif(strstr($permission->name, 'delete'))
                                                                @csrf
                                                                @method('DELETE')
                                                                @if($row->enabled == 1)
                                                                    <a href="{{ route('template_messages.active_nonactive', [$row->id, 0]) }}" class="btn btn-danger btn-sm round" title="Delete Data Tipe Pesan">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('template_messages.active_nonactive', [$row->id, 1]) }}" class="btn btn-secondary btn-sm round" title="Restore Data Tipe Pesan">
                                                                        <i class="fa fa-undo"></i>
                                                                    </a>
                                                                @endif
															@endif
														@endforeach
													@endif
                                                </td>
                                            </tr>
                                            @php
                                            $i++;
                                            @endphp
                                         @empty
                                         <tr class="item-align-center">
                                             <td colspan="6" class="text-center">Data tidak ada</td>
                                         </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{$data->links('pagination.page')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection