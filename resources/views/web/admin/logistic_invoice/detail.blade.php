<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('logistic-list')}}"></x-back>
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
                    <div class="form-group">
                        <p class="px-2 mb-2">Kode Invoice</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$invoice->inv_code}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Tanggal Invoice</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{date('d M Y', strtotime($invoice->inv_date))}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Vendor</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$invoice->inv_source}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Total Invoice</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$invoice->inv_total}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Status Pembayaran</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$invoice->inv_status_payment}}</h6>
                    </div>
                </div>
            </div>
            <div class="d-flex py-5 px-4 border-bottom">
                <i class="fe fe-box fs-18 mr-2"></i>
                <h5 class="mb-1 font-weight-semibold flex-grow-1">Item Barang</h5>
                <a href="{{url('logistic-item-add')}}" class="btn btn-primary btn-sm btn-pill"><i class="fe fe-plus-circle fs-16 text-white "></i> Tambah</a>
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
            <div class="card text-center no-border shadow-none custom-square">
                <div class="card-body p-0">
                    <div id="content-data">
                        @if($contents_count == 0)
                            <h6 class="m-4">No matching records found</h6>
                        @endif
                        @include('web.admin.logistic_items.paginate')
                    </div>
                </div>
            </div>
            <div class="ajax-load text-center" style="">
                <p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7 mt-4">
                <div class="card-body p-0">
                    <a href="{{(url('logistic-edit/'.$invoice->id))}}" class="d-flex p-4 border-bottom">
                        <i class="fe fe-edit fs-16 mr-2"></i>
                        <h6 class="mb-1 font-weight-semibold">Ubah Data</h6>
                    </a>
                    <a href="{{(url('logistic-delete/'.$invoice->id))}}" data-title="{{$invoice->inv_code}}" class="d-flex p-4 border-bottom btn-confirm">
                        <i class="fe fe-trash fs-16 mr-2"></i>
                        <h6 class="mb-1 font-weight-semibold">Hapus Data</h6>
                    </a>
                </div>
            </div>
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
            $('.ajax-load').html("No more records found");
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