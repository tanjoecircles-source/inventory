<x-layouts.public metatitle="Detail Pesanan" metadesc="Detail pesanan - Toko Kopi Tanjoe Artisan Roastery">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

<style>
    :root {
        --color-surface: #FAF8F5;
        --color-primary: #BE0017;
        --color-secondary: #1F2429;
        --color-secondary-muted: #6B7280;
        --color-border: #ECE7DE;
        --shadow-card: 0 2px 8px -2px rgba(50,45,40,0.06),0 1px 3px 0 rgba(0,0,0,0.02);
        --radius-sm: 8px; --radius-md: 12px; --radius-lg: 16px; --radius-pill: 9999px;
    }
    body { background-color: var(--color-surface) !important; color: var(--color-secondary); font-family: 'Inter', sans-serif; }
    .detail-wrapper { max-width: 600px; margin: 0 auto; padding-bottom: 100px; min-height: 100vh; }
    .detail-top-header { position:sticky; top:0; z-index:100; background:#fff; border-bottom:1px solid var(--color-border); padding:12px 16px; display:flex; align-items:center; gap:12px; box-shadow:0 1px 4px rgba(0,0,0,0.03); }
    .detail-back-btn { width:36px; height:36px; border-radius:50%; background:#F4EFE6; border:1px solid var(--color-border); display:flex; align-items:center; justify-content:center; color:var(--color-secondary); font-size:18px; text-decoration:none !important; transition:all 0.2s ease; flex-shrink:0; }
    .detail-back-btn:hover { background:#ECE7DE; color:var(--color-primary); }
    .detail-header-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:17px; color:var(--color-secondary); margin:0; }
    .invoice-hero { background:linear-gradient(135deg,#BE0017 0%,#8B000F 100%); margin:16px 16px 0; border-radius:var(--radius-lg); padding:20px; position:relative; overflow:hidden; box-shadow:0 6px 20px rgba(190,0,23,0.3); }
    .invoice-hero::before { content:''; position:absolute; top:-30px; right:-30px; width:120px; height:120px; border-radius:50%; background:rgba(255,255,255,0.06); }
    .invoice-hero-label { font-size:11px; font-weight:600; color:rgba(255,255,255,0.7); text-transform:uppercase; letter-spacing:0.06em; margin-bottom:4px; }
    .invoice-hero-code { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:18px; color:#fff; margin-bottom:14px; }
    .invoice-hero-meta { display:flex; gap:8px; flex-wrap:wrap; }
    .invoice-meta-chip { background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.18); border-radius:var(--radius-pill); padding:5px 12px; display:flex; align-items:center; gap:5px; font-size:11.5px; font-weight:600; color:rgba(255,255,255,0.9); }
    .status-chip-paid { background:rgba(16,185,129,0.22); border-color:rgba(16,185,129,0.35); color:#6EE7B7; }
    .status-chip-unpaid { background:rgba(251,191,36,0.22); border-color:rgba(251,191,36,0.35); color:#FCD34D; }
    .detail-section { background:#fff; border:1px solid var(--color-border); border-radius:var(--radius-lg); margin:14px 16px 0; box-shadow:var(--shadow-card); overflow:hidden; }
    .detail-section-header { display:flex; align-items:center; gap:10px; padding:13px 16px; border-bottom:1px solid #F3EFE7; background:#FCFAF7; }
    .detail-section-icon { width:32px; height:32px; border-radius:9px; background:#FEE2E2; color:#BE0017; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; }
    .detail-section-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:13.5px; color:var(--color-secondary); margin:0; }
    .info-grid { padding:14px 16px; display:flex; flex-direction:column; gap:10px; }
    .info-row { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; }
    .info-row-label { font-size:12px; color:var(--color-secondary-muted); font-weight:500; flex-shrink:0; min-width:110px; display:flex; align-items:center; gap:5px; }
    .info-row-val { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:12.5px; color:var(--color-secondary); text-align:right; line-height:1.4; }
    .info-divider { height:1px; background:#F3EFE7; }
    .product-items-list { padding:12px 16px; display:flex; flex-direction:column; gap:12px; }
    .product-item-row { display:flex; gap:12px; align-items:flex-start; padding:10px; background:#FDFBF7; border:1px solid rgba(230,33,41,0.07); border-radius:var(--radius-md); }
    .product-thumb { width:56px; height:56px; border-radius:var(--radius-sm); object-fit:cover; background:#F4EFE6; border:1px solid var(--color-border); flex-shrink:0; }
    .product-thumb-placeholder { width:56px; height:56px; border-radius:var(--radius-sm); background:linear-gradient(135deg,#F4EFE6,#ECE7DE); border:1px solid var(--color-border); flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#9CA3AF; font-size:22px; }
    .product-meta { flex:1; min-width:0; }
    .product-name { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13px; color:var(--color-secondary); margin-bottom:4px; line-height:1.3; }
    .product-variant-tag { display:inline-flex; align-items:center; gap:3px; background:#F3F4F6; border:1px solid #E5E7EB; border-radius:6px; padding:2px 7px; font-size:10.5px; font-weight:600; color:#4B5563; margin-bottom:6px; }
    .product-price-line { display:flex; align-items:center; justify-content:space-between; font-size:12px; }
    .product-qty-text { color:var(--color-secondary-muted); font-weight:500; }
    .product-total-text { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; color:var(--color-primary); font-size:13px; }
    .summary-total-box { padding:14px 16px; border-top:1px dashed var(--color-border); }
    .summary-row { display:flex; align-items:center; justify-content:space-between; font-size:12.5px; margin-bottom:7px; color:var(--color-secondary-muted); }
    .summary-row-val { font-weight:600; color:var(--color-secondary); }
    .summary-divider { height:1px; background:var(--color-border); margin:8px 0; }
    .summary-total-row { display:flex; align-items:center; justify-content:space-between; }
    .summary-total-label { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:14px; color:var(--color-secondary); }
    .summary-total-amount { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:18px; color:var(--color-primary); }
    .shipping-note-chip { background:#FEF3C7; border:1px solid #FDE68A; border-radius:9999px; padding:3px 10px; font-size:11px; font-weight:600; color:#92400E; }
    .status-timeline { padding:14px 16px; display:flex; flex-direction:column; }
    .timeline-item { display:flex; gap:12px; position:relative; }
    .timeline-item:not(:last-child)::before { content:''; position:absolute; left:11px; top:22px; width:2px; height:calc(100% - 4px); background:var(--color-border); }
    .timeline-dot { width:24px; height:24px; border-radius:50%; background:var(--color-border); border:2px solid #fff; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:10px; color:#9CA3AF; position:relative; z-index:1; }
    .timeline-dot.done { background:#10B981; color:#fff; }
    .timeline-dot.current { background:#BE0017; color:#fff; box-shadow:0 0 0 3px rgba(190,0,23,0.15); }
    .timeline-content { padding-bottom:16px; }
    .timeline-label { font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:12.5px; color:var(--color-secondary); margin-bottom:1px; }
    .timeline-sublabel { font-size:11px; color:var(--color-secondary-muted); }
    .action-buttons-area { margin:16px 16px 0; display:flex; flex-direction:column; gap:10px; }
    .btn-wa-contact { width:100%; background:#25D366; color:#fff !important; font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:14px; padding:13px 18px; border-radius:var(--radius-pill); border:none; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 14px rgba(37,211,102,0.3); cursor:pointer; transition:all 0.2s ease; text-decoration:none !important; }
    .btn-wa-contact:hover { background:#128C7E; transform:translateY(-1px); }
    .btn-back-list { width:100%; background:#F9FAFB; color:var(--color-secondary) !important; font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13px; padding:11px 18px; border-radius:var(--radius-pill); border:1px solid var(--color-border); display:flex; align-items:center; justify-content:center; gap:7px; cursor:pointer; transition:all 0.2s ease; text-decoration:none !important; }
    .btn-back-list:hover { background:#F3F4F6; border-color:#D1D5DB; }
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
            'Draft'   => 'Pesanan Diterima',
            'Process' => 'Diproses',
            'Done'    => 'Selesai',
            default   => $sale->inv_status ?? '-',
        };
        $invDesc = $sale->inv_desc ?? '';
        $recipientName  = $sale->customer_name  ?? '-';
        $recipientPhone = $sale->customer_phone ?? '-';
        $shippingAddress = '-';
        if (!empty($invDesc)) {
            if (preg_match('/Nama Penerima:\s*(.+)/m', $invDesc, $m)) $recipientName  = trim($m[1]);
            if (preg_match('/No\. WhatsApp:\s*(.+)/m', $invDesc, $m)) $recipientPhone = trim($m[1]);
            if (preg_match('/Alamat Pengiriman:\s*\n(.*?)(?=\n===|\z)/s', $invDesc, $m)) $shippingAddress = trim($m[1]);
        }
        $waMsg  = "*KONFIRMASI PESANAN - TOKO KOPI TANJOE*\n----------------------------------------\n";
        $waMsg .= "*No. Invoice:* {$sale->inv_code}\n*Penerima:* {$recipientName}\n*No. WA:* {$recipientPhone}\n";
        $waMsg .= "----------------------------------------\nHalo Admin Tanjoe, saya ingin menanyakan info ongkir dan instruksi pembayaran untuk invoice *{$sale->inv_code}*. Terima kasih!";
        $waUrl     = 'https://wa.me/6285974607547?text=' . urlencode($waMsg);
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
                <i class="fe fe-{{ $sale->inv_status_payment === 'paid' ? 'check-circle' : 'clock' }}" style="font-size:12px;"></i>
                {{ $statusPayLabel['label'] }}
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
                @if(in_array($sale->inv_status, ['Process', 'Done']))
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
                @if($sale->inv_status_payment === 'paid')
                    <div class="timeline-dot done"><i class="fe fe-check" style="font-size:10px;"></i></div>
                @else
                    <div class="timeline-dot"><i class="fe fe-minus" style="font-size:10px;"></i></div>
                @endif
                <div class="timeline-content">
                    <div class="timeline-label">Pembayaran</div>
                    <div class="timeline-sublabel">Konfirmasi transfer ke rekening Toko Kopi Tanjoe</div>
                </div>
            </div>
            <div class="timeline-item">
                @if($sale->inv_status === 'Done')
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

    <div class="action-buttons-area">
        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn-wa-contact" id="btnContactAdminWa">
            <i class="fe fe-message-circle"></i>
            <span>Hubungi Admin via WhatsApp</span>
        </a>
        <a href="{{ route('transaction.history') }}" class="btn-back-list" id="btnBackToHistory">
            <i class="fe fe-list"></i>
            <span>Lihat Semua Pesanan</span>
        </a>
    </div>

    @else
    <div style="text-align:center; padding:80px 24px 40px;">
        <i class="fe fe-alert-circle" style="font-size:52px; color:var(--color-primary); display:block; margin-bottom:16px;"></i>
        <h2 style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:20px; margin-bottom:8px;">Pesanan Tidak Ditemukan</h2>
        <p style="color:var(--color-secondary-muted); font-size:13px; margin-bottom:24px;">Invoice yang Anda cari tidak tersedia atau sudah dihapus.</p>
        <a href="{{ route('transaction.history') }}" class="btn-back-list" style="display:inline-flex; width:auto; padding:11px 28px;">
            <i class="fe fe-arrow-left"></i>
            <span>Kembali ke Riwayat Pesanan</span>
        </a>
    </div>
    @endif

</div>

</x-layouts.public>
