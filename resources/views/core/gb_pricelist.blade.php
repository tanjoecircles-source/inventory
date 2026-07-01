<x-layouts.public header="">

<style>
    .gb-slider .swiper-slide {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
    }
    .gb-slider .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .gb-slider .swiper-button-next,
    .gb-slider .swiper-button-prev {
        width: 30px;
        height: 30px;
        background: rgba(0,0,0,0.4);
        border-radius: 50%;
    }
    .gb-slider .swiper-button-next::after,
    .gb-slider .swiper-button-prev::after {
        font-size: 14px;
        color: #fff;
    }
    .gb-slider .swiper-pagination {
        position: absolute;
        bottom: 5px;
    }
    .gb-slider .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
    }
    .gb-slider .swiper-pagination-bullet-active {
        background: #E62129;
    }
    .img-count-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 10px;
        z-index: 10;
    }
</style>

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
@if(session()->has('danger'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('danger') }}",
                type: "error",
                position: "center"
            });
        });
    </script>
@endif
<div class="container pt-3">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="text-center email-style mb-3 mt-3">
                <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:4rem;" alt="tanjoecoffee.com">
            </div>
            
            <h4 class="text-center my-0 py-0">Coffee Pricelist</h4>
            <p class="text-muted text-center">Green Beans Aceh Gayo</p>
            
            
            @forelse($stok_gb as $value)
                <div class="card mb-3">
                    <div class="card-body px-2 py-2">
                        <div class="d-flex title-bar">
                            <div class="mr-auto text-left">
                                <h6 class="mb-1">{{$value->name}} <span class="text-warning fs-11 font-weight-normal"><i>{{$value->is_new}}</i></span></h6>
                                <p class="mb-2"><span class="text-muted fs-12"><i>{{$value->origin}} | {{$value->varietal}}</i></span></p>
                                <a class="mb-1 btn btn-dark btn-sm text-white" role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse{{$value->id}}" aria-expanded="true" aria-controls="collapseOne1"><i class="fe fe-info"></i> More Info</a>
                            </div>
                            <div class="ml-auto text-right">
                                <p class="mb-2"><b>Rp {{str_replace(",", ".", number_format($value->price))}}</b></p>
                                <span class="badge badge-pill badge-{{$value->stock_color}} ml-auto mr-0 py-1 mb-2 my-1"><i class="fe {{$value->stock_icon}}"></i> {{$value->stock_lable}}</span>
                            </div>
                        </div>
                    </div>
                    <div id="collapse{{$value->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                        <div class="card-body px-2 pt-1 pb-3">
                            <div class="row">
                                <div class="col-sm-5">
                                    <!-- Swiper Slider -->
                                    <div class="swiper gb-slider position-relative rounded">
                                        <div class="swiper-wrapper">
                                            @forelse($value->images as $img)
                                            <div class="swiper-slide">
                                                <img src="{{ $img->image_url }}" alt="{{$value->name}}">
                                            </div>
                                            @empty
                                            <div class="swiper-slide">
                                                <img src="{{ asset('assets/images/products/noimages.png') }}" alt="{{$value->name}}">
                                            </div>
                                            @endforelse
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-pagination"></div>
                                        @if(count($value->images) > 1)
                                        <span class="img-count-badge"><i class="fe fe-image"></i> {{count($value->images)}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-7 fs-12 pl-0">
                                    <div class="d-flex border-bottom">
                                        <div class="mr-auto text-left">
                                            <p class="my-1">Origin</p>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <p class="my-1"><b>{{$value->origin}}</b></p>
                                        </div>
                                    </div>
                                    <div class="d-flex border-bottom">
                                        <div class="mr-auto text-left">
                                            <p class="my-1">Elevation</p>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <p class="my-1"><b>{{$value->elevation}} MASL</b></p>
                                        </div>
                                    </div>
                                    <div class="d-flex border-bottom">
                                        <div class="mr-auto text-left">
                                            <p class="my-1">Varietal</p>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <p class="my-1"><b>{{$value->varietal}}</b></p>
                                        </div>
                                    </div>
                                    <div class="d-flex border-bottom">
                                        <div class="mr-auto text-left">
                                            <p class="my-1">Process</p>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <p class="my-1"><b>{{$value->process}}</b></p>
                                        </div>
                                    </div>
                                    <div class="d-flex border-bottom">
                                        <div class="mr-auto text-left">
                                            <p class="my-1">Processor</p>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <p class="my-1"><b>{{$value->processor}}</b></p>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="mr-auto text-left">
                                            <p class="my-1">Harvest</p>
                                        </div>
                                        <div class="ml-auto text-right">
                                            <p class="my-1"><b>{{$value->harvest}}</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row fs-14">
                                <div class="col-sm-12">
                                    <p class="my-2 text-justify">{!!$value->desc!!}</p>
                                    <hr class="my-2">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><b>Price Type</b></td>
                                            <td class="text-center"><b>Qty</b></td>
                                            <td class="text-right"><b>Price Offer</b></td>
                                        </tr>
                                        <tr>
                                            <td>Retail</td>
                                            <td class="text-center">1-15kg</td>
                                            <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Wholesale</td>
                                            <td class="text-center">15-50kg</td>
                                            <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price_grosir15))}}</td>
                                        </tr>
                                        <tr>
                                            <td>Wholesale</td>
                                            <td class="text-center">>50kg</td>
                                            <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price_grosir50))}}</td>
                                        </tr>
                                    </table>
                                    <a class="btn btn-success btn-block" href="https://wa.me/6285974607547?text=Halo,%20Saya%20Ingin%20Menanyakan%20Produk%20Green%20Beans%20Kopi%20Gayo%20{{$value->name}}." target="_blank"><i class="fa fa-whatsapp"></i> WhatsApp Order</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="mx-2 text-center">Tidak ada data</p>
            @endforelse		
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize Swiper for each product's slider
    $('.gb-slider').each(function() {
        var swiper = new Swiper(this, {
            loop: false,
            navigation: {
                nextEl: $(this).find('.swiper-button-next')[0],
                prevEl: $(this).find('.swiper-button-prev')[0],
            },
            pagination: {
                el: $(this).find('.swiper-pagination')[0],
                clickable: true,
            },
        });
    });
});
</script>
</x-layouts>