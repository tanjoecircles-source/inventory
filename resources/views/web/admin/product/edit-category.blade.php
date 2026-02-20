<x-layouts.app background="bg-white">
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-primary" urlback="{{url('product-detail/'.$id)}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-primary"></x-notification>
        @endslot
    </x-header-white-3column>
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
    <div class="">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="card no-border shadow-none custom-square mb-7">
                    <div class="card-body p-0">
                        <a href="{{(url('product-edit/'.$id))}}" class="d-flex p-4 border-bottom">
                            <i class="fe fe-truck fs-16 mr-2"></i>
                            <h6 class="mb-1 font-weight-semibold flex-grow-1">Informasi Produk</h6>
                            <i class="fe fe-chevron-right"></i>
                        </a>
                        <a href="{{(url('product-edit-photo/'.$id))}}" class="d-flex p-4 border-bottom">
                            <i class="fe fe-image fs-16 mr-2"></i>
                            <h6 class="mb-1 font-weight-semibold flex-grow-1">Foto Produk</h6>
                            <i class="fe fe-chevron-right"></i>
                        </a>
                        <a href="{{url('product-edit-sales/'.$id)}}" class="d-flex p-4 border-bottom">
                            <i class="fe fe-dollar-sign fs-16 mr-2"></i>
                            <h6 class="mb-1 font-weight-semibold flex-grow-1">Infromasi Penjualan</h6>
                            <i class="fe fe-chevron-right"></i>
                        </a>
                        @if($in_trans == 'true')
                            <div class="d-flex p-4 border-bottom" style="opacity:0.5">
                                <i class="fe fe-shopping-cart fs-16 mr-2 mt-1"></i>
                                <h6 class="my-1 font-weight-semibold flex-grow-1">Set Produk Terjual</h6>
                                <span class="badge badge-success m-0"><i class="fe fe-refresh-ccw"></i> Dalam Proses Transaksi</span>
                            </div>
                        @else
                            @if($is_sold_out == 'false')
                                <a href="{{(url('product-sold/'.$id))}}" data-title="{{$name}}" data-content="Merubah Produk Terjual" class="d-flex p-4 border-bottom btn-confirm">
                                    <i class="fe fe-shopping-cart fs-16 mr-2"></i>
                                    <h6 class="mb-1 font-weight-semibold flex-grow-1">Set Produk Terjual</h6>
                                    <i class="fe fe-chevron-right"></i>
                                </a>
                            @else
                            <a href="{{(url('product-sold/'.$id))}}" data-title="{{$name}}" data-content="Membatalkan Produk Terjual" class="d-flex p-4 border-bottom btn-confirm">
                                    <i class="fe fe-x fs-16 mr-2"></i>
                                    <h6 class="mb-1 font-weight-semibold flex-grow-1">Batalkan Produk Terjual</h6>
                                    <i class="fe fe-chevron-right"></i>
                                </a>
                            @endif
                        @endif
                       
                    </div>
                </div>
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