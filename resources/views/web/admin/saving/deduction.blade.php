<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('saving-detail/'.$id)}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="saving-deduction-form" name="saving-deduction-form" action="{{url('saving-deduction-create/'.$id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    @if(session()->has('success'))
                        <input type="hidden" id="alert_success" value="{{ session('success') }}">
                    @endif
                    @if(session()->has('danger'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="fe fe-alert-circle mr-1" aria-hidden="true"></i> {{ session('danger') }}
                    </div>
                    @endif
                    <h5 class="mb-1 font-weight-bold">Tambah Potongan Tabungan</h5>
                    <p class="text-muted mb-3">Periode {{$detail->periode}} &bull; Sisa Rp {{number_format($sisa_tabungan, 0, ',', '.')}}</p>
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker" name="date" value="{{old('date', $date)}}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Item Potongan</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}" placeholder="Contoh: Bayar operasional">
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Potongan</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{old('amount', '0')}}">
                        </div>
                        @error('amount')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-add" name="btn-add">Simpan</button>
                    </div>
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
});
</script>
</x-layouts.app>
