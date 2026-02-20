<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('purchasing-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <p class="px-2 mb-2">Kategori</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$purchasing->pur_category}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Kode Invoice</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$purchasing->pur_code}}</h6>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <p class="px-2 mb-2">Tanggal Invoice</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{date('d M Y', strtotime($purchasing->pur_date))}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Pelanggan</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$purchasing->vendor_name}}</h6>
                            </div>
                        </div>
                    </div>
                    
                    @if($purchasing->pur_status == 'Draft')
                    <div class="form-group">
                    <a href="{{(url('purchasing-edit/'.$purchasing->id))}}" class="btn btn-outline-dark btn-sm mr-1 px-2 py-1"><i class="fe fe-edit"></i> Ubah</a>
                    <a href="{{(url('purchasing-delete/'.$purchasing->id))}}" data-title="{{$purchasing->pur_code}}" class="btn btn-outline-danger btn-sm btn-confirm px-2 py-1"><i class="fe fe-trash"></i> Hapus</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-box mr-1"></i> Items Produk</h5>
            </div>
            @if(session()->has('success'))
            <input type="hidden" id="alert_success" value="{{ session('success') }}">
            @endif
            @if(session()->has('danger'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fe fe-x mr-1" aria-hidden="true"></i> {{ session('danger') }}
            </div>
            @endif
            <div class="card text-center no-border shadow-none custom-square mb-2">
                <div class="card-body p-0">
                    <div id="content-data">
                    @foreach ($contents as $content)
                    <a href="{{url('sales-item-detail/'.$content->id.'?inv='.$content->itm_pur_id)}}" class="">
                    <div class="card-body px-2 py-2 border-bottom">
                        <div class="d-flex title-bar">
                            <div class="mr-auto text-left">
                                <p class="mb-1">{{$content->product_name}}</p>
                            </div>
                            <div class="ml-auto text-right">
                                <p class="text-muted mb-2">{{$content->itm_qty}} x {{str_replace(",", ".", number_format($content->product_price))}}</p>
                                <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->itm_total))}}</p>
                            </div>
                        </div>
                    </div>
                    </a>
                    @endforeach
                    </div>
                </div>
                @if($purchasing->pur_status == 'Draft')
                <a href="{{url('purchasing-item-add/'.$purchasing->id)}}" class="card-body p-2 border-top font-weight-semibold"><i class="fe fe-plus-circle fs-16"></i> Tambah Produk</a>
                @endif
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <div class="mr-auto text-left">
                    <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-shopping-bag mr-1"></i> Total</h5>
                </div>
                @if($purchasing->pur_status == 'Draft' && $purchasing->pur_total != '')
                <div class="ml-auto text-right">
                    <a href="{{url('purchasing-set/'.$purchasing->id)}}"><i class="fe fe-settings fs-18"></i></a>
                </div>
                @endif
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-2">
                <div class="card-body p-2">
                    <form id="purchasing-form" name="purchasing-form" action="{{url('purchasing-update-final/'.$purchasing->id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Sub Total</p>
                        </div>
                        <div class="ml-auto text-right">
                            <input type="hidden" name="pur_sub_total" value="{{$pur_sub_total}}">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($pur_sub_total))}}</p>
                        </div>
                    </div>
                    @if(!empty($purchasing->pur_discount))
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Discount</p> 
                        </div>
                        <div class="ml-auto text-right text-success">
                            <input type="hidden" id="text_disc" class="form-control form-control-sm" name="pur_discount" value="{{$purchasing->pur_discount}}">
                            <p id="lab_disc" class="mb-0">- Rp {{str_replace(",", ".", number_format($purchasing->pur_discount))}}</p>
                        </div>
                    </div>
                    @endif
                    @if(!empty($purchasing->pur_expedition))
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Pengiriman</p> 
                        </div>
                        <div class="ml-auto text-right text-danger">
                            <input type="hidden" id="pur_expedition" class="form-control form-control-sm" name="pur_expedition" value="{{$purchasing->pur_expedition}}">
                            <p id="lab_expedition" class="mb-0">+ Rp {{str_replace(",", ".", number_format($purchasing->pur_expedition))}}</p>
                        </div>
                    </div>
                    @endif
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Total</p>
                        </div>
                        <div class="ml-auto text-right">
                            <input type="hidden" name="pur_total" value="{{$pur_total}}">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($pur_total))}}</p>
                        </div>
                    </div>
                    @if($purchasing->pur_status == 'Draft')
                        <button type="submit" class="btn btn-primary btn-block" id="btn-update" name="btn-update">Simpan</button>
                        @if($purchasing->pur_total != 0)
                        <a href="{{url('purchasing-publish/'.$purchasing->id)}}" data-title="{{$purchasing->pur_code}}" class="btn btn-outline-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Publish</a>
                        @endif
                    @endif
                    </form>
                </div>
            </div>
            @if($purchasing->pur_status == 'Publish')
            <div class="d-flex py-2 px-2 border-bottom">
                <div class="mr-auto text-left">
                    <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-credit-card mr-1"></i> Info Pembayaran</h5>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-2">
                <div class="card-body p-2">
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Status Pembayaran</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">{{$purchasing->pur_status_payment}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Jumlah Bayar</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($purchasing->pur_payment))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Kurang Bayar</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($purchasing->must_pay))}}</p>
                        </div>
                    </div>
                    @if($purchasing->pur_status_payment == 'Belum Lunas')
                    <a href="{{url('purchasing-payment/'.$purchasing->id)}}" data-title="{{$purchasing->pur_code}}" class="btn btn-dark btn-block btn-payment" id="btn-payment" name="btn-payment"><i class="fe fe-credit-card"></i> Pembayaran</a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<script>
$(document).off('click', '.btn-confirm').on('click', '.btn-confirm', function(e){
    e.preventDefault();
    $('#modal-confirm .modal-body').html('You will delete data <b>'+$(this).data('title')+'</b>?');
    $('#modal-confirm .btn-action').attr('href', $(this).attr('href'));
    var myModal = new bootstrap.Modal(document.getElementById('modal-confirm'), {
        keyboard: false
    });
    myModal.show();
});

$(document).off('click', '.btn-publish').on('click', '.btn-publish', function(e){
    e.preventDefault();
    $('#modal-confirm .modal-body').html('You will publish data <b>'+$(this).data('title')+'</b>?');
    $('#modal-confirm .btn-action').attr('href', $(this).attr('href'));
    var myModal = new bootstrap.Modal(document.getElementById('modal-confirm'), {
        keyboard: false
    });
    myModal.show();
});

</script>
</x-layouts.app>