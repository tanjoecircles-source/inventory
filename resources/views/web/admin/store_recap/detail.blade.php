<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('store-recap-list')}}"></x-back>
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
                        <div class="col-6">
                            <div class="form-group">
                                <p class="px-2 mb-2">Periode</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$detail->periode}}</h6>
                            </div>
                            <div class="form-group pt-3">
                                <a href="{{(url('store-recap-edit/'.$detail->id))}}" class="btn btn-outline-dark btn-sm mr-2"><i class="fe fe-edit fs-16"></i> Ubah</a>
                            <a href="{{(url('store-recap-delete/'.$detail->id))}}" data-title="{{$detail->periode}}" class="btn btn-outline-danger btn-sm btn-confirm"><i class="fe fe-trash fs-16"></i> Hapus</a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <p class="px-2 mb-2">Profit</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->profit))}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mt-2">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-3 mt-2">
                        <div class="mr-auto text-left">
                            <h5 class="mb-0 font-weight-bold text-dark">Pemasukan</h5>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Cash</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($detail->income_cash))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">QRIS/Online</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($detail->income_qris))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1 font-weight-bold">Total Pemasukan</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->income_total))}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mt-2">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-3 mt-2">
                        <div class="mr-auto text-left">
                            <h5 class="mb-0 font-weight-bold text-dark">Pengeluaran</h5>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Cash Toko</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($detail->outcome_cash))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Purchasing</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($detail->outcome_purchasing))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Operational</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($detail->outcome_operational))}}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Fee Staf </p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($detail->outcome_barista))}}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1 font-weight-bold">Total Pengeluaran</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->outcome_total))}}</p>
                        </div>
                    </div>
                </div>
            </div>    
            @if($detail->status == 'Draft')
                <a href="{{url('store-recap-publish/'.$detail->id)}}" data-title="{{$detail->periode}}" class="btn btn-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Publish</a>
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