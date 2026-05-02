<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('sales-detail/'.$inv_id)}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            @if(session()->has('danger'))
            <div class="alert alert-warning" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fe fe-alert-triangle mr-1" aria-hidden="true"></i> {{ session('danger') }}
            </div>
            @endif
            <form id="sales-item-form" name="sales-item-form" action="{{url('sales-item-create')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-0">
                <div class="card-body px-2 py-4">
                    <input type="text" id="barcode-result" hidden>
                    <div class="form-group">
                        <label class="form-label">Cari Produk</label>
                        <select class="form-control @error('itm_product') is-invalid @enderror" name="itm_product" id="itm_product" placeholder="Pilih Produk">
                            @foreach($product as $value)
                                @if(old('itm_product') == $value->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('itm_product') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group" id="price-type-group" style="display:none;">
                        <label class="form-label" style="font-size:13px;font-weight:600;color:#444;margin-bottom:8px;">Tipe Harga</label>
                        <input type="hidden" name="itm_price_type" id="itm_price_type" value="">
                        <div id="price-type-pills" class="price-type-pills">
                            <div class="price-type-placeholder text-muted" style="font-size:13px;">Pilih produk terlebih dahulu...</div>
                        </div>
                    </div>
                    <style>
                    .price-type-pills { display:flex; gap:6px; flex-wrap:nowrap; }
                    .price-pill {
                        flex:1; text-align:center; justify-content:center;
                        padding:7px 6px; border-radius:50px;
                        border:2px solid #e0e0e0; background:#f8f9fa;
                        cursor:pointer; font-size:12px; font-weight:500;
                        color:#555; transition:all 0.2s ease;
                        user-select:none; white-space:nowrap;
                    }
                    .price-pill:hover { border-color:#adb5bd; background:#f1f3f5; color:#222; }
                    .price-pill.active {
                        border-color: var(--pill-color, #206bc4);
                        background: var(--pill-color, #206bc4);
                        color:#fff; box-shadow:0 3px 10px rgba(0,0,0,0.15);
                        transform:translateY(-1px);
                    }
                    </style>
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
                        <input type="text" class="form-control @error('itm_qty') is-invalid @enderror" name="itm_qty" id="itm_qty" value="1" placeholder="0">
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
                    <input type="hidden" name="inv_id" value="{{$inv_id}}">
                    <input type="hidden" id="itm_total" name="itm_total" value="0">
                    <button type="submit" class="btn btn-primary btn-block" id="btn-update" name="btn-update">Simpan</button>
                    <a href="{{url('sales-detail/'.$inv_id)}}" class="btn btn-dark btn-block btn-outline" id="btn-cancel" name="btn-cancel">Batal</a>
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

    $('#itm_product').select2({
        "ajax" : {
            "url" : "{{url('product-combo')}}",
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
        placeholder: 'Cari Product',
        // language: {
        //     inputTooShort: function () {
        //         return "Silakan masukkan 1 atau lebih karakter";
        //     }
        // },
        // minimumInputLength: 1
    });
    
    // Simpan data harga produk yang sedang aktif
    var currentProductData = null;

    // Definisi opsi pill per tipe produk
    var pillOptions = {
        1: [ // Green Beans
            { value:'ecer',     label:'Ecer 1–15kg',  color:'#206bc4' },
            { value:'grosir15', label:'Grosir ≥ 15kg', color:'#f59f00' },
            { value:'grosir50', label:'Grosir ≥ 50kg', color:'#d63939' }
        ],
        2: [ // Roasted Filter
            { value:'normal',   label:'Normal',   color:'#206bc4' },
            { value:'bundling', label:'Bundling', color:'#f59f00' },
            { value:'b2b',      label:'B2B',      color:'#d63939' }
        ],
        3: [ // Roasted Espresso
            { value:'normal',   label:'Normal',   color:'#206bc4' },
            { value:'bundling', label:'Bundling', color:'#f59f00' },
            { value:'b2b',      label:'B2B',      color:'#d63939' }
        ]
    };

    function getPriceByType(data, selectedValue) {
        var price = data.price;
        if (data.type == 1) {
            if (selectedValue === 'grosir15') price = data.price_grosir15 || data.price;
            else if (selectedValue === 'grosir50') price = data.price_grosir50 || data.price;
        } else if (data.type == 2 || data.type == 3) {
            if (selectedValue === 'bundling') price = data.price_grosir15 || data.price;
            else if (selectedValue === 'b2b') price = data.price_grosir50 || data.price;
        }
        return price;
    }

    function updatePriceFromType() {
        if (!currentProductData) return;
        var selectedType = $("#itm_price_type").val();
        var price = getPriceByType(currentProductData, selectedType);

        $("#itm_price").inputmask('remove');
        $("#itm_price").val(price);
        $("#itm_price").inputmask({
            rightAlign:false, radixPoint:',', groupSeparator:".",
            alias:"numeric", autoGroup:true, digits:0
        });
        var qty = $("#itm_qty").val();
        var amount = price * qty;
        $("#itm_amount").html(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        $("#itm_total").val(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    }

    function renderPills(productType) {
        var options = pillOptions[productType] || pillOptions[2];
        var $container = $("#price-type-pills").empty();
        $.each(options, function(i, opt) {
            var isFirst = (i === 0);
            var pill = $('<div>')
                .addClass('price-pill' + (isFirst ? ' active' : ''))
                .attr({'data-value': opt.value, style: '--pill-color:' + opt.color + ';'})
                .text(opt.label);
            if (isFirst) $("#itm_price_type").val(opt.value);
            $container.append(pill);
        });
        $("#price-type-group").show();
    }

    $(document).on('click', '.price-pill', function() {
        if ($(this).hasClass('disabled-pill')) return;
        $("#price-type-pills .price-pill").removeClass('active');
        $(this).addClass('active');
        $("#itm_price_type").val($(this).data('value'));
        updatePriceFromType();
    });

    $("#itm_product").on('change', function(e) {
        let id = $(this).val();
        let qty = $("#itm_qty").val();
        $.ajax({
            type:'GET',
            url:"{{url('product-detail-json')}}",
            data:{'id':id},
            success:function(data){
                if(data.stock == 0){
                    $("#btn-update").prop("disabled", true);
                    $("#itm_price_type").prop("disabled", true);
                    currentProductData = null;
                    $('#modal-warning .modal-body').html('Tidak dapat menambah produk, Cek kembali Ketersediaan Stok!');
                    var myModal = new bootstrap.Modal(document.getElementById('modal-warning'), {
                        keyboard: false
                    });
                    myModal.show();
                }else{
                    $("#btn-update").prop("disabled", false);
                    currentProductData = data;

                    // Render radio pills sesuai tipe produk
                    renderPills(data.type);
                    updatePriceFromType();
                }
            }
        });
        
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