<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('barista-fee-detail/'.$detail->id)}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="d-flex mt-4">
                <h5 class="mb-0 pb-0">Slip Gaji</h5>
                <div class="ml-auto"><a href="{{(url('barista-fee-printslip/'.$person->id.'?mid='.$detail->id))}}" class="btn btn-dark btn-sm" target="_blank"><i class="fe fe-printer fs-16"></i> Cetak Slip</a></div>
            </div>
            <div class="card no-border shadow-none custom-square mt-3 mb-4">
                <div class="card-body px-2 pt-4 pb-0">
                    <div class="d-flex mb-2 border-bottom">
                        <p class="px-2 mb-2">Periode</p>
                        <p class="px-2 ml-auto font-weight-bold">{{$detail->periode}}</p>
                    </div>
                    <div class="d-flex mb-2 border-bottom">
                        <p class="px-2 mb-2">Nama</p>
                        <p class="px-2 ml-auto font-weight-bold">{{$person->employee}}</p>
                    </div>
                    <div class="d-flex mb-0">
                        <p class="px-2 mb-2">Jabatan</p>
                        <p class="px-2 ml-auto font-weight-bold">{{$person->position}}</p>
                    </div>
                </div>
            </div>
            <h6>Rincian Penghasilan</h6>
            <div class="card no-border shadow-none custom-square mt-3 mb-4">
                <div class="card-body px-2 pt-4 pb-0">
                    <div class="d-flex mb-2 border-bottom">
                        <p class="px-2 mb-2">Upah Short Shift<br><span class="fs-11">Rp {{str_replace(",", ".", number_format($set->barista_fee_short))}} x {{$person->shift_short}} Shift</span></p>
                        <p class="px-2 ml-auto font-weight-bold">Rp {{str_replace(",", ".", number_format($person->fee_short))}}</p>
                    </div>
                    <div class="d-flex mb-2 border-bottom">
                        <p class="px-2 mb-2">Upah Long Shift<br><span class="fs-11">Rp {{str_replace(",", ".", number_format($set->barista_fee_long))}} x {{$person->shift_long}} Shift</span></p>
                        <p class="px-2 ml-auto font-weight-bold">Rp {{str_replace(",", ".", number_format($person->fee_long))}}</p>
                    </div>
                    <div class="d-flex">
                        <p class="px-2 mb-0">Total Penghasilan</p>
                        <p class="px-2 ml-auto font-weight-bold">Rp {{str_replace(",", ".", number_format($person->sub_total))}}</p>
                    </div>
                </div>
            </div>

            <h6>Potongan</h6>
            <div class="card no-border shadow-none custom-square mt-3 mb-4">
                <div class="card-body px-2 pt-4 pb-0">
                    <div class="d-flex">
                        <p class="px-2 mb-2">{{$person->desc}}</p>
                        <p class="px-2 ml-auto font-weight-bold">Rp {{str_replace(",", ".", number_format($person->potongan))}}</p>
                    </div>
                </div>
            </div>

            <h6>Ringkasan Gaji</h6>
            <div class="card no-border shadow-none custom-square mt-3 mb-4">
                <div class="card-body px-2 pt-4 pb-0">
                    <div class="d-flex mb-2 border-bottom">
                        <p class="px-2">Total Penghasilan</p>
                        <p class="px-2 ml-auto font-weight-bold">Rp {{str_replace(",", ".", number_format($person->sub_total))}}</p>
                    </div>
                    <div class="d-flex mb-2 border-bottom">
                        <p class="px-2">Total Potongan</p>
                        <p class="px-2 ml-auto font-weight-bold">Rp {{str_replace(",", ".", number_format($person->potongan))}}</p>
                    </div>
                    <div class="d-flex mb-2">
                        <p class="px-2">Gaji Bersih (Take Home Pay)</p>
                        <p class="px-2 ml-auto font-weight-bold">Rp {{str_replace(",", ".", number_format($person->total))}}</p>
                    </div>
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
</script>
</x-layouts.app>