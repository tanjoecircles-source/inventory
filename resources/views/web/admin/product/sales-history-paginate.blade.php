@foreach ($contents as $item)
<div class="d-flex align-items-center py-3 border-top">
    <div class="flex-grow-1">
        <h6 class="mb-1 font-weight-semibold">{{ $item->customer_name ?? '-' }}</h6>
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="fe fe-calendar mr-1"></i>{{ \Carbon\Carbon::parse($item->inv_date)->format('d M Y') }}
            </small>
            <span class="badge badge-pill badge-dark px-3 py-1 fs-12">
                <i class="fe fe-shopping-cart mr-1"></i>{{ $item->itm_qty }} pcs
            </span>
        </div>
        <small class="text-muted d-block mt-1">
            <i class="fe fe-user mr-1"></i>Author : {{ $item->author_name ?? '-' }}
        </small>
    </div>
</div>
@endforeach