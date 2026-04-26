<x-layouts.app>
<style>
    .checkout-section {
        background: #fff;
        border-radius: 15px;
        margin-bottom: 15px;
    }
    .payment-option {
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .payment-option.active {
        border-color: #705ec8;
        background: rgba(112, 94, 200, 0.05);
    }
    .checkout-footer {
        position: fixed;
        bottom: 60px;
        left: 0;
        right: 0;
        background: #fff;
        padding: 15px;
        box-shadow: 0 -5px 15px rgba(0,0,0,0.05);
        z-index: 1000;
    }
</style>

<div class="container pb-5 mb-5">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="mt-4 mb-4 d-flex align-items-center">
                <a href="{{ url('cart') }}" class="text-dark mr-3"><i class="fe fe-arrow-left fs-20"></i></a>
                <h5 class="font-weight-bold mb-0">Checkout</h5>
            </div>

            <form action="{{ url('order-process') }}" method="POST" id="checkout-form">
                @csrf
                <!-- Shipping Address -->
                <div class="checkout-section p-3 shadow-sm">
                    <h6 class="font-weight-bold mb-3"><i class="fe fe-map-pin mr-2 text-primary"></i>Alamat Pengiriman</h6>
                    <div class="form-group mb-0">
                        <label class="text-muted small mb-1">Nama Penerima</label>
                        <input type="text" name="customer_name" class="form-control mb-2" value="{{ $user->name }}" placeholder="Nama Lengkap" style="border-radius: 8px;">
                        
                        <label class="text-muted small mb-1">Nomor Telepon</label>
                        <input type="text" name="customer_phone" class="form-control mb-2" value="{{ $user->phone }}" placeholder="Contoh: 08123456789" style="border-radius: 8px;">

                        <label class="text-muted small mb-1">Alamat Lengkap</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap pengiriman..." style="border-radius: 8px;"></textarea>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="checkout-section p-3 shadow-sm">
                    <h6 class="font-weight-bold mb-3"><i class="fe fe-shopping-bag mr-2 text-primary"></i>Ringkasan Pesanan</h6>
                    @foreach($cart as $id => $details)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-dark fs-14">{{ $details['name'] }} <span class="text-muted small">x{{ $details['quantity'] }}</span></span>
                            <span class="font-weight-semibold">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <hr class="my-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Subtotal</span>
                        <span class="font-weight-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="text-muted">Biaya Pengiriman</span>
                        <span class="text-success font-weight-bold">Gratis</span>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-section p-3 shadow-sm mb-5">
                    <h6 class="font-weight-bold mb-3"><i class="fe fe-credit-card mr-2 text-primary"></i>Metode Pembayaran</h6>
                    
                    <input type="hidden" name="payment_method" id="selected-payment" value="Manual Transfer">
                    
                    <div class="payment-option active" data-method="Manual Transfer">
                        <div class="d-flex align-items-center">
                            <i class="fe fe-send fs-20 text-muted mr-3"></i>
                            <div>
                                <h6 class="mb-0 font-weight-bold">Transfer Bank Manual</h6>
                                <p class="mb-0 text-muted small">Konfirmasi manual via WhatsApp</p>
                            </div>
                            <i class="fe fe-check-circle ml-auto text-primary fs-20"></i>
                        </div>
                    </div>

                    <div class="payment-option" data-method="Midtrans">
                        <div class="d-flex align-items-center">
                            <i class="fe fe-shield fs-20 text-muted mr-3"></i>
                            <div>
                                <h6 class="mb-0 font-weight-bold">Otomatis (QRIS / VA)</h6>
                                <p class="mb-0 text-muted small">Pembayaran instan via Midtrans</p>
                            </div>
                            <i class="fe fe-circle ml-auto text-light fs-20"></i>
                        </div>
                    </div>
                </div>

                <div class="checkout-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Total Pembayaran</span>
                                    <h5 class="font-weight-bold text-primary mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block btn-lg font-weight-bold" style="border-radius: 10px;">Buat Pesanan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.payment-option').click(function() {
        $('.payment-option').removeClass('active');
        $('.payment-option i.ml-auto').removeClass('fe-check-circle text-primary').addClass('fe-circle text-light');
        
        $(this).addClass('active');
        $(this).find('i.ml-auto').removeClass('fe-circle text-light').addClass('fe-check-circle text-primary');
        
        $('#selected-payment').val($(this).data('method'));
    });
</script>
</x-layouts.app>
