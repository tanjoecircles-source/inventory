<x-layouts.public metatitle="Instruksi Pembayaran" metadesc="Instruksi Pembayaran - Toko Kopi Tanjoe Artisan Roastery">

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
        --radius-sm: 5px; --radius-md: 12px; --radius-lg: 16px; --radius-pill: 9999px;
    }
    body { background-color: var(--color-surface) !important; color: var(--color-secondary); font-family: 'Inter', sans-serif; }
    .pay-wrapper { max-width: 600px; margin: 0 auto; padding-bottom: 40px; min-height: 100vh; }

    /* Header */
    .pay-top-header { position:sticky; top:0; z-index:100; background:#fff; border-bottom:1px solid var(--color-border); padding:12px 16px; display:flex; align-items:center; gap:12px; box-shadow:0 1px 4px rgba(0,0,0,0.03); }
    .pay-back-btn { width:36px; height:36px; border-radius:50%; background:#F4EFE6; border:1px solid var(--color-border); display:flex; align-items:center; justify-content:center; color:var(--color-secondary); font-size:18px; text-decoration:none !important; transition:all 0.2s; flex-shrink:0; }
    .pay-back-btn:hover { background:#ECE7DE; color:var(--color-primary); }
    .pay-header-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:17px; color:var(--color-secondary); margin:0; }

    /* Invoice chip */
    .pay-inv-chip { margin:8px 8px 0; background:#fff; border:1px solid var(--color-border); border-radius:var(--radius-sm); padding:12px 16px; display:flex; align-items:center; justify-content:space-between; box-shadow:var(--shadow-card); }
    .pay-inv-code { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:13px; color:var(--color-secondary); display:flex; align-items:center; gap:6px; }
    .pay-inv-badge { background:#EDE9FE; color:#5B21B6; border-radius:var(--radius-pill); padding:3px 10px; font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:11px; }

    /* Total banner */
    .pay-total-banner { margin:8px 8px 0; background:linear-gradient(135deg,#1F2429 0%,#374151 100%); border-radius:var(--radius-sm); padding:16px 18px; display:flex; align-items:center; justify-content:space-between; }
    .pay-total-label { font-size:12px; color:rgba(255,255,255,0.65); margin-bottom:3px; }
    .pay-total-amount { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:22px; color:#fff; }

    /* Card rekening */
    .pay-card { margin:8px 8px 0; background:#fff; border:1px solid var(--color-border); border-radius:var(--radius-sm); box-shadow:var(--shadow-card); overflow:hidden; }
    .pay-card-header { display:flex; align-items:center; gap:10px; padding:12px 16px; border-bottom:1px solid #F3EFE7; background:#FCFAF7; }
    .pay-card-icon { width:30px; height:30px; border-radius:9px; background:#FEF3C7; color:#92400E; display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0; }
    .pay-card-title { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:13px; color:var(--color-secondary); margin:0; }
    .bank-item { display:flex; align-items:center; gap:14px; padding:14px 16px; border-bottom:1px solid #F3EFE7; }
    .bank-item:last-child { border-bottom:none; }
    .bank-logo { width:72px; flex-shrink:0; }
    .bank-logo img { max-width:100%; height:26px; object-fit:contain; }
    .bank-info-label { font-size:11px; color:var(--color-secondary-muted); margin-bottom:2px; }
    .bank-info-an { font-size:12px; color:var(--color-secondary); margin-bottom:5px; }
    .bank-acc-row { display:flex; align-items:center; gap:8px; }
    .bank-acc-no { font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:17px; color:var(--color-secondary); letter-spacing:0.03em; }
    .btn-copy { background:#F3F4F6; border:1px solid #E5E7EB; border-radius:6px; padding:3px 10px; font-size:11px; font-weight:600; color:#4B5563; cursor:pointer; transition:all 0.15s; }
    .btn-copy:hover { background:#E5E7EB; }

    /* Note */
    .pay-note { margin:10px 16px 0; font-size:11.5px; color:var(--color-secondary-muted); line-height:1.55; }

    /* CTA */
    .pay-cta-area { margin:16px 16px 0; }
    .btn-confirm-payment { width:100%; background:linear-gradient(135deg,#BE0017 0%,#E62129 100%); color:#fff !important; font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:14px; padding:14px 18px; border-radius:var(--radius-pill); border:none; display:flex; align-items:center; justify-content:center; gap:8px; box-shadow:0 4px 16px rgba(190,0,23,0.3); cursor:pointer; transition:all 0.2s; text-decoration:none !important; }
    .btn-confirm-payment:hover { opacity:0.92; transform:translateY(-1px); }
    .confirm-sub { text-align:center; font-size:11px; color:var(--color-secondary-muted); margin-top:7px; }
    .btn-back-detail { width:100%; margin-top:10px; background:#F9FAFB; color:var(--color-secondary) !important; font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:13px; padding:11px 18px; border-radius:var(--radius-pill); border:1px solid var(--color-border); display:flex; align-items:center; justify-content:center; gap:7px; transition:all 0.2s; text-decoration:none !important; }
    .btn-back-detail:hover { background:#F3F4F6; }
</style>

@php
    $formatRupiah = fn($n) => 'Rp ' . number_format((float)$n, 0, ',', '.');
    $custName = $sale->customer_name ?? 'Pelanggan';

    $waMsg  = "*KONFIRMASI PEMBAYARAN - TOKO KOPI TANJOE*\n";
    $waMsg .= "No. Invoice: *{$sale->inv_code}*\n";
    $waMsg .= "Nama: {$custName}\n";
    $waMsg .= "Total: *" . $formatRupiah($sale->inv_total ?? 0) . "*\n\n";
    $waMsg .= "Saya telah melakukan pembayaran. Terlampir bukti transfer. Mohon dikonfirmasi. Terima kasih!";
    $waUrl  = 'https://wa.me/6285974607547?text=' . urlencode($waMsg);
@endphp

<div class="pay-wrapper">

    {{-- Header --}}
    <div class="pay-top-header">
        <a href="{{ route('transaction.history.detail', $sale->id) }}" class="pay-back-btn">
            <i class="fe fe-arrow-left"></i>
        </a>
        <h1 class="pay-header-title">Instruksi Pembayaran</h1>
    </div>

    {{-- Invoice chip --}}
    <div class="pay-inv-chip">
        <div class="pay-inv-code">
            <i class="fe fe-file-text" style="color:var(--color-primary);"></i>
            {{ $sale->inv_code }}
        </div>
        <span class="pay-inv-badge">Menunggu Pembayaran</span>
    </div>

    {{-- Total --}}
    <div class="pay-total-banner">
        <div>
            <div class="pay-total-label">Total yang harus dibayar</div>
            <div class="pay-total-amount">{{ $formatRupiah($sale->inv_total ?? 0) }}</div>
        </div>
        <i class="fe fe-credit-card" style="color:rgba(255,255,255,0.25); font-size:32px;"></i>
    </div>

    {{-- Rekening --}}
    <div class="pay-card">
        <div class="pay-card-header">
            <div class="pay-card-icon"><i class="fe fe-credit-card"></i></div>
            <p class="pay-card-title">Transfer ke Rekening Berikut</p>
        </div>

        {{-- BCA --}}
        <div class="bank-item">
            <div class="bank-logo">
                <img src="{{ asset('assets/images/png/bca.png') }}" alt="BCA">
            </div>
            <div class="flex-fill">
                <div class="bank-info-label">Bank Central Asia (BCA)</div>
                <div class="bank-info-an">a.n. <strong>Muhammad Rizki Awayna</strong></div>
                <div class="bank-acc-row">
                    <span class="bank-acc-no">7780 106578</span>
                    <button class="btn-copy" onclick="copyAcc('7780106578', this)">Salin</button>
                </div>
            </div>
        </div>

        {{-- Mandiri --}}
        <div class="bank-item">
            <div class="bank-logo">
                <img src="{{ asset('assets/images/png/mandiri.png') }}" alt="Mandiri">
            </div>
            <div class="flex-fill">
                <div class="bank-info-label">Bank Mandiri</div>
                <div class="bank-info-an">a.n. <strong>Suhendra Juniar Azhari</strong></div>
                <div class="bank-acc-row">
                    <span class="bank-acc-no">1370011890809</span>
                    <button class="btn-copy" onclick="copyAcc('1370011890809', this)">Salin</button>
                </div>
            </div>
        </div>
    </div>

    <p class="pay-note">
        <i class="fe fe-info" style="font-size:11px;"></i>
        Setelah transfer, kirim bukti pembayaran via WhatsApp dengan menekan tombol di bawah. Admin akan mengkonfirmasi dalam 1×24 jam.
    </p>

    {{-- CTA --}}
    <div class="pay-cta-area">
        <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn-confirm-payment">
            <i class="fe fe-check-circle"></i>
            <span>Konfirmasi Pembayaran</span>
        </a>
        <p class="confirm-sub">
            <i class="fe fe-message-circle" style="font-size:11px;"></i>
            Kirim bukti transfer via WhatsApp
        </p>
        <a href="{{ route('transaction.history.detail', $sale->id) }}" class="btn-back-detail">
            <i class="fe fe-arrow-left"></i>
            <span>Kembali ke Detail Pesanan</span>
        </a>
    </div>

</div>

<script>
function copyAcc(text, btn) {
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
</script>

</x-layouts.public>
