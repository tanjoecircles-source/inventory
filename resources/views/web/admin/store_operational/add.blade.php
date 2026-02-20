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
            <form id="store-operational-form" name="store-operational-form" action="{{url('store-operational-create')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select class="form-control @error('op_category') is-invalid @enderror" name="op_category" id="op_category" placeholder="Pilih Kategori">
                            <option value="Offline" selected>Offline</option>
                            <option value="Online">Online</option>
                        </select>
                        @error('op_category') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode Invoice</label>
                        <input type="text" class="form-control @error('op_code') is-invalid @enderror" name="op_code" value="{{$op_code}}" placeholder="Tulis Kode Invoice">
                        @error('op_code')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Belanja</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker" name="op_date" value="{{$date}}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('op_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Vendor <a href="{{url('vendor-add?redirect=store-operational-add')}}" class="btn-dark btn-sm pull-right mb-1"><i class="fe fe-plus-circle"></i> Tambah</a></label>
                        <select class="form-control @error('op_vendor') is-invalid @enderror" name="op_vendor" id="op_vendor" placeholder="Pilih vendor">
                            @foreach($vendor as $value)
                                @if(old('op_vendor') == $value->id)
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

    $('#op_vendor').select2({
        "ajax" : {
            "url" : "{{url('vendor-combo')}}",
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