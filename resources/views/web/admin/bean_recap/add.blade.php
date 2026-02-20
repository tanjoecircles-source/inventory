<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('bean-recap-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="bean-recap-form" name="bean-recap-form" action="{{url('bean-recap-create')}}" method="POST" enctype="multipart/form-data" >
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
                    <h5 class="mt-6">Pemasukan</h5>
                    <div class="form-group">
                        <label class="form-label">Jumlah Pemasukan</label>
                        <input type="text" class="form-control masked @error('income') is-invalid @enderror" name="income" id="income" value="{{ old('income') }}" readonly >
                        @error('income')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah HPP</label>
                        <input type="text" class="form-control masked @error('hpp') is-invalid @enderror" name="hpp" id="hpp" value="{{ old('hpp') }}" readonly >
                        @error('hpp')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Profit</label>
                        <input type="text" class="form-control masked @error('profit') is-invalid @enderror" name="profit" id="profit" value="{{ old('profit') }}" readonly >
                        @error('profit')<div class="text-danger">{{ $message }}</div>@enderror
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
            url:"{{url('bean-recap-calculate')}}",
            data:{'id':id},
            success:function(data){
                $("#income").val(data.income.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#hpp").val(data.hpp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#profit").val(data.profit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            }
        }); 
    });
});
</script>
</x-layouts.app>