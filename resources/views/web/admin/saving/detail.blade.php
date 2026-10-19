<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('saving-list')}}"></x-back>
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
                        @if($detail->status == 'Published')
                            <span class="badge badge-success badge-pill px-2 py-1"><i class="fe fe-check mr-1"></i>Published</span>
                        @else
                            <span class="badge badge-warning badge-pill px-2 py-1"><i class="fe fe-clock mr-1"></i>Draft</span>
                        @endif
                    </div>
                    <div class="p-3 bg-white">
                        <div class="row">
                            <div class="col-6 border-right">
                                <span class="fs-10 text-muted d-block mb-1">TABUNGAN MASUK</span>
                                <h6 class="font-weight-bold mb-0 fs-13 text-primary">Rp {{number_format($summary->total_tabungan ?? 0, 0, ',', '.')}}</h6>
                            </div>
                            <div class="col-6 text-right">
                                <span class="fs-10 text-muted d-block mb-1">TOTAL POTONGAN</span>
                                <h6 class="font-weight-bold mb-0 fs-13 text-danger">Rp {{number_format($summary->total_potongan ?? 0, 0, ',', '.')}}</h6>
                            </div>
                            <div class="col-12 mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-11 font-weight-semibold text-muted">SISA TABUNGAN</span>
                                    <h6 class="font-weight-bold mb-0 text-success fs-13">
                                        Rp {{number_format($summary->sisa_tabungan ?? 0, 0, ',', '.')}}
                                    </h6>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="fs-11 font-weight-semibold text-muted">JUMLAH PENABUNG</span>
                                    <span class="font-weight-bold fs-13">{{$summary->total_penabung ?? 0}} orang</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-scissors mr-1"></i> Potongan Tabungan</h5>
                <a class="btn btn-dark btn-sm btn-pill py-1" href="{{url('saving-deduction/'.$detail->id)}}"><i class="fe fe-plus-circle"></i> Tambah</a>
            </div>
            <div class="card no-border shadow-none custom-square mb-4">
                <div class="card-body p-0">
                    @if(session()->has('success'))
                        <input type="hidden" id="alert_success" value="{{ session('success') }}">
                    @endif
                    @if(session()->has('danger'))
                    <div class="alert alert-danger mx-3 mt-3" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ session('danger') }}
                    </div>
                    @endif
                    @if($deductions->isEmpty())
                        <p class="mb-1 text-center py-5">Belum ada potongan tabungan pada periode ini</p>
                    @else
                        @foreach ($deductions as $potongan)
                        <div class="px-3 py-3 border-bottom">
                            <div class="d-flex align-items-center mb-1">
                                <div class="flex-grow-1">
                                    <h6 class="font-weight-bold mb-0 fs-14">{{$potongan->name}}</h6>
                                    <span class="text-muted fs-11">{{date('d M Y', strtotime($potongan->date))}}</span>
                                </div>
                                <a href="{{url('saving-deduction-delete/'.$potongan->id)}}" class="btn btn-outline-danger btn-sm btn-confirm py-1 px-2 br-7" data-title="{{$potongan->name}}">
                                    <i class="fe fe-trash-2"></i>
                                </a>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fs-12">Jumlah Potongan</span>
                                <span class="font-weight-bold text-danger fs-14">- Rp {{number_format($potongan->amount, 0, ',', '.')}}</span>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-users mr-1"></i> Tabungan Masuk</h5>
            </div>
            <div class="card no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    @if($contents->isEmpty())
                        <p class="mb-1 text-center py-5">Tidak ada tabungan masuk pada periode ini</p>
                    @else
                        @foreach ($contents as $content)
                        <div class="px-3 py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="font-weight-bold mb-0 fs-14">{{$content->employee}}</h6>
                                @if(!empty($content->category))
                                    <span class="badge badge-info badge-pill px-2 py-1">{{$content->category}}</span>
                                @endif
                            </div>
                            <div class="row fs-12">
                                <div class="col-6 mb-2">
                                    <span class="text-muted d-block mb-1">Sub Total Profit</span>
                                    <span class="font-weight-semibold">Rp {{number_format($content->sub_total, 0, ',', '.')}}</span>
                                </div>
                                <div class="col-6 mb-2 text-right">
                                    <span class="text-muted d-block mb-1">Tabungan Masuk</span>
                                    <span class="font-weight-semibold text-primary">+ Rp {{number_format($content->tabungan_credit, 0, ',', '.')}}</span>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center bg-light p-2 br-7">
                                        <span class="font-weight-semibold">Diterima</span>
                                        <span class="font-weight-bold mb-0">Rp {{number_format($content->total, 0, ',', '.')}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    alert_success = $("#alert_success").val();
    if(alert_success != undefined){
        notif({
            msg: alert_success,
            type: "success",
            position: "center"
        });
    }
});

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
