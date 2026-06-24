<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('store-purchasing-detail/'.$detail->itm_pur_id)}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <form action="{{url('store-purchasing-item-update/'.$detail->id.'?pur='.$detail->itm_pur_id)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <p class="px-2 mb-2">Produk</p>
                            <input type="text" name="itm_product" class="form-control" value="{{$detail->itm_product}}" required>
                        </div>
                        <div class="form-group">
                            <p class="px-2 mb-2">Harga</p>
                            <input type="text" name="itm_price" id="itm_price" class="form-control masked" value="{{$detail->itm_price}}" required onkeyup="hitungTotal()" onchange="hitungTotal()">
                        </div>
                        <div class="form-group">
                            <p class="px-2 mb-2">Qty</p>
                            <input type="number" name="itm_qty" id="itm_qty" class="form-control" value="{{$detail->itm_qty}}" min="1" required onkeyup="hitungTotal()" onchange="hitungTotal()">
                        </div>
                        <div class="form-group">
                            <p class="px-2 mb-2">Total</p>
                            <input type="text" name="itm_total" id="itm_total" class="form-control" value="{{$detail->itm_total}}" readonly style="background:#f5f5f5;font-weight:bold;">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">
                            <i class="fe fe-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function hitungTotal() {
    var harga = document.getElementById('itm_price').value.replace(/\./g, '');
    var qty = document.getElementById('itm_qty').value;
    harga = parseInt(harga) || 0;
    qty = parseInt(qty) || 0;
    var total = harga * qty;
    document.getElementById('itm_total').value = total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
</x-layouts.app>