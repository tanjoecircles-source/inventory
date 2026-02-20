<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('product-list')}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>

    <div class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <form id="product-sales-form" name="product-sales-form" action="{{url('product-create-sales/'.$id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="card no-border shadow-none custom-square mb-0">
                        <div class="card-body px-3 pb-0">
                            <div class="form-group">
                                <h5>Informasi Penjualan</h5>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Jual</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="price" id="price" value="{{ old('price') }}">
                                </div>
                                @error('price')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Komisi</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="sales_commission" id="sales_commission" value="{{ old('sales_commission') }}">
                                </div>
                                @error('sales_commission')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Sistem Pembayaran</label>
                                <div class="selectgroup d-flex">
                                    <label class="selectgroup-item mr-1">
                                        <input type="checkbox" name="payment_type[]" value="cash" class="selectgroup-input">
                                        <span class="selectgroup-button">Tunai</span>
                                    </label>
                                    <label class="selectgroup-item ml-1">
                                        <input type="checkbox" name="payment_type[]" value="credit" class="selectgroup-input">
                                        <span class="selectgroup-button">Kredit</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card text-center no-border shadow-none custom-square mb-7">
                        <div class="card-body py-3 px-3">
                            <div class="row">
                                <div class="col">
                                    <a href="#" class="btn btn-outline-primary btn-block btn-lg" id="btn-back" name="btn-back">Sebelumnya</a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-add" name="btn-add">Selesai</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
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