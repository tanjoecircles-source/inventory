<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('home')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<style>
.swipeInfo {
    width: 100%;
}

.swipeInfo .swiper-slide img {
    border-radius: 8px !important;
    border: 2px solid #eee;
    object-fit: cover;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="row px-2">
                <div class="col-12 p-2">
                    <h5 class="text-left mt-2 mb-0">Green Bean Map</h5>
                </div>
            </div>
            <div class="swiper swipeInfo">
                <div class="swiper-wrapper mb-6 text-center">
                    <div class="swiper-slide">  
                        <div class="row px-2">
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Belakang Kiri</3>
                                    </div>
                                    <div class="card-body pt-1 pb-2 px-2 fs-12" style="min-height:125px">
                                        @foreach ($map_belakang_kiri as $mbk)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$mbk->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$mbk->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/001-belakang-kiri')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Belakang Kanan</3>
                                    </div>
                                    <div class="card-body pt-1 px-2 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_belakang_kanan as $mbk)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$mbk->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$mbk->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/001-belakang-kanan')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Tengah Kiri</3>
                                    </div>
                                    <div class="card-body pt-1 px-2 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_tengah_kiri as $v)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$v->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$v->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/001-tengah-kiri')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Tengah Kanan</3>
                                    </div>
                                    <div class="card-body px-2 pt-1 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_tengah_kanan as $v)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$v->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$v->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/001-tengah-kanan')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Depan Kiri</3>
                                    </div>
                                    <div class="card-body pt-1 px-2 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_depan_kiri as $v)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$v->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$v->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/001-depan-kiri')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Depan Kanan</3>
                                    </div>
                                    <div class="card-body pt-1 px-2 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_depan_kanan as $v)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$v->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$v->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/001-depan-kanan')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="row px-2">
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Belakang Kiri</3>
                                    </div>
                                    <div class="card-body px-2 pt-1 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_belakang_kiri_2 as $mbk)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$mbk->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$mbk->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/002-belakang-kiri')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Belakang Kanan</3>
                                    </div>
                                    <div class="card-body px-2 pt-1 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_belakang_kanan_2 as $mbk)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$mbk->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$mbk->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/002-belakang-kanan')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Depan Kiri</3>
                                    </div>
                                    <div class="card-body px-2 pt-1 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_depan_kiri_2 as $v)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$v->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$v->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/002-depan-kiri')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2">
                                <div class="card mb-0">
                                    <div class="card-header px-2" style="min-height:2.5rem">
                                        <h3 class="card-title fs-13">Depan Kanan</3>
                                    </div>
                                    <div class="card-body px-2 pt-1 pb-2 fs-12" style="min-height:125px">
                                        @foreach ($map_depan_kanan_2 as $v)
                                        <div class="d-flex title-bar">
                                            <div class="mr-auto text-left">
                                                <p class="mb-1">{{$v->name}}</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <a href="{{(url('gb-map-delete/'.$v->id))}}" class="mx-1 btn-confirm" data-title="{{$mbk->name}}"><i class="fe fe-trash fs-11"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer p-2" style="min-height:2.5rem">
                                        <a href="{{url('gb-map-add/002-depan-kanan')}}" class="btn btn-sm btn-block btn-dark"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    
</div>
<script>
var swiper = new Swiper(".swipeInfo", {
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: false,
        spaceBetween: 8, // Space between the slides
    },
});
</script>
</x-layouts.app>