<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <!-- <x-back backstyle="text-dark" urlback="{{url('product-explore')}}"></x-back> -->
    <x-back backstyle="text-dark" urlback="{{ redirect()->back()->getTargetUrl() }}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
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
                            <p class="px-2 ml-auto font-weight-bold">{{$info['jarak_tempuh']}} Km</p>
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
                @if($info['is_sold_out'] == 'true')
                    <button class="btn btn-default btn-block btn-lg" disabled><i class=" fe fe-info"></i> Produk Sudah Terjual</button>
                    <a href="{{url('product-explore')}}" class="btn btn-primary btn-sm my-2"><i class="fe fe-search"></i> Cari Stok Lain</a>
                @else
                    @if($etalase == 0)
                        <a id="add_etalase_{{$id_produk}}" onclick="addEtalase('{{$id_produk}}')" class="btn btn-primary btn-lg btn-block"><span id="label-add-etalase"><i class="fe fe-plus"></i> Tambah ke Etalase</span></a>
                    @else
                        <a id="rmv_etalase_{{$id_produk}}" onclick="removeEtalase('{{$id_produk}}')" class="btn btn-white btn-lg btn-block"><span id="label-rmv-etalase"><i class="fe fe-trash"></i> Hapus Dari Etalase</span></a>
                    @endif
                @endif
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

function addEtalase(id){
    $.ajax({
        url:"{{url('product-explore-etalase')}}",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data : {product_id:id},
        type:'post',
        beforeSend: function(){
            setTimeout($('#label-add-etalase').replaceWith('<i class="fa fa-circle-o-notch fa-spin fs-14"></i> proses...'), 10000);
        }
    })
    .done(function(data){
        if(data.status == 1){
            $('#add_etalase_'+data.id).replaceWith('<a id="rmv_etalase_'+data.id+'" onclick="removeEtalase(\''+data.id+'\')" class="btn btn-white btn-block btn-lg"><span id="label-rmv-etalase"><i class="fe fe-trash"></i> Hapus Dari Etalase<span></a>');
        }
    })
    .fail(function(jqXHR,ajaxOptions,thrownError){
        return false;
    });
}

function removeEtalase(id){
    $.ajax({
        url:"{{url('product-explore-unetalase')}}",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data : {product_id:id},
        type:'post',
        beforeSend: function(){
            setTimeout($('#label-rmv-etalase').replaceWith('<i class="fa fa-circle-o-notch fa-spin fs-14"></i> proses...'), 10000);
        }
    })
    .done(function(data){
        if(data.status == 0){
            $('#rmv_etalase_'+data.id).replaceWith('<a id="add_etalase_'+data.id+'" onclick="addEtalase(\''+data.id+'\')" class="btn btn-primary btn-block btn-lg"><span id="label-add-etalase"><i class="fe fe-plus"></i> Tambah Ke Etalase</span></a>');
        }
    })
    .fail(function(jqXHR,ajaxOptions,thrownError){
        return false;
    });
}
</script>
</x-layouts.app>