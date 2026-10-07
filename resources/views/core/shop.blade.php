<x-layouts.public metatitle="Pricelist & Marketplace" metadesc="Toko Kopi Tanjoe - Artisan Roastery | Curating Gayo’s Finest, Distributing with Purpose">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

<style>
    :root {
        --color-surface: #FAF8F5;
        --color-surface-card: #FFFFFF;
        --color-surface-dim: #EFECE6;
        --color-primary: #E62129;
        --color-primary-dark: #C00018;
        --color-primary-light: rgba(230, 33, 41, 0.08);
        --color-secondary: #1F2429;
        --color-secondary-muted: #6B7280;
        --color-tertiary: #10B981;
        --color-tertiary-dark: #059669;
        --color-error: #EF4444;
        --color-warning: #D97706;
        --color-chip-bg: #F4EFE6;
        --color-border: #ECE7DE;
        --shadow-card: 0 2px 10px -2px rgba(50, 45, 40, 0.07), 0 1px 3px 0 rgba(0, 0, 0, 0.03);
        --shadow-hover: 0 8px 22px -4px rgba(50, 45, 40, 0.12), 0 2px 6px 0 rgba(0, 0, 0, 0.04);
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 16px;
        --radius-pill: 9999px;
    }

    body {
        background-color: var(--color-surface) !important;
        color: var(--color-secondary);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    .font-heading {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .shop-container-wrap {
        max-width: 600px;
        margin: 0 auto;
        padding-bottom: 95px;
        min-height: 100vh;
        background-color: var(--color-surface);
        position: relative;
    }

    /* Top App Header: Search (Left) + Cart (Right) */
    .top-brand-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px 10px;
        background: var(--color-surface);
        position: sticky;
        z-index: 100;
    }
    .top-brand-header .search-input-box {
        flex: 1;
        margin-bottom: 0;
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-pill);
        display: flex;
        align-items: center;
        padding: 0 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
        height: 42px;
    }
    .top-brand-header .search-input-box:focus-within {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(230, 33, 41, 0.1);
    }
    .top-brand-header .search-input-box input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: var(--color-secondary);
        padding: 9px 8px;
        width: 100%;
    }
    .top-brand-header .search-input-box input::placeholder {
        color: #9CA3AF;
    }
    .header-icon-btn {
        position: relative;
        color: var(--color-secondary);
        font-size: 19px;
        width: 42px;
        height: 42px;
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: 12px;
        text-decoration: none !important;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.15s ease;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    }
    .header-icon-btn:hover {
        background: #F3EFE7;
    }
    .header-cart-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--color-primary);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        min-width: 18px;
        height: 18px;
        padding: 0 4px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--color-surface);
        transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .header-cart-badge.pop {
        transform: scale(1.35);
    }

    /* Search Bar with Filter Slider Button */
    .search-row {
        display: flex;
        gap: 8px;
        padding: 0 16px;
        margin-bottom: 12px;
    }
    .search-input-box {
        flex: 1;
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-pill);
        display: flex;
        align-items: center;
        padding: 0 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .search-input-box:focus-within {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(230, 33, 41, 0.1);
    }
    .search-input-box input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: var(--color-secondary);
        padding: 9px 8px;
        width: 100%;
    }
    .search-input-box input::placeholder {
        color: #9CA3AF;
    }
    .search-btn-filter {
        width: 40px;
        height: 40px;
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-secondary);
        font-size: 16px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .search-btn-filter:hover {
        background: #F3EFE7;
    }

    /* Batch Notice Card */
    .notice-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: 14px;
        margin: 0 16px 14px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: var(--shadow-card);
    }
    .notice-icon-box {
        width: 38px;
        height: 38px;
        background: #FEE2E2;
        color: var(--color-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        margin-right: 12px;
    }
    .notice-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 13.5px;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 2px;
    }
    .badge-fresh-roast {
        background: #E0E7FF;
        color: #3730A3;
        font-size: 10px;
        font-weight: 700;
        padding: 1px 7px;
        border-radius: var(--radius-pill);
    }
    .notice-desc {
        font-size: 11px;
        color: var(--color-secondary-muted);
        margin-bottom: 0;
        line-height: 1.3;
    }
    .notice-wa-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
        margin-left: 8px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .notice-wa-btn:hover {
        background: #059669;
        color: #fff;
    }

    /* Category Filter Segmented Tabs */
    .category-pills-bar {
        display: flex;
        gap: 8px;
        padding: 0 16px;
        overflow-x: auto;
        scrollbar-width: none;
        margin-bottom: 12px;
    }
    .category-pills-bar::-webkit-scrollbar {
        display: none;
    }
    .category-pill {
        white-space: nowrap;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        padding: 6px 15px;
        border-radius: var(--radius-pill);
        background: #ECE7DE;
        color: var(--color-secondary);
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        text-decoration: none !important;
    }
    .category-pill.active {
        background: var(--color-primary);
        color: #FFFFFF !important;
        box-shadow: 0 2px 6px rgba(230, 33, 41, 0.25);
    }

    /* Dropdown Filters & Counter Row */
    .filter-dropdowns-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 16px;
        margin-bottom: 12px;
        gap: 6px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .filter-dropdowns-row::-webkit-scrollbar {
        display: none;
    }
    .filter-select-btn {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-pill);
        padding: 5px 11px;
        font-size: 11px;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--color-secondary);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        white-space: nowrap;
        outline: none;
    }
    .variant-counter {
        font-size: 11px;
        font-weight: 600;
        color: #F87171;
        white-space: nowrap;
        margin-left: auto;
        padding-left: 4px;
    }

    /* 2-Column Product Card Grid */
    .products-grid {
        display: flex;
        flex-wrap: wrap;
        margin: 0 10px;
    }
    .product-col {
        width: 50%;
        padding: 0 6px;
        margin-bottom: 14px;
    }
    @media (min-width: 768px) {
        .product-col {
            width: 33.333%;
        }
    }

    /* Product Card */
    .product-card-item {
        background: #FFFFFF;
        border-radius: var(--radius-lg);
        border: 1px solid var(--color-border);
        box-shadow: var(--shadow-card);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .product-card-item:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    /* Card Image Area */
    .product-image-wrap {
        position: relative;
        width: 100%;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        background: #F3EFE7;
        overflow: hidden;
        cursor: pointer;
    }
    .product-image-wrap img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s ease;
    }
    .product-card-item:hover .product-image-wrap img {
        transform: scale(1.05);
    }

    /* Image Badges Overlay */
    .badge-top-left {
        position: absolute;
        top: 8px;
        left: 8px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        z-index: 5;
    }
    .badge-tag-pill {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 9.5px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: var(--radius-pill);
        line-height: 1.3;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        display: inline-block;
        width: fit-content;
    }
    .badge-tag-pill.tag-new {
        background: #FFFFFF;
        color: #1F2429;
        border: 1px solid #E5E7EB;
    }
    .badge-tag-pill.tag-bestseller {
        background: var(--color-primary);
        color: #FFFFFF;
    }
    .badge-tag-pill.tag-tier {
        background: var(--color-primary);
        color: #FFFFFF;
    }

    /* Status Pill on Bottom-Right of Image */
    .badge-status-corner {
        position: absolute;
        bottom: 8px;
        right: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: var(--radius-pill);
        display: inline-flex;
        align-items: center;
        gap: 3px;
        z-index: 5;
        box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    }
    .badge-status-corner.ready {
        background: var(--color-tertiary);
        color: #FFFFFF;
    }
    .badge-status-corner.soldout {
        background: var(--color-error);
        color: #FFFFFF;
    }

    /* Card Details Body */
    .product-body {
        padding: 10px 10px 12px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-product-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 13.5px;
        color: var(--color-secondary);
        line-height: 1.3;
        margin-bottom: 2px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 35px;
    }

    .card-product-origin {
        font-size: 11px;
        color: var(--color-secondary-muted);
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Process Badge Chip */
    .card-process-chip {
        background: var(--color-chip-bg);
        color: #52473C;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 6px;
        border-radius: 5px;
        margin-bottom: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }

    /* Pricing Section */
    .card-price-meta {
        font-size: 10px;
        color: #9CA3AF;
        line-height: 1.2;
        margin-bottom: 1px;
    }
    .card-price-meta .strikethrough {
        text-decoration: line-through;
    }

    .card-price-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .card-main-price {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14.5px;
        font-weight: 800;
        color: var(--color-primary);
        letter-spacing: -0.01em;
    }
    .card-main-price.soldout-price {
        color: var(--color-secondary);
    }
    .card-pack-info {
        font-size: 10.5px;
        color: var(--color-secondary-muted);
        font-weight: 500;
    }
    .card-pack-info.soldout-text {
        color: var(--color-error);
        font-weight: 600;
    }

    /* Action Buttons Row */
    .card-actions-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: auto;
    }
    .btn-card-info {
        width: 34px;
        height: 34px;
        background: #F4EFE6;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-pill);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-secondary);
        font-size: 13px;
        cursor: pointer;
        flex-shrink: 0;
        transition: all 0.15s ease;
        text-decoration: none !important;
    }
    .btn-card-info:hover {
        background: #EAE3D5;
    }

    .btn-card-cta {
        flex: 1;
        height: 34px;
        background: var(--color-primary);
        color: #FFFFFF !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: var(--radius-pill);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        cursor: pointer;
        text-decoration: none !important;
        transition: all 0.15s ease;
        padding: 0 10px;
    }
    .btn-card-cta:hover {
        background: var(--color-primary-dark);
        transform: translateY(-1px);
    }
    .btn-card-cta.btn-disabled-sold {
        background: #F3F4F6;
        color: #9CA3AF !important;
        border: 1px solid #E5E7EB;
        cursor: not-allowed;
    }

    /* Bottom Consultation Banner */
    .consult-banner {
        background: #F2FAF6;
        border: 1px solid #C4EED9;
        border-radius: var(--radius-lg);
        margin: 10px 16px 20px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .consult-icon-box {
        width: 40px;
        height: 40px;
        background: var(--color-tertiary);
        color: #FFFFFF;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        margin-right: 10px;
    }
    .consult-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: var(--color-secondary);
        margin-bottom: 2px;
    }
    .consult-desc {
        font-size: 11px;
        color: var(--color-secondary-muted);
        margin-bottom: 0;
        line-height: 1.3;
    }
    .btn-consult-tanya {
        background: #00875D;
        color: #FFFFFF !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        padding: 7px 14px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none !important;
        flex-shrink: 0;
        margin-left: 8px;
        transition: all 0.2s ease;
    }
    .btn-consult-tanya:hover {
        background: #006B49;
    }

    /* ---------------------------------------------------- */
    /* CART VIEW SECTION STYLES (Based on cart.md)          */
    /* ---------------------------------------------------- */
    .cart-view-container {
        padding: 0 16px;
    }
    .cart-header-title-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-top: 10px;
    }
    .cart-title-main {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 17px;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .cart-title-main i {
        color: var(--color-primary);
        font-size: 19px;
    }
    .cart-items-count-pill {
        background: #ECE7DE;
        color: #4B5563;
        font-size: 11.5px;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 3px 10px;
        border-radius: var(--radius-pill);
    }

    .cart-select-all-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #FFFFFF;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid var(--color-border);
        margin-bottom: 12px;
        font-size: 12.5px;
        font-weight: 600;
    }

    /* Red Square Checkbox */
    .custom-cart-checkbox {
        position: relative;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        user-select: none;
    }
    .custom-cart-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .checkbox-box {
        width: 20px;
        height: 20px;
        background: #FFFFFF;
        border: 2px solid #D1D5DB;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        margin-right: 8px;
    }
    .custom-cart-checkbox input:checked ~ .checkbox-box {
        background: var(--color-primary);
        border-color: var(--color-primary);
    }
    .checkbox-box i {
        color: #FFFFFF;
        font-size: 12px;
        display: none;
    }
    .custom-cart-checkbox input:checked ~ .checkbox-box i {
        display: block;
    }

    .btn-clear-all-cart {
        color: #EF4444;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: transparent;
        border: none;
        padding: 0;
    }
    .btn-clear-all-cart:hover {
        text-decoration: underline;
    }

    /* Cart Item Card */
    .cart-item-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-card);
        padding: 12px;
        margin-bottom: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .cart-item-top {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }
    .cart-item-img-wrap {
        position: relative;
        width: 72px;
        height: 72px;
        border-radius: 10px;
        background: #F3EFE7;
        overflow: hidden;
        flex-shrink: 0;
    }
    .cart-item-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .cart-item-weight-tag {
        position: absolute;
        bottom: 3px;
        left: 3px;
        background: rgba(0,0,0,0.65);
        color: #fff;
        font-size: 9px;
        font-weight: 600;
        padding: 1px 4px;
        border-radius: 4px;
    }
    .cart-item-info {
        flex: 1;
        min-width: 0;
    }
    .cart-item-title-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 2px;
    }
    .cart-item-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 13.5px;
        color: var(--color-secondary);
        line-height: 1.25;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 6px;
    }
    .btn-delete-cart-item {
        color: #9CA3AF;
        font-size: 15px;
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 0;
        transition: color 0.15s ease;
    }
    .btn-delete-cart-item:hover {
        color: #EF4444;
    }
    .cart-item-origin-sub {
        font-size: 11px;
        color: var(--color-secondary-muted);
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cart-item-variant-pill {
        background: var(--color-chip-bg);
        color: #52473C;
        font-size: 10.5px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 5px;
        display: inline-block;
        margin-bottom: 6px;
    }
    .cart-item-price-stepper-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .cart-item-price {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 14.5px;
        color: var(--color-primary);
    }

    /* Cart Item Note Input */
    .cart-item-note-wrap {
        border-top: 1px dashed var(--color-border);
        padding-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        color: #6B7280;
    }
    .cart-item-note-input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 11.5px;
        font-family: 'Inter', sans-serif;
        color: var(--color-secondary);
        width: 100%;
        padding: 2px 0;
    }
    .cart-item-note-input::placeholder {
        color: #9CA3AF;
        font-style: italic;
    }

    /* Voucher & Promo Card */
    .voucher-promo-box {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 12px 14px;
        margin-bottom: 14px;
        box-shadow: var(--shadow-card);
    }
    .voucher-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .voucher-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 13.5px;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .voucher-title i {
        color: var(--color-primary);
    }
    .voucher-active-status {
        color: #059669;
        font-size: 11.5px;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .voucher-coupon-tile {
        background: #F8FAF9;
        border: 1px dashed #A7F3D0;
        border-radius: 10px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .coupon-code-badge {
        background: #D1FAE5;
        color: #065F46;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 6px;
        letter-spacing: 0.05em;
    }
    .coupon-desc-text {
        font-size: 11.5px;
        font-weight: 600;
        color: var(--color-secondary);
        margin-bottom: 1px;
    }
    .coupon-sub-text {
        font-size: 10.5px;
        color: #059669;
        font-weight: 600;
    }
    .btn-apply-voucher {
        background: #FFFFFF;
        border: 1px solid #D1D5DB;
        color: var(--color-primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: var(--radius-pill);
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-apply-voucher.applied {
        background: #059669;
        color: #FFFFFF;
        border-color: #059669;
    }

    /* Order Summary Breakdown Box */
    .order-summary-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 14px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-card);
    }
    .order-summary-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 14px;
        color: var(--color-secondary);
        margin-bottom: 12px;
    }
    .summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12.5px;
        margin-bottom: 8px;
        color: var(--color-secondary);
    }
    .summary-row.discount-row {
        color: #059669;
        font-weight: 600;
    }
    .summary-row.ongkir-row .summary-val {
        color: #9CA3AF;
        font-size: 11.5px;
    }
    .summary-divider {
        height: 1px;
        background: var(--color-border);
        margin: 10px 0;
    }
    .summary-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 800;
        color: var(--color-secondary);
    }
    .summary-total-price {
        font-size: 18px;
        color: var(--color-primary);
    }

    /* Sticky Checkout Bar for Cart */
    .sticky-checkout-bar {
        position: fixed;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 600px;
        background: #FFFFFF;
        border-top: 1px solid var(--color-border);
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 990;
        box-shadow: 0 -4px 16px rgba(0,0,0,0.08);
    }
    @php $isAuthShop = \Illuminate\Support\Facades\Auth::check(); @endphp
    @if($isAuthShop)
    /* Push sticky cart bar above bottom nav for logged-in users */
    .sticky-checkout-bar {
        bottom: 60px;
    }
    #bottom-bar {
        z-index: 1000;
    }
    @endif
    .checkout-total-col .checkout-sub-label {
        font-size: 10.5px;
        color: var(--color-secondary-muted);
        display: block;
        margin-bottom: 1px;
    }
    .checkout-total-col .checkout-total-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 16px;
        color: var(--color-primary);
        line-height: 1.1;
    }
    .checkout-total-col .checkout-hemat-tag {
        font-size: 10px;
        color: #059669;
        font-weight: 700;
    }
    .btn-checkout-action {
        background: var(--color-primary);
        color: #FFFFFF !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 800;
        padding: 10px 20px;
        border-radius: var(--radius-pill);
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none !important;
        box-shadow: 0 4px 12px rgba(230, 33, 41, 0.3);
        transition: all 0.2s ease;
    }
    .btn-checkout-action:hover {
        background: var(--color-primary-dark);
        transform: translateY(-1px);
    }
    .btn-checkout-action:disabled {
        background: #D1D5DB;
        color: #9CA3AF !important;
        box-shadow: none;
        cursor: not-allowed;
    }

    /* Checkout Section Styles */
    .checkout-view-container {
        padding: 0 16px;
    }
    .checkout-subheader-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .checkout-title-group {
        text-align: center;
    }
    .checkout-main-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 16px;
        color: var(--color-secondary);
        margin-bottom: 1px;
    }
    .checkout-main-subtitle {
        font-size: 11px;
        color: var(--color-secondary-muted);
        margin-bottom: 0;
    }
    .btn-help-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-secondary-muted);
        font-size: 18px;
        cursor: pointer;
        text-decoration: none !important;
    }
    .checkout-steps-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 6px 20px 16px;
        position: relative;
    }
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    .step-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        background: #E5E7EB;
        color: #9CA3AF;
        margin-bottom: 4px;
        position: relative;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    .step-item.active .step-icon-circle {
        background: var(--color-primary-dark);
        color: #FFFFFF;
        box-shadow: 0 4px 10px rgba(190, 0, 23, 0.35);
    }
    .step-active-dot {
        position: absolute;
        top: 0;
        right: 0;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #10B981;
        border: 2px solid #FFFFFF;
    }
    .step-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10.5px;
        font-weight: 700;
        color: #9CA3AF;
    }
    .step-item.active .step-label {
        color: var(--color-primary-dark);
    }
    .step-progress-line {
        position: absolute;
        top: 24px;
        left: 45px;
        right: 45px;
        height: 2px;
        background: #E5E7EB;
        z-index: 1;
    }
    .order-mini-summary-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin-bottom: 14px;
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }
    .order-summary-header-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 14px;
        cursor: pointer;
        user-select: none;
    }
    .order-bag-icon-box {
        width: 36px;
        height: 36px;
        background: #FEE2E2;
        color: var(--color-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .order-title-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 800;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .order-beans-count-pill {
        background: #ECE7DE;
        color: #4B5563;
        font-size: 10.5px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: var(--radius-pill);
    }
    .order-total-price-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14.5px;
        font-weight: 800;
        color: var(--color-primary);
        margin-top: 1px;
    }
    .order-thumbs-stack {
        display: flex;
        align-items: center;
    }
    .order-thumb-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #FFFFFF;
        object-fit: cover;
        margin-left: -8px;
        background: #ECE7DE;
    }
    .order-thumb-avatar:first-child {
        margin-left: 0;
    }
    .order-chevron-icon {
        margin-left: 8px;
        color: var(--color-secondary-muted);
        font-size: 14px;
        transition: transform 0.2s ease;
    }
    .order-summary-header-toggle[aria-expanded="true"] .order-chevron-icon {
        transform: rotate(180deg);
    }
    .order-breakdown-drawer {
        background: #FAF8F5;
        border-top: 1px dashed var(--color-border);
        padding: 12px 14px;
        font-size: 12px;
    }
    .order-breakdown-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .auth-main-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        padding: 18px 16px 20px;
        box-shadow: var(--shadow-card);
        margin-bottom: 14px;
    }
    .auth-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 800;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }
    .auth-card-title i {
        color: var(--color-primary);
        font-size: 17px;
    }
    .auth-card-desc {
        font-size: 11.5px;
        color: var(--color-secondary-muted);
        line-height: 1.4;
        margin-bottom: 16px;
    }
    .auth-nav-tabs {
        display: flex;
        background: #F3EFE7;
        border-radius: var(--radius-pill);
        padding: 4px;
        margin-bottom: 14px;
    }
    .auth-tab-btn {
        flex: 1;
        text-align: center;
        padding: 7px 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        border-radius: var(--radius-pill);
        border: none;
        background: transparent;
        color: var(--color-secondary-muted);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .auth-tab-btn.active {
        background: var(--color-primary-dark);
        color: #FFFFFF !important;
        box-shadow: 0 2px 6px rgba(190, 0, 23, 0.25);
    }
    .btn-google-sso {
        width: 100%;
        background: #FFFFFF;
        border: 1.5px solid #E5E7EB;
        border-radius: var(--radius-pill);
        padding: 9px 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none !important;
        transition: all 0.15s ease;
        margin-bottom: 14px;
    }
    .btn-google-sso:hover {
        background: #F9FAFB;
        border-color: #D1D5DB;
    }
    .auth-or-divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #9CA3AF;
        font-size: 11px;
        font-weight: 500;
        margin-bottom: 14px;
    }
    .auth-or-divider::before,
    .auth-or-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #E5E7EB;
    }
    .auth-or-divider:not(:empty)::before {
        margin-right: .75em;
    }
    .auth-or-divider:not(:empty)::after {
        margin-left: .75em;
    }
    .form-group-field {
        margin-bottom: 12px;
    }
    .field-label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }
    .field-label {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 700;
        color: var(--color-secondary);
    }
    .field-link {
        font-size: 11px;
        font-weight: 600;
        color: var(--color-primary);
        text-decoration: none !important;
    }
    .custom-input-wrap {
        position: relative;
        background: #F8F9FA;
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        display: flex;
        align-items: center;
        padding: 0 12px;
        transition: all 0.2s ease;
    }
    .custom-input-wrap:focus-within {
        background: #FFFFFF;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(230, 33, 41, 0.1);
    }
    .input-icon-prefix {
        color: #9CA3AF;
        font-size: 15px;
        margin-right: 8px;
    }
    .custom-form-input {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        padding: 9px 0;
        font-family: 'Inter', sans-serif;
        font-size: 12.5px;
        color: var(--color-secondary);
    }
    .input-icon-suffix {
        color: #10B981;
        font-size: 15px;
    }
    .remember-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        font-size: 11.5px;
    }
    .remember-label-box {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        user-select: none;
        font-weight: 600;
        color: var(--color-secondary);
    }
    .trust-shield-tag {
        color: #059669;
        font-weight: 700;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    .btn-submit-auth {
        width: 100%;
        background: var(--color-primary-dark);
        color: #FFFFFF !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 800;
        padding: 11px 16px;
        border-radius: var(--radius-pill);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(190, 0, 23, 0.28);
        transition: all 0.2s ease;
        text-decoration: none !important;
    }
    /* Logged User Banner */
    .logged-user-banner {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin-bottom: 12px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }
    .user-avatar-badge {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #BE0017, #E62129);
        color: #FFFFFF;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .user-meta-info {
        line-height: 1.25;
    }
    .user-name-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 13px;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .badge-user-verified {
        font-size: 10px;
        font-weight: 700;
        background: #D1FAE5;
        color: #065F46;
        padding: 1px 6px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    .user-email-subtitle {
        font-size: 11px;
        color: #6B7280;
    }
    .btn-logout-switch {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #6B7280;
        padding: 5px 9px;
        border-radius: 8px;
        border: 1px solid #E5E7EB;
        background: #F9FAFB;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none !important;
        transition: all 0.15s ease;
    }
    .btn-logout-switch:hover {
        background: #FEE2E2;
        color: #BE0017;
        border-color: #FECACA;
    }

    /* Completed Step State */
    .step-item.completed .step-icon-circle,
    .step-completed-circle {
        background: #10B981 !important;
        color: #FFFFFF !important;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.35) !important;
    }
    .step-item.completed .step-label,
    .step-completed-label {
        color: #10B981 !important;
    }

    /* Shipping Summary Labels Card */
    .shipping-summary-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin-bottom: 14px;
        box-shadow: var(--shadow-card);
        padding: 14px 16px;
        position: relative;
    }
    .shipping-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #E5E7EB;
    }
    .shipping-card-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .shipping-icon-pin {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: #FEE2E2;
        color: #BE0017;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .shipping-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 13.5px;
        color: var(--color-secondary);
    }
    .shipping-card-subtitle {
        font-size: 10.5px;
        color: #6B7280;
    }
    .btn-edit-shipping-pill {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 9999px;
        border: 1px solid #E5E7EB;
        background: #F9FAFB;
        color: #4B5563;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }
    .btn-edit-shipping-pill:hover {
        background: #F3F4F6;
        color: #111827;
        border-color: #D1D5DB;
    }
    .shipping-labels-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .shipping-label-item {
        background: #FDFBF7;
        border: 1px solid rgba(230, 33, 41, 0.08);
        border-radius: 10px;
        padding: 9px 12px;
    }
    .shipping-label-key {
        font-size: 10.5px;
        font-weight: 700;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 3px;
    }
    .shipping-label-val {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 13px;
        color: var(--color-secondary);
    }
    .badge-wa-status {
        font-size: 10px;
        font-weight: 700;
        background: #D1FAE5;
        color: #065F46;
        padding: 2px 6px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    .shipping-address-text-box {
        font-size: 12.5px;
        color: #374151;
        line-height: 1.45;
        margin-top: 2px;
        font-family: 'Inter', sans-serif;
    }

    /* Payment & Checkout Section */
    .payment-action-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin-bottom: 14px;
        box-shadow: var(--shadow-card);
        padding: 16px;
    }
    .payment-card-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 14px;
        color: var(--color-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 12px;
    }
    .payment-methods-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 14px;
    }
    .payment-method-tile {
        border: 1.5px solid #E5E7EB;
        border-radius: 12px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #F9FAFB;
        margin-bottom: 0;
    }
    .payment-method-tile.active {
        border-color: #BE0017;
        background: #FFF5F5;
        box-shadow: 0 0 0 1px #BE0017;
    }
    .payment-tile-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .payment-badge-icon {
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 11px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        letter-spacing: 0.02em;
    }
    .bca-badge {
        background: #005EAA;
        color: #FFFFFF;
    }
    .mandiri-badge {
        background: #002D62;
        color: #FFB300;
    }
    .wa-badge {
        background: #10B981;
        color: #FFFFFF;
        font-size: 13px;
        padding: 4px 7px;
    }
    .payment-tile-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
        color: var(--color-secondary);
    }
    .payment-tile-desc {
        font-size: 10.5px;
        color: #6B7280;
    }
    .payment-check-indicator {
        font-size: 16px;
        color: #BE0017;
        display: none;
    }
    .payment-method-tile.active .payment-check-indicator {
        display: block;
    }

    /* Payment Summary Breakdown */
    .payment-summary-box {
        background: #FDFBF7;
        border: 1px solid rgba(230, 33, 41, 0.08);
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 14px;
    }
    .payment-summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        margin-bottom: 6px;
        color: #4B5563;
    }
    .badge-free-shipping {
        font-size: 10.5px;
        font-weight: 700;
        color: #059669;
        background: #D1FAE5;
        padding: 2px 7px;
        border-radius: 9999px;
    }
    .payment-summary-divider {
        height: 1px;
        background: #E5E7EB;
        margin: 8px 0;
    }
    .payment-summary-row.total-row {
        font-size: 13px;
        font-weight: 800;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--color-secondary);
        margin-bottom: 0;
    }
    .total-amount-val {
        font-size: 16px;
        color: #BE0017;
        font-weight: 800;
    }

    /* Pay Now CTA */
    .btn-pay-now {
        width: 100%;
        background: #BE0017;
        color: #FFFFFF !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 14px;
        padding: 12px 18px;
        border-radius: 9999px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(190, 0, 23, 0.35);
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none !important;
    }
    .btn-pay-now:hover {
        background: #93000F;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(190, 0, 23, 0.42);
    }
    .custom-textarea-wrap {
        padding: 6px 12px;
        align-items: flex-start;
    }
    .custom-form-textarea {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        padding: 6px 0;
        font-family: 'Inter', sans-serif;
        font-size: 12.5px;
        color: var(--color-secondary);
        resize: none;
    }
    .field-help-hint {
        font-size: 10.5px;
        color: #6B7280;
        display: block;
        margin-top: 3px;
    }

    .express-wa-box {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: var(--radius-lg);
        margin-bottom: 16px;
        padding: 12px 14px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .express-icon-box {
        width: 38px;
        height: 38px;
        background: #34D399;
        color: #FFFFFF;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .express-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 800;
        color: var(--color-secondary);
        margin-bottom: 2px;
    }
    .express-desc {
        font-size: 11px;
        color: #4B5563;
        line-height: 1.35;
        margin-bottom: 5px;
    }
    .express-wa-link {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11.5px;
        font-weight: 800;
        color: var(--color-tertiary-dark);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none !important;
    }
    .express-wa-link:hover {
        color: #064E3B;
        text-decoration: underline !important;
    }
    .checkout-trust-footer {
        text-align: center;
        padding: 10px 20px;
    }
    .trust-pill-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #059669;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 3px;
    }
    .trust-sub-note {
        font-size: 10.5px;
        color: #9CA3AF;
        line-height: 1.3;
        margin-bottom: 0;
    }

    /* Product Detail Modal & Drawer */
    #modalProductDetail .modal-dialog {
        max-width: 500px;
        margin: 10px auto;
    }
    #modalProductDetail .modal-content {
        border-radius: 18px;
        border: none;
        overflow: hidden;
    }
    #modalProductDetail .modal-header {
        border-bottom: 1px solid var(--color-border);
        padding: 12px 16px;
    }

    /* Swiper Inside Detail Modal */
    .modal-slider .swiper-slide {
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F3EFE7;
        cursor: pointer;
    }
    .modal-slider .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Stepper */
    .qty-stepper {
        display: inline-flex;
        align-items: center;
        background: #F3F4F6;
        border-radius: var(--radius-pill);
        padding: 2px 4px;
    }
    .qty-btn {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: none;
        background: #FFFFFF;
        color: var(--color-secondary);
        font-weight: 700;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    }
    .qty-btn:active {
        transform: scale(0.92);
    }
    .qty-input {
        width: 32px;
        text-align: center;
        border: none;
        background: transparent;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
        color: var(--color-secondary);
    }

    /* Toast Notification */
    .cart-toast {
        position: fixed;
        bottom: 80px;
        left: 50%;
        transform: translateX(-50%) translateY(30px);
        background: var(--color-secondary);
        color: #fff;
        padding: 9px 18px;
        border-radius: var(--radius-pill);
        font-size: 12.5px;
        font-weight: 600;
        font-family: 'Plus Jakarta Sans', sans-serif;
        z-index: 2000;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .cart-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
</style>

<div class="shop-container-wrap">
    
    <!-- 1. Top Header: Search (Kiri) + Tombol Keranjang (Kanan) -->
    <div class="top-brand-header" id="topHeaderShop">
        <div class="search-input-box">
            <i class="fe fe-search text-muted mr-1"></i>
            <input type="text" id="shopSearchInput" placeholder="Cari roasted beans, origin, process..." autocomplete="off">
            <i class="fe fe-x text-muted cursor-pointer d-none" id="clearSearchBtn"></i>
        </div>
        <div class="header-icon-btn" id="openCartHeaderBtn" title="Keranjang Belanja">
            <i class="fe fe-shopping-bag"></i>
            <span class="header-cart-badge" id="cartBadgeCount">0</span>
        </div>
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
                
                <div class="product-card-item open-product-detail" data-id="{{ $product->id }}" style="cursor: pointer;">
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
                        <div class="card-price-meta">
                            @if($isReady)
                                @if(!empty($product->price_discount) && $product->price_discount > $product->price)
                                <span class="strikethrough">Rp {{ str_replace(',', '.', number_format($product->price_discount)) }}</span>
                                @else
                                <span>Whole Beans / Giling</span>
                                @endif
                            @else
                                <span class="text-danger">Batch Habis</span>
                            @endif
                        </div>

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
                </div>

                <!-- Hidden Raw Product Metadata for Modal Use -->
                <div class="d-none" id="raw-product-{{ $product->id }}">
                    <span class="raw-name">{{ $product->name }}</span>
                    <span class="raw-origin">{{ $product->origin ?? '-' }}</span>
                    <span class="raw-elevation">{{ !empty($product->elevation) ? $product->elevation . ' MASL' : '-' }}</span>
                    <span class="raw-varietal">{{ $product->varietal ?? '-' }}</span>
                    <span class="raw-process">{{ $product->process ?? '-' }}</span>
                    <span class="raw-processor">{{ $product->processor ?? '-' }}</span>
                    <span class="raw-harvest">{{ $product->harvest ?? '-' }}</span>
                    <span class="raw-price">{{ (int)$product->price }}</span>
                    <span class="raw-price-grosir">{{ (int)($product->price_grosir15 ?? $product->price) }}</span>
                    <span class="raw-price-formatted">{{ $priceFormatted }}</span>
                    <span class="raw-price-grosir-formatted">{{ $priceGrosirFormatted }}</span>
                    <span class="raw-thumbnail">{{ $thumbnailUrl }}</span>
                    <span class="raw-status">{{ $isReady ? 'ready' : 'soldout' }}</span>
                    <span class="raw-type">{{ $product->type }}</span>
                    <span class="raw-tab">{{ $tabType }}</span>
                    <span class="raw-satuan">{{ !empty($product->satuan) ? $product->satuan : '200gr' }}</span>
                    <div class="raw-desc">{!! $product->desc !!}</div>
                    <div class="raw-images">{{ json_encode($product->images->pluck('image_url')) }}</div>
                </div>

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

    <!-- ============================================================== -->
    <!-- SECTION B: CART VIEW (According to cart.md & user mockup)      -->
    <!-- ============================================================== -->
    <div id="viewCartSection" class="cart-view-container d-none">
        
        <!-- Cart Title Bar with Back Button -->
        <div class="cart-header-title-bar">
            <div class="d-flex align-items-center">
                <button type="button" class="btn-card-info mr-2" id="btnBackToCatalogTop" title="Kembali Belanja Kopi">
                    <i class="fe fe-arrow-left"></i>
                </button>
                <div class="cart-title-main">
                    <i class="fe fe-shopping-bag"></i>
                    <span>Keranjang Belanja</span>
                </div>
            </div>
            <span class="cart-items-count-pill" id="cartTotalItemsCountBadge">0 Barang</span>
        </div>

        <!-- Select All & Delete All Bar -->
        <div class="cart-select-all-row">
            <label class="custom-cart-checkbox mb-0">
                <input type="checkbox" id="selectAllCartCheckbox" checked>
                <div class="checkbox-box"><i class="fe fe-check"></i></div>
                <span id="selectAllLabel">Pilih Semua (0)</span>
            </label>
            <button type="button" class="btn-clear-all-cart" id="btnClearAllCart">
                <i class="fe fe-trash-2"></i> Hapus Semua
            </button>
        </div>

        <!-- Cart Items Stream List -->
        <div id="cartItemsListStream">
            <!-- Dynamically populated from JS -->
        </div>

        <!-- Empty Cart State -->
        <div id="emptyCartDisplay" class="text-center py-5 d-none">
            <i class="fe fe-shopping-bag fs-40 text-muted mb-2 d-block"></i>
            <h5 class="font-heading font-weight-bold text-secondary">Keranjang Anda masih kosong</h5>
            <p class="text-muted fs-12 mb-3">Jelajahi koleksi roasted beans artisanal kami dan tambahkan ke keranjang.</p>
            <button type="button" class="btn btn-danger btn-sm rounded-pill px-4 font-weight-bold" id="btnBackToCatalog">
                Mulai Belanja Kopi
            </button>
        </div>

        <!-- Ringkasan Pesanan (Order Summary) -->
        <div class="order-summary-card" id="orderSummaryCard">
            <h4 class="order-summary-title">Ringkasan Pesanan</h4>
            <div class="summary-row">
                <span class="text-muted" id="summaryTotalItemsLabel">Total Harga (0 barang)</span>
                <span class="font-weight-bold" id="summaryRawSubtotal">Rp 0</span>
            </div>
            <div class="summary-row ongkir-row">
                <span class="text-muted">Estimasi Ongkir</span>
                <span class="summary-val">Dihitung saat checkout</span>
            </div>
            <div class="summary-divider"></div>
            <div class="summary-total-row">
                <span>Total Tagihan</span>
                <span class="summary-total-price" id="summaryGrandTotal">Rp 0</span>
            </div>
        </div>

        <!-- Sticky Checkout Bar for Cart View -->
        <div class="sticky-checkout-bar" id="cartStickyCheckoutBar">
            <div class="checkout-total-col">
                <span class="checkout-sub-label">Total Belanja</span>
                <div class="checkout-total-val" id="stickyTotalBelanja">Rp 0</div>
            </div>
            <button type="button" class="btn-checkout-action" id="btnCheckoutWhatsApp">
                <i class="fe fe-shopping-cart"></i> <span id="checkoutBtnLabel">Checkout (0)</span>
            </button>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- SECTION C: CHECKOUT PUBLIC VIEW (checkout-public.md)           -->
    <!-- ============================================================== -->
    <div id="viewCheckoutSection" class="checkout-view-container d-none">
        
        <!-- Checkout Subheader -->
        <div class="checkout-subheader-row">
            <button type="button" class="btn-back-link" onclick="switchView('cart')" title="Kembali ke Keranjang">
                <i class="fe fe-arrow-left"></i>
            </button>
            <div class="checkout-title-group">
                <h2 class="checkout-main-title">Checkout Pesanan</h2>
                <p class="checkout-main-subtitle">Toko Kopi Tanjoe &bull; Artisan Roastery</p>
            </div>
            <a href="https://wa.me/6285974607547?text=Halo%20Tanjoe%20Coffee,%20bisa%20bantu%20proses%20checkout%20pesanan%20saya?" target="_blank" class="btn-help-icon" title="Bantuan Roaster">
                <i class="fe fe-help-circle"></i>
            </a>
        </div>

        @php
            $isLoggedInShop = Auth::check();
            $currUserShop = Auth::user();
            $hasShippingShop = $isLoggedInShop && !empty($currUserShop->phone) && !empty($currUserShop->address);
        @endphp

        <!-- 3-Step Progress Indicator -->
        <div class="checkout-steps-bar">
            <div class="step-progress-line"></div>
            
            <!-- Step 1: Akun -->
            <div class="step-item {{ $isLoggedInShop ? 'completed' : 'active' }}" id="stepIndicatorAkunShop">
                <div class="step-icon-circle {{ $isLoggedInShop ? 'step-completed-circle' : '' }}">
                    <i class="fe {{ $isLoggedInShop ? 'fe-check' : 'fe-lock' }}"></i>
                    @if(!$isLoggedInShop)
                        <span class="step-active-dot"></span>
                    @endif
                </div>
                <span class="step-label {{ $isLoggedInShop ? 'step-completed-label' : '' }}">1. Akun</span>
            </div>

            <!-- Step 2: Alamat -->
            <div class="step-item {{ $isLoggedInShop ? ($hasShippingShop ? 'completed' : 'active') : '' }}" id="stepIndicatorAlamatShop">
                <div class="step-icon-circle {{ $hasShippingShop ? 'step-completed-circle' : '' }}">
                    <i class="fe {{ $hasShippingShop ? 'fe-check' : 'fe-truck' }}"></i>
                    @if($isLoggedInShop && !$hasShippingShop)
                        <span class="step-active-dot"></span>
                    @endif
                </div>
                <span class="step-label {{ $hasShippingShop ? 'step-completed-label' : '' }}">2. Alamat</span>
            </div>

            <!-- Step 3: Bayar -->
            <div class="step-item {{ $hasShippingShop ? 'active' : '' }}" id="stepIndicatorBayarShop">
                <div class="step-icon-circle">
                    <i class="fe fe-credit-card"></i>
                    @if($hasShippingShop)
                        <span class="step-active-dot"></span>
                    @endif
                </div>
                <span class="step-label">3. Bayar</span>
            </div>
        </div>

        @if($isLoggedInShop)
            <!-- Logged-in User Account Banner -->
            <div class="logged-user-banner">
                <div class="d-flex align-items-center">
                    <div class="user-avatar-badge">
                        {{ strtoupper(substr($currUserShop->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="user-meta-info">
                        <div class="user-name-title">
                            <span>{{ $currUserShop->name ?? 'Pelanggan Tanjoe' }}</span>
                            <span class="badge-user-verified"><i class="fe fe-check-circle"></i> Masuk</span>
                        </div>
                        <div class="user-email-subtitle">{{ $currUserShop->email ?? '' }}</div>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="btn-logout-switch" title="Keluar / Ganti Akun">
                    <i class="fe fe-log-out"></i>
                    <span>Ganti</span>
                </a>
            </div>
        @endif

        <!-- Collapsible Order Summary ("Pesanan Anda") -->
        <div class="order-mini-summary-card">
            <div class="order-summary-header-toggle" data-toggle="collapse" data-target="#orderDetailCollapseInShop" aria-expanded="false">
                <div class="d-flex align-items-center">
                    <div class="order-bag-icon-box">
                        <i class="fe fe-shopping-bag"></i>
                    </div>
                    <div>
                        <div class="order-title-text">
                            <span>Pesanan Anda</span>
                            <span class="order-beans-count-pill" id="checkoutBeansCountPillShop">0 Beans</span>
                        </div>
                        <div class="order-total-price-text" id="checkoutOrderTotalTextShop">Rp 0</div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="order-thumbs-stack" id="orderThumbnailsStackShop">
                        <img src="{{ asset('assets/images/products/no-image.png') }}" class="order-thumb-avatar" alt="Bean">
                    </div>
                    <i class="fe fe-chevron-down order-chevron-icon"></i>
                </div>
            </div>

            <div class="collapse" id="orderDetailCollapseInShop">
                <div class="order-breakdown-drawer" id="orderBreakdownDrawerItemsShop">
                    <!-- Populated via JS from cart -->
                </div>
            </div>
        </div>

        @if($isLoggedInShop)
            <!-- 5A. FORM LENGKAPI DATA PENGIRIMAN (Shown when phone/address is missing or user clicks Edit) -->
            <div class="auth-main-card {{ $hasShippingShop ? 'd-none' : '' }}" id="shippingFormSectionShop">
                <div class="auth-card-title">
                    <i class="fe fe-map-pin"></i>
                    <span>Lengkapi Data & Alamat Pengiriman</span>
                </div>
                <p class="auth-card-desc">
                    Mohon lengkapi nomor WhatsApp aktif dan alamat pengiriman untuk koordinasi pengiriman biji kopi pesanan Anda.
                </p>

                <form id="formShippingAddressShop" onsubmit="handleSaveShippingShop(event)">
                    @csrf
                    <div class="form-group-field">
                        <div class="field-label-row">
                            <label class="field-label">Nama Penerima</label>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-user input-icon-prefix"></i>
                            <input type="text" name="name" id="shippingNameInputShop" class="custom-form-input" value="{{ $currUserShop->name ?? '' }}" placeholder="Nama Lengkap Penerima" required>
                        </div>
                    </div>

                    <div class="form-group-field">
                        <div class="field-label-row">
                            <label class="field-label">Nomor WhatsApp / HP Aktif</label>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-phone input-icon-prefix"></i>
                            <input type="tel" name="phone" id="shippingPhoneInputShop" class="custom-form-input" value="{{ $currUserShop->phone ?? '' }}" placeholder="08xxxxxxxxxx" required>
                            <i class="fe fe-check-circle input-icon-suffix d-none" id="phoneValidIconShop"></i>
                        </div>
                        <small class="field-help-hint">*Digunakan untuk konfirmasi nomor resi pengiriman & update kurir.</small>
                    </div>

                    <div class="form-group-field mb-3">
                        <div class="field-label-row">
                            <label class="field-label">Alamat Lengkap Pengiriman</label>
                        </div>
                        <div class="custom-input-wrap custom-textarea-wrap">
                            <i class="fe fe-map-pin input-icon-prefix align-self-start mt-2"></i>
                            <textarea name="address" id="shippingAddressInputShop" rows="3" class="custom-form-textarea" placeholder="Tuliskan nama jalan, nomor rumah/toko, RT/RW, kelurahan, kecamatan, kota/kabupaten, dan kode pos..." required>{{ $currUserShop->address ?? '' }}</textarea>
                        </div>
                        <small class="field-help-hint">*Pastikan alamat detail agar kurir dapat mengantar tepat waktu.</small>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        @if($hasShippingShop)
                            <button type="button" class="btn btn-light btn-sm mr-2" style="border-radius: 9999px;" onclick="toggleEditShippingFormShop(false)">
                                Batal
                            </button>
                        @endif
                        <button type="submit" class="btn-submit-auth" id="btnSaveShippingSubmitShop">
                            <span id="btnSaveShippingTextShop">Simpan & Lanjut ke Pembayaran</span>
                            <i class="fe fe-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- 5B. LABEL MODE: ALAMAT & KONTAK PENGIRIMAN (Shown when phone & address exist) -->
            <div class="shipping-summary-card {{ !$hasShippingShop ? 'd-none' : '' }}" id="shippingLabelSectionShop">
                <div class="shipping-card-header">
                    <div class="shipping-card-header-left">
                        <div class="shipping-icon-pin">
                            <i class="fe fe-map-pin"></i>
                        </div>
                        <div>
                            <div class="shipping-card-title">Alamat & Kontak Pengiriman</div>
                            <div class="shipping-card-subtitle">Terverifikasi untuk Pengiriman Biji Kopi</div>
                        </div>
                    </div>
                    <button type="button" class="btn-edit-shipping-pill" id="btnToggleEditShippingShop" onclick="toggleEditShippingFormShop(true)">
                        <i class="fe fe-edit-2"></i>
                        <span>Ubah</span>
                    </button>
                </div>

                <div class="shipping-labels-grid">
                    <div class="shipping-label-item">
                        <span class="shipping-label-key"><i class="fe fe-user"></i> Penerima</span>
                        <span class="shipping-label-val recipient-name" id="displayRecipientNameShop">{{ $currUserShop->name ?? '-' }}</span>
                    </div>

                    <div class="shipping-label-item">
                        <span class="shipping-label-key"><i class="fe fe-phone"></i> WhatsApp Aktif</span>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="shipping-label-val wa-number" id="displayRecipientPhoneShop">{{ $currUserShop->phone ?? '-' }}</span>
                            <span class="badge-wa-status"><i class="fe fe-check-circle"></i> Terhubung</span>
                        </div>
                    </div>

                    <div class="shipping-label-item">
                        <span class="shipping-label-key"><i class="fe fe-navigation"></i> Alamat Tujuan</span>
                        <div class="shipping-address-text-box" id="displayRecipientAddressShop">
                            {{ $currUserShop->address ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5C. PAYMENT & TOMBOL BAYAR SECTION (Shown when phone & address exist) -->
            <div class="payment-action-card {{ !$hasShippingShop ? 'd-none' : '' }}" id="paymentActionSectionShop">
                <div class="payment-card-title">
                    <i class="fe fe-credit-card"></i>
                    <span>Metode Pembayaran</span>
                </div>

                <div class="payment-methods-list">
                    <label class="payment-method-tile active" onclick="selectPaymentMethodShop('bca', this)">
                        <input type="radio" name="payment_method_choice_shop" value="bca" checked class="d-none">
                        <div class="payment-tile-left">
                            <div class="payment-badge-icon bca-badge">BCA</div>
                            <div>
                                <div class="payment-tile-name">Transfer Bank BCA</div>
                                <div class="payment-tile-desc">Rek: 123-456-7890 a/n Toko Kopi Tanjoe</div>
                            </div>
                        </div>
                        <i class="fe fe-check-circle payment-check-indicator"></i>
                    </label>

                    <label class="payment-method-tile" onclick="selectPaymentMethodShop('mandiri', this)">
                        <input type="radio" name="payment_method_choice_shop" value="mandiri" class="d-none">
                        <div class="payment-tile-left">
                            <div class="payment-badge-icon mandiri-badge">Mandiri</div>
                            <div>
                                <div class="payment-tile-name">Bank Mandiri / Livin'</div>
                                <div class="payment-tile-desc">Rek: 987-654-3210 a/n Toko Kopi Tanjoe</div>
                            </div>
                        </div>
                        <i class="fe fe-check-circle payment-check-indicator"></i>
                    </label>

                    <label class="payment-method-tile" onclick="selectPaymentMethodShop('wa_direct', this)">
                        <input type="radio" name="payment_method_choice_shop" value="wa_direct" class="d-none">
                        <div class="payment-tile-left">
                            <div class="payment-badge-icon wa-badge"><i class="fe fe-message-circle"></i></div>
                            <div>
                                <div class="payment-tile-name">Konfirmasi Chat WhatsApp Roastery</div>
                                <div class="payment-tile-desc">Kirim rincian invoice langsung ke admin Roaster</div>
                            </div>
                        </div>
                        <i class="fe fe-check-circle payment-check-indicator"></i>
                    </label>
                </div>

                <!-- Ringkasan Biaya -->
                <div class="payment-summary-box">
                    <div class="payment-summary-row">
                        <span class="text-muted">Total Jml Produk</span>
                        <span class="font-weight-bold" id="paySummaryBeansCountShop">0 Produk</span>
                    </div>
                    <div class="payment-summary-row">
                        <span class="text-muted">Subtotal Produk</span>
                        <span class="font-weight-bold text-dark" id="paySummarySubtotalShop">Rp 0</span>
                    </div>
                    <div class="payment-summary-row">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span class="badge-manual-shipping">Akan dihitung manual</span>
                    </div>
                    <div class="payment-summary-divider"></div>
                    <div class="payment-summary-row total-row">
                        <span class="total-label">Total Tagihan</span>
                        <span class="total-amount-val" id="paySummaryFinalTotalShop">Rp 0</span>
                    </div>
                </div>

                <!-- TOMBOL BAYAR SEKARANG -->
                <button type="button" class="btn-pay-now" id="btnExecutePayShop" onclick="handleExecutePaymentShop()">
                    <i class="fe fe-check-circle"></i>
                    <span>Bayar Sekarang (<span class="btn-pay-amount-label" id="btnPayAmountLabelShop">Rp 0</span>)</span>
                </button>
            </div>

        @else
            <!-- Public Auth / Login Card ("Satu Langkah Lagi Menuju Seduhan") -->
            <div class="auth-main-card">
                <div class="auth-card-title">
                    <i class="fe fe-coffee"></i>
                    <span>Satu Langkah Lagi Menuju Seduhan</span>
                </div>
                <p class="auth-card-desc">
                    Masuk akun untuk menyimpan alamat pengiriman roastery otomatis, melacak batch roasting, dan mengumpulkan Tanjoe Bean Points.
                </p>

                <!-- Tab Switcher -->
                <div class="auth-nav-tabs">
                    <button type="button" class="auth-tab-btn active" id="tabMasukAkunBtnShop">Masuk Akun</button>
                    <button type="button" class="auth-tab-btn" id="tabDaftarBaruBtnShop">Daftar Baru</button>
                </div>

                <!-- Google Fast Login -->
                <a href="{{ route('login_google', ['redirect' => 'shop-checkout']) }}" class="btn-google-sso">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="16" height="16" alt="Google">
                    <span>Lanjut Cepat dengan Google</span>
                </a>

                <div class="auth-or-divider">atau gunakan Akun Tanjoe</div>

                <!-- FORM LOGIN (Masuk Akun) -->
                <form id="formLoginCheckoutShop" action="{{ url('auth-process') }}" method="POST">
                    @csrf
                    <div class="form-group-field">
                        <div class="field-label-row">
                            <label class="field-label">Alamat Email</label>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-at-sign input-icon-prefix"></i>
                            <input type="email" name="email" class="custom-form-input" placeholder="barista@homebrew.id" required id="checkoutEmailInputShop">
                            <i class="fe fe-check-circle input-icon-suffix d-none" id="emailCheckValidShop"></i>
                        </div>
                    </div>

                    <div class="form-group-field">
                        <div class="field-label-row">
                            <label class="field-label">Kata Sandi / PIN</label>
                            <a href="{{ url('forgot-password') }}" class="field-link">Lupa Sandi?</a>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-key input-icon-prefix"></i>
                            <input type="password" name="password" class="custom-form-input" placeholder="••••••••••••••" required id="checkoutPasswordInputShop">
                            <i class="fe fe-eye text-muted cursor-pointer" id="togglePasswordVisibilityShop"></i>
                        </div>
                    </div>

                    <div class="remember-row">
                        <label class="remember-label-box mb-0">
                            <input type="checkbox" name="remember" checked style="accent-color: #BE0017;">
                            <span>Ingat sesi di ponsel ini</span>
                        </label>
                        <span class="trust-shield-tag">
                            <i class="fe fe-shield"></i> Aman
                        </span>
                    </div>

                    <button type="submit" class="btn-submit-auth">
                        <span>Masuk & Lanjut ke Pengiriman</span>
                        <i class="fe fe-arrow-right"></i>
                    </button>
                </form>

                <!-- FORM REGISTER (Daftar Baru) -->
                <form id="formRegisterCheckoutShop" action="{{ route('register_user') }}" method="POST" class="d-none">
                    @csrf
                    <div class="form-group-field">
                        <div class="field-label-row">
                            <label class="field-label">Nama Lengkap</label>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-user input-icon-prefix"></i>
                            <input type="text" name="name" class="custom-form-input" placeholder="Nama Barista / Pemesan" required>
                        </div>
                    </div>

                    <div class="form-group-field">
                        <div class="field-label-row">
                            <label class="field-label">Nomor WhatsApp / HP</label>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-phone input-icon-prefix"></i>
                            <input type="tel" name="phone" class="custom-form-input" placeholder="0812xxxxxxxx" required>
                        </div>
                    </div>

                    <div class="form-group-field">
                        <div class="field-label-row">
                            <label class="field-label">Alamat Email</label>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-at-sign input-icon-prefix"></i>
                            <input type="email" name="email" class="custom-form-input" placeholder="barista@homebrew.id" required>
                        </div>
                    </div>

                    <div class="form-group-field">
                        <div class="field-label-row">
                            <label class="field-label">Kata Sandi</label>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-key input-icon-prefix"></i>
                            <input type="password" name="password" class="custom-form-input" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>

                    <div class="form-group-field mb-3">
                        <div class="field-label-row">
                            <label class="field-label">Konfirmasi Kata Sandi</label>
                        </div>
                        <div class="custom-input-wrap">
                            <i class="fe fe-key input-icon-prefix"></i>
                            <input type="password" name="password_confirmation" class="custom-form-input" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit-auth">
                        <span>Daftar & Lanjut ke Pengiriman</span>
                        <i class="fe fe-arrow-right"></i>
                    </button>
                </form>

            </div>

            <!-- Express WhatsApp Guest Checkout Box -->
            <div class="express-wa-box">
                <div class="express-icon-box">
                    <i class="fe fe-headphones"></i>
                </div>
                <div>
                    <div class="express-title">Pesan Kilat Tanpa Akun?</div>
                    <p class="express-desc">
                        Sedang buru-buru? Hubungi Roaster Tanjoe via WhatsApp. Keranjang <b id="expressWaTotalDisplayShop">Rp 0</b> Anda otomatis diformat ke pesan chat.
                    </p>
                    <a href="#" target="_blank" class="express-wa-link" id="btnExpressCheckoutWhatsAppShop">
                        <span>Kirim Keranjang ke Admin WhatsApp</span>
                        <i class="fe fe-arrow-up-right"></i>
                    </a>
                </div>
            </div>
        @endif

        <!-- Trust Footer -->
        <div class="checkout-trust-footer">
            <div class="trust-pill-text">
                <i class="fe fe-lock"></i>
                <span>Enkripsi 256-Bit SSL &bull; Transaksi Terlindungi</span>
            </div>
            <p class="trust-sub-note">
                Toko Kopi Tanjoe menjamin keaslian lot beans, tanggal roasting fresh, dan privasi kontak Anda.
            </p>
        </div>

    </div>

</div>

<!-- Product Detail Modal -->
<div class="modal fade" id="modalProductDetail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center justify-content-between">
                <h6 class="modal-title font-heading font-weight-bold" id="detailModalTitle">Detail Kopi</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <!-- Swiper Slider in Modal -->
                <div class="swiper modal-slider position-relative">
                    <div class="swiper-wrapper" id="modalSliderWrapper"></div>
                    <div class="swiper-pagination"></div>
                </div>

                <div class="p-3">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div>
                            <h5 class="font-heading font-weight-bold mb-1" id="detailModalName"></h5>
                            <p class="text-muted fs-12 mb-0" id="detailModalOrigin"></p>
                        </div>
                        <div class="text-right">
                            <div class="font-heading font-weight-bold fs-16 text-danger" id="detailModalPrice"></div>
                            <span class="badge badge-pill badge-success fs-10" id="detailModalStatus">Ready</span>
                        </div>
                    </div>

                    <!-- Technical Specs Grid -->
                    <div class="bg-light p-2 rounded mb-3 fs-12">
                        <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Origin:</span><b id="specOrigin">-</b></div>
                        <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Elevation:</span><b id="specElevation">-</b></div>
                        <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Varietal:</span><b id="specVarietal">-</b></div>
                        <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Process:</span><b id="specProcess">-</b></div>
                        <div class="d-flex justify-content-between py-1 border-bottom"><span class="text-muted">Processor:</span><b id="specProcessor">-</b></div>
                        <div class="d-flex justify-content-between py-1"><span class="text-muted">Harvest:</span><b id="specHarvest">-</b></div>
                    </div>

                    <!-- Tasting Notes / Description -->
                    <div class="mb-3">
                        <label class="font-weight-bold fs-12 text-secondary mb-1">Tasting Notes & Deskripsi:</label>
                        <div class="fs-12 text-muted" id="detailModalDesc"></div>
                    </div>

                    <!-- Add to Cart Builder Box -->
                    <div class="border rounded p-2 mb-2 bg-white">
                        <div class="form-group mb-2">
                            <label class="fs-12 font-weight-bold mb-1" id="labelGrindOption">Pilihan Kemasan & Profil Gilingan:</label>
                            <select class="form-control form-control-sm mb-2" id="selectGrindOption">
                                <option value="Whole Beans (Biji Utuh)">Whole Beans (Biji Utuh)</option>
                                <option value="Giling Halus (Espresso)">Giling Halus (Espresso / Mokapot)</option>
                                <option value="Giling Sedang (V60)">Giling Sedang (V60 / Filter)</option>
                                <option value="Giling Kasar (French Press)">Giling Kasar (French Press / Cold Brew)</option>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label class="fs-11 font-weight-bold text-muted mb-1">Catatan Tambahan (opsional):</label>
                            <input type="text" class="form-control form-control-sm" id="modalCustomerNote" placeholder="Contoh: Portafilter 51mm Bottomless, Roasting Dark, dll.">
                        </div>

                        <div class="pt-2">
                            <button type="button" class="btn btn-danger btn-block rounded-pill font-weight-bold py-2 shadow-sm" id="btnModalAddToCart">
                                <i class="fe fe-shopping-cart mr-1"></i> + Masukkan Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
    // -------------------------------------------------------------
    // CART STATE STORE (localStorage based persistent shopping cart)
    // -------------------------------------------------------------
    var CART_KEY = 'tanjoe_cart_items_v2';
    var VOUCHER_APPLIED_KEY = 'tanjoe_cart_voucher_applied_v2';
    var PROMO_DISCOUNT_AMOUNT = 25000;

    function getCart() {
        try {
            var raw = localStorage.getItem(CART_KEY);
            return raw ? JSON.parse(raw) : [];
        } catch(e) {
            return [];
        }
    }

    function saveCart(cart) {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        updateCartBadgeUI();
        renderCartView();
    }

    function isVoucherApplied() {
        return localStorage.getItem(VOUCHER_APPLIED_KEY) !== 'false';
    }

    function setVoucherApplied(applied) {
        localStorage.setItem(VOUCHER_APPLIED_KEY, applied ? 'true' : 'false');
        renderCartView();
    }

    function formatRupiah(num) {
        return 'Rp ' + (num || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function showCartToast(msg) {
        var $toast = $('#cartToast');
        $('#cartToastText').text(msg || 'Berhasil ditambahkan ke keranjang!');
        $toast.addClass('show');
        setTimeout(function() {
            $toast.removeClass('show');
        }, 2600);
    }

    // Seed default sample cart if totally empty on first visit so user gets the exact experience
    if (!localStorage.getItem(CART_KEY)) {
        var initialSample = [
            {
                id: 1,
                name: 'Catuji H. Cucu',
                origin: 'Mekarwangi, W. Java',
                process: 'Anaerobic Honey',
                variant: 'Whole Beans (Biji Utuh)',
                price: 130000,
                quantity: 1,
                weight: '200g',
                note: '',
                selected: true,
                image: '{{ asset("assets/images/products/no-image.png") }}'
            },
            {
                id: 2,
                name: 'HSN Gedong Alas',
                origin: 'Temanggung',
                process: 'Hermetic Sealed Natural',
                variant: 'Giling Halus (Espresso)',
                price: 130000,
                quantity: 2,
                weight: '200g',
                note: 'Portafilter 51mm Bottomless',
                selected: true,
                image: '{{ asset("assets/images/products/no-image.png") }}'
            },
            {
                id: 3,
                name: 'Mosto Bodjongwaroe',
                origin: 'Bodjongwaroe, W. Java',
                process: 'Mosto Washed',
                variant: 'Giling Sedang (V60)',
                price: 125000,
                quantity: 1,
                weight: '200g',
                note: '',
                selected: true,
                image: '{{ asset("assets/images/products/no-image.png") }}'
            }
        ];
        localStorage.setItem(CART_KEY, JSON.stringify(initialSample));
        localStorage.setItem(VOUCHER_APPLIED_KEY, 'true');
    }

    // -------------------------------------------------------------
    // CART BADGE & UI UPDATES
    // -------------------------------------------------------------
    function updateCartBadgeUI() {
        var cart = getCart();
        var totalQty = 0;
        cart.forEach(function(item) {
            totalQty += (parseInt(item.quantity) || 1);
        });

        $('#cartBadgeCount').text(totalQty);
        $('#bottomNavCartCount').text(totalQty);
        if (totalQty > 0) {
            $('#bottomNavCartCount').removeClass('d-none');
        } else {
            $('#bottomNavCartCount').addClass('d-none');
        }

        // Update bottom bar cart badge
        var $bottomBarBadge = $('#bottomBarCartBadge');
        if ($bottomBarBadge.length) {
            $bottomBarBadge.text(totalQty > 99 ? '99+' : totalQty);
            if (totalQty > 0) {
                $bottomBarBadge.show();
            } else {
                $bottomBarBadge.hide();
            }
        }

        // Pop animation
        $('#cartBadgeCount').addClass('pop');
        setTimeout(function() {
            $('#cartBadgeCount').removeClass('pop');
        }, 300);
    }

    // -------------------------------------------------------------
    // RENDER CART VIEW
    // -------------------------------------------------------------
    function renderCartView() {
        var cart = getCart();
        var $stream = $('#cartItemsListStream');
        $stream.empty();

        if (cart.length === 0) {
            $('#emptyCartDisplay').removeClass('d-none');
            $('#orderSummaryCard').addClass('d-none');
            $('#cartStickyCheckoutBar').addClass('d-none');
            $('#selectAllLabel').text('Pilih Semua (0)');
            $('#cartTotalItemsCountBadge').text('0 Barang');
            return;
        }

        $('#emptyCartDisplay').addClass('d-none');
        $('#orderSummaryCard').removeClass('d-none');
        $('#cartStickyCheckoutBar').removeClass('d-none');

        var totalItemsCount = 0;
        var selectedItemsCount = 0;
        var rawSubtotal = 0;
        var allSelected = true;

        cart.forEach(function(item, index) {
            var isChecked = item.selected !== false;
            if (isChecked) {
                selectedItemsCount += item.quantity;
                rawSubtotal += (item.price * item.quantity);
            } else {
                allSelected = false;
            }
            totalItemsCount += item.quantity;

            var itemTotalPrice = item.price * item.quantity;
            var notePlaceholder = 'Tulis Catatan Gilingan (e.g. Medium Coarse V60)';
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
                                <div class="cart-item-price">${formatRupiah(itemTotalPrice)}</div>
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
                        <input type="text" class="cart-item-note-input" data-index="${index}" placeholder="${notePlaceholder}" value="${noteValue}">
                    </div>
                </div>
            `;
            $stream.append(itemCardHtml);
        });

        $('#cartTotalItemsCountBadge').text(cart.length + ' Barang');
        $('#selectAllLabel').text(`Pilih Semua (${cart.length})`);
        $('#selectAllCartCheckbox').prop('checked', allSelected && cart.length > 0);

        var grandTotal = rawSubtotal;

        $('#summaryTotalItemsLabel').text(`Total Harga (${selectedItemsCount} barang)`);
        $('#summaryRawSubtotal').text(formatRupiah(rawSubtotal));
        $('#summaryGrandTotal').text(formatRupiah(grandTotal));
        $('#stickyTotalBelanja').text(formatRupiah(grandTotal));
        $('#checkoutBtnLabel').text(`Checkout (${selectedItemsCount})`);

        if (selectedItemsCount === 0) {
            $('#btnCheckoutWhatsApp').prop('disabled', true);
        } else {
            $('#btnCheckoutWhatsApp').prop('disabled', false);
        }
    }

    // -------------------------------------------------------------
    // CART ACTIONS (Add, Qty change, Delete, Notes, Voucher, Select)
    // -------------------------------------------------------------

    // Add to cart from Product Card button directly
    $(document).on('click', '.btn-add-cart-direct', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        var name = $(this).data('name');
        var origin = $(this).data('origin');
        var process = $(this).data('process');
        var price = parseInt($(this).data('price')) || 0;
        var image = $(this).data('image');

        var cart = getCart();
        var existingIdx = cart.findIndex(function(item) {
            return item.id == id && item.variant === 'Whole Beans (Biji Utuh)';
        });

        if (existingIdx !== -1) {
            cart[existingIdx].quantity += 1;
        } else {
            cart.push({
                id: id,
                name: name,
                origin: origin,
                process: process,
                variant: 'Whole Beans (Biji Utuh)',
                price: price,
                quantity: 1,
                weight: '200g',
                note: '',
                selected: true,
                image: image
            });
        }

        saveCart(cart);
        showCartToast(name + ' ditambahkan ke keranjang!');
    });

    // Add to cart from Modal
    $('#btnModalAddToCart').on('click', function() {
        if (!currentModalProduct) return;
        var grind = $('#selectGrindOption').val();
        var note = $('#modalCustomerNote').val();
        var qty = 1;

        var cart = getCart();
        var existingIdx = cart.findIndex(function(item) {
            return item.id == currentModalProduct.id && item.variant === grind;
        });

        if (existingIdx !== -1) {
            cart[existingIdx].quantity += qty;
            if (note) cart[existingIdx].note = note;
        } else {
            var firstImg = currentModalProduct.images && currentModalProduct.images.length > 0 ? currentModalProduct.images[0] : '';
            cart.push({
                id: currentModalProduct.id,
                name: currentModalProduct.name,
                origin: $('#specOrigin').text(),
                process: $('#specProcess').text(),
                variant: grind,
                price: currentModalProduct.price,
                quantity: qty,
                weight: currentModalProduct.satuan || '200g',
                note: note,
                selected: true,
                image: firstImg
            });
        }

        saveCart(cart);
        $('#modalProductDetail').modal('hide');
        showCartToast(currentModalProduct.name + ' ditambahkan ke keranjang!');
    });

    // Qty Stepper in Cart
    $(document).on('click', '.btn-cart-plus', function() {
        var idx = $(this).data('index');
        var cart = getCart();
        if (cart[idx]) {
            cart[idx].quantity += 1;
            saveCart(cart);
        }
    });

    $(document).on('click', '.btn-cart-minus', function() {
        var idx = $(this).data('index');
        var cart = getCart();
        if (cart[idx]) {
            if (cart[idx].quantity > 1) {
                cart[idx].quantity -= 1;
                saveCart(cart);
            } else {
                if (confirm('Hapus ' + cart[idx].name + ' dari keranjang?')) {
                    cart.splice(idx, 1);
                    saveCart(cart);
                }
            }
        }
    });

    // Delete single item
    $(document).on('click', '.btn-remove-item', function() {
        var idx = $(this).data('index');
        var cart = getCart();
        if (cart[idx]) {
            cart.splice(idx, 1);
            saveCart(cart);
            showCartToast('Produk dihapus dari keranjang.');
        }
    });

    // Delete All
    $('#btnClearAllCart').on('click', function() {
        if (confirm('Apakah Anda yakin ingin mengosongkan seluruh isi keranjang?')) {
            saveCart([]);
            showCartToast('Keranjang telah dikosongkan.');
        }
    });

    // Select Individual Checkbox
    $(document).on('change', '.cart-item-checkbox', function() {
        var idx = $(this).data('index');
        var isChecked = $(this).is(':checked');
        var cart = getCart();
        if (cart[idx]) {
            cart[idx].selected = isChecked;
            saveCart(cart);
        }
    });

    // Select All Checkbox
    $('#selectAllCartCheckbox').on('change', function() {
        var isChecked = $(this).is(':checked');
        var cart = getCart();
        cart.forEach(function(item) {
            item.selected = isChecked;
        });
        saveCart(cart);
    });

    // Edit Note input live
    $(document).on('change', '.cart-item-note-input', function() {
        var idx = $(this).data('index');
        var val = $(this).val();
        var cart = getCart();
        if (cart[idx]) {
            cart[idx].note = val;
            saveCart(cart);
        }
    });

    // -------------------------------------------------------------
    // NAVIGATION & VIEW SWITCHER (Katalog <-> Keranjang <-> Checkout)
    // -------------------------------------------------------------
    function switchView(target) {
        if (target === 'cart') {
            $('#viewCatalogSection').addClass('d-none');
            $('#topHeaderShop').addClass('d-none');
            $('#viewCheckoutSection').addClass('d-none');
            $('#viewCartSection').removeClass('d-none');
            renderCartView();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else if (target === 'checkout') {
            $('#viewCatalogSection').addClass('d-none');
            $('#topHeaderShop').addClass('d-none');
            $('#viewCartSection').addClass('d-none');
            $('#viewCheckoutSection').removeClass('d-none');
            initCheckoutOrderShop();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            $('#viewCartSection').addClass('d-none');
            $('#viewCheckoutSection').addClass('d-none');
            $('#topHeaderShop').removeClass('d-none');
            $('#viewCatalogSection').removeClass('d-none');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }

    // Checkout Order Summary Loader in Shop
    function initCheckoutOrderShop() {
        var cart = getCart();
        var selectedItems = cart.filter(function(i) { return i.selected !== false; });
        if (selectedItems.length === 0) selectedItems = cart;

        var totalQty = 0;
        var rawSubtotal = 0;
        var $thumbsStack = $('#orderThumbnailsStackShop');
        var $drawer = $('#orderBreakdownDrawerItemsShop');
        
        $thumbsStack.empty();
        $drawer.empty();

        selectedItems.forEach(function(item, idx) {
            totalQty += (parseInt(item.quantity) || 1);
            var itemTotal = item.price * item.quantity;
            rawSubtotal += itemTotal;

            if (idx < 3) {
                var imgUrl = item.image || '{{ asset("assets/images/products/no-image.png") }}';
                $thumbsStack.append('<img src="' + imgUrl + '" class="order-thumb-avatar" alt="' + item.name + '">');
            }

            var itemRow = `
                <div class="order-breakdown-item">
                    <div>
                        <b>${item.name}</b> (${item.quantity}x)
                        <div class="text-muted fs-11">${item.variant}</div>
                        ${item.note ? '<div class="text-secondary fs-10">Note: ' + item.note + '</div>' : ''}
                    </div>
                    <div class="font-weight-bold text-right">${formatRupiah(itemTotal)}</div>
                </div>
            `;
            $drawer.append(itemRow);
        });

        var grandTotal = rawSubtotal;

        $drawer.append(`
            <div class="order-breakdown-item border-top pt-2 mt-2 fs-13">
                <b>Total Tagihan</b>
                <b class="text-danger">${formatRupiah(grandTotal)}</b>
            </div>
        `);

        $('#checkoutBeansCountPillShop').text(totalQty + ' Beans');
        $('#checkoutOrderTotalTextShop').text(formatRupiah(grandTotal));
        $('#expressWaTotalDisplayShop').text(formatRupiah(grandTotal));

        // Update payment summary box for logged in user
        $('#paySummaryBeansCountShop').text(totalQty + ' Produk');
        $('#paySummarySubtotalShop').text(formatRupiah(rawSubtotal));
        $('#paySummaryFinalTotalShop').text(formatRupiah(grandTotal));
        $('#btnPayAmountLabelShop').text(formatRupiah(grandTotal));

        // Format express WhatsApp message
        var waMessage = "Halo Toko Kopi Tanjoe,\nSaya ingin melakukan pemesanan kilat via WhatsApp:\n\n";
        selectedItems.forEach(function(item, idx) {
            var itemTotal = item.price * item.quantity;
            waMessage += `${idx + 1}. *${item.name}* (${item.weight || '200g'})\n`;
            waMessage += `   • Varian: ${item.variant}\n`;
            waMessage += `   • Jumlah: ${item.quantity} pack @ ${formatRupiah(item.price)} = *${formatRupiah(itemTotal)}*\n`;
            if (item.note) waMessage += `   • Catatan: ${item.note}\n`;
            waMessage += `\n`;
        });
        waMessage += `*Total Tagihan:* *${formatRupiah(grandTotal)}*\n\n`;
        waMessage += `Mohon konfirmasi pesanan kilat ini. Terima kasih!`;

        $('#btnExpressCheckoutWhatsAppShop').attr('href', 'https://wa.me/6285974607547?text=' + encodeURIComponent(waMessage));
    }

    var selectedPaymentMethodValueShop = 'bca';

    window.selectPaymentMethodShop = function(method, el) {
        selectedPaymentMethodValueShop = method;
        $('#paymentActionSectionShop .payment-method-tile').removeClass('active');
        $(el).addClass('active');
        $(el).find('input[type="radio"]').prop('checked', true);
    };

    window.toggleEditShippingFormShop = function(show) {
        if (show) {
            $('#shippingFormSectionShop').removeClass('d-none');
            $('#shippingLabelSectionShop').addClass('d-none');
            $('#paymentActionSectionShop').addClass('d-none');
            
            // Update steps indicator
            $('#stepIndicatorAlamatShop').removeClass('completed').addClass('active');
            $('#stepIndicatorAlamatShop .step-icon-circle').removeClass('step-completed-circle').html('<i class="fe fe-truck"></i><span class="step-active-dot"></span>');
            $('#stepIndicatorAlamatShop .step-label').removeClass('step-completed-label');
            
            $('#stepIndicatorBayarShop').removeClass('active');
            $('#stepIndicatorBayarShop .step-icon-circle').html('<i class="fe fe-credit-card"></i>');
        } else {
            $('#shippingFormSectionShop').addClass('d-none');
            $('#shippingLabelSectionShop').removeClass('d-none');
            $('#paymentActionSectionShop').removeClass('d-none');
            
            // Update steps indicator
            $('#stepIndicatorAlamatShop').removeClass('active').addClass('completed');
            $('#stepIndicatorAlamatShop .step-icon-circle').addClass('step-completed-circle').html('<i class="fe fe-check"></i>');
            $('#stepIndicatorAlamatShop .step-label').addClass('step-completed-label');
            
            $('#stepIndicatorBayarShop').addClass('active');
            $('#stepIndicatorBayarShop .step-icon-circle').html('<i class="fe fe-credit-card"></i><span class="step-active-dot"></span>');

            // Smooth scroll to shipping label and payment
            if ($('#shippingLabelSectionShop').length) {
                $('html, body').animate({
                    scrollTop: $('#shippingLabelSectionShop').offset().top - 80
                }, 300);
            }
        }
    };

    window.handleSaveShippingShop = function(e) {
        if (e && e.preventDefault) {
            e.preventDefault();
        }
        var name = $('#shippingNameInputShop').val() ? $('#shippingNameInputShop').val().trim() : '';
        var phone = $('#shippingPhoneInputShop').val() ? $('#shippingPhoneInputShop').val().trim() : '';
        var address = $('#shippingAddressInputShop').val() ? $('#shippingAddressInputShop').val().trim() : '';

        if (!phone) {
            alert('Mohon isi nomor WhatsApp aktif Anda.');
            $('#shippingPhoneInputShop').focus();
            return false;
        }
        if (phone.length < 8) {
            alert('Nomor WhatsApp minimal 8 digit.');
            $('#shippingPhoneInputShop').focus();
            return false;
        }
        if (!address) {
            alert('Mohon isi alamat lengkap pengiriman.');
            $('#shippingAddressInputShop').focus();
            return false;
        }
        if (address.length < 5) {
            alert('Alamat pengiriman minimal 5 karakter.');
            $('#shippingAddressInputShop').focus();
            return false;
        }

        var $btn = $('#btnSaveShippingSubmitShop');
        var origHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fe fe-loader fe-spin mr-1"></i> Menyimpan Data...');

        var csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

        $.ajax({
            url: '{{ route("shop.save_shipping") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            dataType: 'json',
            data: {
                _token: csrfToken,
                name: name,
                phone: phone,
                address: address
            },
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);

                if (res && res.success) {
                    var u = res.user || {};
                    var resName = u.name || name || '-';
                    var resPhone = u.phone || phone || '-';
                    var resAddress = u.address || address || '-';

                    $('#displayRecipientNameShop').text(resName);
                    $('#displayRecipientPhoneShop').text(resPhone);
                    $('#displayRecipientAddressShop').text(resAddress);

                    $('#shippingNameInputShop').val(resName !== '-' ? resName : '');
                    $('#shippingPhoneInputShop').val(resPhone !== '-' ? resPhone : '');
                    $('#shippingAddressInputShop').val(resAddress !== '-' ? resAddress : '');

                    window.toggleEditShippingFormShop(false);

                    if (typeof window.renderCheckoutSummaryShop === 'function') {
                        window.renderCheckoutSummaryShop();
                    }
                } else {
                    alert((res && res.message) ? res.message : 'Gagal menyimpan data.');
                }
            },
            error: function(err) {
                $btn.prop('disabled', false).html(origHtml);
                var errMsg = 'Terjadi kesalahan saat menyimpan data.';
                if (err.responseJSON) {
                    if (err.responseJSON.message) {
                        errMsg = err.responseJSON.message;
                    } else if (err.responseJSON.errors) {
                        var firstErrKey = Object.keys(err.responseJSON.errors)[0];
                        if (firstErrKey && err.responseJSON.errors[firstErrKey].length > 0) {
                            errMsg = err.responseJSON.errors[firstErrKey][0];
                        }
                    }
                } else if (err.statusText) {
                    errMsg = 'Status: ' + err.statusText + ' (' + err.status + ')';
                }
                alert(errMsg);
            }
        });

        return false;
    };

    window.handleExecutePaymentShop = function() {
        var cart = [];
        try {
            var raw = localStorage.getItem('tanjoe_cart_items_v2');
            cart = raw ? JSON.parse(raw) : [];
        } catch(e){}

        var selectedItems = cart.filter(function(i) { return i.selected !== false; });
        if (selectedItems.length === 0) selectedItems = cart;

        if (selectedItems.length === 0) {
            alert('Keranjang belanja Anda masih kosong.');
            switchView('catalog');
            return;
        }

        var recipientName = $('#displayRecipientNameShop').text().trim();
        var recipientPhone = $('#displayRecipientPhoneShop').text().trim();
        var recipientAddress = $('#displayRecipientAddressShop').text().trim();

        if (!recipientPhone || recipientPhone === '-') {
            alert('Mohon lengkapi nomor WhatsApp aktif Anda terlebih dahulu.');
            toggleEditShippingFormShop(true);
            return;
        }

        if (!recipientAddress || recipientAddress === '-') {
            alert('Mohon lengkapi alamat pengiriman Anda terlebih dahulu.');
            toggleEditShippingFormShop(true);
            return;
        }

        var $btn = $('#btnExecutePayShop');
        var origHtml = $btn.html();
        $btn.prop('disabled', true).html('<i class="fe fe-loader fe-spin mr-2"></i><span>Membuat Pesanan...</span>');

        var csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

        $.ajax({
            url: '{{ route("shop.process_checkout") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            dataType: 'json',
            data: {
                _token: csrfToken,
                name: recipientName !== '-' ? recipientName : '',
                phone: recipientPhone,
                address: recipientAddress,
                items: selectedItems
            },
            success: function(res) {
                $btn.prop('disabled', false).html(origHtml);

                if (res && res.success) {
                    try {
                        var remainingCart = cart.filter(function(i) { return i.selected === false; });
                        localStorage.setItem('tanjoe_cart_items_v2', JSON.stringify(remainingCart));
                    } catch(e) {}

                    if (res.wa_url) {
                        window.open(res.wa_url, '_blank');
                    }

                    alert('Pesanan berhasil dibuat dengan No. Invoice: ' + res.inv_code);
                    switchView('katalog');
                } else {
                    alert((res && res.message) ? res.message : 'Gagal membuat pesanan.');
                }
            },
            error: function(err) {
                $btn.prop('disabled', false).html(origHtml);
                var errMsg = 'Terjadi kesalahan saat memproses pesanan.';
                if (err.responseJSON && err.responseJSON.message) {
                    errMsg = err.responseJSON.message;
                }
                alert(errMsg);
            }
        });
    };

    // Checkout trigger from Cart
    $('#btnCheckoutWhatsApp').on('click', function() {
        var cart = getCart();
        var selectedItems = cart.filter(function(i) { return i.selected !== false; });
        if (selectedItems.length === 0) {
            alert('Pilih minimal satu produk untuk checkout.');
            return;
        }
        window.location.href = "{{ route('shop.checkout') }}";
    });

    $('#btnBackToCartFromCheckout').on('click', function() {
        switchView('cart');
    });

    $('#openCartHeaderBtn').on('click', function() {
        switchView('cart');
    });

    $('#brandLogoNav, #btnBackToCatalog, #btnBackToCatalogTop').on('click', function() {
        switchView('katalog');
    });

    // Checkout Tab Switching in Shop (Masuk vs Daftar)
    $('#tabMasukAkunBtnShop').on('click', function() {
        $(this).addClass('active');
        $('#tabDaftarBaruBtnShop').removeClass('active');
        $('#formLoginCheckoutShop').removeClass('d-none');
        $('#formRegisterCheckoutShop').addClass('d-none');
    });

    $('#tabDaftarBaruBtnShop').on('click', function() {
        $(this).addClass('active');
        $('#tabMasukAkunBtnShop').removeClass('active');
        $('#formRegisterCheckoutShop').removeClass('d-none');
        $('#formLoginCheckoutShop').addClass('d-none');
    });

    // Password visibility toggle in Shop Checkout
    $('#togglePasswordVisibilityShop').on('click', function() {
        var $pwd = $('#checkoutPasswordInputShop');
        if ($pwd.attr('type') === 'password') {
            $pwd.attr('type', 'text');
            $(this).removeClass('fe-eye').addClass('fe-eye-off');
        } else {
            $pwd.attr('type', 'password');
            $(this).removeClass('fe-eye-off').addClass('fe-eye');
        }
    });

    // Email validation indicator in Shop Checkout
    $('#checkoutEmailInputShop').on('input', function() {
        var email = $(this).val();
        if (email.indexOf('@') !== -1 && email.indexOf('.') !== -1) {
            $('#emailCheckValidShop').removeClass('d-none');
        } else {
            $('#emailCheckValidShop').addClass('d-none');
        }
    });

    // Initial render
    updateCartBadgeUI();
    renderCartView();

    // -------------------------------------------------------------
    // CATALOG FILTERING & MODAL CODE
    // -------------------------------------------------------------
    var currentActiveTab = 'all';
    var currentOrigin = 'all';
    var currentProcess = 'all';
    var currentSort = 'default';
    var currentSearch = '';
    var modalSwiper = null;

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

    // Open Detail Modal
    var currentModalProduct = null;
    $(document).on('click', '.open-product-detail', function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        var $raw = $('#raw-product-' + id);
        if (!$raw.length) return;

        var name = $raw.find('.raw-name').text();
        var origin = $raw.find('.raw-origin').text();
        var elevation = $raw.find('.raw-elevation').text();
        var varietal = $raw.find('.raw-varietal').text();
        var process = $raw.find('.raw-process').text();
        var processor = $raw.find('.raw-processor').text();
        var harvest = $raw.find('.raw-harvest').text();
        var price = parseInt($raw.find('.raw-price').text()) || 0;
        var priceFormatted = $raw.find('.raw-price-formatted').text();
        var desc = $raw.find('.raw-desc').html();
        var status = $raw.find('.raw-status').text();
        var type = $raw.find('.raw-type').text();
        var tab = $raw.find('.raw-tab').text();
        var satuan = $raw.find('.raw-satuan').text() || '200gr';
        
        var images = [];
        try {
            images = JSON.parse($raw.find('.raw-images').text());
        } catch(err) {
            images = [];
        }

        currentModalProduct = {
            id: id,
            name: name,
            price: price,
            priceFormatted: priceFormatted,
            images: images,
            type: type,
            tab: tab,
            satuan: satuan
        };

        // Filter / Espresso vs Green Beans grind options
        if (type == '1' || tab === 'greenbeans') {
            $('#labelGrindOption').text('Pilihan Kemasan:');
            $('#selectGrindOption').html(`
                <option value="Whole Beans (Biji Utuh)">Whole Beans (Biji Utuh)</option>
            `);
        } else {
            $('#labelGrindOption').text('Pilihan Kemasan & Profil Gilingan:');
            $('#selectGrindOption').html(`
                <option value="Whole Beans (Biji Utuh)">Whole Beans (Biji Utuh)</option>
                <option value="Giling Halus (Espresso)">Giling Halus (Espresso / Mokapot)</option>
                <option value="Giling Sedang (V60)">Giling Sedang (V60 / Filter)</option>
                <option value="Giling Kasar (French Press)">Giling Kasar (French Press / Cold Brew)</option>
            `);
        }

        $('#detailModalTitle').text(name);
        $('#detailModalName').text(name);
        $('#detailModalOrigin').text(origin + ' • ' + process);
        $('#detailModalPrice').text(priceFormatted);
        $('#specOrigin').text(origin);
        $('#specElevation').text(elevation);
        $('#specVarietal').text(varietal);
        $('#specProcess').text(process);
        $('#specProcessor').text(processor);
        $('#specHarvest').text(harvest);
        $('#detailModalDesc').html(desc || 'Single origin roasted beans pilihan kualitas terbaik.');
        $('#modalCustomerNote').val('');
        
        if (status === 'ready') {
            $('#detailModalStatus').text('Ready Stock').removeClass('badge-danger').addClass('badge-success');
            $('#btnModalAddToCart').removeClass('d-none');
        } else {
            $('#detailModalStatus').text('Sold Out').removeClass('badge-success').addClass('badge-danger');
            $('#btnModalAddToCart').addClass('d-none');
        }

        // Build Slider Slides
        var slidesHtml = '';
        if (images.length > 0) {
            $.each(images, function(i, url) {
                slidesHtml += '<div class="swiper-slide" data-img="' + url + '"><img src="' + url + '" alt="' + name + '"></div>';
            });
        } else {
            slidesHtml = '<div class="swiper-slide"><img src="{{ asset('assets/images/products/no-image.png') }}" alt="' + name + '"></div>';
        }
        $('#modalSliderWrapper').html(slidesHtml);

        $('#modalProductDetail').modal('show');

        setTimeout(function() {
            if (modalSwiper) modalSwiper.destroy(true, true);
            modalSwiper = new Swiper('.modal-slider', {
                loop: false,
                pagination: {
                    el: '.modal-slider .swiper-pagination',
                    clickable: true,
                },
            });
        }, 200);
    });

    // Check initial URL params or hash
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('tab') === 'cart' || window.location.hash === '#cart') {
        switchView('cart');
    } else if (urlParams.get('tab') === 'checkout' || window.location.hash === '#checkout') {
        window.location.href = "{{ route('shop.checkout') }}";
    }
});
</script>

</x-layouts.public>
