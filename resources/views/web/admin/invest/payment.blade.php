<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('invest-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="invest-pay-form" name="invest-pay-form" action="{{url('invest-pay/'.$id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <p class="px-2 mb-2">Nama Investor</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$name}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Alamat</p>
                                <h6 class="px-2 m-0 font-weight-bold">{{$address}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Total Bayar</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($total_payment))}}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <p class="px-2 mb-2">Nomor HP</p>
                                <h6 class="px-2 m-0 font-weight-bold">+62{{$phone}}</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Jumlah Investasi</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($total_invest))}} ({{$margin}}%)</h6>
                            </div>
                            <div class="form-group">
                                <p class="px-2 mb-2">Kurang Bayar</p>
                                <h6 class="px-2 m-0 font-weight-bold">Rp {{str_replace(",", ".", number_format($underpayment))}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Tanggal Pembayaran</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker" name="payment_date" value="{{ $payment_date }}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('start_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jumlah Pembayaran</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('total_payment') is-invalid @enderror" id="total_payment" name="total_payment">
                        </div>
                        @error('total_payment')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        
                        <input type="hidden" name="sum_payment" value="{{$total_payment}}">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-add" name="btn-add">Simpan</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.masked').inputmask({
        rightAlign:false,
        radixPoint: ',',
        groupSeparator: ".",
        alias: "numeric",
        autoGroup: true,
        digits: 0
    });
</script>
</x-layouts.app>