<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('store-operational-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="store-operational-form" name="store-operational-form" action="{{url('store-operational-update/'.$detail->id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select class="form-control @error('op_category') is-invalid @enderror" name="op_category" id="op_category" placeholder="Pilih Kategori">
                            <option value="Offline" {{ ($detail->op_category == 'Offline') ? 'selected' : ''; }}>Offline</option>
                            <option value="Online"  {{ ($detail->op_category == 'Online') ? 'selected' : ''; }}>Online</option>
                        </select>
                        @error('op_category') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode Invoice</label>
                        <input type="text" class="form-control @error('op_code') is-invalid @enderror" name="op_code" value="{{$detail->op_code}}" placeholder="Kode Invoice">
                        @error('op_code')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Invoice</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker" name="op_date" value="{{$op_date}}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('op_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Vendor</label>
                        <select class="form-control @error('op_vendor') is-invalid @enderror" name="op_vendor" id="op_vendor" placeholder="Pilih Vendor">
                            @foreach($vendor as $value)
                                @if($detail->op_vendor == $value->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('op_vendor') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-update" name="btn-update">Simpan</button>
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

    $('#op_cust').select2({
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