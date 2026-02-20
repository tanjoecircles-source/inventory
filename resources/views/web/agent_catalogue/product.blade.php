<x-layouts.public metatitle="{{$info['harga']}}" metadesc="{{$info['judul']}}" metaimage="{{$meta_image}}">
    <x-header-red-3column notif="">
        @slot('back')
        <x-back backstyle="text-white" urlback="{{url('mitra?name='.$nameurl.'&id='.$codeurl)}}"></x-back>
        @endslot
    </x-header-red-3column>
    <style>
        .swiper-pagination-progressbar .swiper-pagination-progressbar-fill {
            background: #E62129;
        }
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 24px;
            color:#fff
        }
        .swiper-pagination-bullet {
            background: #fff;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="swiper swiperProduct">
                    <div class="swiper-wrapper mb-0">
                        @foreach($foto AS $key => $val)
                            <div class="swiper-slide"><img class="rounded shadow" src="{{ $val }}" alt="{{$info['judul']}}" ></div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    {{-- <div class="swiper-pagination"></div> --}}
                    <div thumbsSlider="" class="swiper mySwiper mt-2">
                        <div class="swiper-wrapper">
                            @foreach($foto AS $key => $val)
                            <div class="swiper-slide"><img class="rounded shadow" src="{{ $val }}" /></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto px-0">
                <div class="card no-border shadow-none custom-square my-2">
                    <div class="card-body px-4 py-4">
                        <h4 class="mb-0">{{$info['harga']}}</h4>
                        <p class="fs-15">{{$info['judul']}}</p>
                    </div>
                </div>
                <div class="card no-border shadow-none custom-square my-2">
                    <div class="card-body px-4 py-4">
                        <h5>Informasi Kendaraan</h5>
                        <div class="row mb-2 border-bottom">
                            <div class="col text-center">
                                <span class="colorinput-color m-1" style="background:{{$info['kode_warna']}};width:1.7rem;height:1.7rem;"></span>
                                <p class="text-muted fs-13 m-0">Warna</p>
                                <p>{{$info['warna']}}</p>
                            </div>
                            <div class="col text-center">
                                <img class="my-2" src="{{ asset('assets/images/png/condition.png') }}" alt="tag" >
                                <p class="text-muted fs-13 m-0">Kondisi</p>
                                <p>{{$info['kondisi']}}</p>
                            </div>
                            <div class="col text-center">
                                <img class="my-2" src="{{ asset('assets/images/png/brand.png') }}" alt="tag" >
                                <p class="text-muted fs-13 m-0">Merek</p>
                                <p>{{$info['brand']}}</p>
                            </div>
                            <div class="col text-center">
                                <img class="my-2" src="{{ asset('assets/images/png/transmission.png') }}" alt="tag" >
                                <p class="text-muted fs-13 m-0">Transmisi</p>
                                <p>{{$info['tranmisi']}}</p>
                            </div>
                        </div>
                        <a style="cursor: pointer;" onclick="showMore()" id="showmore" class="font-weight-semibold text-primary fs-15 mt-5">Tampilkan Selengkapnya</a>
                        <div class="my-4" id="moredetail">
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Tipe</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['tipe']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Varian</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['varian']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Tahun</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['tahun']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Kapasitas Mesin</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['kapasitas_mesin']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Bahan Bakar</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['bahan_bakar']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Tipe Bodi</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['tipe_bodi']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Kilometer</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['jarak_tempuh']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Kapasitas Penumpang</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['kapasitas_penumpang']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Riwayat Kepemilikan</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['tangan_ke']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Tanggal Akhir Pajak</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['pajak']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Kode Plat</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['kode_plat'].' **** **'}}</p>
                            </div>
                        </div>
                        <h5 class="mt-4 mb-1">Deskripsi</h5>
                        <p>@php echo $info['deskripsi'] @endphp</p>
                    </div>
                </div>
                <div class="card text-center no-border shadow-none custom-square mb-7">
                    <div class="card-body p-2">
                        <a href="https://api.whatsapp.com/send/?phone=62{{$agent_phone}}&text&type=phone_number&app_absent=0&text={{$agent_content_text}}" target="_blank" class="btn btn-primary btn-block btn-lg mt-1"><i class="fe fe-help-circle"></i> Tanyakan Info Unit Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".swiperProduct", {
        loop: true,
        spaceBetween: 10,
        zoom: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
        });
    
    $("#moredetail").hide();
    
    function showMore(){
        $("#moredetail").slideDown();
        $("#showmore").hide();
    }
    </script>
    </x-layouts.app>