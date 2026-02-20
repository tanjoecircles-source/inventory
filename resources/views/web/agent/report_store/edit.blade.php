<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('report-store')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="report-store-form" name="report-store-form" action="{{url('report-store-update/'.$detail->id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker" name="date" value="{{$date}}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Barista</label>
                        <select class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" placeholder="Pilih Barista">
                            @foreach($employee as $value)
                                @if($detail->employee_id == $value->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('employee_id') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pemasukan</label>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked @error('cash') is-invalid @enderror" name="cash" value="{{ $detail->cash }}" placeholder="Cash">
                                </div>
                                @error('cash')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked @error('qris') is-invalid @enderror" name="qris" value="{{ $detail->qris }}" placeholder="QRIS/Online">
                                </div>
                                @error('qris')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block" id="btn-update" name="btn-update">Simpan</button>
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