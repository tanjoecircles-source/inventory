<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('store-purchasing-detail/'.$detail->id)}}"></x-back>
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
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->pur_name}}</h6>
                    </div>
                </div>
            </div>
            
            <form id="setup-form" name="setup-form" action="{{url('store-purchasing-setup/'.$detail->id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-plus-circle mr-1"></i> Penambahan Biaya</h5>
            </div>
            <div class="card no-border shadow-none custom-square mt-0 mb-2">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Atur Biaya Pengiriman</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('pur_expedition') is-invalid @enderror" id="pur_expedition" name="pur_expedition" value="{{!empty($detail->pur_expedition) ? $detail->pur_expedition : 0}}">
                        </div>
                        @error('pur_expedition')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-minus-circle mr-1"></i> Pengurangan Biaya</h5>
            </div>
            <div class="card no-border shadow-none custom-square mt-0 mb-2">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Atur Diskon</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('pur_discount') is-invalid @enderror" id="pur_discount" name="pur_discount" value="{{!empty($detail->pur_discount) ? $detail->pur_discount : 0}}">
                        </div>
                        @error('pur_discount')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block" id="btn-payment" name="btn-payment">Simpan</button>
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
        $("#pur_expedition").removeAttr("readonly");
    }); 
    $("#full-pay").click(function(){
        $("#pur_expedition").addAttr("readonly");
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