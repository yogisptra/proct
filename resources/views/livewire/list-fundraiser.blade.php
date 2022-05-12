<div>
    <div class="modal-body__inner pt-4 pb-6 overflow-x-hidden overflow-y-auto listFundraiser">
        <div class="container">
            <ul class="campaign-detail__fundraiser">
                @foreach($fundraiser as $row)
                <li class="border border-gray-light rounded-xs p-4">
                    <div class="d-flex">
                        <div class="bg-skeleton w-12 h-12 rounded-circle overflow-hidden shadow">
                            <img class="w-full h-full object-cover" src="{{ isset($row->hasFundraiser->image) ? asset('assets/images/donatur/'. $row->hasFundraiser->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="{{ $row->hasFundraiser->name }}">
                        </div>
                        <div class="flex-1 ms-3 mt-0_75"><span class="text-base d-flex align-items-center flex-1"><span class="fw-medium line-clamp-1">{{ $row->hasFundraiser->name }}</span><i class="ms-1 mt-0_25 text-primary rck ryd-verified-simple"></i>
                            </span>
                            <time class="text-secondary fw-medium text-default rp ns">{{ $row->nominalTransaksi + $row->uniqueCode }}</time>
                            <p class="mt-2">Berhasil mengajak {{ $row->jumlahTransaksi ?? 0 }} orang memulai perjalanan kebaikan</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
