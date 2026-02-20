<x-layouts.app>
<x-header-white-2column-center>
    @slot('left')
        <x-back backstyle="text-dark" urlback="{{url('transaction')}}"></x-back>
    @endslot
    @slot('right')
        <div class="text-center text-dark">{!! substr($info['judul'], 0 , 100) !!}</div>
    @endslot
</x-header-white-2column-center>
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
    .nav-pills .nav-link{
        font-size: 14px;
        font-weight: 600;
        background: transparent;
        outline: none;
        border: none;
        border-radius: 0px;
        padding-bottom: 14px;
        border-bottom: transparent solid 2px;
    }
    .nav-pills .nav-link.active{
        border-bottom: #E60911 solid 2px;
        color: #E60911;
        background: transparent;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item w-50" role="presentation">
                    <button class="nav-link active w-100" id="pills-transaction-tab" data-toggle="pill" data-target="#pills-transaction" type="button" role="tab" aria-controls="pills-transaction" aria-selected="true">Informasi Transaksi</button>
                </li>
                <li class="nav-item w-50" role="presentation">
                    <button class="nav-link w-100" id="pills-info-unit-tab" data-toggle="pill" data-target="#pills-info-unit" type="button" role="tab" aria-controls="pills-info-unit" aria-selected="false">Informasi Unit</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-transaction" role="tabpanel" aria-labelledby="pills-transaction-tab">
                    <!-- info transaksi -->
                    <div class="card no-border shadow-none custom-square my-2">
                        <div class="card-body px-3 py-3">
                            <h5>Informasi Pengajuan Visitasi</h5>
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="text-muted">Pengajuan Waktu Visitasi</span>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <i class="fa fa-calendar text-danger mr-2"></i>
                                    <span class="text-dark">{{ $info['visit_date'] }}</span>
                                </div>

                                <div class="col-lg-12">
                                    <span class="text-muted">Lokasi</span>
                                </div>
                                <div class="col-lg-12">
                                    <i class="fa fa-map-marker text-danger mr-3"></i>
                                    <span class="text-dark">{{ $info['location'] }}</span>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <span class="text-muted pl-5">{{ $info['customer_address'] }}</span>
                                </div>
                                
                                <div class="col-lg-12">
                                    <span class="text-muted">Nama Pembeli</span>
                                </div>
                                <div class="col-lg-12">
                                    <i class="fa fa-user-o text-danger mr-2"></i>
                                    <span class="text-dark">{{ $info['customer_name'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 mt-3">
                        <div class="col-8 text-left text-mutes">Selesai...</div>
                        <div class="col text-right text-primary">{{ date('d M Y, H:i', strtotime($detail->updated_at)) }}</div>
                    </div>

                    <div class="card no-border shadow-none custom-square my-2">
                        <div class="card-body px-3 py-3">
                            <div class="row">
                                <div class="col text-muted">
                                    <h6>Catatan:</h6>
                                    <p class="text-justify p-catatan">Produk Terjual</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end info transaksi -->
                </div>

                <div class="tab-pane fade" id="pills-info-unit" role="tabpanel" aria-labelledby="pills-info-unit-tab">

                    <!-- info unit -->
                    <div class="swiper swiperProduct mb-3">
                        <div class="swiper-wrapper">
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
                    <div class="card no-border shadow-none custom-square my-2">
                        <div class="card-body px-4 py-4">
                            <h4 class="mb-0">{{$info['harga']}}</h4>
                            <p class="text-primary font-weight-semibold fs-13 mb-1">Komisi {{$info['komisi']}}</p>
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
                    <!-- end info unit -->

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