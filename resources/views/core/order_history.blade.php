<x-layouts.public metatitle="Riwayat Pesanan" metadesc="Riwayat Pesanan - Toko Kopi Tanjoe Artisan Roastery">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

<style>
    :root {
        --color-surface: #FAF8F5;
        --color-surface-card: #FFFFFF;
        --color-primary: #BE0017;
        --color-primary-accent: #E62129;
        --color-secondary: #1F2429;
        --color-secondary-muted: #6B7280;
        --color-border: #ECE7DE;
        --shadow-card: 0 2px 8px -2px rgba(50, 45, 40, 0.06), 0 1px 3px 0 rgba(0, 0, 0, 0.02);
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-pill: 9999px;
    }

    body {
        background-color: var(--color-surface) !important;
        color: var(--color-secondary);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    .history-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding-bottom: 90px;
        min-height: 100vh;
        background-color: var(--color-surface);
    }

    /* Top Sticky Header */
    .history-top-header {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #FFFFFF;
        border-bottom: 1px solid var(--color-border);
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    }
    .history-back-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #F4EFE6;
        border: 1px solid var(--color-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-secondary);
        font-size: 18px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .history-back-btn:hover {
        background: #ECE7DE;
        color: var(--color-primary);
    }
    .history-header-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 17px;
        color: var(--color-secondary);
        margin: 0;
        line-height: 1;
    }

    /* Filter Tabs Bar */
    .filter-pills-bar {
        display: flex;
        gap: 8px;
        padding: 12px 16px 8px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .filter-pills-bar::-webkit-scrollbar {
        display: none;
    }
    .filter-pill-item {
        padding: 6px 14px;
        border-radius: var(--radius-pill);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        color: var(--color-secondary-muted);
        text-decoration: none !important;
        white-space: nowrap;
        transition: all 0.2s ease;
    }
    .filter-pill-item.active {
        background: var(--color-primary);
        color: #FFFFFF !important;
        border-color: var(--color-primary);
        box-shadow: 0 2px 6px rgba(190, 0, 23, 0.25);
    }

    /* Order Card */
    .order-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin: 0 16px 14px;
        box-shadow: var(--shadow-card);
        overflow: hidden;
        transition: transform 0.15s ease;
    }
    .order-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        border-bottom: 1px solid #F3EFE7;
        background: #FCFAF7;
    }
    .order-code-badge {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 12px;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .order-date-text {
        font-size: 11px;
        color: var(--color-secondary-muted);
    }
    .status-badge-pill {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10.5px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: var(--radius-pill);
    }
    .badge-status-unpaid {
        background: #FEF3C7;
        color: #92400E;
    }
    .badge-status-paid {
        background: #D1FAE5;
        color: #065F46;
    }

    /* Order Items List in Card */
    .order-card-body {
        padding: 12px 14px;
    }
    .order-item-row {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    .order-item-row:last-child {
        margin-bottom: 0;
    }
    .order-item-thumb {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        background: #F4EFE6;
        border: 1px solid var(--color-border);
        flex-shrink: 0;
    }
    .order-item-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 13px;
        color: var(--color-secondary);
        line-height: 1.3;
        margin-bottom: 2px;
    }
    .order-item-variant {
        font-size: 11px;
        color: var(--color-secondary-muted);
        line-height: 1.25;
    }
    .order-item-price-qty {
        font-size: 12px;
        font-weight: 600;
        color: var(--color-secondary);
        margin-top: 4px;
    }

    /* Order Card Footer */
    .order-card-footer {
        padding: 12px 14px;
        border-top: 1px dashed var(--color-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #FFFFFF;
    }
    .order-total-label {
        font-size: 11px;
        color: var(--color-secondary-muted);
    }
    .order-total-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 14px;
        color: var(--color-primary-accent);
    }
    .order-actions-group {
        display: flex;
        gap: 6px;
    }
    .btn-order-detail {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: var(--radius-pill);
        border: 1px solid var(--color-border);
        background: #F9FAFB;
        color: var(--color-secondary);
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-order-detail:hover {
        background: #F3F4F6;
        color: var(--color-primary);
    }
    .btn-order-wa {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: var(--radius-pill);
        border: none;
        background: #10B981;
        color: #FFFFFF !important;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-order-wa:hover {
        background: #059669;
    }

    /* Empty State */
    .empty-orders-box {
        text-align: center;
        padding: 50px 20px;
        margin: 20px 16px;
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
    }
    .empty-orders-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #FEE2E2;
        color: var(--color-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        margin: 0 auto 14px;
    }
    .empty-orders-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 16px;
        color: var(--color-secondary);
        margin-bottom: 6px;
    }
    .empty-orders-desc {
        font-size: 12px;
        color: var(--color-secondary-muted);
        max-width: 320px;
        margin: 0 auto 16px;
        line-height: 1.45;
    }
    .btn-shop-now {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 800;
        background: var(--color-primary);
        color: #FFFFFF !important;
        padding: 9px 20px;
        border-radius: var(--radius-pill);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none !important;
        box-shadow: 0 4px 10px rgba(190, 0, 23, 0.3);
    }

    /* Guest Banner */
    .guest-auth-prompt {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin: 0 16px 16px;
        padding: 16px;
        box-shadow: var(--shadow-card);
        text-align: center;
    }
</style>

<div class="history-wrapper">

    <!-- Top Header -->
    <div class="history-top-header">
        <a href="{{ url('/shop') }}" class="history-back-btn" title="Kembali ke Toko">
            <i class="fe fe-arrow-left"></i>
        </a>
        <h1 class="history-header-title">Riwayat Pesanan</h1>
    </div>

    @if(!$isLoggedIn)
        <!-- Guest Banner: Login to view orders -->
        <div class="guest-auth-prompt mt-3">
            <div class="empty-orders-icon">
                <i class="fe fe-user"></i>
            </div>
            <h2 class="empty-orders-title">Masuk untuk Melihat Riwayat</h2>
            <p class="empty-orders-desc">
                Silakan masuk dengan akun Anda untuk melihat seluruh riwayat invoice dan status pesanan kopi Anda.
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('login_google', ['redirect' => 'transaction-history']) }}" class="btn btn-outline-dark btn-sm rounded-pill font-weight-bold px-3 py-2 mr-2">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="14" height="14" class="mr-1" alt="Google">
                    Masuk Google
                </a>
                <a href="{{ url('/login?redirect=transaction-history') }}" class="btn-shop-now">
                    Masuk Akun
                </a>
            </div>
        </div>
    @else
        <!-- Filter Tabs -->
        <div class="filter-pills-bar">
            <a href="{{ url('transaction-history') }}" class="filter-pill-item {{ $currentFilter == 'all' ? 'active' : '' }}">
                Semua Pesanan
            </a>
            <a href="{{ url('transaction-history?status=unpaid') }}" class="filter-pill-item {{ $currentFilter == 'unpaid' ? 'active' : '' }}">
                Belum Dibayar
            </a>
            <a href="{{ url('transaction-history?status=paid') }}" class="filter-pill-item {{ $currentFilter == 'paid' ? 'active' : '' }}">
                Lunas
            </a>
        </div>

        @if($orders->isEmpty())
            <!-- Empty State -->
            <div class="empty-orders-box mt-2">
                <div class="empty-orders-icon">
                    <i class="fe fe-coffee"></i>
                </div>
                <h2 class="empty-orders-title">Belum Ada Pesanan</h2>
                <p class="empty-orders-desc">
                    Anda belum memiliki transaksi pesanan roasted beans. Jelajahi katalog artisan roastery kami sekarang.
                </p>
                <a href="{{ url('/shop') }}" class="btn-shop-now">
                    <i class="fe fe-shopping-bag"></i>
                    <span>Mulai Belanja Kopi</span>
                </a>
            </div>
        @else
            <!-- List of Order Cards -->
            <div class="orders-list-stream mt-2">
                @foreach($orders as $sale)
                    @php
                        $isPaid = ($sale->inv_status_payment === 'paid');
                        $itemCount = $sale->items->count();
                        $firstItem = $sale->items->first();
                        $formattedDate = date('d M Y', strtotime($sale->inv_date ?? $sale->created_at));
                        $formattedTotal = 'Rp ' . number_format((float)$sale->inv_total, 0, ',', '.');
                        
                        // Format WA Chat Message for this invoice
                        $waText = "Halo Admin Toko Kopi Tanjoe,\nSaya ingin konfirmasi status pesanan saya dengan No. Invoice *{$sale->inv_code}* ({$formattedTotal}). Mohon info perhitungannya. Terima kasih!";
                        $waUrl = 'https://wa.me/6285974607547?text=' . urlencode($waText);
                    @endphp

                    <div class="order-card">
                        <!-- Card Header -->
                        <div class="order-card-header">
                            <div>
                                <div class="order-code-badge">
                                    <i class="fe fe-file-text text-danger"></i>
                                    <span>{{ $sale->inv_code }}</span>
                                </div>
                                <div class="order-date-text">{{ $formattedDate }}</div>
                            </div>
                            <div>
                                <span class="status-badge-pill {{ $isPaid ? 'badge-status-paid' : 'badge-status-unpaid' }}">
                                    {{ $isPaid ? 'Lunas' : 'Menunggu Konfirmasi' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body: Products -->
                        <div class="order-card-body">
                            @if($firstItem)
                                @php
                                    $imgUrl = !empty($firstItem->product_photo) ? asset('assets/images/products/' . $firstItem->product_photo) : asset('assets/images/products/no-image.png');
                                @endphp
                                <div class="order-item-row">
                                    <img src="{{ $imgUrl }}" class="order-item-thumb" alt="{{ $firstItem->product_name }}">
                                    <div class="flex-fill">
                                        <div class="order-item-title">{{ $firstItem->product_name ?? 'Roasted Beans' }}</div>
                                        <div class="order-item-variant">
                                            @if(!empty($firstItem->product_origin))
                                                Origin: {{ $firstItem->product_origin }} &bull;
                                            @endif
                                            Qty: {{ (int)$firstItem->itm_qty }} pack
                                        </div>
                                        <div class="order-item-price-qty">
                                            Rp {{ number_format((float)$firstItem->itm_price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($itemCount > 1)
                                <div class="text-muted fs-11 mt-1 pl-1">
                                    <i class="fe fe-plus-circle mr-1"></i> +{{ $itemCount - 1 }} produk lainnya dalam pesanan ini
                                </div>
                            @endif
                        </div>

                        <!-- Card Footer: Total & Actions -->
                        <div class="order-card-footer">
                            <div>
                                <div class="order-total-label">Total Tagihan</div>
                                <div class="order-total-val">{{ $formattedTotal }}</div>
                            </div>
                            <div class="order-actions-group">
                                <a href="{{ route('transaction.history.detail', $sale->id) }}" class="btn-order-detail">
                                    Detail
                                </a>
                                <a href="{{ $waUrl }}" target="_blank" class="btn-order-wa" title="Chat Admin">
                                    <i class="fe fe-message-circle"></i>
                                    <span>Chat Admin</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination if needed -->
                @if($orders->hasPages())
                    <div class="p-3 d-flex justify-content-center">
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        @endif
    @endif

</div>

</x-layouts.public>
