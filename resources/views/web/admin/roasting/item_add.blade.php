<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('roasting-detail/'.$roasting_id)}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="roasting-item-form" name="roasting-item-form" action="{{url('roasting-item-create/'.$roasting_id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-0">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Cari Produk</label>
                        <select class="form-control @error('product') is-invalid @enderror" name="product" id="product" placeholder="Pilih Produk">
                            @foreach($product as $value)
                                @if(old('product') == $value->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('product') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Roasting Profile</label>
                        <select class="form-control @error('profile') is-invalid @enderror" name="profile" id="profile" placeholder="Pilih Profile">
                            <option value="">Pilih</option>
                            @foreach($roast_profile as $vprof)
                                <option value="{{ $vprof->id }}">{{ $vprof->name }}</option>
                            @endforeach
                        </select>
                        @error('profile') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="text" class="form-control @error('qty') is-invalid @enderror" name="qty" id="qty" value="1" placeholder="0">
                        @error('qty')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    {{-- <div class="form-group">
                        <label class="form-label">Log Artisan</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="artisan_log">
                            <label class="custom-file-label">Pilih file</label>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block" id="btn-update" name="btn-update">Simpan</button>
                    <a href="{{url('roasting-detail/'.$roasting_id)}}" class="btn btn-dark btn-block btn-outline" id="btn-cancel" name="btn-cancel">Batal</a>
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

    $('#product').select2({
        "ajax" : {
            "url" : "{{url('product-combo-gb')}}",
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
        placeholder: 'Cari Product',
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