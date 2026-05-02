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
            <div class="card no-border shadow-none custom-square mt-4 mb-4 overflow-hidden br-7 border">
                <div class="card-body p-0">
                    <div class="bg-white p-3 d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="fs-10 d-block mb-1">PERIODE</span>
                            <h5 class="font-weight-bold mb-0 text-uppercase">{{$detail->periode}}</h5>
                        </div>
                        @if($detail->status == 'Draft')
                            <a href="{{(url('share-profit-delete/'.$detail->id))}}" data-title="{{$detail->periode}}" class="btn btn-danger btn-sm btn-confirm py-1 px-3 br-7">
                                <i class="fe fe-trash-2 mr-1"></i> Hapus
                            </a>
                        @endif
                        <a href="{{url('share-profit-print/'.$detail->id)}}" target="_blank" class="btn btn-default btn-sm py-1 px-3 br-7 ml-2">
                            <i class="fe fe-printer mr-1"></i> Cetak
                        </a>
                    </div>
                    <div class="p-3 bg-white">
                        <div class="row">
                            <div class="col-6 border-right">
                                <span class="fs-10 text-muted d-block mb-1">TOTAL PROFIT</span>
                                <h6 class="font-weight-bold mb-0 fs-13">Rp {{str_replace(",", ".", number_format($detail->total_profit))}}</h6>
                            </div>
                            <div class="col-6 text-right">
                                <span class="fs-10 text-muted d-block mb-1">TOTAL SHARE</span>
                                <h6 class="font-weight-bold mb-0 fs-13">Rp {{str_replace(",", ".", number_format($detail->total_share))}}</h6>
                            </div>
                            <div class="col-12 mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-11 font-weight-semibold text-muted">SISA BELUM DIBAGIKAN</span>
                                    <h6 class="font-weight-bold mb-0 {{ $detail->balanced > 0 ? 'text-danger' : 'text-success' }} fs-13">
                                        Rp {{str_replace(",", ".", number_format($detail->balanced))}}
                                    </h6>
                                </div>
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
            <div class="card no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    @if($contents->isEmpty())
                        <p class="mb-1 text-center py-5">Tidak ada data pembagian</p>
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
                        <div class="px-3 py-4 border-bottom">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="font-weight-bold mb-0 fs-14">{{$content->employee}}</h6>
                                </div>
                                @if($detail->status == 'Draft')
                                    <a href="{{url('share-profit-share-delete/'.$content->id.'?mid='.$detail->id)}}" class="btn btn-outline-danger btn-sm btn-confirm py-1 px-2 br-7" data-title="pembagian {{$content->employee}}">
                                        <i class="fe fe-trash-2"></i>
                                    </a>
                                @endif
                            </div>
                            
                            <div class="row fs-12">
                                <div class="col-6 mb-2">
                                    <span class="text-muted d-block mb-1">Sub Total Profit</span>
                                    <span class="font-weight-semibold">Rp {{str_replace(",", ".", number_format($content->sub_total))}}</span>
                                </div>
                                <div class="col-6 mb-2 text-right">
                                    <span class="text-muted d-block mb-1">Tabungan/KUR</span>
                                    <span class="font-weight-semibold">Rp {{str_replace(",", ".", number_format($content->tabungan_credit))}}</span>
                                </div>
                                
                                @if(!empty($content->potongan))
                                <div class="col-12 mb-3">
                                    <div class="bg-light p-2 border-left border-danger">
                                        <span class="text-muted d-block fs-11">Potongan: {{$content->desc}}</span>
                                        <span class="text-danger font-weight-bold">- Rp {{str_replace(",", ".", number_format($content->potongan))}}</span>
                                    </div>
                                </div>
                                @endif

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center bg-success text-white p-2 br-7 shadow-sm">
                                        <span class="font-weight-bold">Jumlah Transfer</span>
                                        <span class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->total))}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="bg-light px-3 py-4">
                            <h6 class="font-weight-bold mb-3 fs-13">Ringkasan Total Pembagian</h6>
                            <div class="d-flex justify-content-between fs-12 mb-2">
                                <span class="text-muted">Total Sub Profit</span>
                                <span class="font-weight-semibold">Rp {{str_replace(",", ".", number_format($total_sub_total))}}</span>
                            </div>
                            <div class="d-flex justify-content-between fs-12 mb-2">
                                <span class="text-muted">Total Tabungan</span>
                                <span class="font-weight-semibold">Rp {{str_replace(",", ".", number_format($total_tabungan_credit))}}</span>
                            </div>
                            <div class="d-flex justify-content-between fs-12 mb-3">
                                <span class="text-muted">Total Potongan Pribadi</span>
                                <span class="text-danger font-weight-semibold">Rp {{str_replace(",", ".", number_format($total_potongan))}}</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold">GRAND TOTAL TRANSFER</span>
                                <h5 class="font-weight-bold text-primary mb-0">Rp {{str_replace(",", ".", number_format($total_total))}}</h5>
                            </div>
                        </div>
                    @endif
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