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
            <form id="barista-fee-form" name="barista-fee-form" action="{{url('barista-fee-create')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Periode</label>
                        <select class="form-control @error('periode_id') is-invalid @enderror" name="periode_id" id="periode_id" placeholder="Pilih Periode">
                            @foreach($periode as $value)
                                @if(old('periode_id') == $value->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('periode_id') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') }}</textarea>
                        @error('desc')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-add" name="btn-add">Simpan</button>
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

    $('#periode_id').select2({
        "ajax" : {
            "url" : "{{url('barista-fee-comboperiod')}}",
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
        placeholder: 'Pilih Periode'
    });

    $("#periode_id").on('change', function(e) {
        let id = $(this).val();
        $.ajax({
            type:'GET',
            url:"{{url('barista-fee-total')}}",
            data:{'id':id},
            success:function(data){
                $("#profit").val(data.sales_profit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            }
        }); 
    });
});
</script>
</x-layouts.app>