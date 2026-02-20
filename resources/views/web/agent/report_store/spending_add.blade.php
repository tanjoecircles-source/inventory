<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('report-store-detail/'.$report_id)}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <form id="report-store-spending-form" name="report-store-spending-form" action="{{url('report-store-spending-create')}}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="card no-border shadow-none custom-square mt-4 mb-0">
                    <div class="card-body px-2 py-4">
                        <div class="form-group">
                            <label class="form-label">Nama Produk</label>
                            <input type="type" class="form-control @error('product') is-invalid @enderror" name="product" id="product" value="{{ old('product') }}">
                            @error('product')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga</label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon fs-15">Rp</span>
                                <input type="text" class="form-control masked" name="price" id="price" value="{{ old('price') }}">
                            </div>
                            @error('price')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" name="qty" id="qty" value="1" placeholder="0">
                            @error('qty')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-7 bg-white">
                    <div class="d-flex title-bar text-black">
                        <div class="mr-auto text-left">
                            <h6 class="font-weight-bold mb-0">Jumlah</h6>
                        </div>
                        <div class="ml-auto text-right">
                            <h6 class="font-weight-bold mb-0">Rp <span id="amount">0</span></h6>
                        </div>
                    </div>
                </div>
                <div class="card text-center no-border shadow-none custom-square mb-7">
                    <div class="card-body p-2">
                        <input type="hidden" name="report_id" value="{{$report_id}}">
                        <input type="hidden" id="total" name="total" value="0">
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
    
        $("#qty").keyup(function(){
            price = $("#price").val();
            qty = $(this).val();
            amount = price.replace(/\./g,"") * qty;
            $("#amount").html(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $("#total").val(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            
        });
    
        $("#price").keyup(function(){
            price = $(this).val().replace(/\./g,"");
            qty = $("#qty").val();
            amount = price * qty;
            $("#amount").html(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            $("#total").val(amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
            
        });
    });
    </script>
    </x-layouts.app>