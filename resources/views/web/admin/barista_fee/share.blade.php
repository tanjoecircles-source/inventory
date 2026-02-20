<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('barista-fee-detail/'.$profit->id)}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="barista-fee-pay-form" name="barista-fee-pay-form" action="{{url('barista-fee-share-create/'.$profit->id)}}" method="POST" enctype="multipart/form-data" >
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
                    <div class="form-group">
                        <label class="form-label">Personil</label>
                        <select class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" placeholder="Pilih Personil">
                            @foreach($employee as $value)
                                @if(old('employee_id') == $value->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('employee_id') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Shift</label>
                        <div class="row">
                            <div class="col">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">S</span>
                                    <input type="text" class="form-control @error('shift_short') is-invalid @enderror" id="shift_short" name="shift_short" value="0" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">L</span>
                                    <input type="text" class="form-control @error('shift_long') is-invalid @enderror" id="shift_long" name="shift_long" value="0" readonly>
                                </div>
                            </div>
                        </div>
                        @error('sub_total')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sub Total Profit</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('sub_total') is-invalid @enderror" id="sub_total" name="sub_total" value="0" readonly>
                        </div>
                        @error('sub_total')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Potongan Profit</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('potongan') is-invalid @enderror" id="potongan" name="potongan" value="0">
                        </div>
                        @error('potongan')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Keterangan Potongan</label>
                        <textarea class="form-control @error('potongan') is-invalid @enderror" id="desc" name="desc"></textarea>
                        @error('desc')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Share Profit</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('total') is-invalid @enderror" id="total" name="total" value="0" readonly>
                        </div>
                        @error('total')<div class="text-danger">{{ $message }}</div>@enderror
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

    $('#employee_id').select2({
        "ajax" : {
            "url" : "{{url('employee-combo')}}",
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
        placeholder: 'Pilih Personil'
    });
    
    $("#employee_id").on('change', function(e) {
        let id_employee = $(this).val();
        let id_profit = "{{$profit->id}}";
        $.ajax({
            type:'GET',
            url:"{{url('barista-fee-calculate')}}",
            data:{
                'id_employee':id_employee,
                'id_profit':id_profit
            },
            success:function(data){
                $("#shift_short").val(data.shift_short.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#shift_long").val(data.shift_long.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#sub_total").val(data.percent_share.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $("#total").val(data.percent_share.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            }
        }); 
    });

    $("#potongan").keyup(function(){
        sub_total = $("#sub_total").val();
        potongan = $(this).val();
        total = sub_total.replace(/\./g,"") - potongan.replace(/\./g,"");
        $("#total").val(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        
    });
});
</script>
</x-layouts.app>