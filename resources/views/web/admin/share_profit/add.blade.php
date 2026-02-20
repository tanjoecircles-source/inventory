<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('share-profit-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="share-profit-form" name="share-profit-form" action="{{url('share-profit-create')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Periode</label>
                        <select class="form-control @error('periode_id') is-invalid @enderror" name="periode_id" id="periode_id" placeholder="Pilih Periode">
                            <option value="">Pilih Periode</option>
                            @foreach($period as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('periode_id') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Profit Toko Kopi</label>
                        <input type="text" class="form-control masked @error('profit_toko') is-invalid @enderror" name="profit_toko" id="profit_toko" value="{{ old('profit_toko') }}" readonly >
                        @error('profit_toko')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Profit Coffee Bean & Tools</label>
                        <input type="hidden" class="form-control" name="potongan_non_investor" id="potongan_non_investor" value="{{ old('potongan_non_investor') }}">
                        <input type="text" class="form-control masked @error('profit_bean') is-invalid @enderror" name="profit_bean" id="profit_bean" value="{{ old('profit_bean') }}" readonly >
                        @error('profit_bean')<div class="text-danger">{{ $message }}</div>@enderror
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

    $("#periode_id").on('change', function(e) {
        let id = $(this).val();
        $.ajax({
            type:'GET',
            url:"{{url('share-profit-calculate')}}",
            data:{'id':id},
            success:function(data){
                $("#profit_toko").val(data.profit_toko.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#potongan_non_investor").val(data.potongan_non_investor);
                $("#profit_bean").val(data.profit_bean.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            }
        }); 
    });
});
</script>
</x-layouts.app>