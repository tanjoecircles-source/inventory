<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('sales-list')}}"></x-back>
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
                                <h6 class="px-2 m-0 font-weight-bold">{{$invoice->inv_category}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Kode Invoice</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$invoice->inv_code}}</h6>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <p class="px-2 mb-2">Tanggal Invoice</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{date('d M Y', strtotime($invoice->inv_date))}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Pelanggan</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$invoice->cust_name}}</h6>
                            </div>
                        </div>
                    </div>
                    
                    @if($invoice->inv_status == 'Draft')
                    <div class="form-group">
                    <a href="{{(url('sales-edit/'.$invoice->id))}}" class="btn btn-outline-dark btn-sm mr-1 px-2 py-1"><i class="fe fe-edit"></i> Ubah</a>
                    <a href="{{(url('sales-delete/'.$invoice->id))}}" data-title="{{$invoice->inv_code}}" class="btn btn-outline-danger btn-sm btn-confirm px-2 py-1"><i class="fe fe-trash"></i> Hapus</a>
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
                        @if($contents_count == 0)
                            <h6 class="m-4">No matching records found</h6>
                        @endif
                        @include('web.admin.sales_items.paginate')
                    </div>
                </div>
                @if($invoice->inv_status == 'Draft')
                <a href="{{url('sales-item-add/'.$invoice->id)}}" class="card-body p-2 border-top font-weight-semibold"><i class="fe fe-plus-circle fs-16"></i> Tambah Produk</a>
                @endif
            </div>
            <div class="ajax-load text-center" style="">
                <p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <div class="mr-auto text-left">
                    <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-shopping-bag mr-1"></i> Total</h5>
                </div>
                @if($invoice->inv_status == 'Draft' && $invoice->inv_total != '')
                <div class="ml-auto text-right">
                    <a href="{{url('sales-set/'.$invoice->id)}}"><i class="fe fe-settings fs-18"></i></a>
                </div>
                @endif
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-2">
                <div class="card-body p-2">
                    <form id="sales-form" name="sales-form" action="{{url('sales-update-final/'.$invoice->id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Sub Total</p>
                        </div>
                        <div class="ml-auto text-right">
                            <input type="hidden" name="inv_hpp" value="{{$inv_hpp}}">
                            <input type="hidden" name="inv_sub_total" value="{{$inv_sub_total}}">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($inv_sub_total))}}</p>
                        </div>
                    </div>
                    @if(!empty($invoice->inv_discount))
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Discount</p> 
                        </div>
                        <div class="ml-auto text-right text-success">
                            <input type="hidden" id="text_disc" class="form-control form-control-sm" name="inv_discount" value="{{$invoice->inv_discount}}">
                            <p id="lab_disc" class="mb-0">- Rp {{str_replace(",", ".", number_format($invoice->inv_discount))}}</p>
                        </div>
                    </div>
                    @endif
                    @if(!empty($invoice->inv_expedition))
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Pengiriman</p> 
                        </div>
                        <div class="ml-auto text-right text-danger">
                            <input type="hidden" id="inv_expedition" class="form-control form-control-sm" name="inv_expedition" value="{{$invoice->inv_expedition}}">
                            <p id="lab_expedition" class="mb-0">+ Rp {{str_replace(",", ".", number_format($invoice->inv_expedition))}}</p>
                        </div>
                    </div>
                    @endif
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Total</p>
                        </div>
                        <div class="ml-auto text-right">
                            <input type="hidden" name="inv_total" value="{{$inv_total}}">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($inv_total))}}</p>
                        </div>
                    </div>
                    @if($invoice->inv_status == 'Draft')
                        <button type="submit" class="btn btn-primary btn-block" id="btn-update" name="btn-update">Simpan</button>
                        @if($invoice->inv_total != 0)
                        <a href="{{url('sales-publish/'.$invoice->id)}}" data-title="{{$invoice->inv_code}}" class="btn btn-outline-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Publish</a>
                        @endif
                    @endif
                    @if($invoice->inv_status == 'Publish')
                        <a href="{{url('sales-print/'.$invoice->id)}}" data-title="{{$invoice->inv_code}}" target="_blank" class="btn btn-primary btn-block btn-print" id="btn-print" name="btn-print"><i class="fe fe-file-text"></i> Cetak Invoice</a>
                        @if($invoice->inv_status_payment == 'unpaid' )
                        <a href="{{url('sales-drafting/'.$invoice->id)}}" data-title="{{$invoice->inv_code}}" class="btn btn-outline-dark btn-block btn-draft" id="btn-draft" name="btn-draft">Drafting</a>
                        @endif    
                    @endif
                    </form>
                </div>
            </div>
            @if($invoice->inv_status == 'Publish')
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
                            <p class="mb-0">{{$invoice->inv_status_payment}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Jumlah Bayar</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($invoice->inv_payment))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Kurang Bayar</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($invoice->must_pay))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Jenis Pembayaran</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">{{$invoice->inv_payment_type}}</p>
                        </div>
                    </div>
                    @if($invoice->inv_status_payment == 'unpaid')
                        @if(Auth::user()->id == 1 || Auth::user()->id == 3)
                            <a href="{{url('sales-payment/'.$invoice->id)}}" data-title="{{$invoice->inv_code}}" class="btn btn-dark btn-block btn-payment" id="btn-payment" name="btn-payment"><i class="fe fe-credit-card"></i> Pembayaran</a>
                        @else
                            <div class="alert alert-dark"><i class="fe fe-info fs-25"></i><br><span class="fs-12">Tunjukan <b>Bukti Pembayaran</b> kepada finanace. Perubahan <b>Status Pembayaran</b> akan diproses oleh Finance</span></div>
                        @endif
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

$(document).off('click', '.btn-draft').on('click', '.btn-draft', function(e){
    e.preventDefault();
    $('#modal-confirm .modal-body').html('You will drafting data <b>'+$(this).data('title')+'</b>?');
    $('#modal-confirm .btn-action').attr('href', $(this).attr('href'));
    var myModal = new bootstrap.Modal(document.getElementById('modal-confirm'), {
        keyboard: false
    });
    myModal.show();
});

$(document).ready(function () {
    count = "{{$contents_count}}"
    limit = "{{$limit}}"
    if(count <= 10){
        $('.ajax-load').hide();
    }
    alert_success = $("#alert_success").val();
    if(alert_success != undefined){
        notif({
            msg: alert_success,
            type: "success",
            position: "center"
        });
    }
});
var page = 1;
$(window).scroll(function(){
    var key = '{{$keyword}}';
    if ($(window).scrollTop() >= $(document).height() - $(window).height() - 1){
        page++;
        loadMoreData(page, key);
    }
});

function loadMoreData(page, key){
    $.ajax({
        url:'?page=' + page + '&keyword=' + key,
        type:'get',
        beforeSend: function(){
            $('.ajax-load').show();
        }
    })
    .done(function(data){
        if(data.html == ""){
            $('.ajax-load').html(" ");
            return;     
        }
        $('.ajax-load').hide();
        $('#content-data').append(data.html);
    })
    .fail(function(jqXHR,ajaxOptions,thrownError){
        $('.ajax-load').html("server error");
    });
}
</script>
</x-layouts.app>