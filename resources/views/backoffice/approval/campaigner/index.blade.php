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
        <h3 class="content-header-title">Kelola Data Campaigner</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Approval</li>
                    <li class="breadcrumb-item active"  > <a href="">Data Campaigner</a> </li>
                    
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
                                                                <label>Diajukan</label>
                                                                <div class="input-group">
                                                                    <input name="name" class="form-control round" placeholder="Diajukan oleh" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Tanggal Bergabung</label>
                                                                <div class="input-group">
                                                                    <input type="date" name="created_at" class="form-control round" placeholder="Tanggal Bergabung" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Status Campaigner</label>
                                                                <div class="input-group">
                                                                    <select name="is_campaigner" id="" class="form-control round">
                                                                        <option value="">Pilih Status Campaigner</option>
                                                                        <option value="VERIFIED">VERIFIED</option>
                                                                        <option value="UNVERIFIED">UNVERIFIED</option>
                                                                        <option value="CANCEL">CANCEL</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label>Tipe Campaigner</label>
                                                                <div class="input-group">
                                                                    <select name="type_campaigner" id="" class="form-control round">
                                                                        <option value="">Pilih Tipe Campaigner</option>
                                                                        <option value="PERSONAL">PERSONAL</option>
                                                                        <option value="CORPORATE">CORPORATE</option>
                                                                    </select>
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
                    <h4 class="card-title">Kelola Campaigner</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Pengajuan</th>
                                        <th scope="col">Penanggung Jawab</th>
                                        <th scope="col">Tipe</th>
                                        <th scope="col">Tanggal Bergabung</th>
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
                                            <td>
                                                @if($row->type_campaigner == 'PERSONAL')
                                                    {{ $row->name }}
                                                @else 
                                                    {{ $row->hasCorporate->name_pic ?? '-' }}
                                                @endif
                                            </td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->type_campaigner }}</td>
                                            <td> 
                                                @if($row->type_campaigner == 'PERSONAL')
                                                {{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}
                                                @else
                                                {{ \Carbon\Carbon::parse($row->hasCorporate->created_at)->format('d F Y') }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->is_campaigner == "VERIFIED")
                                                    <span class="badge badge-success">Verified</span>
                                                @elseif ($row->is_campaigner == "PROCESS")
                                                    <span class="badge badge-primary">Process</span>
                                                @elseif ($row->is_campaigner == "UNVERIFIED")
                                                    <span class="badge badge-warning">Unverified</span>
                                                @else
                                                    <span class="badge badge-danger">Cancel</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(count($hasPermissions) == 0)
                                                    <a href="{{ route('campaigner-approval.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail Program">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                @else
                                                    @foreach ($hasPermissions as $permission)
                                                        @if(strstr($permission->name, 'edit'))
                                                            @can($permission->name)
                                                                <a href="{{ route('campaigner-approval.show', $row->encodeHash($row->id)) }}" class="btn btn-warning btn-sm round btn-show" title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                                @if ($row->is_campaigner != 'VERIFIED')
                                                                    <a href="#modal5" data-toggle="modal" class="btn btn-success btn-sm round btn-active" data-id="{{$row->encodeHash($row->id)}}" data-approve="VERIFIED" title="Approve">
                                                                        <i class="fa fa-check"></i>
                                                                    </a>
                                                                @endif
                                                                    @if ($row->is_campaigner != 'CANCEL')
                                                                    <a href="#modal6" data-toggle="modal" class="btn btn-danger btn-sm round btn-active" data-id="{{$row->encodeHash($row->id)}}"  data-approve="CANCEL" title="Cancel">
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

<!-- Modal -->
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
          <form action="{{ route('campaigner-approval.approvalCampaigner') }}" method="post">
              {{csrf_field()}}
              <input type="hidden" name="id" id="user_id" class="xs-input-control user_id">
              <input type="hidden" name="is_campaigner" id="is_campaigner" class="xs-input-control">
              <input type="hidden" name="page" value="list">
              <button type="button" class="btn btn-warning round tx-13" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-danger round tx-13">Kirim</button>
          </form>
        </div>
      </div>
    </div>
</div>  

<div class="modal fade" id="modal6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel6" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel6">Konfirmasi</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('campaigner-approval.approvalCampaigner') }}" method="post">
            @csrf
            <div class="modal-body">
                <textarea type="text" class="form-control" rows="4" name="comment" placeholder="Alasan Anda Menolak"></textarea>
            </div>
            <div class="modal-footer">
                {{csrf_field()}}
                <input type="hidden" name="id" id="user_id" class="xs-input-control user_id">
                <input type="hidden" name="is_campaigner" id="is_campaigner" class="xs-input-control">
                <input type="hidden" name="page" value="list">
                <button type="button" class="btn btn-warning round tx-13" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger round tx-13">Kirim</button>
            </div>
        </form>
      </div>
    </div>
</div>  

@endsection

@section('script')
<script>
    
    $('.btn-active').click(function(){
		var id = $(this).data('id');
        var approve = $(this).data('approve');
        if (approve == "VERIFIED"){
            var modal5 = $('#modal5');
            modal5.find('[id=user_id]').val(id);
            modal5.find('[id=is_campaigner]').val(approve);
            modal5.find('.modal5-message-body').text("Apakah anda yakin akan menyetujui ?")
 
            
        } else {
            var modal6 = $('#modal6');
            modal6.find('[id=user_id]').val(id);
            modal6.find('[id=is_campaigner]').val(approve);
            modal6.find('.modal6-message-body').text("Apakah anda yakin akan menolak ?")
        }
	});
</script>
@endsection
