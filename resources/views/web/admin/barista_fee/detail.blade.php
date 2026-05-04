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
                <div class="card-body px-2 py-2">
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
                            <div class="form-group mb-1">
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
                        @foreach ($contents as $content)
                            <div class="d-flex p-4 border-bottom align-items-center animate__animated animate__fadeIn list-item-custom">
                                <div class="avatar-initial  mr-3" style="background: linear-gradient(135deg, #E62129 0%, #E62129  100%);">
                                    {{ strtoupper(substr($content->employee, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1 text-left">
                                    <h6 class="mb-1 font-weight-bold">
                                        <a href="{{url('barista-fee-person/'.$content->id.'?mid='.$content->bf_id)}}" class="text-dark stretched-link">
                                            {{$content->employee}}
                                        </a>
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <span class="badge badge-soft-info fs-10 mr-2 py-1 px-2 rounded-pill">
                                            <i class="fe fe-trending-up mr-1"></i> Rp{{str_replace(",", ".", number_format($content->sub_total))}}
                                        </span>
                                        <span class="badge badge-soft-danger fs-10 py-1 px-2 rounded-pill">
                                            <i class="fe fe-trending-down mr-1"></i> Rp{{str_replace(",", ".", number_format($content->potongan))}}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <h5 class="font-weight-bold mb-0">
                                        Rp {{str_replace(",", ".", number_format($content->total))}}
                                    </h5>
                                    <a href="{{url('barista-fee-share-delete/'.$content->id)}}" data-title="{{$content->employee}}" class="btn btn-sm btn-outline-dark btn-confirm mt-2 d-inline-block py-0 px-1" style="position: relative; z-index: 2;">
                                        <i class="fe fe-trash-2 fs-14"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @if($detail->status == 'Draft')
                <a href="{{url('barista-fee-publish/'.$detail->id)}}" data-title="{{$detail->periode}}" class="btn btn-dark btn-block btn-publish" id="btn-publish" name="btn-publish">Publish</a>
            @endif
        </div>
    </div>
</div>
<style>
    .list-item-custom {
        transition: all 0.2s ease;
        position: relative;
    }
    .list-item-custom:hover {
        background-color: #f8f9fa;
    }
    .avatar-initial {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-weight: 700;
        background: linear-gradient(135deg, #6c5ff7 0%, #424e79 100%);
        color: white;
        box-shadow: 0 4px 6px rgba(108, 95, 247, 0.2);
    }
    .badge-soft-info {
        background-color: rgba(1, 184, 255, 0.1);
        color: #01b8ff;
        border: none;
    }
    .badge-soft-danger {
        background-color: rgba(255, 91, 91, 0.1);
        color: #ff5b5b;
        border: none;
    }
</style>
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