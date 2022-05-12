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
        <h3 class="content-header-title">Kelola Data Transaksi</h3>
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Approval</li>
                    <li class="breadcrumb-item">Data Transaksi</li>
                    <li class="breadcrumb-item active"  > <a href="">Detail</a> </li>
                    
                </ol>
            </div>
        </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
        
        <div class="d-flex justify-content-end " role="group" aria-label="Button Group">
            <a href="{{ route('transaction-approval.index') }}" type="button" class="btn btn round mr-1" style="background-color: #3bafda; color: white">
                Kembali
            </a>
            @if ($data->transaction_status_id != 'VERIFIED')
            <a href="{{ route('transaction-approval.active_nonactive', [$data->encodeHash($data->id), 'VERIFIED']) }}" type="button" class="round btn btn-success" title="Approve">
                Approve
            </a>
            @endif
        </div>
    </div>
</div>

<div class="content-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
	            <div class="card-header">
	                <h4 class="card-title">Detail Transaksi</h4>
	                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collpase show">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success mt-2">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger mt-2">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                        <div class="form-body">

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Tipe Transaksi</label>
                                    <div class="col-lg-9">
                                        : <span>{{ ucfirst(strtolower($data->type_transaction_id)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Campaign</label>
                                    <div class="col-lg-9">
                                       : <span>{{ $data->hasCampaign->title ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Nomor Transaksi</label>
                                    <div class="col-lg-9">
                                       : <span>{{ $data->transaction_number }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Nominal</label>
                                    <div class="col-lg-9">
                                       : <span>Rp{{ number_format($data->amount+$data->unique_code,0,'.','.') }},-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Tanggal Pembayaran</label>
                                    <div class="col-lg-9">
                                       : <span>{{ \Carbon\Carbon::parse($data->payment_date)->format('l H:i, F Y') ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Tanggal Transaksi</label>
                                    <div class="col-lg-9">
                                       : <span>{{ \Carbon\Carbon::parse($data->transaction_date)->format('l, F Y') ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Status Transaksi</label>
                                    <div class="col-lg-9">
                                            @if($data->transaction_status_id == "VERIFIED")
                                                <span class="badge badge-success round"><i class="fa fa-check"></i> Terverifikasi</span>
                                            @elseif ($data->transaction_status_id == "UNVERIFIED")
                                                <span class="badge badge-info round"><i class="fa fa-recycle"></i> Prospek</span>
                                            @elseif ($data->transaction_status_id == "CANCEL")
                                                <span class="badge badge-danger round"><i class="fa fa-times"></i> Dibatalkan</span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Tujuan Transfer</label>
                                    <div class="col-lg-9">
                                        {{-- <span class="badge badge-primary round">{{ @$data->hasBankAccount->hasBank->name . " - " . @$data->hasBankAccount->name ?? '-' }}</span> --}}
                                        <span class="badge badge-success round">{{ @$data->payment_method ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
	            <div class="card-header">
	                <h4 class="card-title">Data Donatur</h4>
	                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collpase show">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Nama</label>
                                    <div class="col-lg-9">
                                       : <span>{{ $data->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Nomor Telp.</label>
                                    <div class="col-lg-9">
                                       : <span>{{ $data->phone_number }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Email</label>
                                    <div class="col-lg-9">
                                       : <span>{{ $data->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($data->fundraiser_id != null)
        <div class="col-lg-12">
            <div class="card">
	            <div class="card-header">
	                <h4 class="card-title">Data Fundraiser</h4>
	                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collpase show">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Nama</label>
                                    <div class="col-lg-9">
                                        : <span>{{ $data->hasFundraiser->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Nomor Telp.</label>
                                    <div class="col-lg-9">
                                        : <span>{{ $data->hasFundraiser->phone_number }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-lg-3">Email</label>
                                    <div class="col-lg-9">
                                        : <span>{{ $data->hasFundraiser->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(!empty($confirmation))
        <div class="col-lg-12">
            <form method="POST" action="{{ route('transaction-approval.update', $data->transaction_number) }}" class="form form-horizontal" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Konfirmasi Manual</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <button type="submit" class="btn btn-info round">
                                       Simpan
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-lg-3">Nama</label>
                                        <div class="col-lg-9">
                                            : <span>{{ $confirmation->transaction_number }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-body">
                                    <div class="row">
                                        <label class="col-lg-3">Nominal</label>
                                        <div class="col-lg-9" >
                                            <input type="text" style="width: 50%" name="amount" value="{{ number_format($data->amount ? $data->amount : 0, "0",",",".") }}" class="form-control uang">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-body mt-1">
                                    <div class="row">
                                        <label class="col-lg-3">Kode Unik</label>
                                        <div class="col-lg-9">
                                            <input type="text" style="width: 50%" name="unique_code" value="{{ $data->unique_code ? ($data->unique_code) : '-' }}" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-body mt-1">
                                    <div class="row">
                                        <label class="col-lg-3">Tanggal Pembayaran</label>
                                        <div class="col-lg-9">
                                            @if($data->payment_date == null)
                                                <input type="datetime-local" style="width: 50%" class="form-control" name="payment_date" value="{{$data->payment_date}}">
                                            @else
                                                <input type="datetime-local" style="width: 50%" class="form-control" name="payment_date" value="{{\Carbon\Carbon::parse($data->payment_date)->format('Y-m-d\TH:i')}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-body mt-1">
                                    <div class="row">
                                        <label class="col-lg-3">Bukti Transfer</label>
                                        <div class="col-lg-9">
                                            @if($confirmation->image == NULL)
                                            <input type="file" style="width: 50%" name="image" accept="image/*" class="form-control">
                                            @else 
                                            <img src="{{asset('assets/images/manualConfirmation/'. $confirmation->image)}}" class="img-thumbnail" width="200px" >
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
		$('.uang').mask('000.000.000.000.000', {reverse: true});
	});
</script>
@endsection

