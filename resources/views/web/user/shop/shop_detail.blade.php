<x-layouts.public 
    :metatitle="($product->name ?? 'Detail Produk') . ' | Toko Kopi Tanjoe'" 
    :metadesc="($product->origin ?? 'Aceh Gayo') . ' - ' . ($product->process ?? 'Specialty Process') . '. ' . Str::limit(strip_tags($product->desc ?? 'Artisan Coffee Roastery | Curating Gayo’s Finest'), 150)"
    :metaimage="$product->images->first()->image_url ?? asset('assets/images/brand/logo_lp_.png')">

<link rel="stylesheet" href="{{ asset('assets/css/shop.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

<style>
    /* Detail Page Specific Styling */
    .detail-container-wrap {
        max-width: 600px;
        margin: 0 auto;
        padding-bottom: 64px;
        min-height: 100vh;
        background-color: var(--color-surface, #FAF8F5);
        position: relative;
    }

    .detail-top-navbar {
        position: sticky;
        top: 0;
        z-index: 100;
        background: rgba(250, 248, 245, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-bottom: 1px solid rgba(236, 231, 222, 0.7);
    }

    .nav-circle-btn {
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
        position: relative;
        cursor: pointer;
    }
    .nav-circle-btn:hover {
        background: #F4EFE6;
        color: var(--color-primary, #E62129);
    }

    .detail-nav-title {
        font-weight: 700;
        font-size: 14px;
        color: var(--color-secondary, #1F2429);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 220px;
        text-align: center;
    }

    /* Gallery Slider */
    .detail-gallery-box {
        position: relative;
        width: 100%;
        background: #FFFFFF;
        border-bottom: 1px solid var(--color-border, #ECE7DE);
        overflow: hidden;
    }

    .detail-swiper {
        width: 100%;
        height: 380px;
    }

    .detail-swiper .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #FAF8F5;
    }

    .detail-swiper .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-swiper .swiper-pagination-bullet {
        background: #A0988A;
        opacity: 0.5;
        transition: all 0.2s ease;
    }
    .detail-swiper .swiper-pagination-bullet-active {
        background: var(--color-primary, #E62129) !important;
        opacity: 1;
        width: 18px;
        border-radius: 6px;
    }

    /* Content Cards */
    .detail-content-wrap {
        padding: 0px 0px 16px;
    }

    .detail-card-panel {
        background: #FFFFFF;
        border-radius: none;
        border: 1px solid var(--color-border, #ECE7DE);
        padding: 12px;
        margin-bottom: 12px;
        box-shadow: 0 1px 4px rgba(50, 45, 40, 0.04);
    }

    .detail-category-pill {
        display: inline-block;
        background: #F4EFE6;
        color: #8C6D46;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 4px 10px;
        border-radius: 9999px;
        margin-bottom: 8px;
    }

    .detail-main-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--color-secondary, #1F2429);
        line-height: 1.35;
        margin-bottom: 0px;
    }

    .detail-price-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 0px;
    }

    .detail-price-main {
        font-size: 18px;
        font-weight: 800;
        color: var(--color-primary, #E62129);
    }

    .detail-price-strike {
        font-size: 14px;
        color: #9CA3AF;
        text-decoration: line-through;
    }

    .detail-weight-badge {
        font-size: 12px;
        font-weight: 600;
        color: #6B7280;
        background: #F3F4F6;
        padding: 2px 8px;
        border-radius: 6px;
    }

    /* Coffee Spec Passport */
    .spec-grid-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-top: 10px;
    }

    .spec-item-tile {
        background: #FAF8F5;
        border: 1px solid #ECE7DE;
        border-radius: 12px;
        padding: 10px 12px;
    }

    .spec-item-label {
        font-size: 10.5px;
        font-weight: 600;
        color: #8C8275;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .spec-item-value {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--color-secondary, #1F2429);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Option Selection */
    .option-form-label {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--color-secondary, #1F2429);
        margin-bottom: 8px;
        display: block;
    }

    .grind-option-radio-wrap {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 16px;
    }

    .grind-option-card {
        border: 1.5px solid var(--color-border, #ECE7DE);
        border-radius: 5px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.15s ease;
        background: #FFFFFF;
    }

    .grind-option-card:hover {
        border-color: #D5CBBF;
    }

    .grind-option-card.active {
        border-color: var(--color-primary, #E62129);
        background: rgba(230, 33, 41, 0.03);
    }

    .grind-card-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--color-secondary, #1F2429);
    }

    .grind-card-sub {
        font-size: 11px;
        color: #6B7280;
    }

    .grind-radio-dot {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #D1D5DB;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }

    .grind-option-card.active .grind-radio-dot {
        border-color: var(--color-primary, #E62129);
        background: var(--color-primary, #E62129);
    }

    .grind-option-card.active .grind-radio-dot::after {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #FFFFFF;
    }

    /* Qty Stepper in Detail */
    .detail-qty-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px dashed var(--color-border, #ECE7DE);
    }

    .stepper-box-large {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--color-border, #ECE7DE);
        border-radius: 9999px;
        background: #FFFFFF;
        padding: 3px;
    }

    .stepper-box-large .btn-stepper {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: #F4EFE6;
        color: var(--color-secondary, #1F2429);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.15s;
    }

    .stepper-box-large .btn-stepper:hover {
        background: #E8E0D2;
    }

    .stepper-box-large input {
        width: 44px;
        text-align: center;
        border: none;
        outline: none;
        background: transparent;
        font-weight: 700;
        font-size: 14px;
        color: var(--color-secondary, #1F2429);
    }

    /* Sticky Bottom Action Bar */
    .detail-sticky-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #FFFFFF;
        border-top: 1px solid var(--color-border, #ECE7DE);
        padding: 12px 14px;
        box-shadow: 0 -4px 18px rgba(0,0,0,0.06);
        z-index: 1000;
    }

    .detail-sticky-bar-inner {
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .detail-total-preview {
        flex: 1;
    }

    .detail-total-label {
        font-size: 11px;
        color: #6B7280;
        font-weight: 600;
    }

    .detail-total-val {
        font-size: 17px;
        font-weight: 800;
        line-height: 1;
        color: var(--color-primary, #E62129);
    }

    .detail-btn-cart {
        padding: 11px 16px;
        border-radius: 5px;
        background: #F4EFE6;
        color: var(--color-secondary, #1F2429);
        font-weight: 700;
        font-size: 13px;
        border: 1px solid #E2D9CC;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.15s ease;
        white-space: nowrap;
    }

    .detail-btn-cart:hover {
        background: #E8E0D2;
    }

    .detail-btn-buy {
        padding: 11px 22px;
        border-radius: 9999px;
        background: var(--color-primary, #E62129);
        color: #FFFFFF !important;
        font-weight: 700;
        font-size: 13px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 3px 10px rgba(230, 33, 41, 0.25);
        transition: all 0.15s ease;
        white-space: nowrap;
    }

    .detail-btn-buy:hover {
        background: #C00018;
    }

    .detail-btn-disabled {
        opacity: 0.5;
        cursor: not-allowed !important;
        background: #9CA3AF !important;
        box-shadow: none !important;
    }

    /* Related Products */
    .related-section-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--color-secondary, #1F2429);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
</style>

<div class="detail-container-wrap">
    
    <!-- 1. Top Navbar: Back, Title, Share, Cart -->
    <div class="detail-top-navbar">
        <a href="{{ route('shop') }}" class="nav-circle-btn" title="Kembali ke Shop">
            <i class="fe fe-arrow-left"></i>
        </a>
        <div class="detail-nav-title">
            {{ $product->name }}
        </div>
        <div class="d-flex align-items-center" style="gap: 8px;">
            <button type="button" class="nav-circle-btn" id="btnShareProduct" title="Bagikan Produk">
                <i class="fe fe-share-2"></i>
            </button>
            <a href="{{ route('shop.cart') }}" class="nav-circle-btn" title="Keranjang Belanja">
                <i class="fe fe-shopping-bag"></i>
                <span class="header-cart-badge" id="cartBadgeCountDetail">0</span>
            </a>
        </div>
    </div>

    <!-- 2. Hero Gallery / Swiper Slider -->
    <div class="detail-gallery-box">
        <div class="swiper detail-swiper" id="productDetailSwiper">
            <div class="swiper-wrapper">
                @forelse($product->images as $img)
                <div class="swiper-slide">
                    <img src="{{ $img->image_url }}" alt="{{ $product->name }}" loading="lazy">
                </div>
                @empty
                <div class="swiper-slide">
                    <img src="{{ asset('assets/images/products/no-image.png') }}" alt="{{ $product->name }}">
                </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <!-- Floating Badges Top Left -->
        <div class="badge-top-left" style="top: 14px; left: 14px;">
            @if(!empty($product->is_new))
            <span class="badge-tag-pill tag-new">New</span>
            @endif
            @if(!empty($product->is_recomended))
            <span class="badge-tag-pill tag-bestseller">Recommended</span>
            @endif
        </div>

        <!-- Floating Status Bottom Right -->
        <div style="position: absolute; bottom: 14px; right: 14px; z-index: 10;">
            @if($product->is_ready)
            <span class="badge-status-corner ready" style="position: static; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                <i class="fe fe-check-circle fs-10"></i> Ready Stock
            </span>
            @else
            <span class="badge-status-corner soldout" style="position: static; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                <i class="fe fe-x-circle fs-10"></i> Sold Out
            </span>
            @endif
        </div>
    </div>

    <div class="detail-content-wrap">
        
        <!-- 3. Primary Product Info Card -->
        <div class="detail-card-panel">
            <span class="detail-category-pill">{{ $product->category_label }}</span>
            <h1 class="detail-main-title">{{ $product->name }}</h1>
            
            <div class="detail-price-row">
                <div class="detail-price-main" id="detailPriceMainDisplay">
                    Rp {{ str_replace(',', '.', number_format($product->price)) }}
                </div>
                <div class="detail-price-strike d-none" id="detailPriceStrikeDisplay"></div>
                <span class="badge badge-success fs-10 px-2 py-1 rounded-pill d-none" id="detailPriceGrosirBadge" style="font-size: 10px; font-weight: 700; background: #10B981; color: #fff;">
                    Grosir
                </span>
                @if(!empty($product->price_discount) && $product->price_discount > $product->price)
                <div class="detail-price-strike">
                    Rp {{ str_replace(',', '.', number_format($product->price_discount)) }}
                </div>
                @endif
            </div>

            @if(!$product->is_ready)
            <div class="alert alert-warning py-2 px-3 fs-12 mb-0 rounded-lg">
                <i class="fe fe-alert-circle mr-1"></i>
                Batch roasting ini saat ini sedang habis. Hubungi roaster kami jika ingin reservasi batch roasting berikutnya.
            </div>
            @endif
        </div>

        <!-- 4. Coffee Passport Specification Card -->
        <div class="detail-card-panel">
            <h2 class="fs-14 font-weight-bold mb-2 d-flex align-items-center">
                <i class="fe fe-info mr-2 text-primary"></i> Profil & Spesifikasi Kopi
            </h2>
            <div class="spec-grid-container">
                <div class="spec-item-tile">
                    <div class="spec-item-label"><i class="fe fe-map-pin"></i> Origin</div>
                    <div class="spec-item-value" title="{{ $product->origin ?? '-' }}">{{ $product->origin ?? 'Aceh Gayo' }}</div>
                </div>
                <div class="spec-item-tile">
                    <div class="spec-item-label"><i class="fe fe-droplet"></i> Process</div>
                    <div class="spec-item-value" title="{{ $product->process ?? '-' }}">{{ $product->process ?? 'Specialty Process' }}</div>
                </div>
                <div class="spec-item-tile">
                    <div class="spec-item-label"><i class="fe fe-trending-up"></i> Altitude</div>
                    <div class="spec-item-value">{{ !empty($product->elevation) ? $product->elevation . ' MASL' : '1.300 - 1.600 MASL' }}</div>
                </div>
                <div class="spec-item-tile">
                    <div class="spec-item-label"><i class="fe fe-layers"></i> Varietal</div>
                    <div class="spec-item-value" title="{{ $product->varietal ?? '-' }}">{{ $product->varietal ?? 'Multi-varietal' }}</div>
                </div>
                <div class="spec-item-tile">
                    <div class="spec-item-label"><i class="fe fe-user"></i> Processor</div>
                    <div class="spec-item-value" title="{{ $product->processor ?? '-' }}">{{ $product->processor ?? 'Tanjoe Roastery' }}</div>
                </div>
                <div class="spec-item-tile">
                    <div class="spec-item-label"><i class="fe fe-calendar"></i> Harvest</div>
                    <div class="spec-item-value" title="{{ $product->harvest ?? '-' }}">{{ $product->harvest ?? 'Fresh Crop' }}</div>
                </div>
            </div>
        </div>

        <!-- 5. Description & Tasting Notes Card -->
        @if(!empty($product->desc) || !empty($product->summary))
        <div class="detail-card-panel">
            <h2 class="fs-14 font-weight-bold mb-2 d-flex align-items-center">
                <i class="fe fe-file-text text-primary mr-2"></i> Deskripsi & Tasting Notes
            </h2>
            <div class="fs-13 lh-lg" style="line-height: 1.6;">
                {!! !empty($product->desc) ? $product->desc : nl2br(e($product->summary)) !!}
            </div>
        </div>
        @endif

        <!-- 6. Customization: Grind Profile & Quantity -->
        @if($product->is_ready)
        <div class="detail-card-panel">
            <span class="option-form-label">
                <i class="fe fe-sliders mr-1 text-danger"></i> Pilihan Bentuk Biji Kopi:
            </span>

            @if($product->type == '1' || $product->tab_type === 'greenbeans')
                <!-- Green beans option -->
                <div class="grind-option-radio-wrap">
                    <div class="grind-option-card active" data-grind="Whole Beans (Biji Mentah)">
                        <div>
                            <div class="grind-card-title">Green Beans (Biji Mentah)</div>
                            <div class="grind-card-sub">Siap sangrai, kadar air terstandarisasi</div>
                        </div>
                        <div class="grind-radio-dot"></div>
                    </div>
                </div>
            @else
                <!-- Roasted Beans grind options -->
                <div class="grind-option-radio-wrap" id="grindOptionsList">
                    <div class="grind-option-card active" data-grind="Whole Beans (Biji Utuh)">
                        <div>
                            <div class="grind-card-title">Whole Beans (Biji Utuh)</div>
                            <div class="grind-card-sub">Rekomendasi terbaik untuk menjaga kesegaran aroma</div>
                        </div>
                        <div class="grind-radio-dot"></div>
                    </div>

                    <div class="grind-option-card" data-grind="Giling Halus (Espresso / Mokapot)">
                        <div>
                            <div class="grind-card-title">Giling Halus (Fine)</div>
                            <div class="grind-card-sub">Espresso machine, Mokapot, Rok Presso, Flair</div>
                        </div>
                        <div class="grind-radio-dot"></div>
                    </div>

                    <div class="grind-option-card" data-grind="Giling Sedang (V60 / Filter)">
                        <div>
                            <div class="grind-card-title">Giling Sedang (Medium)</div>
                            <div class="grind-card-sub">V60, Kalita Wave, Aeropress, Clever Dripper</div>
                        </div>
                        <div class="grind-radio-dot"></div>
                    </div>

                    <div class="grind-option-card" data-grind="Giling Kasar (French Press / Cold Brew)">
                        <div>
                            <div class="grind-card-title">Giling Kasar (Coarse)</div>
                            <div class="grind-card-sub">French Press, Cold Brew, Tubruk Kasar</div>
                        </div>
                        <div class="grind-radio-dot"></div>
                    </div>
                </div>
            @endif

            <!-- Custom Note Input -->
            <div class="form-group mb-3">
                <label class="fs-12 font-weight-bold text-muted mb-1">
                    Catatan Khusus (opsional):
                </label>
                <input type="text" class="form-control" id="detailCustomerNote">
            </div>

            <!-- Quantity Stepper -->
            <div class="detail-qty-row">
                <span class="fs-13 font-weight-bold text-dark">Jumlah Pesanan:</span>
                <div class="stepper-box-large">
                    <button type="button" class="btn-stepper" id="btnDetailQtyMinus">
                        <i class="fe fe-minus"></i>
                    </button>
                    <input type="text" id="detailQtyInput" value="1" readonly>
                    <button type="button" class="btn-stepper" id="btnDetailQtyPlus">
                        <i class="fe fe-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        @endif    

    </div>

    <!-- 7. Sticky Bottom Action Bar -->
    <div class="detail-sticky-bar">
        <div class="detail-sticky-bar-inner">
            <div class="detail-total-preview">
                <div class="detail-total-label">Subtotal</div>
                <div class="detail-total-val" id="detailSubtotalDisplay">
                    Rp {{ str_replace(',', '.', number_format($product->price)) }}
                </div>
                <div class="">&nbsp;
                <span class="d-none" id="detailSubtotalStrikeDisplay" style="font-size: 11px; color: #9CA3AF; text-decoration: line-through;">
                </span>
                </div>
            </div>

            @if($product->is_ready)
            <button type="button" class="btn btn-dark" id="btnDetailAddToCart">
                <span>+</span><i class="fe fe-shopping-cart"></i>
            </button>
            <button type="button" class="btn btn-primary" id="btnDetailBuyNow">
                <i class="fe fe-shopping-bag"></i>
                <span>Beli Sekarang</span>
            </button>
            @else
            <a href="https://api.whatsapp.com/send?phone=628116886616&text={{ urlencode('Halo Toko Kopi Tanjoe, saya ingin menanyakan ketersediaan kembali untuk beans ' . $product->name) }}" 
               target="_blank" class="detail-btn-cart bg-success text-white border-0" style="padding: 11px 20px;">
                <i class="fe fe-message-circle"></i> Tanya Batch Baru
            </a>
            @endif
        </div>
    </div>

</div>

<!-- Cart Toast Notification -->
<div id="cartToastDetail" class="cart-toast">
    <i class="fe fe-check-circle text-success fs-16"></i>
    <span id="cartToastDetailText">Produk berhasil ditambahkan ke keranjang!</span>
</div>

<!-- ============================================================ -->
<!-- Modal: Produk Berhasil Ditambahkan + Rekomendasi             -->
<!-- ============================================================ -->
<div id="cartSuccessModal" style="
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    align-items: flex-end;
    justify-content: center;
">
    <div id="cartSuccessModalSheet" style="
        background: #FFFFFF;
        border-radius: 20px 20px 0 0;
        width: 100%;
        max-width: 600px;
        padding: 0 0 32px;
        transform: translateY(100%);
        transition: transform 0.35s cubic-bezier(0.34, 1.2, 0.64, 1);
        max-height: 88vh;
        overflow-y: auto;
        position: relative;
    ">
        <!-- Handle bar -->
        <div style="width: 40px; height: 4px; background: #E0D9D0; border-radius: 99px; margin: 12px auto 0;"></div>

        <!-- Success Header -->
        <div style="padding: 18px 20px 14px; border-bottom: 1px solid #F0EDE8;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="
                    width: 44px; height: 44px;
                    border-radius: 50%;
                    background: rgba(16,185,129,0.12);
                    display: flex; align-items: center; justify-content: center;
                    flex-shrink: 0;
                ">
                    <i class="fe fe-check" style="color: #10B981; font-size: 20px;"></i>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 700; color: #1F2429;" id="modalAddedProductName">
                        {{ $product->name }}
                    </div>
                    <div style="font-size: 12px; color: #6B7280;">Berhasil ditambahkan ke keranjang</div>
                </div>
                <button type="button" id="btnCloseCartModal" style="
                    margin-left: auto;
                    width: 32px; height: 32px;
                    border: none;
                    background: #F4EFE6;
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    cursor: pointer;
                    color: #6B7280;
                    flex-shrink: 0;
                ">
                    <i class="fe fe-x" style="font-size: 14px;"></i>
                </button>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 10px; margin-top: 16px;">
                <a href="{{ route('shop.cart') }}" class="btn btn-dark btn-block">
                    <i class="fe fe-shopping-cart mr-1"></i> Lihat Keranjang
                </a>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <!-- Recommendations -->
        <div style="padding: 16px 20px 0;">
            <div style="font-size: 13px; font-weight: 700; color: #1F2429; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                <i class="fe fe-coffee" style="color: #BE0017;"></i>
                Rekomendasi Produk Lainnya
            </div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px;">
                @foreach($relatedProducts->take(4) as $rel)
                <a href="{{ route('shop.detail', $rel->id) }}" 
                   onclick="document.getElementById('cartSuccessModal').style.display='none';"
                   style="
                    background: #FAF8F5;
                    border-radius: 5px;
                    overflow: hidden;
                    text-decoration: none;
                    border: 1px solid #EDE8DF;
                    display: block;
                    transition: transform 0.15s ease;
                " onmousedown="this.style.transform='scale(0.97)'" onmouseup="this.style.transform=''" ontouchstart="this.style.transform='scale(0.97)'" ontouchend="this.style.transform=''">
                    <!-- Product Image -->
                    <div style="height: 100px; overflow: hidden; background: #EDE8DF; position: relative;">
                        <img src="{{ $rel->thumbnail }}" alt="{{ $rel->name }}" 
                             style="width: 100%; height: 100%; object-fit: cover;" loading="lazy"
                             onerror="this.src='{{ asset('assets/images/products/no-image.png') }}'">
                        @if($rel->is_ready)
                        <span style="
                            position: absolute; bottom: 7px; right: 7px;
                            background: #10B981; color: #fff;
                            font-size: 9px; font-weight: 700;
                            padding: 2px 7px; border-radius: 9999px;
                        "><i class="fe fe-check-circle" style="font-size:9px;"></i> Ready</span>
                        @else
                        <span style="
                            position: absolute; bottom: 7px; right: 7px;
                            background: #6B7280; color: #fff;
                            font-size: 9px; font-weight: 700;
                            padding: 2px 7px; border-radius: 9999px;
                        ">Habis</span>
                        @endif
                    </div>
                    <!-- Product Info -->
                    <div style="padding: 8px 10px 10px;">
                        <div style="font-size: 11.5px; font-weight: 700; color: #1F2429; line-height: 1.3; margin-bottom: 2px; 
                                    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $rel->name }}</div>
                        <div style="font-size: 10px; color: #9CA3AF; margin-bottom: 4px;">{{ $rel->origin ?? 'Aceh Gayo' }}</div>
                        <div style="font-size: 12px; font-weight: 800; color: #BE0017;">
                            Rp {{ str_replace(',', '.', number_format($rel->price)) }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
$(document).ready(function() {
    var productPrice = {{ (int)$product->price }};
    var priceGrosir15 = {{ (int)($product->price_grosir15 ?? 0) }};
    var priceGrosir50 = {{ (int)($product->price_grosir50 ?? 0) }};
    var productType = @json($product->type);
    var productId = {{ $product->id }};
    var productName = @json($product->name);
    var productOrigin = @json($product->origin ?? 'Aceh Gayo');
    var productProcess = @json($product->process ?? 'Specialty Process');
    var productWeight = @json($product->satuan ?? '200gr');
    var productImage = @json($product->images->first()->image_url ?? asset('assets/images/products/no-image.png'));
    var isReady = {{ $product->is_ready ? 'true' : 'false' }};

    // Initialize Swiper Slider
    var detailSwiper = new Swiper('#productDetailSwiper', {
        loop: false,
        pagination: {
            el: '.detail-swiper .swiper-pagination',
            clickable: true,
        },
    });

    // Cart Helper Wrappers (delegate to TanjoeCart)
    function getCart() { return window.TanjoeCart ? TanjoeCart.getCart() : []; }
    function saveCart(cart) { if (window.TanjoeCart) TanjoeCart.saveCart(cart); }
    function updateCartBadge() { if (window.TanjoeCart) TanjoeCart.updateAllBadges(); }
    function showToast(msg) { if (window.TanjoeCart) TanjoeCart.showToast(msg); }
    function formatRupiah(num) { return window.TanjoeCart ? TanjoeCart.formatRupiah(num) : 'Rp ' + num; }

    // Initial Badge Update
    updateCartBadge();

    // Listen for updates from other tabs/pages
    window.addEventListener('tanjoe:cart-updated', function() { updateCartBadge(); });

    // Grind Selection Radio Cards
    $(document).on('click', '.grind-option-card', function() {
        $('.grind-option-card').removeClass('active');
        $(this).addClass('active');
    });

    function getSelectedGrind() {
        var $active = $('.grind-option-card.active');
        if ($active.length) {
            return $active.data('grind');
        }
        return 'Whole Beans (Biji Utuh)';
    }

    // Dynamic wholesale / bundling unit price helper
    function getEffectivePrice(qty) {
        var strType = String(productType);
        if (strType === '1') {
            // Green Beans
            if (qty >= 50 && priceGrosir50 > 0) return priceGrosir50;
            if (qty >= 15 && priceGrosir15 > 0) return priceGrosir15;
            return productPrice;
        }

        // Roasted Filter (2) & Espresso (3) Beans - Bundling (Min 2 Pack)
        if (qty >= 2 && priceGrosir15 > 0) {
            return priceGrosir15;
        }
        return productPrice;
    }

    function getTierLabel(qty) {
        var strType = String(productType);
        if (strType === '1') {
            if (qty >= 50 && priceGrosir50 > 0) return 'Grosir ≥50kg';
            if (qty >= 15 && priceGrosir15 > 0) return 'Grosir ≥15kg';
        } else {
            if (qty >= 2 && priceGrosir15 > 0) return 'Bundling (Min 2 Pack)';
        }
        return '';
    }

    // Quantity Stepper
    var currentQty = 1;
    function updateSubtotal() {
        var unitPrice = getEffectivePrice(currentQty);
        var total = unitPrice * currentQty;
        var originalTotal = productPrice * currentQty;
        var isDiscounted = (unitPrice < productPrice);

        $('#detailSubtotalDisplay').text(formatRupiah(total));

        if (isDiscounted) {
            $('#detailSubtotalStrikeDisplay').text(formatRupiah(originalTotal)).removeClass('d-none');
            $('#detailPriceMainDisplay').text(formatRupiah(unitPrice));
            $('#detailPriceStrikeDisplay').text(formatRupiah(productPrice)).removeClass('d-none');
            var tierLabel = getTierLabel(currentQty);
            $('#detailPriceGrosirBadge').text(tierLabel).removeClass('d-none');
        } else {
            $('#detailSubtotalStrikeDisplay').addClass('d-none');
            $('#detailPriceMainDisplay').text(formatRupiah(productPrice));
            $('#detailPriceStrikeDisplay').addClass('d-none');
            $('#detailPriceGrosirBadge').addClass('d-none');
        }
    }

    $('#btnDetailQtyPlus').on('click', function() {
        currentQty += 1;
        $('#detailQtyInput').val(currentQty);
        updateSubtotal();
    });

    $('#btnDetailQtyMinus').on('click', function() {
        if (currentQty > 1) {
            currentQty -= 1;
            $('#detailQtyInput').val(currentQty);
            updateSubtotal();
        }
    });

    // Initial subtotal calculation
    updateSubtotal();

    // Add To Cart Function
    function performAddToCart() {
        if (!isReady) {
            alert('Maaf, produk ini sedang habis.');
            return false;
        }

        var grind = getSelectedGrind();
        var note = $('#detailCustomerNote').val() ? $('#detailCustomerNote').val().trim() : '';
        var qty = currentQty;

        var cart = getCart();
        var existingIdx = cart.findIndex(function(item) {
            return item.id == productId && item.variant === grind;
        });

        if (existingIdx !== -1) {
            cart[existingIdx].quantity += qty;
            if (note) cart[existingIdx].note = note;
            if (priceGrosir15 > 0) cart[existingIdx].price_grosir15 = priceGrosir15;
            if (priceGrosir50 > 0) cart[existingIdx].price_grosir50 = priceGrosir50;
            if (productType) cart[existingIdx].type = productType;
        } else {
            cart.push({
                id: productId,
                name: productName,
                origin: productOrigin,
                process: productProcess,
                variant: grind,
                price: productPrice,
                price_grosir15: priceGrosir15,
                price_grosir50: priceGrosir50,
                type: productType,
                quantity: qty,
                weight: productWeight,
                note: note,
                selected: true,
                image: productImage
            });
        }

        saveCart(cart);
        showToast(qty + 'x ' + productName + ' ditambahkan ke keranjang!');
        return true;
    }

    // -------------------------------------------------------
    // Cart Success Modal helpers
    // -------------------------------------------------------
    function openCartSuccessModal() {
        var $modal = $('#cartSuccessModal');
        $modal.css('display', 'flex');
        // Trigger slide-up animation on next frame
        requestAnimationFrame(function() {
            $('#cartSuccessModalSheet').css('transform', 'translateY(0)');
        });
        // Block body scroll
        $('body').css('overflow', 'hidden');
    }

    function closeCartSuccessModal() {
        $('#cartSuccessModalSheet').css('transform', 'translateY(100%)');
        setTimeout(function() {
            $('#cartSuccessModal').css('display', 'none');
            $('body').css('overflow', '');
        }, 350);
    }

    // Close on backdrop click
    $('#cartSuccessModal').on('click', function(e) {
        if ($(e.target).is('#cartSuccessModal')) {
            closeCartSuccessModal();
        }
    });

    // Close button
    $('#btnCloseCartModal').on('click', function() {
        closeCartSuccessModal();
    });

    // Close on ESC
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') closeCartSuccessModal();
    });

    // Button Click: + Keranjang → open modal after add
    $('#btnDetailAddToCart').on('click', function() {
        var $btn = $(this);
        var origHtml = $btn.html();
        if (performAddToCart()) {
            $btn.html('<i class="fe fe-check"></i> <span>Tersimpan!</span>');
            setTimeout(function() { $btn.html(origHtml); }, 1500);
            // Show success modal with recommendations
            openCartSuccessModal();
        }
    });

    // Button Click: Beli Sekarang → skip modal, go directly to checkout
    $('#btnDetailBuyNow').on('click', function() {
        if (performAddToCart()) {
            setTimeout(function() {
                window.location.href = "{{ route('shop.checkout') }}";
            }, 300);
        }
    });

    // Share Product
    $('#btnShareProduct').on('click', function() {
        var shareData = {
            title: productName + ' - Toko Kopi Tanjoe',
            text: 'Beli ' + productName + ' (' + productOrigin + ' - ' + productProcess + ') di Toko Kopi Tanjoe.',
            url: window.location.href
        };

        if (navigator.share) {
            navigator.share(shareData).catch(function(err) {});
        } else {
            // Fallback copy to clipboard
            var dummy = document.createElement('input');
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            showToast('Link produk berhasil disalin!');
        }
    });
});
</script>

</x-layouts.public>
