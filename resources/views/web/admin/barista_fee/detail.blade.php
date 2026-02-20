<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('barista-fee-list')}}"></x-back>
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
                            <div class="form-group pt-3">
                                <a href="{{(url('barista-fee-edit/'.$detail->id))}}" class="btn btn-outline-dark btn-sm mr-2"><i class="fe fe-edit fs-16"></i> Ubah</a>
                            <a href="{{(url('barista-fee-delete/'.$detail->id))}}" data-title="{{$detail->periode}}" class="btn btn-outline-danger btn-sm btn-confirm"><i class="fe fe-trash fs-16"></i> Hapus</a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <p class="px-2 mb-2">Total Fee</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->total_fee))}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Total Share</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->total_share))}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-share-2 mr-1"></i> Pembagian</h5>
                <a class="btn btn-dark btn-sm btn-pill py-1" href="{{url('barista-fee-share/'.$detail->id)}}"><i class="fe fe-plus-circle"></i> Tambah</a>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    @if($contents->isEmpty())
                        <div class="card-body px-2 py-2 border-bottom text-center">
                            <p class="mb-1 text-center">Tidak ada data</p>
                        </div>
                    @else
                    <div class="card-body px-0 py-2">
                        <table class="table card-table table-vcenter text-nowrap px-0 mb-0">
                            <tr>
                                <td class="text-left font-weight-bold">Barista</td>
                                <td class="text-right font-weight-bold text-info">Subtotal</td>
                                <td class="text-right font-weight-bold text-danger">Potongan</td>
                                <td class="text-right font-weight-bold text-success">Total</td>
                            </tr>
                            @foreach ($contents as $content)
                                    <tr>
                                        <td class="text-left"><a href="{{url('barista-fee-person/'.$content->id.'?mid='.$content->bf_id)}}"><u>{{$content->employee}}</u></a></td>
                                        <td class="text-right text-info">Rp {{str_replace(",", ".", number_format($content->sub_total))}}</td>
                                        <td class="text-right text-danger">Rp {{str_replace(",", ".", number_format($content->potongan))}}</td>
                                        <td class="text-right text-success font-weight-bold">Rp {{str_replace(",", ".", number_format($content->total))}}</td>
                                    </tr>
                            @endforeach
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            @if($detail->status == 'Draft')
                <a href="{{url('barista-fee-publish/'.$detail->id)}}" data-title="{{$detail->periode}}" class="btn btn-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Publish</a>
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