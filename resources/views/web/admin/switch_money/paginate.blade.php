@foreach ($contents as $item)
<a href="{{url('switch-money-detail/'.$item->id)}}" class="card no-border shadow-none custom-square mb-2 text-dark">
    <div class="card-body p-2">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center mb-1">
                    <span class="badge badge-{{ $item->status == 'Published' ? 'success' : 'dark' }} my-0 mr-2">
                        {{ $item->status }}
                    </span>
                    <span class="text-muted fs-12">
                        {{ date('d M Y', strtotime($item->date)) }}
                    </span>
                </div>
                <h6 class="my-2 font-weight-bold">
                    {{ $item->from_bank_name }} <i class="fe fe-arrow-right mx-1 text-muted"></i> {{ $item->to_bank_name }}
                </h6>

            </div>
            <div class="text-right ml-2">
                <h6 class="mb-0 font-weight-bold">Rp {{ number_format($item->amount, 0, ',', '.') }}</h6>
                @if($item->fee > 0)
                <p class="mb-0 text-danger fs-11 mt-1">Fee: Rp {{ number_format($item->fee, 0, ',', '.') }}</p>
                @endif
            </div>
        </div>
    </div>
</a>
@endforeach
