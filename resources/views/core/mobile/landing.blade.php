<x-layouts.public>
<link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>        
<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>   
<style>
    .league-spartan{
        font-family: 'League Spartan' !important;
    }
    .roboto{
        font-family: 'Roboto' !important;
    }
    :root {
        scroll-behavior: smooth;
        font-family: 'Roboto' !important;
    }
    .container, .container-fluid {
        padding-right: 1rem;
        padding-left: 1rem;
    }
    .section-banner{
        /* background-image: url('{{ asset('assets/images/pattern/splash_1.png') }}');  */
        background-color: #fff;
        background-repeat: no-repeat; /* Do not repeat the image */
        background-size: cover;
    }
    .section-benefit{
        background-color: #E62129 ;
        background-repeat: no-repeat; /* Do not repeat the image */
        background-size: cover;
        height: 700px;
    }
    .text-black{
        color: #000;   
    }
    .container, .container-fluid {
        padding-right: 1rem;
        padding-left: 1rem;
    }
    .swiper-button-next::after, .swiper-button-prev::after {
        display: none;
        margin: 30px;
    }
</style>
<x-header-white-2column>
    @slot('left')
        <img src="{{ asset('assets/images/brand/logo.png') }}" class="icon-blue" style="height:1.5rem;" alt="Brocar logo">
    @endslot
    @slot('right')
        <a href="{{url('login')}}" class="btn btn-primary my-2 px-5">Masuk</a>
    @endslot
</x-header-white-3column>
<div class="section-banner">
    <div class="h-7"></div>
    <div class="container">
        <div class="row h-100 py-7 text-center">
            <div class="col-lg-12 col-sm-12">
                <h4 class="font-weight-semibold text-black league-spartan">NEXT GENERATION EARNING<br>PLATFORM IN AUTOMOTIVE</h4> 
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="{{ asset('assets/images/pattern/brocar-img-01.png') }}" alt="tag" ></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/images/pattern/brocar-img-02.png') }}" alt="tag" ></div>
                        <div class="swiper-slide"><img src="{{ asset('assets/images/pattern/brocar-img-03.png') }}" alt="tag" ></div>
                    </div>
                    <div class="swiper-button-next text-primary"><i class="fe fe-arrow-right-circle fs-25"></i></div>
                    <div class="swiper-button-prev text-primary"><i class="fe fe-arrow-left-circle fs-25"></i></div>
                </div>
                <h3 class="font-weight-bold text-black roboto">Tawarkan Mobil Rekanan<br>Kami & Dapatkan Jutaan<br>Rupiah Dengan Mudah</h3>
                <p class="p-0 font-weight-semibold text-black fs-15 roboto">Miliki penghasilan hingga 10 juta perbulan<br>hanya dari rumah!</p>
                <a href="{{url('login')}}" class="btn btn-primary btn-lg btn-pill my-3">Daftar Sekarang <i class="fe fe-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
<section class="section-benefit text-white text-center">
    <div class="container">
        <div class="row py-7">
            <div class="col-lg-6">
                <h3 class="font-weight-bold mb-7">Kelebihan Menjadi<br>Mitra Agen Brocar</h3>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="fs-40 icon-muted"><i class="si si-wallet icon-dropshadow-primary text-primary"></i></span>
                                <h6 class="mb-1 fs-20 text-primary font-weight-bold">1.5 Juta++</h6>
                                <p class="text-primary mb-1 font-weight-bold fs-12">PER TRANSAKSI</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="fs-40 icon-muted"><i class="si si-key icon-dropshadow-primary text-primary"></i></span>
                                <h6 class="mb-1 fs-20 text-primary font-weight-bold">10.000</h6>
                                <p class="text-primary mb-1 font-weight-bold fs-12">STOK MOBIL</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="fs-40 icon-muted"><i class="si si-home icon-dropshadow-primary text-primary"></i></span>
                                <h6 class="mb-1 fs-20 text-primary font-weight-bold">1000</h6>
                                <p class="text-primary mb-1 font-weight-bold fs-12">MITRA SHOWROOM</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="fs-40 icon-muted"><i class="si si-clock icon-dropshadow-primary text-primary"></i></span>
                                <h6 class="mb-1 fs-20 text-primary font-weight-bold">24 JAM</h6>
                                <p class="text-primary mb-1 font-weight-bold fs-12">KERJA DARI RUMAH</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <img src="{{ asset('assets/images/pattern/splash_5.png') }}" style="position:relative">
            </div>
        </div>
    </div>
</section>
<section id="section-role" class="py-7 text-black mt-7 text-center">
<div class="container">
    <div class="row my-5">
        <div class="col-lg-12">
            <h3 class="text-center">Kerjanya Mudah<br>Cuannya Melimpah!</h3>
            <p class="text-center fs-18 font-weight-semibold">Ikuti Cara Kerjanya:</p>
            <div class="row mb-5">
                <div class="col-lg-12 mb-">
                    <i class="fe fe-clipboard fs-60 text-gray mb-2" style="color: #e42d39 !important;"></i>
                    <h4 class="font-weight-semibold pt-4 pb-2 mb-0">Registrasi</h4>
                    <p class="text-muted">
                        Lakukan proses registrasi untuk<br>siap menghasilkan uang!
                    </p>
                    <i class="fe fe-arrow-down text-center text-gray fs-30"></i>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-12">
                    <i class="fe fe-plus-circle fs-60 text-gray mb-4" style="color: #e42d39 !important;"></i>
                    <h4 class="font-weight-semibold pt-4 pb-2 mb-0">Tambahkan</h4>
                    <p class="text-muted">
                        Tambahkan unit yang ingin anda<br>jualkan ke dalam etalase
                    </p>
                    <i class="fe fe-arrow-down text-center text-gray fs-30"></i>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-3">
                    <i class="fe fe-share-2 fs-60 text-gray mb-2" style="color: #e42d39 !important;"></i>
                    <h4 class="font-weight-semibold pt-4 pb-2 mb-0">Sebarkan</h4>
                    <p class="text-muted">
                        Bagikan unit yang sudah anda<br>miliki di etalase pada prospek
                    </p>
                    <i class="fe fe-arrow-down text-center text-gray fs-30"></i>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-3">
                    <i class="fe fe-calendar fs-60 text-gray mb-2" style="color: #e42d39 !important;"></i>
                    <h4 class="font-weight-semibold pt-4 pb-2 mb-0">Atur Visitasi</h4>
                    <p class="text-muted">
                        Atur visitasi untuk mempertemukan<br>prospek dengan penjual
                    </p>
                    <i class="fe fe-arrow-down text-center text-gray fs-30"></i>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <i class="fe fe-check-circle fs-60 text-gray mb-2" style="color: #e42d39 !important;"></i>
                    <h4 class="font-weight-semibold pt-4 pb-2 mb-0">Deal</h4>
                    <p class="text-muted">
                        Jika mobil terjual, penjual akan<br>segera mengirimkan komisi anda
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<section id="section-video" class="bg-primary text-default">
    <iframe width="100%" height="240" src="https://www.youtube.com/embed/0hrZNZtwknI?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>    
</section>
<section id="section-identity" class="pt-7 bg-primary text-white text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="mt-2">#TEMANCUANOTOMOTIF</h3>
                <p class="fs-17">Bersama brocar kamu tidak lagi<br>
                    hanya menjadi pecinta, namun kamu<br>
                    dapat memiliki penghasilan bernilai<br>
                    jutaan dari dunia otomotif!</p>
            </div>
            <div class="col-lg-12">
                <img src="{{ asset('assets/images/pattern/product-preview.png') }}">
            </div>
        </div>
    </div>
</section>
<section id="copyright" class="bg-primary text-white">
    <div class="bg-black-4 p-4">
    <div class="font-weight-normal fs-14 text-center">Copyright &#169;2020 All rights reserved | tanjoecoffee.com</div>
    </div>
</section>
<script>
    var swiper = new Swiper(".mySwiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
</x-layouts>