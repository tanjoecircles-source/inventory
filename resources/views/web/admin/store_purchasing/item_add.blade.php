<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('store-purchasing-detail/'.$pur_id)}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <form id="store-purchasing-item-form" name="store-purchasing-item-form" action="{{url('store-purchasing-item-create')}}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="card no-border shadow-none custom-square mt-4 mb-0">
                    <div class="card-body px-2 py-4">
                        <div class="form-group">
                            <label class="form-label">Nama Produk</label>
                            <input type="type" class="form-control @error('itm_product') is-invalid @enderror" name="itm_product" id="itm_product" value="{{ old('itm_product') }}">
                            @error('itm_product')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga</label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon fs-15">Rp</span>
                                <input type="text" class="form-control masked" name="itm_price" id="itm_price" value="{{ old('itm_price') }}">
                            </div>
                            @error('itm_price')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control @error('itm_qty') is-invalid @enderror" name="itm_qty" id="itm_qty" value="1" placeholder="0">
                            @error('itm_qty')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-7 bg-white">
                    <div class="d-flex title-bar text-black">
                        <div class="mr-auto text-left">
                            <h6 class="font-weight-bold mb-0">Jumlah</h6>
                        </div>
                        <div class="ml-auto text-right">
                            <h6 class="font-weight-bold mb-0">Rp <span id="itm_amount">0</span></h6>
                        </div>
                    </div>
                </div>
                <div class="card text-center no-border shadow-none custom-square mb-7">
                    <div class="card-body p-2">
                        <input type="hidden" name="pur_id" value="{{$pur_id}}">
                        <input type="hidden" id="itm_total" name="itm_total" value="0">
                        <button type="submit" class="btn btn-primary btn-block" id="btn-update" name="btn-update">Simpan</button>
                        <a href="{{url('sales-detail/'.$pur_id)}}" class="btn btn-dark btn-block btn-outline" id="btn-cancel" name="btn-cancel">Batal</a>
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
    
        $("#itm_qty").keyup(function(){
            price = $("#itm_price").val();
            qty = $(this).val();
            amount = price.replace(/\./g,"") * qty;
            $("#itm_amount").html(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $("#itm_total").val(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            
        });
    
        $("#itm_price").keyup(function(){
            price = $(this).val().replace(/\./g,"");
            qty = $("#itm_qty").val();
            amount = price * qty;
            $("#itm_amount").html(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $("#itm_total").val(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            
        });
    });
    </script>
    </x-layouts.app>