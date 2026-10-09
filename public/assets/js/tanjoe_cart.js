/**
 * Tanjoe Coffee - Scoped Shopping Cart Manager (Option 1)
 * Handles:
 * 1. Guest cart: tanjoe_cart_guest
 * 2. Authenticated user cart: tanjoe_cart_user_{auth_id}
 * 3. Transparent auto-merge of guest cart upon user login
 * 4. Transparent migration from legacy key (tanjoe_cart_items_v2)
 * 5. Global cart operations (add, remove, qty, notes, selection, badges)
 */
(function(window) {
    'use strict';

    var LEGACY_KEY = 'tanjoe_cart_items_v2';
    var GUEST_KEY = 'tanjoe_cart_guest';
    var USER_KEY_PREFIX = 'tanjoe_cart_user_';

    var TanjoeCart = {
        /**
         * Get authenticated user ID from meta tag
         */
        getAuthId: function() {
            var meta = document.querySelector('meta[name="auth-user-id"]');
            var val = meta ? meta.getAttribute('content') : '';
            return val && val.trim() !== '' ? val.trim() : null;
        },

        /**
         * Get current storage key based on auth status
         */
        getStorageKey: function() {
            var authId = this.getAuthId();
            return authId ? (USER_KEY_PREFIX + authId) : GUEST_KEY;
        },

        /**
         * Safely parse JSON from localStorage
         */
        _readRaw: function(key) {
            try {
                var raw = localStorage.getItem(key);
                return raw ? JSON.parse(raw) : [];
            } catch (e) {
                return [];
            }
        },

        /**
         * Safely write JSON to localStorage
         */
        _writeRaw: function(key, items) {
            try {
                localStorage.setItem(key, JSON.stringify(items || []));
            } catch (e) {
                console.error('[TanjoeCart] Error writing to localStorage:', e);
            }
        },

        /**
         * Merge two cart item arrays by matching product ID and variant
         */
        _mergeArrays: function(baseCart, incomingCart) {
            var merged = Array.isArray(baseCart) ? baseCart.slice() : [];
            if (!Array.isArray(incomingCart)) return merged;

            incomingCart.forEach(function(item) {
                if (!item || !item.id) return;
                var existingIdx = merged.findIndex(function(m) {
                    return String(m.id) === String(item.id) &&
                           String(m.variant || '') === String(item.variant || '');
                });

                if (existingIdx !== -1) {
                    var baseQty = parseInt(merged[existingIdx].quantity) || 1;
                    var incQty = parseInt(item.quantity) || 1;
                    merged[existingIdx].quantity = baseQty + incQty;
                    if (item.note && !merged[existingIdx].note) {
                        merged[existingIdx].note = item.note;
                    }
                    if (item.price_grosir15) merged[existingIdx].price_grosir15 = item.price_grosir15;
                    if (item.price_grosir50) merged[existingIdx].price_grosir50 = item.price_grosir50;
                    if (item.type) merged[existingIdx].type = item.type;
                } else {
                    merged.push(item);
                }
            });

            return merged;
        },

        /**
         * Transparently migrate legacy storage and auto-merge guest cart on login
         */
        init: function() {
            var authId = this.getAuthId();
            var currentKey = this.getStorageKey();

            // 1. Check legacy key migration
            var legacyItems = this._readRaw(LEGACY_KEY);
            if (legacyItems && legacyItems.length > 0) {
                var currentItems = this._readRaw(currentKey);
                var mergedLegacy = this._mergeArrays(currentItems, legacyItems);
                this._writeRaw(currentKey, mergedLegacy);
                try {
                    localStorage.removeItem(LEGACY_KEY);
                } catch(e) {}
            }

            // 2. If logged in, auto-merge guest cart into authenticated user's cart
            if (authId) {
                var guestItems = this._readRaw(GUEST_KEY);
                if (guestItems && guestItems.length > 0) {
                    var userItems = this._readRaw(currentKey);
                    var mergedUser = this._mergeArrays(userItems, guestItems);
                    this._writeRaw(currentKey, mergedUser);
                    try {
                        localStorage.removeItem(GUEST_KEY);
                    } catch(e) {}
                }
            }

            // 3. Initial badge update
            this.updateAllBadges();
        },

        /**
         * Get cart items for currently active session (user or guest)
         */
        getCart: function() {
            return this._readRaw(this.getStorageKey());
        },

        /**
         * Save cart items and trigger updates
         */
        saveCart: function(items) {
            var key = this.getStorageKey();
            this._writeRaw(key, items);
            this.updateAllBadges();
            this._notifyUpdated(items);
        },

        /**
         * Get effective unit price considering quantity, product type, and wholesale/bundling tiers:
         * - Type 1 (Green Beans): Grosir >= 15kg (price_grosir15), >= 50kg (price_grosir50)
         * - Type 2 (Filter Roast) & Type 3 (Espresso Roast): Bundling >= 2 Pack (price_grosir15)
         */
        getEffectiveUnitPrice: function(item, quantity) {
            if (!item) return 0;
            var qty = quantity !== undefined ? (parseInt(quantity) || 1) : (parseInt(item.quantity) || 1);
            var p50 = parseFloat(item.price_grosir50) || 0;
            var p15 = parseFloat(item.price_grosir15) || 0;
            var base = parseFloat(item.price) || 0;
            var type = String(item.type || '2');

            if (type === '1') {
                // Green Beans
                if (qty >= 50 && p50 > 0) return p50;
                if (qty >= 15 && p15 > 0) return p15;
                return base;
            }

            // Roasted Filter (2) & Espresso (3) Beans - Bundling min 2 pack
            if (qty >= 2 && p15 > 0) {
                return p15;
            }
            return base;
        },

        /**
         * Get discount tier label (e.g. "Bundling", "Grosir ≥15kg", "Grosir ≥50kg")
         */
        getTierLabel: function(item, quantity) {
            if (!item) return '';
            var qty = quantity !== undefined ? (parseInt(quantity) || 1) : (parseInt(item.quantity) || 1);
            var type = String(item.type || '2');
            var p50 = parseFloat(item.price_grosir50) || 0;
            var p15 = parseFloat(item.price_grosir15) || 0;

            if (type === '1') {
                if (qty >= 50 && p50 > 0) return 'Grosir ≥50kg';
                if (qty >= 15 && p15 > 0) return 'Grosir ≥15kg';
            } else {
                if (qty >= 2 && p15 > 0) return 'Bundling';
            }
            return '';
        },

        /**
         * Get item subtotal considering quantity and wholesale/bundling tiers
         */
        getItemSubtotal: function(item) {
            if (!item) return 0;
            var qty = parseInt(item.quantity) || 1;
            return this.getEffectiveUnitPrice(item, qty) * qty;
        },

        /**
         * Add an item to cart
         */
        addItem: function(item) {
            if (!item || !item.id) return false;
            var cart = this.getCart();
            var incomingQty = parseInt(item.quantity) || 1;

            var existingIdx = cart.findIndex(function(m) {
                return String(m.id) === String(item.id) &&
                       String(m.variant || '') === String(item.variant || '');
            });

            if (existingIdx !== -1) {
                cart[existingIdx].quantity = (parseInt(cart[existingIdx].quantity) || 1) + incomingQty;
                if (item.note) cart[existingIdx].note = item.note;
                if (item.price_grosir15) cart[existingIdx].price_grosir15 = parseFloat(item.price_grosir15);
                if (item.price_grosir50) cart[existingIdx].price_grosir50 = parseFloat(item.price_grosir50);
                if (item.type) cart[existingIdx].type = item.type;
            } else {
                cart.push({
                    id: item.id,
                    name: item.name,
                    origin: item.origin || '',
                    process: item.process || '',
                    variant: item.variant || 'Whole Beans (Biji Utuh)',
                    price: parseFloat(item.price) || 0,
                    price_grosir15: parseFloat(item.price_grosir15) || 0,
                    price_grosir50: parseFloat(item.price_grosir50) || 0,
                    type: item.type || '',
                    quantity: incomingQty,
                    weight: item.weight || '200g',
                    note: item.note || '',
                    selected: item.selected !== false,
                    image: item.image || ''
                });
            }

            this.saveCart(cart);
            return true;
        },

        /**
         * Update quantity of an item
         */
        updateQty: function(index, newQty) {
            var cart = this.getCart();
            if (index < 0 || index >= cart.length) return;

            var qty = parseInt(newQty) || 0;
            if (qty <= 0) {
                cart.splice(index, 1);
            } else {
                cart[index].quantity = qty;
            }
            this.saveCart(cart);
        },

        /**
         * Remove an item at specific index
         */
        removeItem: function(index) {
            var cart = this.getCart();
            if (index >= 0 && index < cart.length) {
                cart.splice(index, 1);
                this.saveCart(cart);
            }
        },

        /**
         * Set selection status of an item
         */
        setItemSelected: function(index, isSelected) {
            var cart = this.getCart();
            if (index >= 0 && index < cart.length) {
                cart[index].selected = !!isSelected;
                this.saveCart(cart);
            }
        },

        /**
         * Set selection status of all items
         */
        setAllSelected: function(isSelected) {
            var cart = this.getCart();
            cart.forEach(function(item) {
                item.selected = !!isSelected;
            });
            this.saveCart(cart);
        },

        /**
         * Update note of an item
         */
        updateItemNote: function(index, note) {
            var cart = this.getCart();
            if (index >= 0 && index < cart.length) {
                cart[index].note = note || '';
                // Save without triggering badge refresh
                this._writeRaw(this.getStorageKey(), cart);
                this._notifyUpdated(cart);
            }
        },

        /**
         * Clear selected items (used after placing order)
         */
        clearSelected: function() {
            var cart = this.getCart();
            var remaining = cart.filter(function(i) {
                return i.selected === false;
            });
            this.saveCart(remaining);
            return remaining;
        },

        /**
         * Clear all items in current cart
         */
        clearCart: function() {
            this.saveCart([]);
        },

        /**
         * Get total item quantity
         */
        getTotalQty: function(onlySelected) {
            var cart = this.getCart();
            var total = 0;
            cart.forEach(function(item) {
                if (!onlySelected || item.selected !== false) {
                    total += (parseInt(item.quantity) || 1);
                }
            });
            return total;
        },

        /**
         * Update all cart badges across the layout
         */
        updateAllBadges: function() {
            var totalQty = this.getTotalQty(false);

            // 1. Header shop badge (#cartBadgeCount)
            var $badge = typeof jQuery !== 'undefined' ? jQuery('#cartBadgeCount') : null;
            if ($badge && $badge.length) {
                $badge.text(totalQty);
                if (totalQty > 0) $badge.show(); else $badge.hide();
            }

            // 2. Detail navbar badge (#cartBadgeCountDetail)
            var $detailBadge = typeof jQuery !== 'undefined' ? jQuery('#cartBadgeCountDetail') : null;
            if ($detailBadge && $detailBadge.length) {
                $detailBadge.text(totalQty);
                if (totalQty > 0) $detailBadge.show(); else $detailBadge.hide();
            }

            // 3. Checkout header badge (#checkoutHeaderCartBadge)
            var $chkBadge = typeof jQuery !== 'undefined' ? jQuery('#checkoutHeaderCartBadge') : null;
            if ($chkBadge && $chkBadge.length) {
                $chkBadge.text(totalQty);
            }

            // 4. Bottom bar cart badge (#bottomBarCartBadge)
            var elBottomBadge = document.getElementById('bottomBarCartBadge');
            if (elBottomBadge) {
                elBottomBadge.textContent = totalQty > 99 ? '99+' : totalQty;
                elBottomBadge.style.display = totalQty > 0 ? 'inline-block' : 'none';
            }
        },

        /**
         * Currency formatting
         */
        formatRupiah: function(num) {
            return 'Rp ' + (num || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },

        /**
         * Toast notification helper
         */
        showToast: function(msg) {
            var toastMsg = msg || 'Keranjang diperbarui!';
            if (typeof jQuery !== 'undefined') {
                var $t1 = jQuery('#cartToast');
                var $t2 = jQuery('#cartToastDetail');
                if ($t1.length) {
                    jQuery('#cartToastText').text(toastMsg);
                    $t1.addClass('show');
                    setTimeout(function() { $t1.removeClass('show'); }, 2500);
                } else if ($t2.length) {
                    jQuery('#cartToastDetailText').text(toastMsg);
                    $t2.addClass('show');
                    setTimeout(function() { $t2.removeClass('show'); }, 2500);
                }
            }
        },

        /**
         * Notify window listeners of cart changes
         */
        _notifyUpdated: function(cart) {
            try {
                window.dispatchEvent(new CustomEvent('tanjoe:cart-updated', {
                    detail: {
                        cart: cart,
                        storageKey: this.getStorageKey(),
                        totalQty: this.getTotalQty(false)
                    }
                }));
            } catch (e) {}
        }
    };

    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            TanjoeCart.init();
        });
    } else {
        TanjoeCart.init();
    }

    // Cross-tab synchronization
    window.addEventListener('storage', function(e) {
        if (!e.key) return;
        var activeKey = TanjoeCart.getStorageKey();
        if (e.key === activeKey || e.key === GUEST_KEY || e.key === LEGACY_KEY) {
            TanjoeCart.updateAllBadges();
            try {
                window.dispatchEvent(new CustomEvent('tanjoe:cart-updated', {
                    detail: {
                        cart: TanjoeCart.getCart(),
                        storageKey: activeKey,
                        totalQty: TanjoeCart.getTotalQty(false)
                    }
                }));
            } catch (err) {}
        }
    });

    // Expose globally
    window.TanjoeCart = TanjoeCart;

})(window);
