<x-layouts.app>
<x-header-red-2column>
    @slot('notif')
    <x-notification notifstyle="text-white"></x-notification>
    @endslot
</x-header-red-2column>
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
<style>
    .swipeInfo {
        width: 100%;
    }
    
    .swipeInfo .swiper-slide img {
        border-radius: 8px !important;
        border: 2px solid #eee;
        object-fit: cover;
    }
        
    .swiperProdukPopular {
        width: 100%;
        padding: 0px;
        margin: 0px;
    }

    .swiperProdukPopular .swiper-slide img {
        width: 300px;
        border-radius: 6px 6px 0px 0px;
        object-fit: cover;
    }

    .swiperNews {
        width: 100%;
        padding: 0px;
        margin: 0px;
    }

    .swiperNews .swiper-slide img {
        width: 100%;
        border-radius: 6px 6px 0px 0px;
        object-fit: cover;
    }
</style>
<div class="bg-primary pt-3 text-center text-white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="row px-2">
                    <div class="col p-2">
                        <div class="card" style="background: rgba(255, 255, 255, 0.3);border:none;">
                            <div class="card-body py-3 px-2">
                                <p class="mb-2"><i class="fe fe-calendar"></i> Visitasi</p>
                                <h5>0</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col p-2">
                        <div class="card" style="background: rgba(255, 255, 255, 0.3);border:none;">
                            <div class="card-body py-3 px-2">
                                <p class="mb-2"><i class="fe fe-clipboard"></i> Dipesan</p>
                                <h5>0</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col p-2">
                        <div class="card" style="background: rgba(255, 255, 255, 0.3);border:none;">
                            <div class="card-body py-3 px-2">
                                <p class="mb-2"><i class="fe fe-check-circle"></i> Terjual</p>
                                <h5>0</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="swiper swipeInfo">
                <div class="swiper-wrapper mb-6">
                    <div class="swiper-slide"><img src="{{ asset('assets/images/pattern/slide-1.jpg') }}" alt="tag" ></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/images/pattern/slide-2.jpg') }}" alt="tag" ></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white pt-3 mb-3">
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto d-flex">
            <h5 class="flex-grow-1 mb-0 text-left mb-3">Produk Terpopuler </h5>
            <a class="text-primary font-weight-semibold" href="#">Lihat Semua</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="swiper swiperProdukPopular">
                <div class="swiper-wrapper">
                    @if(sizeof($popular) == 0)
                        <div class="card shadow-none border border-1">
                        
                            <div class="card-body px-2 py-7 text-center bg-gray-100">
                                <p class="mb-0 font-weight-semibold text-dark">Belum ada Produk Terpopuler</p>
                                <a href="{{url('product-add')}}" class="btn btn-primary btn-sm my-2"><i class="fe fe-plus-circle"></i> Tambahkan Lebih Banyak Produk</a>
                            </div>
                        </div>
                    @else
                        @foreach($popular as $key => $value)
                        <div class="swiper-slide">
                            <a href="{{url('product-detail/'.$value->id)}}">
                                <div class="card shadow-none border border-1">
                                    <div class="">
                                        <img src="{{ asset('storage/'.$value->photo_thumbnail) }}" width="100%">
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="m-0 mb-1 fs-13 text-primary font-weight-semibold" style="line-height:18px"><i class="fe fe-users"></i> {{$value->agent_selling}} Agent Sedang Menjualkan</div>
                                        <p class="text-dark fs-13 font-weight-semibold m-0" style="height:40px;line-height:20px">{{Str::limit($value->name, 40)}}</p>
                                        <small class="text-muted">{{$value->production_year}} · {{$value->transmission}}</small>
                                        <a href="{{url('product-detail/'.$value->id)}}" class="btn btn-primary btn-sm p-1 mt-1 btn-block">Lihat Detail</a>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>      
        </div>
    </div>
</div>
</div>
<div class="bg-white pt-3">
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto d-flex">
            <h5 class="flex-grow-1 mb-0 text-left mb-3">Brocar News</h5>
            <a class="text-primary font-weight-semibold" href="#">Lihat Semua</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="swiper swiperNews">
                <div class="swiper-wrapper">
                    @foreach ($news as $key => $value)
                    <div class="swiper-slide">
                        <a href="{{url('news-detail/'.$value->id)}}">
                            <div class="card shadow-none border border-1">
                                <div class="">
                                    <img src="{{ asset('storage/'.$value->photo) }}" width="100%">
                                </div>
                                <div class="card-body p-2">
                                    <h6 class="text-dark" style="height:40px;line-height:22px">{{Str::limit($value->name, 70)}}</h6>
                                    <small class="text-muted">@php echo Str::limit($value->description, 160); @endphp</small>
                                    <a href="{{url('news-detail/'.$value->id)}}" class="mb-0 fs-12 text-primary font-weight-12">Selengkapnya</a>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>      
        </div>
    </div>
</div>
</div>
<script>
    var swiper = new Swiper(".swipeInfo", {
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: false,
        spaceBetween: 8, // Space between the slides
    },
    });

    var swiper = new Swiper(".swiperProdukPopular", {
        slidesPerView: 2.0,
        centeredSlides: false,
        spaceBetween: 8, // Space between the slides
        loop: false, // Swiper loops your slides, and there is no ending point
    });

    var swiper = new Swiper(".swiperNews", {
        slidesPerView: 1.2,
        centeredSlides: false,
        spaceBetween: 8, // Space between the slides
        loop: false, // Swiper loops your slides, and there is no ending point
    });
</script>
</x-layouts.app>