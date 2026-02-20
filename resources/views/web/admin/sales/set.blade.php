<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('sales-detail/'.$detail->id)}}"></x-back>
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
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->inv_code}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Tanggal Invoice</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{date('d M Y', strtotime($detail->inv_date))}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Pelanggan</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->cust_name}}</h6>
                    </div>
                </div>
            </div>
            
            <form id="setup-form" name="setup-form" action="{{url('sales-setup/'.$detail->id)}}" method="POST" enctype="multipart/form-data" >
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
                            <input type="text" class="form-control masked @error('inv_expedition') is-invalid @enderror" id="inv_expedition" name="inv_expedition" value="{{!empty($detail->inv_expedition) ? $detail->inv_expedition : 0}}">
                        </div>
                        @error('inv_expedition')<div class="text-danger">{{ $message }}</div>@enderror
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
                            <input type="text" class="form-control masked @error('inv_discount') is-invalid @enderror" id="inv_discount" name="inv_discount" value="{{!empty($detail->inv_discount) ? $detail->inv_discount : 0}}">
                        </div>
                        @error('inv_discount')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-clipboard mr-1"></i> Keterangan Invoice</h5>
            </div>
            <div class="card no-border shadow-none custom-square mt-0 mb-2">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Tambahkan Keterangan pada Invoice</label>
                        <textarea class="form-control @error('inv_desc') is-invalid @enderror" id="inv_desc" name="inv_desc">{{$detail->inv_desc}}</textarea>    
                        @error('inv_desc')<div class="text-danger">{{ $message }}</div>@enderror
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
        $("#inv_expedition").removeAttr("readonly");
    }); 
    $("#full-pay").click(function(){
        $("#inv_expedition").addAttr("readonly");
    }); 

    $('#inv_cust').select2({
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