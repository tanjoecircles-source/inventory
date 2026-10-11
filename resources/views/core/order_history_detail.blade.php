<x-layouts.public metatitle="Detail Pesanan" metadesc="Detail pesanan - Toko Kopi Tanjoe Artisan Roastery">

<style>
    :root {
        --color-surface: #FAF8F5;
        --color-primary: #BE0017;
        --color-secondary: #1F2429;
        --color-secondary-muted: #6B7280;
        --color-border: #ECE7DE;
        --shadow-card: 0 2px 8px -2px rgba(50,45,40,0.06),0 1px 3px 0 rgba(0,0,0,0.02);
        --radius-sm: 5px; --radius-md: 12px; --radius-lg: 16px; --radius-pill: 9999px;
    }
    body { background-color: var(--color-surface) !important; color: var(--color-secondary); }
    .detail-wrapper { max-width: 600px; margin: 0 auto; padding-bottom: 100px; min-height: 100vh; }
    .detail-top-header { position:sticky; top:0; z-index:100; background:#fff; border-bottom:1px solid var(--color-border); padding:12px 16px; display:flex; align-items:center; gap:12px; box-shadow:0 1px 4px rgba(0,0,0,0.03); }
    .detail-back-btn { width:36px; height:36px; border-radius:50%; background:#F4EFE6; border:1px solid var(--color-border); display:flex; align-items:center; justify-content:center; color:var(--color-secondary); font-size:18px; text-decoration:none !important; transition:all 0.2s ease; flex-shrink:0; }
    .detail-back-btn:hover { background:#ECE7DE; color:var(--color-primary); }
    .detail-header-title { font-weight:800; font-size:17px; color:var(--color-secondary); margin:0; }
    .invoice-hero { background:linear-gradient(135deg,#BE0017 0%,#8B000F 100%); margin:8px 8px 0; border-radius:var(--radius-sm); padding:20px; position:relative; overflow:hidden; }
    .invoice-hero::before { content:''; position:absolute; top:-30px; right:-30px; width:120px; height:120px; border-radius:50%; background:rgba(255,255,255,0.06); }
    .invoice-hero-label { font-size:11px; font-weight:600; color:rgba(255,255,255,0.7); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:4px; }
    .invoice-hero-code { font-weight:800; font-size:18px; color:#fff; margin-bottom:14px; }
    .invoice-hero-meta { display:flex; gap:8px; flex-wrap:wrap; }
    .invoice-meta-chip { background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.18); border-radius:var(--radius-pill); padding:5px 12px; display:flex; align-items:center; gap:5px; font-size:11.5px; font-weight:600; color:rgba(255,255,255,0.9); }
    .status-chip-paid { background:rgba(16,185,129,0.22); border-color:rgba(16,185,129,0.35); color:#6EE7B7; }
    .status-chip-unpaid { background:rgba(251,191,36,0.22); border-color:rgba(251,191,36,0.35); color:#FCD34D; }
    .detail-section { background:#fff; border:1px solid var(--color-border); border-radius:var(--radius-sm); margin:8px 8px 0; box-shadow:var(--shadow-card); overflow:hidden; }
    .detail-section-header { display:flex; align-items:center; gap:10px; padding:13px 16px; border-bottom:1px solid #F3EFE7; background:#FCFAF7; }
    .detail-section-icon { width:32px; height:32px; border-radius:9px; background:#FEE2E2; color:#BE0017; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; }
    .detail-section-title { font-weight:800; font-size:13.5px; color:var(--color-secondary); margin:0; }
    .info-grid { padding:14px 16px; display:flex; flex-direction:column; gap:10px; }
    .info-row { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; }
    .info-row-label { font-size:12px; color:var(--color-secondary-muted); font-weight:500; flex-shrink:0; min-width:110px; display:flex; align-items:center; gap:5px; }
    .info-row-val { font-weight:700; font-size:12.5px; color:var(--color-secondary); text-align:right; line-height:1.4; }
    .info-divider { height:1px; background:#F3EFE7; }
    .product-items-list { padding:12px 16px; display:flex; flex-direction:column; gap:12px; }
    .product-item-row { display:flex; gap:12px; align-items:flex-start; padding:10px; background:#FDFBF7; border:1px solid rgba(230,33,41,0.07); border-radius:var(--radius-md); }
    .product-thumb { width:56px; height:56px; border-radius:var(--radius-sm); object-fit:cover; background:#F4EFE6; border:1px solid var(--color-border); flex-shrink:0; }
    .product-thumb-placeholder { width:56px; height:56px; border-radius:var(--radius-sm); background:linear-gradient(135deg,#F4EFE6,#ECE7DE); border:1px solid var(--color-border); flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#9CA3AF; font-size:22px; }
    .product-meta { flex:1; min-width:0; }
    .product-name { font-weight:700; font-size:13px; color:var(--color-secondary); margin-bottom:4px; line-height:1.3; }
    .product-variant-tag { display:inline-flex; align-items:center; gap:3px; background:#F3F4F6; border:1px solid #E5E7EB; border-radius:6px; padding:2px 7px; font-size:10.5px; font-weight:600; color:#4B5563; margin-bottom:6px; }
    .product-price-line { display:flex; align-items:center; justify-content:space-between; font-size:12px; }
    .product-qty-text { color:var(--color-secondary-muted); font-weight:500; }
    .product-total-text { font-weight:700; color:var(--color-primary); font-size:13px; }
    .summary-total-box { padding:14px 16px; border-top:1px dashed var(--color-border); }
    .summary-row { display:flex; align-items:center; justify-content:space-between; font-size:12.5px; margin-bottom:7px; color:var(--color-secondary-muted); }
    .summary-row-val { font-weight:600; color:var(--color-secondary); }
    .summary-divider { height:1px; background:var(--color-border); margin:8px 0; }
    .summary-total-row { display:flex; align-items:center; justify-content:space-between; }
    .summary-total-label { font-weight:800; font-size:14px; color:var(--color-secondary); }
    .summary-total-amount { font-weight:800; font-size:18px; color:var(--color-primary); }
    .shipping-note-chip { background:#FEF3C7; border:1px solid #FDE68A; border-radius:9999px; padding:3px 10px; font-size:11px; font-weight:600; color:#92400E; }
    .status-timeline { padding:14px 16px; display:flex; flex-direction:column; }
    .timeline-item { display:flex; gap:12px; position:relative; }
    .timeline-item:not(:last-child)::before { content:''; position:absolute; left:11px; top:22px; width:2px; height:calc(100% - 4px); background:var(--color-border); }
    .timeline-dot { width:24px; height:24px; border-radius:50%; background:var(--color-border); border:2px solid #fff; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:10px; color:#9CA3AF; position:relative; z-index:1; }
    .timeline-dot.done { background:#10B981; color:#fff; }
    .timeline-dot.current { background:#BE0017; color:#fff; box-shadow:0 0 0 3px rgba(190,0,23,0.15); }
    .timeline-content { padding-bottom:16px; }
    .timeline-label { font-weight:700; font-size:12.5px; color:var(--color-secondary); margin-bottom:1px; }
    .timeline-sublabel { font-size:11px; color:var(--color-secondary-muted); }
    .action-buttons-area { margin:16px 16px 0; display:flex; flex-direction:column; gap:10px; }
    .btn-wa-contact { width:100%; background:#25D366; color:#fff !important; font-weight:800; font-size:14px; padding:13px 18px; border-radius:var(--radius-pill); border:none; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 14px rgba(37,211,102,0.3); cursor:pointer; transition:all 0.2s ease; text-decoration:none !important; }
    .btn-wa-contact:hover { background:#128C7E; transform:translateY(-1px); }
    .btn-back-list { width:100%; background:#F9FAFB; color:var(--color-secondary) !important; font-weight:700; font-size:13px; padding:11px 18px; border-radius:var(--radius-pill); border:1px solid var(--color-border); display:flex; align-items:center; justify-content:center; gap:7px; cursor:pointer; transition:all 0.2s ease; text-decoration:none !important; }
    .btn-back-list:hover { background:#F3F4F6; border-color:#D1D5DB; }
    /* Payment Instructions */
    .payment-section { background:#fff; border:1px solid var(--color-border); border-radius:var(--radius-lg); margin:14px 16px 0; box-shadow:var(--shadow-card); overflow:hidden; scroll-margin-top:70px; }
    .payment-bank-item { display:flex; align-items:flex-start; gap:14px; padding:14px 16px; border-bottom:1px solid #F3EFE7; }
    .payment-bank-item:last-child { border-bottom:none; }
    .bank-logo-box { width:80px; flex-shrink:0; }
    .bank-logo-box img { max-width:100%; height:28px; object-fit:contain; }
    .bank-detail-name { font-size:11px; color:var(--color-secondary-muted); margin-bottom:2px; }
    .bank-detail-an { font-size:12px; color:var(--color-secondary); margin-bottom:4px; }
    .bank-account-no { font-weight:800; font-size:16px; color:var(--color-secondary); letter-spacing:0.03em; display:flex; align-items:center; gap:8px; }
    .btn-copy-acc { background:#F3F4F6; border:1px solid #E5E7EB; border-radius:6px; padding:2px 8px; font-size:11px; font-weight:600; color:#4B5563; cursor:pointer; }
    .btn-copy-acc:hover { background:#E5E7EB; }
    .payment-total-banner { background:linear-gradient(135deg,#1F2429 0%,#374151 100%); margin:12px 16px; border-radius:var(--radius-md); padding:14px 16px; display:flex; align-items:center; justify-content:space-between; }
    .payment-total-label { font-size:12px; color:rgba(255,255,255,0.7); margin-bottom:2px; }
    .payment-total-amount { font-weight:800; font-size:20px; color:#FFFFFF; }
    .btn-confirm-payment { width:100%; background:linear-gradient(135deg,#BE0017 0%,#E62129 100%); color:#fff !important; font-weight:800; font-size:14px; padding:14px 18px; border-radius:var(--radius-pill); border:none; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 16px rgba(190,0,23,0.35); cursor:pointer; transition:all 0.2s ease; text-decoration:none !important; }
    .btn-confirm-payment:hover { opacity:0.92; transform:translateY(-1px); }
    .confirm-note { text-align:center; font-size:11px; color:var(--color-secondary-muted); margin-top:6px; }
    /* Waiting confirm banner */
    .waiting-confirm-banner { background:#EDE9FE; border:1px solid #C4B5FD; border-radius:var(--radius-md); padding:14px 16px; margin:14px 16px 0; display:flex; align-items:flex-start; gap:12px; }
    .waiting-confirm-icon { width:36px; height:36px; border-radius:50%; background:#7C3AED; color:#fff; display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
    .waiting-confirm-title { font-weight:700; font-size:13px; color:#4C1D95; margin-bottom:3px; }
    .waiting-confirm-desc { font-size:12px; color:#5B21B6; line-height:1.45; }
    /* Print Invoice Button */
    .btn-print-invoice { width:100%; background:linear-gradient(135deg,#1F2429 0%,#374151 100%); color:#fff !important; font-weight:800; font-size:13.5px; padding:12px 18px; border-radius:var(--radius-pill); border:none; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 14px rgba(31,36,41,0.25); cursor:pointer; transition:all 0.2s ease; text-decoration:none !important; }
    .btn-print-invoice:hover { opacity:0.9; transform:translateY(-1px); color:#fff !important; }
</style>

@php
    $sale = $sale ?? null;
    $authUser = $authUser ?? null;
    $formatRupiah = function($num) { return 'Rp ' . number_format((float)$num, 0, ',', '.'); };
    if ($sale) {
        $statusPayLabel = match($sale->inv_status_payment ?? '') {
            'paid'   => ['label' => 'Lunas', 'class' => 'status-chip-paid'],
            'unpaid' => ['label' => 'Belum Dibayar', 'class' => 'status-chip-unpaid'],
            default  => ['label' => ucfirst($sale->inv_status_payment ?? '-'), 'class' => ''],
        };
        $statusOrderLabel = match($sale->inv_status ?? '') {
            'Draft'   => 'Menunggu Konfirmasi Admin',
            'Publish' => 'Invoice Diterbitkan',
            'Process' => 'Diproses',
            'Done'    => 'Selesai',
            default   => $sale->inv_status ?? '-',
        };

        // Data customer langsung dari DB
        $recipientName    = $sale->customer_name  ?? '-';
        $recipientPhone   = $sale->customer_phone ?? '-';
        $shippingAddress  = $sale->customer_address ?? '-';

        $isPublish = ($sale->inv_status === 'Publish');
        $isPaid    = ($sale->inv_status_payment === 'paid');
        $isDelivered = (($sale->inv_status_delivery ?? null) === 'delivered');

        // Jika pesanan sudah dikonfirmasi "Dikirim & Diterima", status akhirnya Selesai.
        if ($isDelivered) {
            $statusOrderLabel = 'Selesai';
        }


        // WA untuk Konfirmasi Pembayaran
        $waConfirmMsg  = "*KONFIRMASI PEMBAYARAN - TOKO KOPI TANJOE*\n";
        $waConfirmMsg .= "No. Invoice: *{$sale->inv_code}*\n";
        $waConfirmMsg .= "Nama: {$recipientName}\n";
        $totalFmt = 'Rp ' . number_format((float)($sale->inv_total ?? 0), 0, ',', '.');
        $waConfirmMsg .= "Total: *{$totalFmt}*\n\n";
        $waConfirmMsg .= "Saya telah melakukan pembayaran. Terlampir bukti transfer. Mohon dikonfirmasi. Terima kasih!";
        $waConfirmUrl = 'https://wa.me/6285974607547?text=' . urlencode($waConfirmMsg);

        // WA Chat Admin
        $waMsg  = "*KONFIRMASI PESANAN - TOKO KOPI TANJOE*\n";
        $waMsg .= "No. Invoice: *{$sale->inv_code}*\n";
        $waMsg .= "Halo Admin Tanjoe, saya ingin menanyakan status pesanan untuk invoice *{$sale->inv_code}*. Terima kasih!";
        $waUrl    = 'https://wa.me/6285974607547?text=' . urlencode($waMsg);
        $invDate   = $sale->inv_date   ? \Carbon\Carbon::parse($sale->inv_date)->translatedFormat('d F Y') : '-';
        $createdAt = $sale->created_at ? \Carbon\Carbon::parse($sale->created_at)->translatedFormat('d F Y, H:i') : '-';
        $totalItems = collect($sale->items ?? [])->sum('itm_qty');
    }
@endphp

<div class="detail-wrapper">

    <div class="detail-top-header">
        <a href="{{ route('transaction.history') }}" class="detail-back-btn"><i class="fe fe-arrow-left"></i></a>
        <h1 class="detail-header-title">Detail Pesanan</h1>
    </div>

    @if($sale)

    <div class="invoice-hero">
        <div class="invoice-hero-label">Nomor Invoice</div>
        <div class="invoice-hero-code">{{ $sale->inv_code }}</div>
        <div class="invoice-hero-meta">
            <div class="invoice-meta-chip {{ $statusPayLabel['class'] }}">
                <i class="fe fe-{{ $isPaid ? 'check-circle' : 'clock' }}" style="font-size:12px;"></i>
                @if($isPaid)
                    Lunas
                @elseif($isPublish)
                    Menunggu Pembayaran
                @else
                    Menunggu Konfirmasi
                @endif
            </div>
            <div class="invoice-meta-chip">
                <i class="fe fe-calendar" style="font-size:12px;"></i> {{ $invDate }}
            </div>
            <div class="invoice-meta-chip">
                <i class="fe fe-package" style="font-size:12px;"></i> {{ $statusOrderLabel }}
            </div>
        </div>
    </div>

    <div class="detail-section">
        <div class="detail-section-header">
            <div class="detail-section-icon"><i class="fe fe-map-pin"></i></div>
            <span class="detail-section-title">Informasi Pengiriman</span>
        </div>
        <div class="info-grid">
            <div class="info-row">
                <span class="info-row-label"><i class="fe fe-user" style="font-size:12px;"></i> Penerima</span>
                <span class="info-row-val">{{ $recipientName }}</span>
            </div>
            <div class="info-divider"></div>
            <div class="info-row">
                <span class="info-row-label"><i class="fe fe-phone" style="font-size:12px;"></i> WhatsApp</span>
                <span class="info-row-val">{{ $recipientPhone }}</span>
            </div>
            <div class="info-divider"></div>
            <div class="info-row" style="align-items:flex-start;">
                <span class="info-row-label" style="padding-top:2px;"><i class="fe fe-navigation" style="font-size:12px;"></i> Alamat</span>
                <span class="info-row-val" style="max-width:200px;">{{ $shippingAddress }}</span>
            </div>
        </div>
    </div>

    <div class="detail-section">
        <div class="detail-section-header">
            <div class="detail-section-icon"><i class="fe fe-shopping-bag"></i></div>
            <span class="detail-section-title">Produk Pesanan ({{ $totalItems }} pcs)</span>
        </div>
        <div class="product-items-list">
            @forelse($sale->items ?? [] as $item)
            @php
                $imgUrl = !empty($item->product_photo) ? asset('storage/'.$item->product_photo) : null;
                $pName  = $item->product_name ?? ('Produk #'.($item->itm_product ?? '?'));
                $pQty   = (float)($item->itm_qty   ?? 1);
                $pPrice = (float)($item->itm_price  ?? 0);
                $pTotal = (float)($item->itm_total  ?? ($pPrice * $pQty));
                $pTags  = array_filter([$item->product_process ?? null, $item->product_origin ?? null]);
            @endphp
            <div class="product-item-row">
                @if($imgUrl)
                    <img src="{{ $imgUrl }}" alt="{{ $pName }}" class="product-thumb">
                @else
                    <div class="product-thumb-placeholder"><i class="fe fe-coffee"></i></div>
                @endif
                <div class="product-meta">
                    <div class="product-name">{{ $pName }}</div>
                    @if(!empty($pTags))
                    <div class="product-variant-tag">
                        <i class="fe fe-tag" style="font-size:9px;"></i>
                        {{ implode(' · ', $pTags) }}
                    </div>
                    @endif
                    <div class="product-price-line">
                        <span class="product-qty-text">{{ $pQty }}x &middot; {{ $formatRupiah($pPrice) }}</span>
                        <span class="product-total-text">{{ $formatRupiah($pTotal) }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:20px 0; color:var(--color-secondary-muted); font-size:13px;">
                <i class="fe fe-package" style="font-size:28px; display:block; margin-bottom:6px;"></i>
                Detail produk tidak tersedia.
            </div>
            @endforelse
        </div>
        <div class="summary-total-box">
            <div class="summary-row">
                <span>Subtotal Produk</span>
                <span class="summary-row-val">{{ $formatRupiah($sale->inv_sub_total ?? 0) }}</span>
            </div>
            @if(($sale->inv_discount ?? 0) > 0)
            <div class="summary-row">
                <span>Diskon</span>
                <span class="summary-row-val" style="color:#10B981;">- {{ $formatRupiah($sale->inv_discount) }}</span>
            </div>
            @endif
            <div class="summary-row">
                <span>Ongkos Kirim</span>
                @if(($sale->inv_expedition ?? 0) > 0)
                    <span class="summary-row-val">{{ $formatRupiah($sale->inv_expedition) }}</span>
                @else
                    <span class="shipping-note-chip">Dihitung Admin</span>
                @endif
            </div>
            <div class="summary-divider"></div>
            <div class="summary-total-row">
                <span class="summary-total-label">Total Tagihan</span>
                <span class="summary-total-amount">{{ $formatRupiah($sale->inv_total ?? 0) }}</span>
            </div>
        </div>
    </div>

    <div class="detail-section">
        <div class="detail-section-header">
            <div class="detail-section-icon"><i class="fe fe-activity"></i></div>
            <span class="detail-section-title">Status Pesanan</span>
        </div>
        <div class="status-timeline">
            <div class="timeline-item">
                <div class="timeline-dot done"><i class="fe fe-check" style="font-size:10px;"></i></div>
                <div class="timeline-content">
                    <div class="timeline-label">Pesanan Diterima</div>
                    <div class="timeline-sublabel">{{ $createdAt }}</div>
                </div>
            </div>
            <div class="timeline-item">
                @if($isPublish || $isPaid || in_array($sale->inv_status, ['Process', 'Done']))
                    <div class="timeline-dot done"><i class="fe fe-check" style="font-size:10px;"></i></div>
                @elseif($sale->inv_status === 'Draft')
                    <div class="timeline-dot current"><i class="fe fe-clock" style="font-size:10px;"></i></div>
                @else
                    <div class="timeline-dot"><i class="fe fe-minus" style="font-size:10px;"></i></div>
                @endif
                <div class="timeline-content">
                    <div class="timeline-label">Konfirmasi Ongkir &amp; Invoice</div>
                    <div class="timeline-sublabel">Admin menghitung ongkos kirim dan menerbitkan invoice resmi</div>
                </div>
            </div>
            <div class="timeline-item">
                @if($isPaid)
                    <div class="timeline-dot done"><i class="fe fe-check" style="font-size:10px;"></i></div>
                @elseif($isPublish)
                    <div class="timeline-dot current"><i class="fe fe-clock" style="font-size:10px;"></i></div>
                @else
                    <div class="timeline-dot"><i class="fe fe-minus" style="font-size:10px;"></i></div>
                @endif
                <div class="timeline-content">
                    <div class="timeline-label">Menunggu Pembayaran</div>
                    <div class="timeline-sublabel">Transfer ke rekening Toko Kopi Tanjoe sesuai instruksi</div>
                </div>
            </div>
            <div class="timeline-item">
                @if($isDelivered)
                    <div class="timeline-dot done"><i class="fe fe-check" style="font-size:10px;"></i></div>
                @else
                    <div class="timeline-dot"><i class="fe fe-minus" style="font-size:10px;"></i></div>
                @endif
                <div class="timeline-content" style="padding-bottom:0;">
                    <div class="timeline-label">Pesanan Selesai</div>
                    <div class="timeline-sublabel">Biji kopi dikirim dan diterima</div>
                </div>
            </div>
        </div>
    </div>

    {{-- INSTRUKSI PEMBAYARAN: tersembunyi by default, tampil via JS saat hash #instruksi-pembayaran --}}
    @if($isPublish && !$isPaid)
    <div class="payment-section" id="instruksi-pembayaran" style="display:none;">
        <div class="detail-section-header">
            <div class="detail-section-icon" style="background:#FEF3C7; color:#92400E;"><i class="fe fe-credit-card"></i></div>
            <span class="detail-section-title">Instruksi Pembayaran</span>
        </div>
        {{-- Total yang harus dibayar --}}
        <div class="payment-total-banner" style="margin:12px 16px 0;">
            <div>
                <div class="payment-total-label">Total yang harus dibayar</div>
                <div class="payment-total-amount">{{ $formatRupiah($sale->inv_total ?? 0) }}</div>
            </div>
            <div>
                <i class="fe fe-chevron-right" style="color:rgba(255,255,255,0.4); font-size:24px;"></i>
            </div>
        </div>
        {{-- Rekening BCA --}}
        <div class="payment-bank-item" style="margin-top:8px;">
            <div class="bank-logo-box">
                <img src="{{ asset('assets/images/png/bca.png') }}" alt="BCA">
            </div>
            <div class="flex-fill">
                <div class="bank-detail-name">Bank Central Asia (BCA)</div>
                <div class="bank-detail-an">a.n. <strong>Muhammad Rizki Awayna</strong></div>
                <div class="bank-account-no">
                    <span id="bca-no">7780 106578</span>
                    <button class="btn-copy-acc" onclick="copyToClipboard('7780106578', this)">Salin</button>
                </div>
            </div>
        </div>
        {{-- Rekening Mandiri --}}
        <div class="payment-bank-item">
            <div class="bank-logo-box">
                <img src="{{ asset('assets/images/png/mandiri.png') }}" alt="Mandiri">
            </div>
            <div class="flex-fill">
                <div class="bank-detail-name">Bank Mandiri</div>
                <div class="bank-detail-an">a.n. <strong>Suhendra Juniar Azhari</strong></div>
                <div class="bank-account-no">
                    <span id="mandiri-no">1370011890809</span>
                    <button class="btn-copy-acc" onclick="copyToClipboard('1370011890809', this)">Salin</button>
                </div>
            </div>
        </div>
        <div style="padding:14px 16px 16px;">
            <p style="font-size:11.5px; color:var(--color-secondary-muted); margin-bottom:12px; line-height:1.5;">
                Setelah melakukan transfer, tekan tombol di bawah untuk mengirim bukti pembayaran via WhatsApp kepada admin kami.
            </p>
            <a href="{{ $waConfirmUrl }}" target="_blank" rel="noopener" class="btn-confirm-payment">
                <i class="fe fe-check-circle"></i>
                <span>Konfirmasi Pembayaran</span>
            </a>
            <p class="confirm-note"><i class="fe fe-info" style="font-size:10px;"></i> Kirim bukti transfer via WhatsApp</p>
        </div>
    </div>
    @endif

    <div class="action-buttons-area">
        @if($isPublish)
        <a href="{{ url('sales-print/' . $sale->id) }}" target="_blank" rel="noopener" class="btn-print-invoice" id="btnPrintInvoice">
            <i class="fe fe-printer"></i>
            <span>Cetak Invoice</span>
        </a>
        @endif
        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn-wa-contact" id="btnContactAdminWa">
            <i class="fe fe-message-circle"></i>
            <span>Hubungi Admin via WhatsApp</span>
        </a>
        <a href="{{ route('transaction.history') }}" class="btn-back-list" id="btnBackToHistory">
            <i class="fe fe-list"></i>
            <span>Lihat Semua Pesanan</span>
        </a>
    </div>

    <script>
    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(function() {
            var orig = btn.textContent;
            btn.textContent = '✓ Tersalin';
            btn.style.background = '#D1FAE5';
            btn.style.color = '#065F46';
            setTimeout(function() {
                btn.textContent = orig;
                btn.style.background = '';
                btn.style.color = '';
            }, 2000);
        }).catch(function() {
            alert('Nomor rekening: ' + text);
        });
    }

    // Tampilkan instruksi pembayaran HANYA jika hash #instruksi-pembayaran ada di URL
    (function() {
        var el = document.getElementById('instruksi-pembayaran');
        if (el && window.location.hash === '#instruksi-pembayaran') {
            el.style.display = 'block';
            setTimeout(function() {
                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        }
    })();
    </script>

    @else
    <div style="text-align:center; padding:80px 24px 40px;">
        <i class="fe fe-alert-circle" style="font-size:52px; color:var(--color-primary); display:block; margin-bottom:16px;"></i>
        <h2 style="font-weight:800; font-size:20px; margin-bottom:8px;">Pesanan Tidak Ditemukan</h2>
        <p style="color:var(--color-secondary-muted); font-size:13px; margin-bottom:24px;">Invoice yang Anda cari tidak tersedia atau sudah dihapus.</p>
        <a href="{{ route('transaction.history') }}" class="btn-back-list" style="display:inline-flex; width:auto; padding:11px 28px;">
            <i class="fe fe-arrow-left"></i>
            <span>Kembali ke Riwayat Pesanan</span>
        </a>
    </div>
    @endif

</div>

</x-layouts.public>
