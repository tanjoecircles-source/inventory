<x-layouts.public metatitle="Keranjang Belanja | Toko Kopi Tanjoe" metadesc="Keranjang Belanja Toko Kopi Tanjoe - Artisan Coffee Roastery">

<link rel="stylesheet" href="{{ asset('assets/css/shop.css?v=1.0') }}">

<style>
    .cart-page-wrap {
        max-width: 600px;
        margin: 0 auto;
        padding-bottom: 100px;
        min-height: 100vh;
        background-color: var(--color-surface, #FAF8F5);
        position: relative;
    }
    .cart-nav-top {
        position: sticky;
        top: 0;
        z-index: 100;
        background: rgba(250, 248, 245, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 8px;
        border-bottom: 1px solid rgba(236, 231, 222, 0.7);
    }
    .btn-back-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #FFFFFF;
        border: 1px solid var(--color-border, #ECE7DE);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-secondary, #1F2429);
        font-size: 17px;
        text-decoration: none !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-back-circle:hover {
        background: #F4EFE6;
        color: var(--color-primary, #E62129);
    }
</style>

<div class="cart-page-wrap">
    
    <!-- 1. Top Navigation Bar -->
    <div class="cart-nav-top">
        <div class="d-flex align-items-center">
            <a href="{{ route('shop') }}" class="btn-back-circle mr-3" title="Kembali ke Katalog">
                <i class="fe fe-arrow-left"></i>
            </a>
            <div class="cart-title-main">
                <i class="fe fe-shopping-bag mr-1"></i>
                <span>Keranjang Belanja</span>
            </div>
        </div>
        <span class="cart-items-count-pill" id="cartTotalItemsCountBadge">0 Barang</span>
    </div>

    <div class="p-2">
        <!-- 2. Select All & Delete All Bar -->
        <div class="cart-select-all-row" id="cartSelectAllRow">
            <label class="custom-cart-checkbox mb-0">
                <input type="checkbox" id="selectAllCartCheckbox" checked>
                <div class="checkbox-box"><i class="fe fe-check"></i></div>
                <span id="selectAllLabel">Pilih Semua (0)</span>
            </label>
            <button type="button" class="btn-clear-all-cart" id="btnClearAllCart">
                <i class="fe fe-trash-2"></i> Hapus Semua
            </button>
        </div>

        <!-- 3. Cart Items Stream List -->
        <div id="cartItemsListStream">
            <!-- Dynamically populated from JS -->
        </div>

        <!-- 4. Empty Cart State -->
        <div id="emptyCartDisplay" class="text-center py-5 d-none">
            <div style="width: 70px; height: 70px; border-radius: 50%; background: #F4EFE6; color: #8C6D46; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 16px;">
                <i class="fe fe-shopping-bag"></i>
            </div>
            <h5 class="font-heading font-weight-bold mb-1">Keranjang Anda masih kosong</h5>
            <p class="text-muted fs-12 mb-3">Jelajahi koleksi roasted beans artisanal kami dan pilih seduhan favorit Anda.</p>
            <a href="{{ route('shop') }}" class="btn btn-dark btn-sm rounded-pill px-4 font-weight-bold shadow-sm">
                <i class="fe fe-coffee mr-1"></i> Mulai Belanja Kopi
            </a>
        </div>

        <!-- 5. Ringkasan Pesanan (Order Summary Card) -->
        <div class="order-summary-card" id="orderSummaryCard">
            <h4 class="order-summary-title">Ringkasan Pesanan</h4>
            <div class="summary-row">
                <span class="text-muted" id="summaryTotalItemsLabel">Total Harga (0 barang)</span>
                <span class="font-weight-bold" id="summaryRawSubtotal">Rp 0</span>
            </div>
            <div class="summary-row ongkir-row">
                <span class="text-muted">Estimasi Ongkir</span>
                <span class="summary-val text-muted">Dihitung saat checkout</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-total-row">
                <span>Total Tagihan</span>
                <span class="summary-total-price" id="summaryGrandTotal">Rp 0</span>
            </div>
        </div>
    </div>

    <!-- 6. Sticky Checkout Bar -->
    <div class="sticky-checkout-bar" id="cartStickyCheckoutBar">
        <div class="checkout-total-col">
            <span class="checkout-sub-label">Total Belanja</span>
            <div class="checkout-total-val" id="stickyTotalBelanja">Rp 0</div>
        </div>
        <button type="button" class="btn btn-primary" id="btnGoToCheckout">
            <i class="fe fe-shopping-cart"></i> <span id="checkoutBtnLabel">Checkout (0)</span>
        </button>
    </div>

</div>

<!-- Cart Toast Alert -->
<div id="cartToast" class="cart-toast">
    <i class="fe fe-check-circle text-success fs-16"></i>
    <span id="cartToastText">Keranjang diperbarui!</span>
</div>

<script>
$(document).ready(function() {
    // Delegate all cart operations to TanjoeCart
    function getCart() { return window.TanjoeCart ? TanjoeCart.getCart() : []; }
    function saveCart(cart) { if (window.TanjoeCart) TanjoeCart.saveCart(cart); }
    function formatRupiah(num) { return window.TanjoeCart ? TanjoeCart.formatRupiah(num) : 'Rp ' + num; }
    function showCartToast(msg) { if (window.TanjoeCart) TanjoeCart.showToast(msg); }

    // Render Cart Items
    function renderCartView() {
        var cart = getCart();
        var $stream = $('#cartItemsListStream');
        $stream.empty();

        if (cart.length === 0) {
            $('#emptyCartDisplay').removeClass('d-none');
            $('#cartSelectAllRow').addClass('d-none');
            $('#orderSummaryCard').addClass('d-none');
            $('#cartStickyCheckoutBar').addClass('d-none');
            $('#cartTotalItemsCountBadge').text('0 Barang');
            return;
        }

        $('#emptyCartDisplay').addClass('d-none');
        $('#cartSelectAllRow').removeClass('d-none');
        $('#orderSummaryCard').removeClass('d-none');
        $('#cartStickyCheckoutBar').removeClass('d-none');

        var totalItemsCount = 0;
        var selectedItemsCount = 0;
        var rawSubtotal = 0;
        var allSelected = true;

        cart.forEach(function(item, index) {
            var qty = (parseInt(item.quantity) || 1);
            var isChecked = item.selected !== false;
            var basePrice = parseFloat(item.price) || 0;
            var unitPrice = window.TanjoeCart ? TanjoeCart.getEffectiveUnitPrice(item, qty) : basePrice;
            var isDiscounted = (unitPrice < basePrice && basePrice > 0);
            var itemTotalPrice = unitPrice * qty;
            var itemOriginalTotalPrice = basePrice * qty;
            var badgeLabel = window.TanjoeCart ? TanjoeCart.getTierLabel(item, qty) : (String(item.type) === '1' ? 'Grosir' : 'Bundling');

            if (isChecked) {
                selectedItemsCount += qty;
                rawSubtotal += itemTotalPrice;
            } else {
                allSelected = false;
            }
            totalItemsCount += qty;

            var noteValue = item.note || '';

            var itemCardHtml = `
                <div class="cart-item-card" data-index="${index}">
                    <div class="cart-item-top">
                        <label class="custom-cart-checkbox mb-0">
                            <input type="checkbox" class="cart-item-checkbox" data-index="${index}" ${isChecked ? 'checked' : ''}>
                            <div class="checkbox-box"><i class="fe fe-check"></i></div>
                        </label>
                        <div class="cart-item-img-wrap">
                            <img src="${item.image || '{{ asset("assets/images/products/no-image.png") }}'}" alt="${item.name}">
                            <span class="cart-item-weight-tag">${item.weight || '200g'}</span>
                        </div>
                        <div class="cart-item-info">
                            <div class="cart-item-title-row">
                                <div class="cart-item-title" title="${item.name}">${item.name}</div>
                                <button type="button" class="btn-delete-cart-item btn-remove-item" data-index="${index}" title="Hapus dari keranjang">
                                    <i class="fe fe-trash-2"></i>
                                </button>
                            </div>
                            <div class="cart-item-origin-sub">${item.origin || 'Specialty Coffee'} • ${item.process || 'Artisanal'}</div>
                            <div class="cart-item-variant-pill">${item.variant || 'Whole Beans (Biji Utuh)'}</div>
                            <div class="cart-item-price-stepper-row">
                                <div>
                                    ${isDiscounted ? `
                                        <div class="d-flex align-items-center" style="gap: 4px; line-height: 1.1; margin-bottom: 0px;">
                                            <span style="font-size: 11px; color: #9CA3AF; text-decoration: line-through;">${formatRupiah(itemOriginalTotalPrice)}</span>
                                            <span class="badge badge-success px-2 py-1 rounded-pill" style="font-size: 9px; background: #10B981; color: #fff;margin:1px 0 1px;">${badgeLabel}</span>
                                        </div>
                                    ` : ''}
                                    <div class="cart-item-price ${isDiscounted ? 'text-success' : ''}">${formatRupiah(itemTotalPrice)}</div>
                                </div>
                                <div class="qty-stepper">
                                    <button type="button" class="qty-btn btn-cart-minus" data-index="${index}"><i class="fe fe-minus"></i></button>
                                    <input type="text" class="qty-input" value="${item.quantity}" readonly>
                                    <button type="button" class="qty-btn btn-cart-plus" data-index="${index}"><i class="fe fe-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cart-item-note-wrap">
                        <i class="fe fe-edit-2"></i>
                        <input type="text" class="cart-item-note-input" data-index="${index}" placeholder="Catatan gilingan / profil seduh (opsional)" value="${noteValue}">
                    </div>
                </div>
            `;
            $stream.append(itemCardHtml);
        });

        $('#cartTotalItemsCountBadge').text(totalItemsCount + ' Barang');
        $('#selectAllLabel').text(`Pilih Semua (${cart.length})`);
        $('#selectAllCartCheckbox').prop('checked', allSelected && cart.length > 0);

        $('#summaryTotalItemsLabel').text(`Total Harga (${selectedItemsCount} barang)`);
        $('#summaryRawSubtotal').text(formatRupiah(rawSubtotal));
        $('#summaryGrandTotal').text(formatRupiah(rawSubtotal));
        $('#stickyTotalBelanja').text(formatRupiah(rawSubtotal));
        $('#checkoutBtnLabel').text(`Checkout (${selectedItemsCount})`);

        if (selectedItemsCount === 0) {
            $('#btnGoToCheckout').prop('disabled', true).addClass('opacity-50');
        } else {
            $('#btnGoToCheckout').prop('disabled', false).removeClass('opacity-50');
        }
    }

    // Initial Render
    renderCartView();

    // Re-render when TanjoeCart fires updates (cross-tab / other pages)
    window.addEventListener('tanjoe:cart-updated', function() { renderCartView(); });

    // Qty Stepper Plus
    $(document).on('click', '.btn-cart-plus', function() {
        var idx = $(this).data('index');
        var cart = getCart();
        if (cart[idx]) {
            cart[idx].quantity = (parseInt(cart[idx].quantity) || 1) + 1;
            saveCart(cart);
        }
    });

    // Qty Stepper Minus
    $(document).on('click', '.btn-cart-minus', function() {
        var idx = $(this).data('index');
        var cart = getCart();
        if (cart[idx]) {
            if (cart[idx].quantity > 1) {
                cart[idx].quantity = parseInt(cart[idx].quantity) - 1;
                saveCart(cart);
            } else {
                if (confirm('Hapus ' + cart[idx].name + ' dari keranjang?')) {
                    cart.splice(idx, 1);
                    saveCart(cart);
                    showCartToast('Produk dihapus dari keranjang.');
                }
            }
        }
    });

    // Remove single item
    $(document).on('click', '.btn-remove-item', function() {
        var idx = $(this).data('index');
        var cart = getCart();
        if (cart[idx]) {
            var name = cart[idx].name;
            cart.splice(idx, 1);
            saveCart(cart);
            showCartToast(name + ' dihapus dari keranjang.');
        }
    });

    // Clear all items
    $('#btnClearAllCart').on('click', function() {
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh keranjang?')) {
            saveCart([]);
            showCartToast('Keranjang telah dikosongkan.');
        }
    });

    // Checkbox individual
    $(document).on('change', '.cart-item-checkbox', function() {
        var idx = $(this).data('index');
        var isChecked = $(this).is(':checked');
        var cart = getCart();
        if (cart[idx]) {
            cart[idx].selected = isChecked;
            saveCart(cart);
        }
    });

    // Select all checkbox
    $('#selectAllCartCheckbox').on('change', function() {
        var isChecked = $(this).is(':checked');
        var cart = getCart();
        cart.forEach(function(item) {
            item.selected = isChecked;
        });
        saveCart(cart);
    });

    // Live Note Input Edit
    $(document).on('change', '.cart-item-note-input', function() {
        var idx = $(this).data('index');
        var val = $(this).val();
        if (window.TanjoeCart) {
            TanjoeCart.updateItemNote(idx, val);
            showCartToast('Catatan disimpan.');
        }
    });

    // Go to Checkout
    $('#btnGoToCheckout').on('click', function() {
        var cart = getCart();
        var selected = cart.filter(function(i) { return i.selected !== false; });
        if (selected.length === 0) {
            alert('Silakan pilih minimal 1 produk untuk checkout.');
            return;
        }
        window.location.href = "{{ route('shop.checkout') }}";
    });
});
</script>

</x-layouts.public>
