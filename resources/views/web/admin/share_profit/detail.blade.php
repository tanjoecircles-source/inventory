<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('share-profit-list')}}"></x-back>
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
                        <div class="col-4">
                            <div class="form-group">
                                <p class="px-2 mb-2">Periode</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$detail->periode}}</h6>
                            </div>
                            @if($detail->status == 'Draft')
                            <div class="form-group pt-3">
                                <a href="{{(url('share-profit-delete/'.$detail->id))}}" data-title="{{$detail->periode}}" class="btn btn-outline-danger btn-sm btn-confirm"><i class="fe fe-trash fs-16"></i> Hapus</a>
                            </div>
                            @endif
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <p class="px-2 mb-2">Total Profit</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($detail->total_profit))}}</h6>
                            </div>
                        </div>
                        <div class="col-4">
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
                @if($detail->status == 'Draft')
                <a class="btn btn-dark btn-sm btn-pill py-1" href="{{url('share-profit-share/'.$detail->id)}}"><i class="fe fe-plus-circle"></i> Tambah</a>
                @endif
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    <table class="table">
                        <tr>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-left">Nama Person<br>(Owner / Investor)</td>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-right">Sub Total Profit</td>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-right">Potongan<br>Tabungan/KUR</td>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-right">Potongan<br>Pribadi</td>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-right">Jumlah<br>Transfer</td>
                        </tr>
                        @if($contents->isEmpty())
                            <tr>
                                <td colspan="4">
                                    <p class="mb-1 text-center">Tidak ada data</p>
                                </td>
                            </tr>
                        @else
                        @php
                        $total_sub_total = 0;
                        $total_tabungan_credit = 0;
                        $total_potongan = 0;
                        $total_total = 0;
                        @endphp
                        @foreach ($contents as $content)
                        @php
                            $total_sub_total += $content->sub_total; 
                            $total_tabungan_credit += $content->tabungan_credit;
                            $total_potongan += $content->potongan;
                            $total_total += $content->total;
                        @endphp
                        <tr>
                            <td class="border-bottom  px-4 py-2 text-left" width="20%">
                                <p class="mb-1">{{$content->employee}}</p>
                            </td>
                            <td class="border-bottom  px-4 py-2 text-right" width="17%">
                                <p class="mb-1">Rp {{str_replace(",", ".", number_format($content->sub_total))}}</p>
                            </td>
                            <td class="border-bottom  px-4 py-2 text-right" width="20%">
                                <p class="mb-1">Rp {{str_replace(",", ".", number_format($content->tabungan_credit))}}</p>
                            </td>
                            <td class="border-bottom  px-4 py-2 text-right" width="23%">
                                <p class="mb-1 text-danger">{{!empty($content->potongan) ? $content->desc.' : Rp '.str_replace(",", ".", number_format($content->potongan)) : '-' }}</p>
                            </td>
                            <td class="border-bottom px-4 py-2 text-right">
                                <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->total))}}</p>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-left">Total</td>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-right">Rp {{str_replace(",", ".", number_format($total_sub_total))}}</td>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-right">Rp {{str_replace(",", ".", number_format($total_tabungan_credit))}}</td>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-right">Rp {{str_replace(",", ".", number_format($total_potongan))}}</td>
                            <td class="font-weight-bold border-bottom  px-4 py-2 text-right">Rp {{str_replace(",", ".", number_format($total_total))}}</td>
                        </tr>
                    @endif
                    </table>
                </div>
            </div>
            @if($detail->status == 'Draft')
                <a href="{{url('share-profit-publish/'.$detail->id)}}" data-title="{{$detail->periode}}" class="btn btn-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Publish</a>
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