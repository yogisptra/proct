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
<!-- Captions start -->
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title">Kelola Data User</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Setting</li>
                    <li class="breadcrumb-item active"  > <a href="">Manage User</a> </li>
                
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
        <form action="{{ route('users.index') }}" class="mr-1">
            <input class="form-control round inputsearch" placeholder="Cari disini" name="search">
        </form>
            @if(count($hasPermissions) == 0)
                <a href="{{ route('users.create') }}" type="submit" class="btn btn-danger round btn-min-width mr-1 mb-1">
                    <i class="fa fa-plus"></i> Tambah
                </a>
            @else
                @foreach ($hasPermissions as $permission)
                    @if(strstr($permission->name, 'create'))
                        @can($permission->name)
                            <a href="{{ route('users.create') }}" type="submit" class="btn btn-danger round btn-min-width mr-1 mb-1">
                                <i class="fa fa-plus"></i> Tambah
                            </a>
                        @endcan
                    @endif
                @endforeach
            @endif
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

            <div class="card mt-0">
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Roles</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 0;
                                    @endphp
                                    @forelse ($data as $key => $user)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->enabled == 1)
                                            <span class="badge badge-success">Aktif</span>
                                            @else
                                            <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- 
                                            <a href="#" data-id="{{ $user->encodeHash($user->id) }}"
                                                class="btn btn-warning btn-sm btn-show round" title="detail">
                                                <i class="fa fa-eye"></i>
                                            </a> --}}

                                            @if(count($hasPermissions) == 0)
                                                <a href="{{ route('users.edit', $user->encodeHash($user->id)) }}"
                                                    class="btn btn-info btn-sm btn-edit round" title="edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                @if($user->id != '2020151101001')
                                                    @if($user->enabled == 1)
                                                        <a href="{{ route('users.active_nonactive', [$user->encodeHash($user->id), $user->encodeHash(0)]) }}"
                                                            class="btn btn-danger btn-sm round" title="Delete User">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('users.active_nonactive', [$user->encodeHash($user->id), $user->encodeHash(1)]) }}"
                                                            class="btn btn-secondary btn-sm round" title="Restore User">
                                                            <i class="fa fa-undo"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            @else
                                                @foreach ($hasPermissions as $permission)
                                                    @if(strstr($permission->name, 'edit'))
                                                        @can($permission->name)
                                                        <a href="{{ route('users.edit', $user->encodeHash($user->id)) }}"
                                                            class="btn btn-info btn-sm btn-edit round" title="edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        @endcan
                                                    @elseif(strstr($permission->name, 'delete'))

                                                        @can($permission->name)
                                                            @if($user->id != '2020151101001')
                                                                @if($user->enabled == 1)
                                                                    <a href="{{ route('users.active_nonactive', [$user->encodeHash($user->id), $user->encodeHash(0)]) }}"
                                                                        class="btn btn-danger btn-sm round" title="Delete User">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ route('users.active_nonactive', [$user->encodeHash($user->id), $user->encodeHash(1)]) }}"
                                                                        class="btn btn-secondary btn-sm round" title="Restore User">
                                                                        <i class="fa fa-undo"></i>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        @endcan
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="item-align-center">
                                        <td colspan="7" class="text-center">Data tidak ada</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$data->links('pagination.page')}}
            </div>
        </div>
    </div>
</div>
<!-- Captions end -->
@endsection
