<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('invest-list')}}"></x-back>
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
                                <p class="px-2 mb-2">Nama Investor</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$detail->name}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Alamat</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$detail->address}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Total Bayar</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->total_payment))}}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <p class="px-2 mb-2">Nomor HP</p>
                                <h6 class="px-2 m-0 font-weight-bold">+62{{$detail->phone}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Jumlah Investasi</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->total_invest))}} ({{$detail->margin}}%)</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Kurang Bayar</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->underpayment))}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{(url('invest-edit/'.$detail->id))}}" class="btn btn-outline-dark btn-sm mr-2"><i class="fe fe-edit fs-16"></i> Ubah Data</a>
                            <a href="{{(url('invest-delete/'.$detail->id))}}" data-title="{{$detail->name}}" class="btn btn-outline-danger btn-sm btn-confirm"><i class="fe fe-trash fs-16"></i> Hapus Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-box mr-1"></i> Pembayaran</h5>
                <a class="btn btn-dark btn-sm btn-pill" href="{{url('invest-payment/'.$detail->id)}}"><i class="fe fe-plus-circle"></i> Pembayaran</a>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    @foreach ($contents as $content)
                    <div class="card-body px-2 py-2 border-bottom">
                        <div class="d-flex title-bar">
                            <div class="mr-auto text-left">
                                <p class="mb-1">{{$content->date_pay}}</p>
                            </div>
                            <div class="ml-auto text-right">
                                <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->total_pay))}}</p>
                            </div>
                            <div class="ml-auto text-right">
                                <a href="{{url('invest-pay-delete?id_pay='.$content->id_pay.'&id='.$detail->id)}}" data-title="{{$content->date_pay}}" class="btn btn-sm btn-danger px-2 py-1 btn-confirm"><i class="fe fe-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
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