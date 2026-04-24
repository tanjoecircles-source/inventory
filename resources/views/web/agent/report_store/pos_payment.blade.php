<x-layouts.app :hideBottomMenu="true">
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{ url('pos') }}"></x-back>
    @endslot
    @slot('notif')
    <h6 class="m-0 font-weight-bold">Pembayaran POS</h6>
    @endslot
</x-header-white-3column>

<style>
    .payment-container { max-width: 600px; margin: 20px auto; padding: 0 15px; }
    .card-payment { border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .summary-item { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
    .total-big { font-size: 24px; font-weight: 800; color: #1e2a3a; text-align: center; margin: 20px 0; }
    
    .pay-methods { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 20px; }
    .pay-method-card { 
        background: #fff; border: 2px solid #f1f5f9; border-radius: 12px; padding: 15px 10px;
        text-align: center; cursor: pointer; transition: all 0.2s;
    }
    .pay-method-card i { font-size: 20px; display: block; margin-bottom: 5px; }
    .pay-method-card span { font-size: 12px; font-weight: 600; }
    .pay-method-card.active { border-color: #10b981; background: #ecfdf5; color: #059669; }

    .input-pay { 
        font-size: 20px; font-weight: 700; text-align: right; 
        border: 2px solid #f1f5f9; border-radius: 10px; padding: 10px 15px;
    }
    .input-pay:focus { border-color: #3b82f6; box-shadow: none; }
    .label-pay { font-size: 12px; color: #64748b; margin-bottom: 5px; font-weight: 600; }

    .btn-confirm-pay { 
        background: #1e2a3a; color: #fff; border: none; border-radius: 12px; 
        padding: 15px; width: 100%; font-weight: 700; font-size: 16px;
        margin-top: 10px; transition: opacity 0.2s;
    }
    .btn-confirm-pay:active { opacity: 0.9; }
    .btn-confirm-pay:disabled { background: #cbd5e1; cursor: not-allowed; }
</style>

<div class="payment-container">
    <div class="card card-payment">
        <div class="card-body">
            <h6 class="font-weight-bold mb-3 border-bottom pb-2">Ringkasan Pesanan</h6>
            <div id="payment-items-list">
                <!-- Items injected by JS -->
            </div>
            <div class="total-big" id="payment-total-display">Rp 0</div>
        </div>
    </div>

    <form id="checkout-form" action="{{ url('pos-checkout') }}" method="POST">
        @csrf
        <input type="hidden" name="payment_method" id="f-payment-method" value="cash">
        <input type="hidden" name="cash" id="f-cash" value="0">
        <input type="hidden" name="qris" id="f-qris" value="0">
        <div id="items-hidden-container"></div>

        <div class="label-pay">Pilih Metode Pembayaran</div>
        <div class="pay-methods">
            <div class="pay-method-card active" id="m-cash" onclick="setPayMethod('cash')">
                <i class="fe fe-dollar-sign"></i>
                <span>Tunai</span>
            </div>
            <div class="pay-method-card" id="m-qris" onclick="setPayMethod('qris')">
                <i class="fe fe-credit-card"></i>
                <span>QRIS</span>
            </div>
            <div class="pay-method-card" id="m-split" onclick="setPayMethod('split')">
                <i class="fe fe-shuffle"></i>
                <span>Split</span>
            </div>
        </div>

        <div class="card card-payment">
            <div class="card-body">
                <div id="input-cash-wrapper">
                    <div class="label-pay">Jumlah Bayar Tunai</div>
                    <input type="text" class="form-control input-pay mask-money" id="input-cash" placeholder="0" onkeyup="calculateChange()">
                </div>
                
                <div id="input-qris-wrapper" class="mt-3 d-none">
                    <div class="label-pay">Jumlah Bayar QRIS</div>
                    <input type="text" class="form-control input-pay mask-money" id="input-qris" placeholder="0" onkeyup="calculateChange()">
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div class="label-pay m-0">Kembalian</div>
                    <div class="font-weight-bold fs-18" id="change-display">Rp 0</div>
                </div>
            </div>
        </div>

        <button type="button" class="btn-confirm-pay" id="btn-submit" onclick="submitFinal()">
            Konfirmasi & Selesaikan
        </button>
    </form>
</div>

<script>
    let cart = JSON.parse(localStorage.getItem('pos_cart')) || {};
    let total = 0;
    let paymentMethod = 'cash';

    function initPage() {
        renderSummary();
        setPayMethod('cash');
        
        // Auto fill cash if method is cash
        if (paymentMethod === 'cash') {
            document.getElementById('input-cash').value = total.toLocaleString('id-ID');
            calculateChange();
        }
    }

    function renderSummary() {
        const list = document.getElementById('payment-items-list');
        const hidden = document.getElementById('items-hidden-container');
        list.innerHTML = '';
        hidden.innerHTML = '';
        total = 0;
        let idx = 0;

        for (let id in cart) {
            let item = cart[id];
            let subtotal = item.qty * item.price;
            total += subtotal;

            list.innerHTML += `
                <div class="summary-item">
                    <span>${item.name} (x${item.qty})</span>
                    <span class="font-weight-semibold">Rp ${subtotal.toLocaleString('id-ID')}</span>
                </div>
            `;

            hidden.innerHTML += `
                <input type="hidden" name="items[${idx}][product_id]" value="${id}">
                <input type="hidden" name="items[${idx}][name]" value="${item.name}">
                <input type="hidden" name="items[${idx}][price]" value="${item.price}">
                <input type="hidden" name="items[${idx}][qty]" value="${item.qty}">
            `;
            idx++;
        }

        document.getElementById('payment-total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
        if (Object.keys(cart).length === 0) {
            window.location.href = "{{ url('pos') }}";
        }
    }

    function setPayMethod(m) {
        paymentMethod = m;
        document.getElementById('f-payment-method').value = m;
        
        document.querySelectorAll('.pay-method-card').forEach(el => el.classList.remove('active'));
        document.getElementById('m-' + m).classList.add('active');

        const cashW = document.getElementById('input-cash-wrapper');
        const qrisW = document.getElementById('input-qris-wrapper');

        if (m === 'cash') {
            cashW.classList.remove('d-none');
            qrisW.classList.add('d-none');
            document.getElementById('input-qris').value = 0;
            document.getElementById('input-cash').value = total.toLocaleString('id-ID');
        } else if (m === 'qris') {
            cashW.classList.add('d-none');
            qrisW.classList.remove('d-none');
            document.getElementById('input-cash').value = 0;
            document.getElementById('input-qris').value = total.toLocaleString('id-ID');
        } else {
            cashW.classList.remove('d-none');
            qrisW.classList.remove('d-none');
            document.getElementById('input-cash').value = (total/2).toLocaleString('id-ID');
            document.getElementById('input-qris').value = (total/2).toLocaleString('id-ID');
        }
        calculateChange();
    }

    function calculateChange() {
        const cashVal = parseInt(document.getElementById('input-cash').value.replace(/[^0-9]/g, '')) || 0;
        const qrisVal = parseInt(document.getElementById('input-qris').value.replace(/[^0-9]/g, '')) || 0;
        
        const paid = cashVal + qrisVal;
        const change = paid - total;

        document.getElementById('change-display').textContent = 'Rp ' + (change > 0 ? change.toLocaleString('id-ID') : 0);
        document.getElementById('btn-submit').disabled = paid < total;

        document.getElementById('f-cash').value = cashVal;
        document.getElementById('f-qris').value = qrisVal;
    }

    function submitFinal() {
        if (confirm('Selesaikan transaksi ini?')) {
            // Clear cart on success is handled by the next page or we can do it here if redirecting
            // but we need the form to submit first. 
            // We'll clear it after successful post-checkout redirect.
            document.getElementById('checkout-form').submit();
        }
    }

    // Money masking simple
    document.querySelectorAll('.mask-money').forEach(el => {
        el.addEventListener('input', function(e) {
            let v = this.value.replace(/[^0-9]/g, '');
            if (v) this.value = parseInt(v).toLocaleString('id-ID');
        });
    });

    document.addEventListener('DOMContentLoaded', initPage);
</script>
</x-layouts.app>
