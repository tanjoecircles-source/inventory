<x-layouts.app>
<x-header-white-2column-center>
    @slot('left')
        <x-back backstyle="text-dark" urlback="{{url('qrcode-agent')}}"></x-back>
    @endslot
    @slot('right')
        <div class="text-center text-dark">Info Penjualan</div>
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
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <!-- info dealer -->
            <div class="card no-border shadow-none custom-square py-2 mb-2">
                <div class="card-body px-4 py-4">
                    <h4>Informasi Penjual / Dealer</h4>
                    <div class="row">
                        <div class="col-1 pr-0">
                            <!-- <i class="fa fa-map-marker fa-2x text-primary"></i> -->
                            <img src="{{ asset('assets/images/png/bro_location.png')}}" class="img-responsive" style="width: 16px; height: 18px;">
                        </div>
                        <div class="col-11">
                            <span class="mb-3"><b>{{ $seller->name ?? '' }}</b></span><br>
                            <span class="text-muted">{{ $seller->address ?? '' }}</span><br>
                            <span class="text-muted">{{ ($seller->detailDistrict->name ?? '').(empty($seller->detailRegion->name) ? '' : ', '.$seller->detailRegion->name) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end info dealer -->

            <!-- info unit -->
            <div class="card no-border shadow-none custom-square py-2 my-0">
                <div class="card-body px-4 py-0 my-0">
                    <h4>Informasi Unit</h4>
                </div>
            </div>
            <div class="swiper swiperProduct mb-3">
                <div class="swiper-wrapper">
                    @foreach($foto AS $key => $val)
                        <div class="swiper-slide"><img class="rounded shadow" src="{{ $val }}" alt="{{$info['judul']}}" ></div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
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
            
            <!-- info customer -->
            <div class="card no-border shadow-none custom-square py-2 mb-2">
                <div class="card-body px-4 py-4">
                    <h4>Informasi Pembeli</h4>
                    <div class="d-flex flex-row">
                        @php 
                        $bgDefault = asset('assets/images/users/6.jpg');
                        @endphp
                        <div id="user-thumbnail" class="avatar avatar-xl brround d-block cover-image m-2" style="background: url('{!! $bgDefault !!}') center center;"></div>
                        <div class="pt-2">
                            <p class="mb-1 text-dark font-weight-semibold">{{ $visitation->customer_name }}</p>
                            <p class="text-muted mb-0">{{ $visitation->customer_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end info customer -->
            
            <!-- info payment -->
            <div class="card no-border shadow-none custom-square py-2 mb-2">
                <div class="card-body px-4 py-4">
                <h4>Informasi Pembayaran</h4>
                <div id="accordion">
                    @if($payment_method == 'cash')
                    <div class="card border-primary">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link pl-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Pembayaran Tunai
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <b>Bank BCA</b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-muted">5671457334</div>
                                    <div class="col text-right text-primary"><b>Salin</b></div>
                                </div>
                                <div class="row">
                                    <div class="col">{{ $seller->name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($payment_method == 'credit')
                    <div class="card border-primary">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link pl-0" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Kredit
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <b>Catatan:</b>
                                <br>
                                <span class="text-muted">Kredit telah disepakati oleh pembeli dan penjual</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col">
                        <a href="{{ $link_checkout }}" class="btn btn-primary btn-block" data-toggle="modal" data-target="#confirm-checkout-dialog">Checkout Produk</a>
                        <button type="button" class="btn btn-outline-primary btn-block">Ajukan Pembatalan</button>
                    </div>
                </div>
            </div>
            <!-- end info payment -->

        </div>
    </div>
    </div>
</div>
<!-- bottom sheet confirm -->
<!-- Modal -->
<div class="modal fade" id="confirm-checkout-dialog" role="dialog" >
    <div class="modal-dialog mx-auto" style="position:absolute;bottom:64px;margin:0;width:100%;left:0;right:0;">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-center w-100 font-weight-bolder">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-center">
            <img src="{{ url('assets/images/png/ic_attention.png') }}" style="width:82px;height: 82px;">
            <p id="modal-text">Anda yakin akan melakukan checkout?</p>
            <div class="row ml-1 mr-1 mt-5">
                <div class="col text-center">
                    <a class="btn btn-block btn-outline-primary fs-14 btn-confirm-visit" data-dismiss="modal" href="#">Batal</a>
                </div>
                <div class="col text-center">
                    <a class="btn btn-block btn-primary fs-14 btn-checkout-dialog" href="#">Ya</a>
                </div>
            </div>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>

    </div>
</div>
<!-- end bottom sheet confirm -->
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

    $('#confirm-checkout-dialog').on('shown.bs.modal', function(e){
        var href = e.relatedTarget.href;
        $('#confirm-checkout-dialog .btn-checkout-dialog').attr('href', href);
    });
</script>
</x-layouts.app>