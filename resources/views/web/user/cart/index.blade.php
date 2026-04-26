<x-layouts.app>
<style>
    .cart-item {
        border-bottom: 1px solid #f0f0f0;
    }
    .cart-item:last-child {
        border-bottom: none;
    }
    .qty-input {
        width: 40px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: bold;
    }
    .btn-qty {
        width: 25px;
        height: 25px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
    }
    .checkout-bar {
        position: fixed;
        bottom: 60px; /* Above bottom menu */
        left: 0;
        right: 0;
        background: #fff;
        padding: 15px;
        box-shadow: 0 -5px 15px rgba(0,0,0,0.05);
        z-index: 1000;
    }
</style>

<div class="container pb-5">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="mt-4 mb-4 d-flex align-items-center">
                <a href="{{ url('home') }}" class="text-dark mr-3"><i class="fe fe-arrow-left fs-20"></i></a>
                <h5 class="font-weight-bold mb-0">Keranjang Belanja</h5>
            </div>

            @if(count($cart) > 0)
                <div class="card shadow-sm mb-5" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        @foreach($cart as $id => $details)
                            <div class="cart-item p-3 d-flex align-items-center" data-id="{{ $id }}">
                                <img src="{{ asset('assets/images/products/noimage.png') }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px;" alt="{{ $details['name'] }}">
                                <div class="ml-3 flex-grow-1">
                                    <h6 class="font-weight-bold mb-1 text-dark">{{ $details['name'] }}</h6>
                                    <p class="text-primary font-weight-bold mb-2">Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                                    
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center bg-light rounded p-1">
                                            <button class="btn btn-qty btn-light update-cart" data-type="minus"><i class="fe fe-minus fs-12"></i></button>
                                            <input type="text" class="qty-input" value="{{ $details['quantity'] }}" readonly>
                                            <button class="btn btn-qty btn-light update-cart" data-type="plus"><i class="fe fe-plus fs-12"></i></button>
                                        </div>
                                        <a href="javascript:void(0)" class="ml-auto text-danger remove-from-cart"><i class="fe fe-trash-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="checkout-bar">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Total Pembayaran</span>
                                    <h5 class="font-weight-bold text-primary mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                                </div>
                                <a href="{{ route('checkout') }}" class="btn btn-primary btn-block btn-lg font-weight-bold d-flex align-items-center justify-content-center" style="border-radius: 10px;">Checkout Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <img src="{{ asset('assets/images/png/empty-cart.png') }}" style="width: 150px; opacity: 0.5;">
                    <h6 class="mt-4 font-weight-bold">Keranjangmu masih kosong</h6>
                    <p class="text-muted small">Ayo cari kopi terbaik untukmu!</p>
                    <a href="{{ url('home') }}" class="btn btn-primary px-4 mt-2" style="border-radius: 10px;">Mulai Belanja</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(".update-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        var id = ele.closest(".cart-item").attr("data-id");
        var qtyInput = ele.siblings(".qty-input");
        var currentQty = parseInt(qtyInput.val());
        var type = ele.attr("data-type");
        var newQty = currentQty;

        if(type === 'plus') {
            newQty++;
        } else {
            if(currentQty > 1) newQty--;
        }

        $.ajax({
            url: '{{ route('cart-update') }}',
            method: "post",
            data: {
                _token: '{{ csrf_token() }}', 
                id: id, 
                quantity: newQty
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        var id = ele.closest(".cart-item").attr("data-id");

        if(confirm("Hapus item ini dari keranjang?")) {
            $.ajax({
                url: '{{ route('cart-remove') }}',
                method: "post",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: id
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
</x-layouts.app>
