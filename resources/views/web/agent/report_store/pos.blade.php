<x-layouts.app :hideBottomMenu="true">
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('home')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>

@if(session()->has('danger'))
<script>
    $(function () {
        notif({ msg: "{{ session('danger') }}", type: "error", position: "center" });
    });
</script>
@endif

@if(session()->has('success'))
<script>
    $(function () {
        notif({ msg: "{{ session('success') }}", type: "success", position: "center" });
    });
</script>
@endif

<style>
/* ── POS Layout ── */
.pos-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 56px);
    background: #f4f6fb;
}

/* Header info bar */
.pos-meta {
    background: #fff;
    border-bottom: 1px solid #e8eaf0;
    padding: 10px 16px 8px;
}
.pos-meta .form-control,
.pos-meta .form-select {
    font-size: 13px;
    border-radius: 8px;
    border: 1px solid #dde1ec;
    padding: 6px 10px;
    background: #f8f9fc;
}
.pos-meta label { font-size: 11px; color: #888; margin-bottom: 2px; font-weight: 600; }

/* Product Grid */
.pos-products {
    flex: 1;
    overflow-y: auto;
    padding: 12px 12px 0;
}
.product-card {
    background: #fff;
    border-radius: 12px;
    padding: 12px 10px;
    margin-bottom: 10px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    transition: transform 0.1s, box-shadow 0.1s;
    border: 2px solid transparent;
}
.product-card:active { transform: scale(0.97); }
.product-card.in-cart { border-color: #10b981; }
.product-card .prod-name { font-size: 13px; font-weight: 600; color: #1e2a3a; margin-bottom: 2px; }
.product-card .prod-price { font-size: 12px; color: #10b981; font-weight: 700; }
.btn-add-product {
    width: 32px; height: 32px;
    border-radius: 50%;
    border: none;
    background: #10b981;
    color: #fff;
    font-size: 18px;
    line-height: 1;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    cursor: pointer;
    transition: background 0.15s;
}
.btn-add-product:hover { background: #059669; }
.product-action { display: flex; align-items: center; gap: 8px; }
.qty-badge { border-radius: 8px; padding: 4px 8px; font-size: 11px; }

/* Cart Panel */
.pos-cart {
    background: #fff;
    border-top: 1px solid #e8eaf0;
    border-radius: 20px 20px 0 0;
    padding: 14px 16px 6px;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
    max-height: 45vh;
    display: flex;
    flex-direction: column;
}
.pos-cart-title {
    font-size: 13px;
    font-weight: 700;
    color: #1e2a3a;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.cart-badge {
    background: #10b981;
    color: #fff;
    border-radius: 20px;
    font-size: 11px;
    padding: 2px 8px;
    font-weight: 700;
}
.cart-items { overflow-y: auto; flex: 1; }
.cart-item {
    display: flex;
    align-items: center;
    padding: 6px 0;
    border-bottom: 1px solid #f1f3f7;
    gap: 8px;
}
.cart-item-name { font-size: 12px; font-weight: 600; color: #1e2a3a; flex: 1; }
.cart-item-sub  { font-size: 11px; color: #888; }
.qty-ctrl { display: flex; align-items: center; gap: 6px; }
.qty-btn {
    width: 24px; height: 24px;
    border-radius: 50%;
    border: 1px solid #dde1ec;
    background: #f4f6fb;
    font-size: 14px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    line-height: 1;
    transition: background 0.1s;
}
.qty-btn:hover { background: #e2e6ee; }
.qty-val { font-size: 13px; font-weight: 700; min-width: 18px; text-align: center; }
.cart-item-total { font-size: 12px; font-weight: 700; color: #1e2a3a; min-width: 70px; text-align: right; }

/* Cart Footer */
.cart-footer { padding-top: 10px; }
.cart-total-row {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 10px;
}
.cart-total-label { font-size: 13px; color: #555; }
.cart-total-val   { font-size: 17px; font-weight: 800; color: #10b981; }

/* Payment method */
.pay-method-row { display: flex; gap: 8px; margin-bottom: 10px; }
.pay-method-btn {
    flex: 1;
    padding: 8px 4px;
    border-radius: 10px;
    border: 2px solid #dde1ec;
    background: #f8f9fc;
    font-size: 12px;
    font-weight: 600;
    color: #555;
    text-align: center;
    cursor: pointer;
    transition: all 0.15s;
}
.pay-method-btn.active {
    border-color: #10b981;
    background: #ecfdf5;
    color: #10b981;
}

.btn-checkout {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 13px;
    font-size: 15px;
    font-weight: 700;
    width: 100%;
    cursor: pointer;
    letter-spacing: 0.3px;
    transition: opacity 0.15s;
}
.btn-checkout:disabled { opacity: 0.5; cursor: not-allowed; }
.btn-checkout:not(:disabled):active { opacity: 0.85; }

.empty-cart { text-align: center; color: #bbb; font-size: 12px; padding: 10px 0; }
</style>

<div class="pos-wrapper">
    {{-- Meta bar --}}
    <div class="pos-meta">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <div class="font-weight-bold fs-14" style="color:#1e2a3a;">Shift: {{ \App\Models\ShiftStore::find($activeSession->shift_id)->name ?? '-' }}</div>
                <div class="text-muted fs-12">Barista: {{ \App\Models\Employee::find($activeSession->employee_id)->name ?? '-' }}</div>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#modal-transactions">
                    <i class="fe fe-list"></i> Transaksi
                </button>
                <a href="{{ url('pos-close-shift/'.$activeSession->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Tutup shift ini dan buat laporan?')">Tutup Shift</a>
            </div>
        </div>
    </div>

    {{-- Product list --}}
    <div class="pos-products" id="product-list">
        @forelse($products as $p)
        <div class="product-card" id="pc-{{ $p->id }}"
             onclick="addToCart({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->price }})"
             data-id="{{ $p->id }}"
             data-name="{{ $p->name }}"
             data-price="{{ $p->price }}">
            <div class="product-info">
                <div class="prod-name">{{ $p->name }}</div>
                <div class="prod-price">Rp {{ number_format($p->price, 0, ',', '.') }}</div>
            </div>
            <div class="product-action">
                <span class="badge badge-success qty-badge d-none" id="qty-badge-{{ $p->id }}">0</span>
                <button type="button" class="btn-add-product">+</button>
            </div>
        </div>
        @empty
        <p class="text-center text-muted mt-4">Tidak ada produk aktif.</p>
        @endforelse
    </div>

    {{-- Cart Panel --}}
    <div class="pos-cart">
        <div class="pos-cart-title">
            <span><i class="fe fe-shopping-cart mr-1"></i> Keranjang</span>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-outline-warning mr-2 py-0 px-2 fs-11" onclick="holdCart()" id="btn-hold" disabled><i class="fe fe-pause"></i> Hold</button>
                <button type="button" class="btn btn-sm btn-outline-info mr-2 py-0 px-2 fs-11" onclick="showHeldCarts()"><i class="fe fe-list"></i> Hold List (<span id="held-count">0</span>)</button>
                <span class="cart-badge" id="cart-count">0 item</span>
            </div>
        </div>
        <div class="cart-items" id="cart-items">
            <div class="empty-cart" id="empty-cart">Belum ada produk dipilih</div>
        </div>
        <div class="cart-footer">
            <div class="cart-total-row">
                <span class="cart-total-label">Total</span>
                <span class="cart-total-val" id="cart-total">Rp 0</span>
            </div>
            <button type="button" class="btn-checkout" id="btn-checkout" disabled onclick="window.location.href='{{ url('pos-payment') }}'">
                <i class="fe fe-arrow-right-circle mr-1"></i> Bayar Sekarang
            </button>
        </div>
    </div>
</div>

<!-- Modal Transactions -->
<div class="modal fade" id="modal-transactions" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Riwayat Transaksi Shift Ini</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="max-height: 60vh; overflow-y: auto;">
                <table class="table table-striped mb-0 fs-12">
                    <thead class="bg-light">
                        <tr>
                            <th>Waktu</th>
                            <th>No. Struk</th>
                            <th>Total</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td>{{ $trx->created_at->format('H:i') }}</td>
                            <td>{{ $trx->receipt_no }}</td>
                            <td>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                            <td><span class="badge badge-info">{{ strtoupper($trx->payment_method) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-muted">Belum ada transaksi di shift ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hold Carts -->
<div class="modal fade" id="modal-held-carts" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0">Pesanan Tersimpan (Hold)</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" id="held-carts-container" style="max-height: 60vh; overflow-y: auto;">
            </div>
        </div>
    </div>
</div>

<script>
const CART_KEY = 'pos_cart';
const HELD_KEY = 'pos_held_carts';
let heldCarts = [];
const META_KEY = 'pos_meta';

let cart      = {};
let payMethod = 'cash';

/* ════════════════════════════════════════
   LocalStorage helpers
════════════════════════════════════════ */
function saveCart() {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
}

function loadCart() {
    try {
        const raw = localStorage.getItem(CART_KEY);
        cart = raw ? JSON.parse(raw) : {};
    } catch(e) {
        cart = {};
    }
}

function clearStorage() {
    localStorage.removeItem(CART_KEY);
}

/* ════════════════════════════════════════
   Cart operations
════════════════════════════════════════ */
function addToCart(id, name, price) {
    id = String(id);
    if (cart[id]) {
        cart[id].qty++;
    } else {
        cart[id] = { name: name, price: Number(price), qty: 1 };
    }
    saveCart();
    renderCart();
    highlightCard(id);
}

function changeQty(id, delta) {
    id = String(id);
    if (!cart[id]) return;
    cart[id].qty += delta;
    if (cart[id].qty <= 0) {
        delete cart[id];
        let pc = document.getElementById('pc-' + id);
        if (pc) pc.classList.remove('in-cart');
    }
    saveCart();
    renderCart();
}

function highlightCard(id) {
    document.querySelectorAll('.product-card').forEach(function(el) {
        const pid = el.dataset.id;
        const badge = document.getElementById('qty-badge-' + pid);
        if (cart[pid]) {
            el.classList.add('in-cart');
            if (badge) {
                badge.textContent = cart[pid].qty;
                badge.classList.remove('d-none');
            }
        } else {
            el.classList.remove('in-cart');
            if (badge) {
                badge.classList.add('d-none');
            }
        }
    });
}

/* ════════════════════════════════════════
   Render cart
════════════════════════════════════════ */
function renderCart() {
    const itemsEl = document.getElementById('cart-items');
    const emptyEl = document.getElementById('empty-cart');
    const countEl = document.getElementById('cart-count');
    const totalEl = document.getElementById('cart-total');
    const btnEl   = document.getElementById('btn-checkout');

    const keys = Object.keys(cart);
    let totalQty = 0, totalAmt = 0;

    // remove old rows
    itemsEl.querySelectorAll('.cart-item').forEach(function(el) { el.remove(); });

    if (keys.length === 0) {
        emptyEl.style.display = '';
        countEl.textContent   = '0 item';
        totalEl.textContent   = 'Rp 0';
        btnEl.disabled        = true;
        document.getElementById('btn-hold').disabled = true;
        return;
    }

    emptyEl.style.display = 'none';
    btnEl.disabled        = false;
    document.getElementById('btn-hold').disabled = false;

    keys.forEach(function(id) {
        const item = cart[id];
        const sub  = item.price * item.qty;
        totalQty  += item.qty;
        totalAmt  += sub;

        const row = document.createElement('div');
        row.className = 'cart-item';
        row.id = 'ci-' + id;
        row.innerHTML =
            '<div style="flex:1">' +
                '<div class="cart-item-name">' + item.name + '</div>' +
                '<div class="cart-item-sub">Rp ' + formatNum(item.price) + ' / item</div>' +
            '</div>' +
            '<div class="qty-ctrl">' +
                '<div class="qty-btn" onclick="changeQty(' + id + ', -1)">−</div>' +
                '<div class="qty-val">' + item.qty + '</div>' +
                '<div class="qty-btn" onclick="changeQty(' + id + ', 1)">+</div>' +
            '</div>' +
            '<div class="cart-item-total">Rp ' + formatNum(sub) + '</div>';
        itemsEl.appendChild(row);
    });

    countEl.textContent = totalQty + ' item';
    totalEl.textContent = 'Rp ' + formatNum(totalAmt);

    // update product card highlights
    highlightCard(null);
}

/* ════════════════════════════════════════
   Clear cart button
════════════════════════════════════════ */
function clearCart() {
    if (!confirm('Kosongkan keranjang?')) return;
    cart = {};
    saveCart();
    renderCart();
    document.querySelectorAll('.product-card').forEach(function(el) {
        el.classList.remove('in-cart');
    });
}

/* ════════════════════════════════════════
   Hold Cart Features
════════════════════════════════════════ */
function loadHeldCarts() {
    try {
        const raw = localStorage.getItem(HELD_KEY);
        heldCarts = raw ? JSON.parse(raw) : [];
    } catch(e) {
        heldCarts = [];
    }
    updateHeldCount();
}

function saveHeldCarts() {
    localStorage.setItem(HELD_KEY, JSON.stringify(heldCarts));
    updateHeldCount();
}

function updateHeldCount() {
    document.getElementById('held-count').textContent = heldCarts.length;
}

function holdCart() {
    if (Object.keys(cart).length === 0) return;
    let totalAmt = 0;
    Object.values(cart).forEach(function(i) { totalAmt += i.price * i.qty; });
    
    const name = prompt('Masukkan nama pelanggan / catatan pesanan:', 'Pelanggan ' + (heldCarts.length + 1));
    if (name === null) return; // user clicked cancel
    
    heldCarts.push({
        name: name || 'Tanpa Nama',
        time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}),
        cart: JSON.parse(JSON.stringify(cart)),
        total: totalAmt
    });
    
    saveHeldCarts();
    cart = {};
    saveCart();
    renderCart();
}

function showHeldCarts() {
    const container = document.getElementById('held-carts-container');
    container.innerHTML = '';
    
    if (heldCarts.length === 0) {
        container.innerHTML = '<div class="p-4 text-center text-muted">Belum ada pesanan yang di-hold.</div>';
    } else {
        heldCarts.forEach(function(held, index) {
            container.innerHTML +=
                '<div class="d-flex align-items-center justify-content-between p-3 border-bottom">' +
                    '<div>' +
                        '<div class="font-weight-bold fs-14">' + held.name + '</div>' +
                        '<div class="text-muted fs-12"><i class="fe fe-clock"></i> ' + held.time + ' — Rp ' + formatNum(held.total) + '</div>' +
                    '</div>' +
                    '<div class="d-flex">' +
                        '<button type="button" class="btn btn-sm btn-success mr-1" onclick="restoreHeldCart(' + index + ')"><i class="fe fe-check"></i> Buka</button>' +
                        '<button type="button" class="btn btn-sm btn-danger" onclick="deleteHeldCart(' + index + ')"><i class="fe fe-trash"></i></button>' +
                    '</div>' +
                '</div>';
        });
    }
    
    $('#modal-held-carts').modal('show');
}

function restoreHeldCart(index) {
    if (Object.keys(cart).length > 0) {
        if (!confirm('Keranjang Anda saat ini tidak kosong! Menimpa keranjang saat ini dengan pesanan Hold?')) {
            return;
        }
    }
    cart = JSON.parse(JSON.stringify(heldCarts[index].cart));
    saveCart();
    renderCart();
    
    // Remove from array after restoring
    heldCarts.splice(index, 1);
    saveHeldCarts();
    
    $('#modal-held-carts').modal('hide');
}

function deleteHeldCart(index) {
    if (!confirm('Hapus pesanan tertunda ini?')) return;
    heldCarts.splice(index, 1);
    saveHeldCarts();
    showHeldCarts(); // refresh modal
}

/* ════════════════════════════════════════
   Helpers
════════════════════════════════════════ */
function formatNum(n) {
    return Number(n).toLocaleString('id-ID');
}

/* ════════════════════════════════════════
   Init on page load
════════════════════════════════════════ */
$(document).ready(function () {
    @if(session('success'))
        localStorage.removeItem(CART_KEY);
        cart = {};
        notif({
            msg: "<b>Success:</b> {{ session('success') }}",
            type: "success"
        });
    @endif

    // restore cart from localStorage
    loadCart();
    loadHeldCarts();
    renderCart();
});
</script>
</x-layouts.app>
