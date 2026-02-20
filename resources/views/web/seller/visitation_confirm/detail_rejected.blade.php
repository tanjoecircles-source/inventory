<x-layouts.app>
<x-header-white-2column-center>
    @slot('left')
        <x-back backstyle="text-dark" urlback="{{url('visitation-confirm')}}"></x-back>
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
            <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation" style="width: calc(100% / 2);">
                    <button class="nav-link w-100 active" id="pills-list-agent-tab" data-toggle="pill" data-target="#pills-list-agent" type="button" role="tab" aria-controls="pills-list-agent" aria-selected="true">List Agent</button>
                </li>
                <li class="nav-item" role="presentation" style="width: calc(100% / 2);">
                    <button class="nav-link w-100" id="pills-info-unit-tab" data-toggle="pill" data-target="#pills-info-unit" type="button" role="tab" aria-controls="pills-info-unit" aria-selected="false">Informasi Unit</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-list-agent" role="tabpanel" aria-labelledby="pills-list-agent-tab">
                    <!-- list agent -->
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
                    <div id="content-data">
                        @if(empty($listRejected->count()))
                            <h6 class="m-4 text-center">No matching records found</h6>
                        @endif
                        @include('web.seller.visitation_confirm.paginate_detail_rejected')
                    </div>
                    <div class="ajax-load" style="display:none">
                        <p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                    </div>
                    <!-- end list-agen -->
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
<!-- bottom sheet confirm -->
<!-- Modal -->
<div class="modal fade" id="confirm-visition-dialog" role="dialog" >
    <div class="modal-dialog" style="position:absolute;bottom:64px;margin:0;width:100%;">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-center w-100 font-weight-bolder">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-center">
            <img src="{{ url('assets/images/png/ic_attention.png') }}" style="width:82px;height: 82px;">
            <p id="modal-text">Setujui pengajuan visitasi?</p>
            <div class="row ml-1 mr-1 mt-5">
                <div class="col text-center">
                    <a class="btn btn-block btn-outline-primary fs-14 btn-confirm-visit" data-dismiss="modal" href="#">Batal</a>
                </div>
                <div class="col text-center">
                    <a class="btn btn-block btn-primary fs-14 btn-approve-visit" href="#">Ya</a>
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

    //paginate agent list
    var page = 1;
    var onLoading = false;

    $(window).scroll(function(){
        if (!onLoading && $(window).scrollTop() >= $(document).height() - $(window).height() - 1){
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page, key){
        $.ajax({
            url:'?page=' + page,
            type:'get',
            beforeSend: function(){
                $('.ajax-load').show();
                onLoading = true;
            }
        })
        .done(function(data){
            $('.ajax-load').hide();
            if(data.html == "" && page == 1){
                $('#content-data').html('<h6 class="m-4 text-center">No more records found</h6>');
                return;     
            }else if(data.html == "" && page >= 1){
                $('#content-data').append('<h6 class="m-4 text-center">No more records found</h6>');
                return;     
            }
            onLoading = false;
            $('#content-data').append(data.html);
        })
        .fail(function(jqXHR,ajaxOptions,thrownError){
            onLoading = false;
            $('.ajax-load').hide();
            $('#content-data').append('<h6 class="m-4 text-center">Server Error</h6>');
        });
    }

    // $(document).on('click', '.btn-confirm-visit', function(e){
    //     e.preventDefault();
    //     e.stopImmediatePropagation();
    //     // console.log($(this).data());
    //     if ($(this).data('visitconfirm') == "1"){
    //         $('#confirm-visition-dialog #modal-text').html('Setujui pengajuan visitasi?');
    //         $('#confirm-visition-dialog a.btn-approve-visit').attr('href', "{{ url('visitation-approve') }}/"+$(this).data('visitid'));
    //     }else{
    //         $('#confirm-visition-dialog #modal-text').html('Tolak pengajuan visitasi?');
    //         $('#confirm-visition-dialog a.btn-approve-visit').attr('href', "{{ url('visitation-reject') }}/"+$(this).data('visitid'));
    //     }
    //     $('#confirm-visition-dialog').modal('show');
    // })
</script>
</x-layouts.app>