<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('product-list')}}"></x-back>
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
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto px-0">
                <div class="card no-border shadow-none custom-square my-2">
                    <div class="card-body px-4 py-4">
                        <h5>Informasi Produk</h5>
                        {{-- <div class="row mb-2 border-bottom">
                            <div class="col text-center">
                                <img class="my-2" src="{{ asset('assets/images/png/condition.png') }}" alt="tag" >
                                <p class="text-muted fs-13 m-0">Kategori</p>
                                <p>{{$info['kategori']}}</p>
                            </div>
                            <div class="col text-center">
                                <img class="my-2" src="{{ asset('assets/images/png/brand.png') }}" alt="tag" >
                                <p class="text-muted fs-13 m-0">Nama</p>
                                <p>{{$info['nama']}}</p>
                            </div>
                            <div class="col text-center">
                                <img class="my-2" src="{{ asset('assets/images/png/transmission.png') }}" alt="tag" >
                                <p class="text-muted fs-13 m-0">Harga</p>
                                <p>{{$info['harga']}}</p>
                            </div>
                        </div> --}}
                        <div class="my-4" id="moredetail">
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">SKU</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['code']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Group</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['product_parent']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Kategori</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['kategori']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Nama</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['nama']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Berat Satuan (Gram)</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['satuan']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Stock</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['stock']}}@if(Auth::user()->id == 1 || Auth::user()->id == 3) &nbsp;&nbsp;&nbsp;<a href="{{url('product-stock-set/'.$id_produk)}}" class="btn btn-sm btn-default px-2 py-1"> <i class="fe fe-settings"></i></a>@endif</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Harga</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['harga']}} @if(!empty($info['harga15'])) | {{$info['harga15']}} @endif @if(!empty($info['harga50'])) | {{$info['harga50']}} @endif</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">HPP</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['hpp']}}@if(Auth::user()->id == 1 || Auth::user()->id == 3) &nbsp;&nbsp;&nbsp;<a href="{{url('product-hpp-set/'.$id_produk)}}" class="btn btn-sm btn-default px-2 py-1"> <i class="fe fe-settings"></i></a>@endif</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Estimasi Profit</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['profit']}} @if(!empty($info['profit15'])) | {{$info['profit15']}} @endif @if(!empty($info['profit50'])) | {{$info['profit50']}} @endif</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Origin</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['origin']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Process</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['process']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Varietal</p>
                                <p class="px-2 ml-auto font-weight-bold">{{$info['varietal']}}</p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Status</p>
                                <p class="px-2 ml-auto font-weight-bold">{{($info['status'] == 'Active' ? 'Aktif' : 'Tidak Aktif')}}</p>
                            </div>
                        </div>
                        <h5 class="mt-4 mb-1">Deskripsi</h5>
                        <p>@php echo $info['deskripsi']@endphp</p>
                    </div>
                </div>
                @if(Auth::user()->id == 1 || Auth::user()->id == 3)
                <div class="card text-center no-border shadow-none custom-square my-2">
                    <div class="card-body p-0">
                        @if($info['is_recomended'] == 'false')
                        <a href="{{(url('product-choosed/'.$id_produk))}}" data-title="{{$info['nama']}}" data-content="Menentukan Produk Plihan" class="d-flex p-4 border-bottom btn-confirm">
                            <i class="fe fe-star fs-16 mr-2"></i>
                            <p class="mb-1 font-weight-semibold">Jadikan Favorit</p>
                        </a>
                        @else
                        <a href="{{(url('product-choosed/'.$id_produk))}}" data-title="{{$info['nama']}}" data-content="Menghilangkan Produk Plihan" class="d-flex p-4 border-bottom btn-confirm">
                            <i class="fe fe-star text-yellow fs-16 mr-2"></i>
                            <p class="mb-1 font-weight-semibold">Hilangkan Favorit</p>
                        </a>
                        @endif
                        
                        <a href="{{(url('product-edit/'.$id_produk))}}" class="d-flex p-4 border-bottom">
                            <i class="fe fe-edit fs-16 mr-2"></i>
                            <p class="mb-1 font-weight-semibold">Ubah Data</p>
                        </a>
                        <a href="{{(url('product-delete/'.$id_produk))}}" data-title="{{$info['nama']}}" data-content="Menghapus Data" class="d-flex p-4 border-bottom btn-confirm">
                            <i class="fe fe-trash fs-16 mr-2"></i>
                            <p class="mb-1 font-weight-semibold">Hapus Data</p>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script>
    $(document).off('click', '.btn-confirm').on('click', '.btn-confirm', function(e){
        e.preventDefault();
        $('#modal-confirm .modal-body').html('Anda Yakin '+$(this).data('content')+' <b>'+$(this).data('title')+'</b>?');
        $('#modal-confirm .btn-action').attr('href', $(this).attr('href'));
        var myModal = new bootstrap.Modal(document.getElementById('modal-confirm'), {
            keyboard: false
        });
        myModal.show();
    });
    
    </script>
    </x-layouts.app>