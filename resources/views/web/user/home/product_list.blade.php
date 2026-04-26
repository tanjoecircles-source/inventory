@forelse($product as $item)
<div class="col-6 p-2 product-item">
    <div class="card product-card shadow-sm">
        <div class="product-image-container">
            <img src="{{ asset('assets/images/products/noimage.png') }}" class="product-image" alt="{{ $item->name }}">
            @if($item->is_new == 1)
                <span class="badge-new">BARU</span>
            @endif
            @if($item->is_sold_out == 'true' || $item->is_sold_out == 1)
                <div class="badge-sold-out">STOK HABIS</div>
            @endif
        </div>
        <div class="card-body p-3">
            <h6 class="text-dark font-weight-semibold mb-1 text-truncate">{{ $item->name }}</h6>
            <p class="text-primary font-weight-bold mb-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted extra-small"><i class="fe fe-tag mr-1"></i>{{ $item->detailType->name ?? 'Uncategorized' }}</span>
                <button class="btn btn-primary btn-icon btn-sm rounded-circle add-to-cart" data-id="{{ $item->id }}" {{ ($item->is_sold_out == 'true' || $item->is_sold_out == 1) ? 'disabled' : '' }}>
                    <i class="fe fe-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@empty
@endforelse
