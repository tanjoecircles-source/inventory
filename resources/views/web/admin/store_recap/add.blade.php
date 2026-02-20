<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('store-recap-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="store-recap-form" name="store-recap-form" action="{{url('store-recap-create')}}" method="POST" enctype="multipart/form-data" >
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
                        <div class="row ">
                            <div class="col-6">
                                <label class="form-label">QRIS</label>
                                <input type="text" class="form-control masked @error('income_qris') is-invalid @enderror" name="income_qris" id="income_qris" value="{{ old('income_qris') }}" readonly >
                                @error('income_qris')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Cash</label>
                                <input type="text" class="form-control masked @error('income_cash') is-invalid @enderror" name="income_cash" id="income_cash" value="{{ old('income_cash') }}" readonly >
                                @error('income_cash')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Pemasukan</label>
                        <input type="text" class="form-control masked @error('income_total') is-invalid @enderror" name="income_total" id="income_total" value="{{ old('income_total') }}" readonly >
                        @error('income_total')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <h5 class="mt-6">Pengeluaran</h5>
                    <div class="form-group">
                        <div class="row ">
                            <div class="col-6">
                                <label class="form-label">Cash Toko</label>
                                <input type="text" class="form-control masked @error('outcome_cash') is-invalid @enderror" name="outcome_cash" id="outcome_cash" value="{{ old('outcome_cash') }}" readonly >
                                @error('outcome_cash')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Belanja Stok</label>
                                <input type="text" class="form-control masked @error('outcome_purchasing') is-invalid @enderror" name="outcome_purchasing" id="outcome_purchasing" value="{{ old('outcome_purchasing') }}" readonly >
                                @error('outcome_purchasing')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row ">
                            <div class="col-6">
                                <label class="form-label">Operasional</label>
                                <input type="text" class="form-control masked @error('outcome_operational') is-invalid @enderror" name="outcome_operational" id="outcome_operational" value="{{ old('outcome_operational') }}" readonly >
                                @error('outcome_operational')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Gaji Barista</label>
                                <input type="text" class="form-control masked @error('outcome_barista') is-invalid @enderror" name="outcome_barista" id="outcome_barista" value="{{ old('outcome_barista') }}" readonly >
                                @error('outcome_barista')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Pengeluaran</label>
                        <input type="text" class="form-control masked @error('outcome_total') is-invalid @enderror" name="outcome_total" id="outcome_total" value="{{ old('outcome_total') }}" readonly >
                        @error('outcome_total')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <h5 class="mt-6">Profit</h5>
                    <div class="form-group">
                        <label class="form-label">Total Profit</label>
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
            url:"{{url('store-recap-calculate')}}",
            data:{'id':id},
            success:function(data){
                $("#income_qris").val(data.income_qris.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#income_cash").val(data.income_cash.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#income_total").val(data.income_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#outcome_cash").val(data.outcome_cash.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#outcome_purchasing").val(data.outcome_purchasing.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#outcome_operational").val(data.outcome_operational.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#outcome_barista").val(data.outcome_barista.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#outcome_total").val(data.outcome_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#profit").val(data.profit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            }
        }); 
    });
});
</script>
</x-layouts.app>