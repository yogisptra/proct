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
        <h3 class="content-header-title">Kelola Data Pencairan</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Approval</li>
                    <li class="breadcrumb-item active"  > <a href="">Data Pencairan</a> </li>
                    
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
            <div class="card mt-2">
                <div class="card-header">
                    <h4 class="card-title">Kelola Data Pencairan</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Pengajuan</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 1;
                                    @endphp
                                    @forelse ($data as $key => $row)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $row->hasUser->name }}</td>
                                            <td>Rp{{ number_format($row->amount,0,'.','.') }},-</td>
                                            <td>
                                                @if ($row->status == "VERIFIED")
                                                    <span class="badge badge-success">Verified</span>
                                                @elseif ($row->status == "PROCESS")
                                                    <span class="badge badge-primary">Process</span>
                                                @elseif ($row->status == "UNVERIFIED")
                                                    <span class="badge badge-warning">Unverified</span>
                                                @else
                                                    <span class="badge badge-danger">Cancel</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($hasPermissions) == 0)
                                                    <a href="{{ route('widhdrawal-approval.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail Program">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @else
                                                    @foreach ($hasPermissions as $permission)
                                                        @if(strstr($permission->name, 'edit'))
                                                            @can($permission->name)
                                                                <a href="{{ route('widhdrawal-approval.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                @if ($row->status != 'VERIFIED')
                                                                    <a href="#modal5" data-toggle="modal" class="btn btn-success btn-sm round btn-active" data-id="{{$row->encodeHash($row->id)}}" data-approve="VERIFIED" title="Approve">
                                                                        <i class="fa fa-check"></i>
                                                                    </a>
                                                                @endif
                                                                    @if ($row->status != 'CANCEL')
                                                                    <a href="#modal5" data-toggle="modal" class="btn btn-danger btn-sm round btn-active" data-id="{{$row->encodeHash($row->id)}}"  data-approve="CANCEL" title="Cancel">
                                                                        <i class="fa fa-close"></i>
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

{{-- Modal --}}
<div class="modal fade" id="modal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel5">Konfirmasi</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="mg-b-0 modal5-message-body"></p>
        </div>
        <div class="modal-footer">
          <form action="{{ route('widhdrawal-approval.approvalWidhdrawal') }}" method="post">
              {{csrf_field()}}
              <input type="hidden" name="id" id="widhdrawal_id" class="xs-input-control widhdrawal_id">
              <input type="hidden" name="status" id="status" class="xs-input-control">
              <input type="hidden" name="page" value="list">
              <button type="button" class="btn btn-warning round tx-13" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger round tx-13">Kirim</button>
          </form>
        </div>
      </div>
    </div>
  </div>  

@endsection

@section('script')
<script>
    
    $('.btn-active').click(function(){
		var id = $(this).data('id');
        var approve = $(this).data('approve');
        if (approve == "VERIFIED" || approve == "CANCEL"){
            var modal5 = $('#modal5');
            modal5.find('[id=widhdrawal_id]').val(id);
            modal5.find('[id=status]').val(approve);
            if (approve == "VERIFIED"){
                modal5.find('.modal5-message-body').text("Apakah anda yakin akan menyetujui ?")
            } 
            else if (approve == "CANCEL") {
                modal5.find('.modal5-message-body').text("Apakah anda yakin akan menolak ?")
            }
        }
	});
</script>
@endsection
