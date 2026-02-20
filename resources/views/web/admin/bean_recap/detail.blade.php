<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('bean-recap-list')}}"></x-back>
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
                            <div class="form-group">
                                <p class="px-2 mb-2">Total Potongan</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->total_potongan))}}</h6>
                            </div>
                            @if($detail->status == 'Draft')
                            <div class="form-group pt-3">
                                <a href="{{(url('bean-recap-edit/'.$detail->id))}}" class="btn btn-outline-dark btn-sm mr-2"><i class="fe fe-edit fs-16"></i> Ubah</a>
                                <a href="{{(url('bean-recap-delete/'.$detail->id))}}" data-title="{{$detail->periode}}" class="btn btn-outline-danger btn-sm btn-confirm"><i class="fe fe-trash fs-16"></i> Hapus</a>
                            </div>
                            @endif
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <p class="px-2 mb-2">Total Recap Profit</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->profit))}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Sisa Profit</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->sisa_profit))}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mt-2">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-3 mt-2">
                        <div class="mr-auto text-left">
                            <h5 class="mb-0 font-weight-bold text-dark">Recap</h5>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Income</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($detail->income))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">HPP</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($detail->hpp))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1 font-weight-bold">Total</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->profit))}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-minus mr-1"></i> Potongan</h5>
                @if($detail->status == 'Draft')
                <a class="btn btn-dark btn-sm btn-pill py-1" href="{{url('bean-recap-spending/'.$detail->id)}}"><i class="fe fe-plus-circle"></i> Tambah</a>
                @endif
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    <table class="table table-vcenter">
                    @if($spending->isEmpty())
                        <tr>
                            <td>
                                <p class="mb-1 text-center">Tidak ada data</p>
                            </td>
                        </tr>
                    @else
                        @foreach ($spending as $spn)
                        <tr>
                            <td class="border-bottom  px-4 py-2 text-left" width="15%">
                                <p class="mb-1">{{date('d M Y', strtotime($spn->date))}}</p>
                            </td>
                            <td class="border-bottom  px-4 py-2 text-left"  width="25%">
                                <p class="mb-1">{{$spn->name}}</p>
                            </td>
                            <td class="border-bottom  px-4 py-2 text-left">
                                <p class="mb-1">{{$spn->is_non_investor == 'true' ? 'Non Investor' : 'With Investor'}}</p>
                            </td>
                            <td class="border-bottom px-4 py-2 text-right">
                                <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($spn->amount))}}</p>
                            </td>
                            @if($detail->status == 'Draft')
                            <td class="border-bottom px-4 py-2 text-right" width="5%">
                                <a href="{{(url('bean-recap-spending-delete/'.$spn->id.'?mid='.$detail->id))}}" data-title="{{$spn->name}}" class="btn btn-sm btn-danger btn-confirm py-0 px-1">
                                    <i class="fe fe-trash fs-16"></i>
                                </a>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    @endif
                    </table>
                </div>
            </div> 
            @if($detail->status == 'Draft')
                <a href="{{url('bean-recap-publish/'.$detail->id)}}" data-title="{{$detail->periode}}" class="btn btn-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Publish</a>
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