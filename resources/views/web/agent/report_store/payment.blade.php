<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('report-store-detail/'.$detail->id)}}"></x-back>
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
                    <div class="form-group">
                        <p class="px-2 mb-2">Kode Invoice</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->pur_code}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Tanggal Invoice</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{date('d M Y', strtotime($detail->pur_date))}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Pelanggan</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->vendor_name}}</h6>
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-credit-card mr-1"></i> Pembayaran</h5>
            </div>
            @if(session()->has('success'))
            <input type="hidden" id="alert_success" value="{{ session('success') }}">
            @endif
            @if(session()->has('danger'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fe fe-x-circle mr-1" aria-hidden="true"></i> {{ session('danger') }}
            </div>
            @endif
            <form id="payment-form" name="payment-form" action="{{url('report-store-pay/'.$detail->id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    
                    <div class="form-group">
                        <label class="form-label">Opsi Pembayaran</label>
                        <div class="row">
                            <div class="col">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment-option" id="full-pay" value="full-pay" checked>
                                    <span class="custom-control-label">Bayar Lunas</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment-option" id="partial-pay" value="partial-pay">
                                    <span class="custom-control-label">Bayar Sebagian</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Bayar</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('pur_payment') is-invalid @enderror" id="pur_payment" name="pur_payment" value="{{$detail->must_pay}}" readonly="true">
                        </div>
                        @error('pur_payment')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block" id="btn-payment" name="btn-payment">Bayar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>

$(document).ready(function () {
    $('.masked').inputmask({
        rightAlign:false,
        radixPoint: ',',
        groupSeparator: ".",
        alias: "numeric",
        autoGroup: true,
        digits: 0
    });

    $("#partial-pay").click(function(){
        $("#pur_payment").removeAttr("readonly");
    }); 
    $("#full-pay").click(function(){
        $("#pur_payment").addAttr("readonly");
    }); 

    $('#pur_cust').select2({
        "ajax" : {
            "url" : "{{url('customer-combo')}}",
            "type" : "POST",
            "dataType" : "json",
            "data": function (params) {
                var query = {
                    _token: "{{ csrf_token() }}",
                    search: params.term,
                    type: "public"
                }
                return query;
            }
        },
        placeholder: 'Cari Pelanggan',
        // language: {
        //     inputTooShort: function () {
        //         return "Silakan masukkan 1 atau lebih karakter";
        //     }
        // },
        // minimumInputLength: 1
    });
    
});
</script>
</x-layouts.app>