<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('roasting-detail/'.$detail->roasting_id)}}"></x-back>
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
                        <p class="px-2 mb-2">Roast Profile</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->roasting_profile}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Produk</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->product_name}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Qty</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->qty}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Log Artisan</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->artisan_log}}</h6>
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    <a href="{{(url('roasting-item-delete/'.$detail->roasting_id.'?id='.$detail->id))}}" data-title="{{$detail->product_name}}" class="d-flex p-4 border-bottom btn-confirm">
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
</script>
</x-layouts.app>