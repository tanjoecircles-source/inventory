<x-layouts.public metatitle="Checkout Pesanan" metadesc="Checkout Pesanan - Toko Kopi Tanjoe Artisan Roastery">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

<style>
    :root {
        --color-surface: #FAF8F5;
        --color-surface-card: #FFFFFF;
        --color-surface-dim: #EFECE6;
        --color-primary: #BE0017;
        --color-primary-accent: #E62129;
        --color-primary-light: rgba(230, 33, 41, 0.08);
        --color-secondary: #1F2429;
        --color-secondary-muted: #6B7280;
        --color-tertiary: #10B981;
        --color-tertiary-dark: #00875D;
        --color-error: #EF4444;
        --color-chip-bg: #F4EFE6;
        --color-border: #ECE7DE;
        --shadow-card: 0 2px 10px -2px rgba(50, 45, 40, 0.07), 0 1px 3px 0 rgba(0, 0, 0, 0.03);
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

    .checkout-wrapper {
        max-width: 600px;
        margin: 0 auto;
        padding-bottom: 50px;
        min-height: 100vh;
        background-color: var(--color-surface);
    }

    /* Simple Clean Checkout Header */
    .checkout-simple-header {
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
    .btn-checkout-back {
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
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-checkout-back:hover {
        background: #ECE7DE;
        color: var(--color-primary);
    }
    .checkout-header-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 17px;
        color: var(--color-secondary);
        margin: 0;
        line-height: 1;
    }

    /* Order Summary Card (Direct View) */
    .order-mini-summary-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin: 0 16px 14px;
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }
    .order-summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px 10px;
    }
    .order-bag-icon-box {
        width: 36px;
        height: 36px;
        background: #FEE2E2;
        color: var(--color-primary-accent);
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
        color: var(--color-primary-accent);
        margin-top: 1px;
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

    /* Auth / Login Card */
    .auth-main-card {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin: 0 16px 14px;
        padding: 18px 16px 20px;
        box-shadow: var(--shadow-card);
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
        color: var(--color-primary-accent);
        font-size: 17px;
    }
    .auth-card-desc {
        font-size: 11.5px;
        color: var(--color-secondary-muted);
        line-height: 1.4;
        margin-bottom: 16px;
    }

    /* Segmented Tab Switcher (Masuk Akun vs Daftar Baru) */
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
        background: var(--color-primary);
        color: #FFFFFF !important;
        box-shadow: 0 2px 6px rgba(190, 0, 23, 0.25);
    }

    /* Google Button */
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

    /* Divider */
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

    /* Form Fields */
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
        color: var(--color-primary-accent);
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
        border-color: var(--color-primary-accent);
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
        cursor: pointer;
    }

    /* Remember Checkbox & Trust Tag */
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

    /* Submit Button */
    .btn-submit-auth {
        width: 100%;
        background: var(--color-primary);
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
    .btn-submit-auth:hover {
        background: #93000F;
        transform: translateY(-1px);
    }

    /* Logged User Banner */
    .logged-user-banner {
        background: #FFFFFF;
        border: 1px solid var(--color-border);
        border-radius: var(--radius-lg);
        margin: 0 16px 12px;
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
        margin: 0 16px 14px;
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
        margin: 0 16px 14px;
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
    .payment-info-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
    }
    .payment-info-icon-box {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #FEE2E2;
        color: #BE0017;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .payment-info-text {
        font-size: 12px;
        color: #475569;
        line-height: 1.45;
        font-weight: 500;
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
    .badge-manual-shipping {
        font-size: 11px;
        font-weight: 600;
        color: #4B5563;
        background: #F1F5F9;
        border: 1px solid #E2E8F0;
        padding: 2px 8px;
        border-radius: 9999px;
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

    /* Express WhatsApp Order Box */
    .express-wa-box {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: var(--radius-lg);
        margin: 0 16px 16px;
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

    /* Trust Footer */
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
</style>

@php
    $isLoggedIn = Auth::check();
    $currUser = Auth::user();
    $hasShipping = $isLoggedIn && !empty($currUser->phone) && !empty($currUser->address);
@endphp

<div class="checkout-wrapper">
    
    <!-- Clean Checkout Header -->
    <div class="checkout-simple-header mb-3">
        <a href="{{ url('/shop?tab=cart') }}" class="btn-checkout-back" title="Kembali">
            <i class="fe fe-arrow-left"></i>
        </a>
        <h1 class="checkout-header-title">Checkout</h1>
    </div>

    @if($isLoggedIn)
        <!-- Logged-in User Account Banner -->
        <div class="logged-user-banner">
            <div class="d-flex align-items-center">
                <div class="user-avatar-badge">
                    {{ strtoupper(substr($currUser->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-meta-info">
                    <div class="user-name-title">
                        <span>{{ $currUser->name ?? 'Pelanggan Tanjoe' }}</span>
                        <span class="badge-user-verified"><i class="fe fe-check-circle"></i> Masuk</span>
                    </div>
                    <div class="user-email-subtitle">{{ $currUser->email ?? '' }}</div>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="btn-logout-switch" title="Keluar / Ganti Akun">
                <i class="fe fe-log-out"></i>
                <span>Ganti</span>
            </a>
        </div>
    @endif

    <!-- 4. Direct Order Summary ("Pesanan Anda") -->
    <div class="order-mini-summary-card">
        <div class="order-summary-header">
            <div class="d-flex align-items-center">
                <div class="order-bag-icon-box">
                    <i class="fe fe-shopping-bag"></i>
                </div>
                <div>
                    <div class="order-title-text">
                        <span>Pesanan Anda</span>
                        <span class="order-beans-count-pill" id="checkoutBeansCountPill">0 Beans</span>
                    </div>
                    <div class="order-total-price-text" id="checkoutOrderTotalText">Rp 0</div>
                </div>
            </div>
        </div>

        <div class="order-breakdown-drawer" id="orderBreakdownDrawerItems">
            <!-- Populated via JS from cart -->
        </div>
    </div>

    @if($isLoggedIn)
        <!-- 5A. FORM LENGKAPI DATA PENGIRIMAN (Shown when phone/address is missing or user clicks Edit) -->
        <div class="auth-main-card {{ $hasShipping ? 'd-none' : '' }}" id="shippingFormSection">
            <div class="auth-card-title">
                <i class="fe fe-map-pin"></i>
                <span>Lengkapi Data & Alamat Pengiriman</span>
            </div>
            <p class="auth-card-desc">
                Mohon lengkapi nomor WhatsApp aktif dan alamat pengiriman untuk koordinasi pengiriman biji kopi pesanan Anda.
            </p>

            <form id="formShippingAddress" onsubmit="handleSaveShipping(event)">
                @csrf
                <div class="form-group-field">
                    <div class="field-label-row">
                        <label class="field-label">Nama Penerima</label>
                    </div>
                    <div class="custom-input-wrap">
                        <i class="fe fe-user input-icon-prefix"></i>
                        <input type="text" name="name" id="shippingNameInput" class="custom-form-input" value="{{ $currUser->name ?? '' }}" placeholder="Nama Lengkap Penerima" required>
                    </div>
                </div>

                <div class="form-group-field">
                    <div class="field-label-row">
                        <label class="field-label">Nomor WhatsApp / HP Aktif</label>
                    </div>
                    <div class="custom-input-wrap">
                        <i class="fe fe-phone input-icon-prefix"></i>
                        <input type="tel" name="phone" id="shippingPhoneInput" class="custom-form-input" value="{{ $currUser->phone ?? '' }}" placeholder="08xxxxxxxxxx" required>
                        <i class="fe fe-check-circle input-icon-suffix d-none" id="phoneValidIcon"></i>
                    </div>
                    <small class="field-help-hint">*Digunakan untuk konfirmasi nomor resi pengiriman & update kurir.</small>
                </div>

                <div class="form-group-field mb-3">
                    <div class="field-label-row">
                        <label class="field-label">Alamat Lengkap Pengiriman</label>
                    </div>
                    <div class="custom-input-wrap custom-textarea-wrap">
                        <i class="fe fe-map-pin input-icon-prefix align-self-start mt-2"></i>
                        <textarea name="address" id="shippingAddressInput" rows="3" class="custom-form-textarea" placeholder="Tuliskan nama jalan, nomor rumah/toko, RT/RW, kelurahan, kecamatan, kota/kabupaten, dan kode pos..." required>{{ $currUser->address ?? '' }}</textarea>
                    </div>
                    <small class="field-help-hint">*Pastikan alamat detail agar kurir dapat mengantar tepat waktu.</small>
                </div>

                <div class="d-flex align-items-center gap-2">
                    @if($hasShipping)
                        <button type="button" class="btn btn-light btn-sm mr-2" style="border-radius: 9999px;" onclick="toggleEditShippingForm(false)">
                            Batal
                        </button>
                    @endif
                    <button type="submit" class="btn-submit-auth" id="btnSaveShippingSubmit">
                        <span id="btnSaveShippingText">Simpan & Lanjut ke Pembayaran</span>
                        <i class="fe fe-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- 5B. LABEL MODE: ALAMAT & KONTAK PENGIRIMAN (Shown when phone & address exist) -->
        <div class="shipping-summary-card {{ !$hasShipping ? 'd-none' : '' }}" id="shippingLabelSection">
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
                <button type="button" class="btn-edit-shipping-pill" id="btnToggleEditShipping" onclick="toggleEditShippingForm(true)">
                    <i class="fe fe-edit-2"></i>
                    <span>Ubah</span>
                </button>
            </div>

            <div class="shipping-labels-grid">
                <div class="shipping-label-item">
                    <span class="shipping-label-key"><i class="fe fe-user"></i> Penerima</span>
                    <span class="shipping-label-val recipient-name" id="displayRecipientName">{{ $currUser->name ?? '-' }}</span>
                </div>

                <div class="shipping-label-item">
                    <span class="shipping-label-key"><i class="fe fe-phone"></i> WhatsApp Aktif</span>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="shipping-label-val wa-number" id="displayRecipientPhone">{{ $currUser->phone ?? '-' }}</span>
                        <span class="badge-wa-status"><i class="fe fe-check-circle"></i> Terhubung</span>
                    </div>
                </div>

                <div class="shipping-label-item">
                    <span class="shipping-label-key"><i class="fe fe-navigation"></i> Alamat Tujuan</span>
                    <div class="shipping-address-text-box" id="displayRecipientAddress">
                        {{ $currUser->address ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 5C. PAYMENT & TOMBOL BAYAR SECTION (Shown when phone & address exist) -->
        <div class="payment-action-card {{ !$hasShipping ? 'd-none' : '' }}" id="paymentActionSection">
            <div class="payment-card-title">
                <i class="fe fe-file-text"></i>
                <span>Ringkasan Transaksi</span>
            </div>

            <!-- Keterangan Proses Pembayaran -->
            <div class="payment-info-box">
                <div class="payment-info-icon-box">
                    <i class="fe fe-info"></i>
                </div>
                <div class="payment-info-text">
                    Proses pembayaran akan dilanjutkan melalui admin kami, setelah ongkir dihitung dan invoice diterbitkan.
                </div>
            </div>

            <!-- Ringkasan Biaya -->
            <div class="payment-summary-box">
                <div class="payment-summary-row">
                    <span class="text-muted">Total Jml Produk</span>
                    <span class="font-weight-bold" id="paySummaryBeansCount">0 Produk</span>
                </div>
                <div class="payment-summary-row">
                    <span class="text-muted">Subtotal Produk</span>
                    <span class="font-weight-bold text-dark" id="paySummarySubtotal">Rp 0</span>
                </div>
                <div class="payment-summary-row">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span class="badge-manual-shipping">Akan dihitung manual</span>
                </div>
                <div class="payment-summary-divider"></div>
                <div class="payment-summary-row total-row">
                    <span class="total-label">Total Tagihan</span>
                    <span class="total-amount-val" id="paySummaryFinalTotal">Rp 0</span>
                </div>
            </div>

            <!-- TOMBOL LANJUT CHECKOUT (BY WHATSAPP) -->
            <button type="button" class="btn-pay-now" id="btnExecutePay" onclick="handleExecutePayment()">
                <i class="fe fe-check-circle"></i>
                <span>Konfirmasi Pesanan</span>
            </button>
        </div>

    @else
        <!-- 5. Public Auth / Login Card ("Satu Langkah Lagi Menuju Seduhan") -->
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
                <button type="button" class="auth-tab-btn active" id="tabMasukAkunBtn">Masuk Akun</button>
                <button type="button" class="auth-tab-btn" id="tabDaftarBaruBtn">Daftar Baru</button>
            </div>

            <!-- Google Fast Login -->
            <a href="{{ route('login_google', ['redirect' => 'shop-checkout']) }}" class="btn-google-sso">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="16" height="16" alt="Google">
                <span>Lanjut Cepat dengan Google</span>
            </a>

            <div class="auth-or-divider">atau gunakan Akun Tanjoe</div>

            <!-- FORM LOGIN (Masuk Akun) -->
            <form id="formLoginCheckout" action="{{ url('auth-process') }}" method="POST">
                @csrf
                <div class="form-group-field">
                    <div class="field-label-row">
                        <label class="field-label">Alamat Email</label>
                    </div>
                    <div class="custom-input-wrap">
                        <i class="fe fe-at-sign input-icon-prefix"></i>
                        <input type="email" name="email" class="custom-form-input" placeholder="barista@homebrew.id" required id="checkoutEmailInput">
                        <i class="fe fe-check-circle input-icon-suffix d-none" id="emailCheckValid"></i>
                    </div>
                </div>

                <div class="form-group-field">
                    <div class="field-label-row">
                        <label class="field-label">Kata Sandi / PIN</label>
                        <a href="{{ url('forgot-password') }}" class="field-link">Lupa Sandi?</a>
                    </div>
                    <div class="custom-input-wrap">
                        <i class="fe fe-key input-icon-prefix"></i>
                        <input type="password" name="password" class="custom-form-input" placeholder="••••••••••••••" required id="checkoutPasswordInput">
                        <i class="fe fe-eye text-muted cursor-pointer" id="togglePasswordVisibility"></i>
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
            <form id="formRegisterCheckout" action="{{ route('register_user') }}" method="POST" class="d-none">
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

        <!-- 6. Express WhatsApp Guest Checkout Box -->
        <div class="express-wa-box">
            <div class="express-icon-box">
                <i class="fe fe-headphones"></i>
            </div>
            <div>
                <div class="express-title">Pesan Kilat Tanpa Akun?</div>
                <p class="express-desc">
                    Sedang buru-buru? Hubungi Roaster Tanjoe via WhatsApp. Keranjang <b id="expressWaTotalDisplay">Rp 0</b> Anda otomatis diformat ke pesan chat.
                </p>
                <a href="#" target="_blank" class="express-wa-link" id="btnExpressCheckoutWhatsApp">
                    <span>Kirim Keranjang ke Admin WhatsApp</span>
                    <i class="fe fe-arrow-up-right"></i>
                </a>
            </div>
        </div>
    @endif

    <!-- 7. Trust Footer -->
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

<script>
var selectedPaymentMethodValue = 'bca';

function selectPaymentMethod(method, el) {
    selectedPaymentMethodValue = method;
    $('.payment-method-tile').removeClass('active');
    $(el).addClass('active');
    $(el).find('input[type="radio"]').prop('checked', true);
}

function toggleEditShippingForm(show) {
    if (show) {
        $('#shippingFormSection').removeClass('d-none');
        $('#shippingLabelSection').addClass('d-none');
        $('#paymentActionSection').addClass('d-none');
    } else {
        $('#shippingFormSection').addClass('d-none');
        $('#shippingLabelSection').removeClass('d-none');
        $('#paymentActionSection').removeClass('d-none');

        // Smooth scroll to shipping label and payment
        if ($('#shippingLabelSection').length) {
            $('html, body').animate({
                scrollTop: $('#shippingLabelSection').offset().top - 80
            }, 300);
        }
    }
}

function handleSaveShipping(e) {
    if (e && e.preventDefault) {
        e.preventDefault();
    }
    
    var name = $('#shippingNameInput').val() ? $('#shippingNameInput').val().trim() : '';
    var phone = $('#shippingPhoneInput').val() ? $('#shippingPhoneInput').val().trim() : '';
    var address = $('#shippingAddressInput').val() ? $('#shippingAddressInput').val().trim() : '';

    if (!phone) {
        alert('Mohon isi nomor WhatsApp aktif Anda.');
        $('#shippingPhoneInput').focus();
        return false;
    }
    if (phone.length < 8) {
        alert('Nomor WhatsApp minimal 8 digit.');
        $('#shippingPhoneInput').focus();
        return false;
    }
    if (!address) {
        alert('Mohon isi alamat lengkap pengiriman.');
        $('#shippingAddressInput').focus();
        return false;
    }
    if (address.length < 5) {
        alert('Alamat pengiriman minimal 5 karakter.');
        $('#shippingAddressInput').focus();
        return false;
    }

    var $btn = $('#btnSaveShippingSubmit');
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

                // Update display labels
                $('#displayRecipientName').text(resName);
                $('#displayRecipientPhone').text(resPhone);
                $('#displayRecipientAddress').text(resAddress);

                // Update form fields
                $('#shippingNameInput').val(resName !== '-' ? resName : '');
                $('#shippingPhoneInput').val(resPhone !== '-' ? resPhone : '');
                $('#shippingAddressInput').val(resAddress !== '-' ? resAddress : '');

                // Switch to label & payment view
                toggleEditShippingForm(false);

                // Refresh checkout summary & total price
                if (typeof renderCheckoutSummary === 'function') {
                    renderCheckoutSummary();
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
}

function handleExecutePayment() {
    var cart = [];
    try {
        var raw = localStorage.getItem('tanjoe_cart_items_v2');
        cart = raw ? JSON.parse(raw) : [];
    } catch(e){}

    var selectedItems = cart.filter(function(i) { return i.selected !== false; });
    if (selectedItems.length === 0) selectedItems = cart;

    if (selectedItems.length === 0) {
        alert('Keranjang belanja Anda masih kosong.');
        window.location.href = '{{ url("/shop") }}';
        return;
    }

    var recipientName = $('#displayRecipientName').text().trim();
    var recipientPhone = $('#displayRecipientPhone').text().trim();
    var recipientAddress = $('#displayRecipientAddress').text().trim();

    if (!recipientPhone || recipientPhone === '-') {
        alert('Mohon lengkapi nomor WhatsApp aktif Anda terlebih dahulu.');
        toggleEditShippingForm(true);
        return;
    }

    if (!recipientAddress || recipientAddress === '-') {
        alert('Mohon lengkapi alamat pengiriman Anda terlebih dahulu.');
        toggleEditShippingForm(true);
        return;
    }

    var $btn = $('#btnExecutePay');
    var origHtml = $btn.html();
    $btn.prop('disabled', true).html('<i class="fe fe-loader fe-spin mr-2"></i><span>Membuat Pesanan & Invoice...</span>');

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
                // Clear all checked-out cart items
                try {
                    var remainingCart = cart.filter(function(i) { return i.selected === false; });
                    localStorage.setItem('tanjoe_cart_items_v2', JSON.stringify(remainingCart));
                } catch(e) {}

                // Redirect to order history page (no WhatsApp auto-open)
                window.location.href = '{{ url("/transaction-history") }}';
            } else {
                alert((res && res.message) ? res.message : 'Gagal membuat pesanan.');
            }
        },
        error: function(err) {
            $btn.prop('disabled', false).html(origHtml);
            var errMsg = 'Terjadi kesalahan saat memproses pesanan.';
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
}

$(document).ready(function() {
    var CART_KEY = 'tanjoe_cart_items_v2';

    function getCart() {
        try {
            var raw = localStorage.getItem(CART_KEY);
            return raw ? JSON.parse(raw) : [];
        } catch(e) {
            return [];
        }
    }

    function formatRupiah(num) {
        return 'Rp ' + (num || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Populate order summary in checkout
    function initCheckoutOrder() {
        var cart = getCart();
        var selectedItems = cart.filter(function(i) { return i.selected !== false; });
        if (selectedItems.length === 0) selectedItems = cart;

        var totalQty = 0;
        var rawSubtotal = 0;
        var $thumbsStack = $('#orderThumbnailsStack');
        var $drawer = $('#orderBreakdownDrawerItems');
        
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

        $('#checkoutHeaderCartBadge').text(totalQty);
        $('#checkoutBeansCountPill').text(totalQty + ' Beans');
        $('#checkoutOrderTotalText').text(formatRupiah(grandTotal));
        $('#expressWaTotalDisplay').text(formatRupiah(grandTotal));

        // Update payment summary box for logged in user
        $('#paySummaryBeansCount').text(totalQty + ' Produk');
        $('#paySummarySubtotal').text(formatRupiah(rawSubtotal));
        $('#paySummaryFinalTotal').text(formatRupiah(grandTotal));

        // Format WA message for express guest checkout
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

        $('#btnExpressCheckoutWhatsApp').attr('href', 'https://wa.me/6285974607547?text=' + encodeURIComponent(waMessage));
    }

    initCheckoutOrder();

    // Toggle Tab Masuk vs Daftar
    $('#tabMasukAkunBtn').on('click', function() {
        $(this).addClass('active');
        $('#tabDaftarBaruBtn').removeClass('active');
        $('#formLoginCheckout').removeClass('d-none');
        $('#formRegisterCheckout').addClass('d-none');
    });

    $('#tabDaftarBaruBtn').on('click', function() {
        $(this).addClass('active');
        $('#tabMasukAkunBtn').removeClass('active');
        $('#formRegisterCheckout').removeClass('d-none');
        $('#formLoginCheckout').addClass('d-none');
    });

    // Password visibility toggle
    $('#togglePasswordVisibility').on('click', function() {
        var $pwd = $('#checkoutPasswordInput');
        if ($pwd.attr('type') === 'password') {
            $pwd.attr('type', 'text');
            $(this).removeClass('fe-eye').addClass('fe-eye-off');
        } else {
            $pwd.attr('type', 'password');
            $(this).removeClass('fe-eye-off').addClass('fe-eye');
        }
    });

    // Email validation visual indicator
    $('#checkoutEmailInput').on('input', function() {
        var email = $(this).val();
        if (email.indexOf('@') !== -1 && email.indexOf('.') !== -1) {
            $('#emailCheckValid').removeClass('d-none');
        } else {
            $('#emailCheckValid').addClass('d-none');
        }
    });
});
</script>

</x-layouts.public>
