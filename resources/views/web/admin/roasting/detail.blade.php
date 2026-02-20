<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('roasting-list')}}"></x-back>
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
                                <p class="px-2 mb-2">Kode</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$roasting->code}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Pelanggan</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$roasting->vendor_name}}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <p class="px-2 mb-2">Tanggal</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{date('d M Y', strtotime($roasting->date))}}</h6>
                            </div>
                        </div>
                    </div>
                    
                    @if($roasting->status == 'Draft')
                    <div class="form-group">
                    <a href="{{(url('roasting-edit/'.$roasting->id))}}" class="btn btn-outline-dark btn-sm mr-1 px-2 py-1"><i class="fe fe-edit"></i> Ubah</a>
                    <a href="{{(url('roasting-delete/'.$roasting->id))}}" data-title="{{$roasting->code}}" class="btn btn-outline-danger btn-sm btn-confirm px-2 py-1"><i class="fe fe-trash"></i> Hapus</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-box mr-1"></i> Items Produk</h5>
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
                    @if($contents->isEmpty())
                        <div class="card-body px-2 py-2 border-bottom text-center">
                            <p class="mb-1 text-center">Tidak ada data</p>
                        </div>
                    @else
                        @foreach ($contents as $content)
                            @if($roasting->status == 'Draft')
                                <a href="{{url('roasting-item-detail/'.$roasting->id.'?id='.$content->id)}}">
                            @endif
                            <div class="card-body px-2 py-2 border-bottom">
                                <div class="d-flex title-bar">
                                    <div class="mr-auto text-left">
                                        <p class="mb-1">{{$content->product_name}}</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="font-weight-bold mb-0">{{$content->qty}}x</p>
                                    </div>
                                </div>
                            </div>
                            @if($roasting->status == 'Draft')
                                </a>
                            @endif
                        @endforeach
                        <div class="card-body px-2 py-2 border-bottom">
                            <div class="d-flex title-bar">
                                <div class="mr-auto text-left">
                                    <p class="mb-1 font-weight-bold">Total Qty</p>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class="font-weight-bold mb-0">{{$qty_total}}x</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @if($roasting->status == 'Draft')
                <a href="{{url('roasting-item-add/'.$roasting->id)}}" class="card-body p-2 border-top font-weight-semibold"><i class="fe fe-plus-circle fs-16"></i> Tambah Produk</a>
                @endif
            </div>
            @if($roasting->status == 'Draft')
                <a href="{{url('roasting-publish/'.$roasting->id)}}" data-title="{{$roasting->code}}" class="btn btn-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Publish</a>
            @endif
            @if($roasting->status == 'Publish')
                <a href="{{url('roasting-drafting/'.$roasting->id)}}" data-title="{{$roasting->code}}" class="btn btn-outline-dark btn-block btn-draft" id="btn-draft" name="btn-draft">Drafting</a>
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

$(document).off('click', '.btn-draft').on('click', '.btn-draft', function(e){
    e.preventDefault();
    $('#modal-confirm .modal-body').html('You will drafting data <b>'+$(this).data('title')+'</b>?');
    $('#modal-confirm .btn-action').attr('href', $(this).attr('href'));
    var myModal = new bootstrap.Modal(document.getElementById('modal-confirm'), {
        keyboard: false
    });
    myModal.show();
});
</script>
</x-layouts.app>