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
        <h3 class="content-header-title">Kelola Data Transaksi</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Approval</li>
                    <li class="breadcrumb-item active"  > <a href="">Data Transaksi</a> </li>
                    
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
            <div class="row mt-0">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Filter</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse" style="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="box">
                                            <form action="" method="">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label>No Transaksi</label>
                                                                <div class="input-group">
                                                                    <input name="transaction_number" class="form-control round" placeholder="No Transaksi" value="">
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <label>Nominal</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="amount" class="form-control round" placeholder="Nominal" value="">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-6">
                                                                <label>Nama</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="name" class="form-control round" placeholder="Nama" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Nomor HP</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="phone" class="form-control round" placeholder="Nomor HP" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Email</label>
                                                                <div class="input-group">
                                                                    <input type="text" name="email" class="form-control round" placeholder="Email" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Status Transaksi</label>
                                                                <div class="input-group">
                                                                    <select name="transaction_status_id" id="" class="form-control round">
                                                                        <option value="">Pilih Status Transaksi</option>
                                                                        <option value="VERIFIED">VERIFIED</option>
                                                                        <option value="PROCESS">PROCESS</option>
                                                                        <option value="UNVERIFIED">UNVERIFIED</option>
                                                                        <option value="CANCEL">CANCEL</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Delete Transaksi</label>
                                                                <div class="input-group">
                                                                    <select name="is_delete" id="" class="form-control round">
                                                                        <option value="">Pilih Transaksi</option>
                                                                        <option value="1">TRUE</option>
                                                                        <option value="0">FALSE</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Tanggal Pembayaran</label>
                                                                <div class="input-group">
                                                                    <input type="date" name="payment_date" class="form-control round" placeholder="Tanggal Pembayaran" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Dari Tanggal</label>
                                                                <div class="input-group">
                                                                    <input type="date" name="start_date" class="form-control round" placeholder="Dari Tanggal" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Hingga Tanggal</label>
                                                                <div class="input-group">
                                                                    <input type="date" name="end_date" class="form-control round" placeholder="Hingga Tanggal" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-footer" align="right">
                                                        <button type="submit" class="btn btn-rounded btn-info btn-outline round">
                                                            <i class="fa fa-search"></i> Cari
                                                        </button>
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

            <div class="card mt-2">
                <div class="card-header">
                    <h4 class="card-title">Kelola Transaksi</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor Telp</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Nominal</th>
                                        <th scope="col">Status</th>
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
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->phone_number }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>Rp{{ number_format($row->amount+$row->unique_code,0,'.','.') }},-</td>
                                            <td>
                                                @if ($row->transaction_status_id == "VERIFIED")
                                                    <span class="badge badge-success">Verified</span>
                                                @elseif ($row->transaction_status_id == "PROCESS")
                                                    <span class="badge badge-primary">Proses</span>
                                                @elseif ($row->transaction_status_id == "UNVERIFIED")
                                                    <span class="badge badge-warning">Unverified</span>
                                                @else
                                                    <span class="badge badge-danger">Cancel</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($hasPermissions) == 0)
                                                    <a href="{{ route('transaction-approval.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail Program">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @else
                                                    @foreach ($hasPermissions as $permission)
                                                        @if(strstr($permission->name, 'edit'))
                                                            @can($permission->name)
                                                                <a href="{{ route('transaction-approval.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                @if ($row->transaction_status_id != 'VERIFIED')
                                                                    <a href="#modal5" data-toggle="modal" class="btn btn-success btn-sm round btn-active" data-id="{{$row->encodeHash($row->id)}}" data-approve="VERIFIED" title="Approve">
                                                                        <i class="fa fa-check"></i>
                                                                    </a>
                                                                @endif
                                                                    @if ($row->transaction_status_id != 'CANCEL')
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
          <form action="{{ route('transaction-approval.approvalTransaction') }}" method="post">
              {{csrf_field()}}
              <input type="hidden" name="id" id="id" class="xs-input-control id">
              <input type="hidden" name="transaction_status_id" id="transaction_status_id" class="xs-input-control">
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
            modal5.find('[id=id]').val(id);
            modal5.find('[id=transaction_status_id]').val(approve);
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
