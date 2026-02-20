<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('report-store')}}"></x-back>
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
                                <p class="px-2 mb-2">Tanggal Laporan</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{date('d M Y', strtotime($report_store->date))}} | {{$report_store->shift_name}}</h6>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <p class="px-2 mb-2">Barista</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$report_store->emp_name}}</h6>
                            </div>
                        </div>
                    </div>
                    
                    @if($report_store->status == 'draft')
                    <div class="form-group">
                    <a href="{{(url('report-store-edit/'.$report_store->id))}}" class="btn btn-outline-dark btn-sm mr-1 px-2 py-1"><i class="fe fe-edit"></i> Ubah</a>
                    <a href="{{(url('report-store-delete/'.$report_store->id))}}" data-title="{{$report_store->emp_name}}" class="btn btn-outline-danger btn-sm btn-confirm px-2 py-1"><i class="fe fe-trash"></i> Hapus</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="d-flex py-2 px-2">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-log-in mr-1"></i> Pemasukan</h5>
            </div>
            <div class="card no-border shadow-none custom-square mb-2">
                <div class="card-body px-2 py-1">
                    <div class="d-flex title-bar py-2 border-bottom">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Cash</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0 font-weight-semibold">Rp {{str_replace(",", ".", number_format($report_store->cash))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">QRIS/Online</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0 font-weight-semibold">Rp {{str_replace(",", ".", number_format($report_store->qris))}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-log-out mr-1"></i> Pengeluaran</h5>
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
                    @if($contents)
                        @foreach ($contents as $content)
                        <a href="{{url('report-store-spending-detail/'.$content->id.'?rpt='.$content->report_id)}}" class="">
                        <div class="card-body px-2 py-2 border-bottom">
                            <div class="d-flex title-bar">
                                <div class="mr-auto text-left">
                                    <p class="mb-1">{{$content->product}}</p>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class="text-muted mb-1">{{$content->qty}} x {{str_replace(",", ".", number_format($content->price))}}</p>
                                    <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->total))}}</p>
                                </div>
                            </div>
                        </div>
                        </a>
                        @endforeach
                    @else
                        <p class="text-muted pt-2">Tidak ada pengeluaran</p>
                    @endif
                </div>
                @if($report_store->status == 'draft')
                <a href="{{url('report-store-spending-add/'.$report_store->id)}}" class="card-body p-2 border-top font-weight-semibold"><i class="fe fe-plus-circle fs-16"></i> Input Pengeluaran</a>
                @endif
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <div class="mr-auto text-left">
                    <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-file-text mr-1"></i> Total</h5>
                </div>
                @if($report_store->status == 'draft' && $report_store->total != '')
                <div class="ml-auto text-right">
                    <a href="{{url('report-store-set/'.$report_store->id)}}"><i class="fe fe-settings fs-18"></i></a>
                </div>
                @endif
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-2">
                <div class="card-body p-2">
                    <form id="report-store-form" name="report-store-form" action="{{url('report-store-update-final/'.$report_store->id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="d-flex title-bar py-2 text-success">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Sub Total Pemasukan</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="font-weight-semibold mb-0">Rp {{str_replace(",", ".", number_format($report_store->total))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2 text-primary">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Sub Total Pengeluaran</p>
                        </div>
                        <div class="ml-auto text-right">
                            <input type="hidden" name="spending" value="{{$spending}}">
                            <p class="font-weight-semibold mb-0">Rp {{str_replace(",", ".", number_format($spending))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2 text-info">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Sub Total Stor Cash</p>
                        </div>
                        <div class="ml-auto text-right">
                            <input type="hidden" name="pay" value="{{$report_store->pay}}">
                            <p class="font-weight-semibold mb-0">Rp {{str_replace(",", ".", number_format($report_store->pay))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-2">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Total</p>
                        </div>
                        <div class="ml-auto text-right">
                            <input type="hidden" name="total" value="{{$report_store->total_final}}">
                            <p class="font-weight-semibold mb-0">Rp {{str_replace(",", ".", number_format($report_store->total_final))}}</p>
                        </div>
                    </div>
                    @if($report_store->status == 'draft')
                        <button type="submit" class="btn btn-primary btn-block" id="btn-update" name="btn-update">Simpan</button>
                        @if($report_store->is_saved == 'true')
                            <a href="{{url('report-store-publish/'.$report_store->id)}}" data-title="{{$report_store->date}}" class="btn btn-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Laporkan</a>
                        @endif
                    @elseif($report_store->status == 'reported')
                        @if(Gate::allows('isAdmin'))
                            <a href="{{url('report-store-verification/'.$report_store->id)}}" data-title="{{$report_store->date.' - '.$report_store->shift_name}}" class="btn btn-dark btn-block btn-verifikasi" id="btn-verifikasi" name="btn-verifikasi"><i class="fe fe-check-circle"></i> Verifikasi</a>
                        @endif
                    @endif
                    </form>
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

$(document).off('click', '.btn-publish').on('click', '.btn-publish', function(e){
    e.preventDefault();
    $('#modal-confirm .modal-body').html('You will publish data <b>'+$(this).data('title')+'</b>?');
    $('#modal-confirm .btn-action').attr('href', $(this).attr('href'));
    var myModal = new bootstrap.Modal(document.getElementById('modal-confirm'), {
        keyboard: false
    });
    myModal.show();
});

$(document).off('click', '.btn-verifikasi').on('click', '.btn-verifikasi', function(e){
    e.preventDefault();
    $('#modal-confirm .modal-body').html('You will verification data <b>'+$(this).data('title')+'</b>?');
    $('#modal-confirm .btn-action').attr('href', $(this).attr('href'));
    var myModal = new bootstrap.Modal(document.getElementById('modal-confirm'), {
        keyboard: false
    });
    myModal.show();
});

</script>
</x-layouts.app>