<div>
    <div class="modal-body__inner pt-4 pb-6 overflow-x-hidden overflow-y-auto listDonatur">
        <div class="container">
            <ul class="campaign-detail__fundraiser">
                @forelse($donatur as $row)
                <li class="border border-gray-light rounded-xs p-4">
                    <div class="d-flex">
                        <div class="bg-skeleton w-12 h-12 rounded-circle overflow-hidden shadow">
                            <img class="w-full h-full object-cover" src="{{ isset($row->hasUser->image) ? asset('assets/images/donatur/'. $row->hasUser->image) : asset('frontoffice/assets/uploads/images/no-avatar.svg') }}" alt="{{ $row->name }}">
                        </div>
                        <div class="flex-1 ms-3 mt-0_75">
                            <span class="text-base d-flex align-items-center flex-1">
                                <span class="fw-medium line-clamp-1">
                                    @if($row->is_hamba_allah == 1)
                                    Hamba Allah
                                    @else
                                    {{ $row->name }}
                                    @endif
                                </span>
                            </span>
                            <time class="text-secondary fw-medium text-default rp ns">{{ number_format($row->amount+$row->unique_code,0,'.','.') }}</time>
                            <p class="mt-2">{{ $row->note }}</p>
                            @if(auth()->guard('member')->user())
                                @if(count($row->hasLikes->where('donatur_id', auth()->guard('member')->user()->id)) > 0)
                                    @foreach($row->hasLikes->where('donatur_id', auth()->guard('member')->user()->id) as $likes)
                                        <button class="love-btn d-flex align-items-center mt-2 link-base-light " value="{{ $row->id }}" onclick="amen(this.value, {{ ($likes->donatur_id == auth()->guard('member')->user()->id) ? 0 : 1 }})">
                                            <i class="transition-all rck ryd-heart like {{ ($likes->donatur_id == auth()->guard('member')->user()->id) ? 'link-primary ryd-heart-fill' : '' }} "></i>
                                            <span class="ms-2 text-xxs">Aminkan doa</span>
                                        </button>
                                    @endforeach
                                @else
                                <button class="love-btn d-flex align-items-center mt-2 link-base-light " value="{{ $row->id }}" onclick="amen(this.value, 1)">
                                    <i class="transition-all rck ryd-heart like"></i>
                                    <span class="ms-2 text-xxs">Aminkan doa</span>
                                </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </li>
                @empty 
                <div class="text-center py-4">
                    <div class="rounded-circle bg-primary bg-opacity-5 w-20 h-20 d-flex align-items-center justify-content-center mx-auto"><i class="rck ryd-user text-12 text-primary"></i>
                    </div>
                    <div class="fw-medium mt-3">Belum ada donatur</div>
                </div>
                @endforelse
            </ul>
        </div>
    </div>
</div>
