<x-layouts.public header="">

<link rel="stylesheet" href="{{ asset('product/pricelist.css') }}">

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <!-- Logo Section -->
            <div class="text-center logo-container">
                <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:5rem;" alt="tanjoecoffee.com">
            </div>
            
            <!-- Header Section -->
            <div class="pricelist-header">
                <h1 class="main-title">Daftar Produk dan Harga</h1>
                <h2 class="sub-title">Kopi Aceh Gayo</h2>
            </div>

            <!-- Product Cards -->
            <div class="row">
                <!-- Green Bean Card -->
                <div class="col-6 mb-4">
                    <div class="card card-product">
                        <a href="{{ url('greenbeans') }}" target="_blank" class="product-image-wrapper">
                            <img src="{{ asset('assets/images/products/greenbean.png') }}" alt="Green Bean" class="product-image">
                        </a>
                        <div class="card-body card-body-custom">
                            <a href="{{ url('greenbeans') }}" target="_blank" class="product-title">Green Bean</a>
                            <p class="product-desc">Daftar Produk dan Harga Green Beans</p>
                            <div class="btn-group-custom">
                                <a href="https://wa.me/?text=Berikut%20Daftar%20Harga%20Green%20Bean%20Aceh%20Gayo%20Toko%20Kopi%20Tanjoe%20{{ urlencode('https://app.tanjoecoffee.com/greenbeans') }}" target="_blank" class="btn-share" title="Bagikan ke WhatsApp">
                                    <i class="fe fe-share"></i>
                                </a>
                                <button id="copyurlgreen" class="btn-copy" title="Salin Link">
                                    <i class="fe fe-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roasted Bean Card -->
                <div class="col-6 mb-4">
                    <div class="card card-product">
                        <a href="{{ url('roastedbeans') }}" target="_blank" class="product-image-wrapper">
                            <img src="{{ asset('assets/images/products/roasted.png') }}" alt="Roasted Bean" class="product-image">
                        </a>
                        <div class="card-body card-body-custom">
                            <a href="{{ url('roastedbeans') }}" target="_blank" class="product-title">Roasted Bean</a>
                            <p class="product-desc">Daftar Produk dan Harga Roasted Beans</p>
                            <div class="btn-group-custom">
                                <a href="https://wa.me/?text=Berikut%20Daftar%20Harga%20Roasted%20Bean%20Aceh%20Gayo%20Toko%20Kopi%20Tanjoe%20{{ urlencode('https://app.tanjoecoffee.com/roastedbeans') }}" target="_blank" class="btn-share" title="Bagikan ke WhatsApp">
                                    <i class="fe fe-share"></i>
                                </a>
                                <button id="copyurlroasted" class="btn-copy" title="Salin Link">
                                    <i class="fe fe-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('product/pricelist.js') }}"></script>
</x-layouts.public>
