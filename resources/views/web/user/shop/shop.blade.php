<x-layouts.public metatitle="Pricelist & Marketplace" metadesc="Toko Kopi Tanjoe - Artisan Roastery | Curating Gayo’s Finest, Distributing with Purpose">

<link rel="stylesheet" href="{{ asset('assets/css/shop.css') }}">

<div class="shop-container-wrap">
    
    <!-- 1. Top Header: Search (Kiri) + Tombol Keranjang (Kanan) -->
    <div class="top-brand-header" id="topHeaderShop">
        <div class="search-input-box">
            <i class="fe fe-search text-muted mr-1"></i>
            <input type="text" id="shopSearchInput" placeholder="Cari roasted beans, origin, process..." autocomplete="off">
            <i class="fe fe-x text-muted cursor-pointer d-none" id="clearSearchBtn"></i>
        </div>
        <a href="{{ route('shop.cart') }}" class="header-icon-btn" id="openCartHeaderBtn" title="Keranjang Belanja">
            <i class="fe fe-shopping-bag"></i>
            <span class="header-cart-badge" id="cartBadgeCount">0</span>
        </a>
    </div>

    <!-- ============================================================== -->
    <!-- SECTION A: KATALOG VIEW                                         -->
    <!-- ============================================================== -->
    <div id="viewCatalogSection">

        <!-- Category Segmented Pills Tabs -->
        <div class="category-pills-bar" id="categoryTabs">
            <button type="button" class="category-pill active" data-tab="all">Semua</button>
            <button type="button" class="category-pill" data-tab="filter">Filter Beans</button>
            <button type="button" class="category-pill" data-tab="espresso">Espresso</button>
            @if(count($stok_gb) > 0)
            <button type="button" class="category-pill" data-tab="greenbeans">Green Beans</button>
            @endif
        </div>

        <!-- Secondary Filter Dropdowns & Variant Counter -->
        <div class="filter-dropdowns-row">
            <select class="filter-select-btn" id="filterOrigin">
                <option value="all">Origin (Semua)</option>
                @foreach($origins as $orig)
                <option value="{{ strtolower($orig) }}">{{ $orig }}</option>
                @endforeach
            </select>

            <select class="filter-select-btn" id="filterProcess">
                <option value="all">Process (Semua)</option>
                @foreach($processes as $proc)
                <option value="{{ strtolower($proc) }}">{{ $proc }}</option>
                @endforeach
            </select>

            <select class="filter-select-btn" id="sortProducts">
                <option value="default">Urutkan: Terlaris</option>
                <option value="price_asc">Harga: Rendah ke Tinggi</option>
                <option value="price_desc">Harga: Tinggi ke Rendah</option>
                <option value="name_asc">Nama: A - Z</option>
            </select>

            <span class="variant-counter" id="variantCountDisplay">{{ count($all_products) }} Varian</span>
        </div>

        <!-- 2-Column Product Grid Stream -->
        <div class="products-grid" id="productsGridStream">
            @forelse($all_products as $product)
            @php
                $isReady = ($product->stock > 0);
                $tabType = ($product->type == '2') ? 'filter' : (($product->type == '3') ? 'espresso' : 'greenbeans');
                $priceFormatted = 'Rp ' . str_replace(',', '.', number_format($product->price));
                $priceGrosirFormatted = !empty($product->price_grosir15) ? 'Rp ' . str_replace(',', '.', number_format($product->price_grosir15)) : $priceFormatted;
                
                // Primary image
                $firstImg = $product->images->first();
                $thumbnailUrl = $firstImg ? $firstImg->image_url : asset('assets/images/products/no-image.png');
                
                $isRecommended = (!empty($product->is_recomended) && ($product->is_recomended === 'true' || $product->is_recomended == 1));
            @endphp
            <div class="product-col product-grid-item"
                 data-id="{{ $product->id }}"
                 data-tab="{{ $tabType }}"
                 data-name="{{ strtolower($product->name) }}"
                 data-origin="{{ strtolower($product->origin ?? '') }}"
                 data-process="{{ strtolower($product->process ?? '') }}"
                 data-price="{{ (int)$product->price }}"
                 data-status="{{ $isReady ? 'ready' : 'soldout' }}">
                
                <a href="{{ route('shop.detail', $product->id) }}" class="product-card-item" style="cursor: pointer; text-decoration: none; color: inherit; display: flex; flex-direction: column;">
                    <!-- Image Box -->
                    <div class="product-image-wrap">
                        <img src="{{ $thumbnailUrl }}" alt="{{ $product->name }}" loading="lazy">
                        
                        <!-- Top Left Badges -->
                        <div class="badge-top-left">
                            @if(!empty($product->is_new) && ($product->is_new === 'true' || $product->is_new === 'New' || $product->is_new == 1))
                            <span class="badge-tag-pill tag-new">New</span>
                            @endif
                            @if($isRecommended)
                            <span class="badge-tag-pill tag-bestseller">Recommended</span>
                            @endif
                        </div>

                        <!-- Bottom Right Status Pill -->
                        @if($isReady)
                        <span class="badge-status-corner ready">
                            <i class="fe fe-check-circle fs-10"></i> Ready
                        </span>
                        @else
                        <span class="badge-status-corner soldout">
                            <i class="fe fe-x-circle fs-10"></i> Sold Out
                        </span>
                        @endif
                    </div>

                    <!-- Product Body Details -->
                    <div class="product-body">
                        <h3 class="card-product-title" title="{{ $product->name }}">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="card-product-origin">
                            {{ $product->origin ?? 'Aceh Gayo' }}
                        </div>

                        <div class="card-process-chip" title="{{ $product->process }}">
                            {{ $product->process ?? 'Specialty Process' }}
                        </div>

                        <!-- Price Subtitle & Main Price -->
                        

                        <div class="card-price-row mb-0">
                            <div class="card-main-price {{ !$isReady ? 'soldout-price' : '' }}">
                                {{ $priceFormatted }}
                            </div>
                            <div class="card-pack-info {{ !$isReady ? 'soldout-text' : '' }}">
                                @if($isReady)
                                    {{ !empty($product->satuan) ? $product->satuan : '200gr' }}
                                @else
                                    Habis
                                @endif
                            </div>
                        </div>
                    </div>
                </a>

            </div>
            @empty
            <div class="col-12 py-5 text-center">
                <i class="fe fe-coffee fs-36 text-muted mb-2 d-block"></i>
                <h6 class="font-heading font-weight-bold">Belum ada produk tersedia</h6>
            </div>
            @endforelse
        </div>

        <!-- Empty Search State -->
        <div id="noProductMatch" class="text-center py-5 d-none">
            <i class="fe fe-search fs-36 text-muted mb-2 d-block"></i>
            <h6 class="font-heading font-weight-bold text-secondary">Produk tidak ditemukan</h6>
            <p class="text-muted fs-12 mb-3">Tidak ada varian kopi yang sesuai dengan filter Anda.</p>
            <button type="button" class="btn btn-sm btn-outline-danger px-3 rounded-pill" id="btnResetSearch">Reset Pencarian</button>
        </div>

        <!-- Bottom Consultation & Grind Size Banner -->
        <div class="consult-banner">
            <div class="d-flex align-items-center">
                <div class="consult-icon-box">
                    <i class="fe fe-user-check"></i>
                </div>
                <div>
                    <div class="consult-title">Konsultasi Roaster & Grind Size</div>
                    <p class="consult-desc">Butuh profil gilingan V60, Mokapot, atau French Press?</p>
                </div>
            </div>
            <a href="https://wa.me/6285974607547?text=Halo%20Roaster%20Tanjoe,%20saya%20ingin%20konsultasi%20profil%20gilingan%20dan%20beans." target="_blank" class="btn-consult-tanya">
                <i class="fa fa-whatsapp"></i> Tanya
            </a>
        </div>

    </div>

</div>

<!-- Cart Toast Alert -->
<div id="cartToast" class="cart-toast">
    <i class="fe fe-check-circle text-success fs-16"></i>
    <span id="cartToastText">Produk berhasil ditambahkan ke keranjang!</span>
</div>

<script>
$(document).ready(function() {
    // Sync cart badge via TanjoeCart
    if (window.TanjoeCart) {
        TanjoeCart.updateAllBadges();
    }
    window.addEventListener('tanjoe:cart-updated', function() {
        if (window.TanjoeCart) TanjoeCart.updateAllBadges();
    });

    // -------------------------------------------------------------
    // CATALOG FILTERING & SEARCH
    // -------------------------------------------------------------
    var currentActiveTab = 'all';
    var currentOrigin = 'all';
    var currentProcess = 'all';
    var currentSort = 'default';
    var currentSearch = '';

    function runFilters() {
        var visibleCount = 0;
        var items = $('.product-grid-item');

        items.each(function() {
            var $el = $(this);
            var tab = $el.data('tab');
            var name = ($el.data('name') || '').toString().toLowerCase();
            var origin = ($el.data('origin') || '').toString().toLowerCase();
            var process = ($el.data('process') || '').toString().toLowerCase();

            var matchTab = (currentActiveTab === 'all' || tab === currentActiveTab);
            var matchOrigin = (currentOrigin === 'all' || origin.indexOf(currentOrigin) !== -1);
            var matchProcess = (currentProcess === 'all' || process.indexOf(currentProcess) !== -1);
            
            var matchSearch = true;
            if (currentSearch.trim() !== '') {
                var q = currentSearch.toLowerCase();
                matchSearch = (name.indexOf(q) !== -1 || origin.indexOf(q) !== -1 || process.indexOf(q) !== -1);
            }

            if (matchTab && matchOrigin && matchProcess && matchSearch) {
                $el.removeClass('d-none');
                visibleCount++;
            } else {
                $el.addClass('d-none');
            }
        });

        // Sorting
        var $grid = $('#productsGridStream');
        var visibleItems = items.filter(':not(.d-none)').get();

        if (currentSort === 'price_asc') {
            visibleItems.sort(function(a, b) {
                return $(a).data('price') - $(b).data('price');
            });
            $.each(visibleItems, function(idx, itm) { $grid.append(itm); });
        } else if (currentSort === 'price_desc') {
            visibleItems.sort(function(a, b) {
                return $(b).data('price') - $(a).data('price');
            });
            $.each(visibleItems, function(idx, itm) { $grid.append(itm); });
        } else if (currentSort === 'name_asc') {
            visibleItems.sort(function(a, b) {
                return $(a).data('name').localeCompare($(b).data('name'));
            });
            $.each(visibleItems, function(idx, itm) { $grid.append(itm); });
        }

        $('#variantCountDisplay').text(visibleCount + ' Varian');
        if (visibleCount === 0) {
            $('#noProductMatch').removeClass('d-none');
        } else {
            $('#noProductMatch').addClass('d-none');
        }
    }

    // Category Tabs
    $('#categoryTabs').on('click', '.category-pill', function() {
        $('#categoryTabs .category-pill').removeClass('active');
        $(this).addClass('active');
        currentActiveTab = $(this).data('tab');
        runFilters();
    });

    // Dropdown filters
    $('#filterOrigin').on('change', function() {
        currentOrigin = $(this).val();
        runFilters();
    });
    $('#filterProcess').on('change', function() {
        currentProcess = $(this).val();
        runFilters();
    });
    $('#sortProducts').on('change', function() {
        currentSort = $(this).val();
        runFilters();
    });

    // Search input
    $('#shopSearchInput').on('input', function() {
        currentSearch = $(this).val();
        if (currentSearch.length > 0) {
            $('#clearSearchBtn').removeClass('d-none');
        } else {
            $('#clearSearchBtn').addClass('d-none');
        }
        runFilters();
    });

    $('#clearSearchBtn').on('click', function() {
        $('#shopSearchInput').val('');
        currentSearch = '';
        $(this).addClass('d-none');
        runFilters();
    });

    $('#btnResetSearch').on('click', function() {
        $('#shopSearchInput').val('');
        currentSearch = '';
        $('#clearSearchBtn').addClass('d-none');
        $('#filterOrigin').val('all');
        $('#filterProcess').val('all');
        $('#sortProducts').val('default');
        $('#categoryTabs .category-pill[data-tab="all"]').click();
    });

    // Redirect legacy ?tab=cart or ?tab=checkout if accessed
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('tab') === 'cart' || window.location.hash === '#cart') {
        window.location.href = "{{ route('shop.cart') }}";
    } else if (urlParams.get('tab') === 'checkout' || window.location.hash === '#checkout') {
        window.location.href = "{{ route('shop.checkout') }}";
    }
});
</script>

</x-layouts.public>
