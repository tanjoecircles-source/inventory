<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-search searchstyle="text-dark" searchurl="{{url('product-explore-search')}}"></x-search>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
@if(session()->has('success'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('success') }}",
                type: "success",
                position: "center"
            });
        });
    </script>
@endif
<style>
    .category-scroll {
        overflow-x: auto;
        white-space: nowrap;
        padding: 10px 0;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .category-scroll::-webkit-scrollbar {
        display: none;
    }
    .category-pill {
        display: inline-block;
        padding: 8px 20px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 20px;
        margin-right: 10px;
        font-size: 13px;
        font-weight: 600;
        color: #666;
        transition: all 0.3s;
    }
    .category-pill.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }
    .product-card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        transition: transform 0.2s;
        height: 100%;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-image-container {
        position: relative;
        padding-top: 100%; /* 1:1 Aspect Ratio */
    }
    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .badge-new {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #28a745;
        color: #fff;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: bold;
    }
    .badge-sold-out {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
    }
</style>

<div class="container pb-5">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <!-- Header Section -->
            <div class="mt-4 mb-3">
                <h5 class="font-weight-bold mb-1">Halo, {{Auth::user()->name}}!</h5>
                <p class="text-muted small">Mau belanja kopi apa hari ini?</p>
            </div>

            <!-- Search Bar -->
            <div class="mb-4">
                <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="fe fe-search text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0 pl-0 py-4" placeholder="Cari kopi favoritmu..." style="height: 45px;">
                </div>
            </div>

            <!-- Promo Banner (Mock) -->
            <div class="mb-4">
                <div class="card bg-primary text-white p-4" style="border-radius: 15px; background: linear-gradient(45deg, #7c1212, #a31d1d) !important;">
                    <div class="row align-items-center">
                        <div class="col-7">
                            <h6 class="font-weight-bold mb-1">Special Discount!</h6>
                            <p class="small mb-2">Dapatkan potongan 15% untuk setiap pembelian Green Bean Gayo.</p>
                            <button class="btn btn-white btn-sm text-primary font-weight-bold">Cek Sekarang</button>
                        </div>
                        <div class="col-5 text-right">
                            <i class="fe fe-shopping-bag fs-50 opacity-2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="category-scroll mb-3">
                <a href="#" class="category-pill active">Semua</a>
                <a href="#" class="category-pill">Green Bean</a>
                <a href="#" class="category-pill">Roasted Filter</a>
                <a href="#" class="category-pill">Roasted Espresso</a>
                <a href="#" class="category-pill">Specialty</a>
            </div>

            <!-- Product Grid -->
            <div class="row px-1" id="product-grid">
                @include('web.user.home.product_list')
            </div>

            <!-- Loading Indicator -->
            <div id="loading-indicator" class="text-center py-4" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let page = 1;
        let loading = false;
        let hasMore = true;

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                if (!loading && hasMore) {
                    loadMoreProducts();
                }
            }
        });

        function loadMoreProducts() {
            page++;
            loading = true;
            $('#loading-indicator').show();

            $.ajax({
                url: "?page=" + page,
                type: "get"
            })
            .done(function(data) {
                if (data.trim() == "") {
                    hasMore = false;
                    $('#loading-indicator').hide();
                    return;
                }
                $('#loading-indicator').hide();
                $("#product-grid").append(data);
                loading = false;
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                loading = false;
                $('#loading-indicator').hide();
            });
        }

        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let btn = $(this);
            let originalHtml = btn.html();
            
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            
            $.ajax({
                url: "{{ route('cart-add') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: id
                },
                success: function(response) {
                    btn.prop('disabled', false).html(originalHtml);
                    if(response.success) {
                        notif({
                            msg: response.message,
                            type: "success",
                            position: "center"
                        });
                        // Update cart badge
                        $('#cart-badge').text(response.cart_count).show();
                    } else {
                        notif({
                            msg: response.message,
                            type: "error",
                            position: "center"
                        });
                    }
                },
                error: function() {
                    btn.prop('disabled', false).html(originalHtml);
                    notif({
                        msg: "Gagal menambahkan produk",
                        type: "error",
                        position: "center"
                    });
                }
            });
        });
    });
</script>
</x-layouts.app>
