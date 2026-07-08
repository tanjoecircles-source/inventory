<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('product-detail/'.$id_produk)}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto px-0">
                <div class="card no-border shadow-none custom-square my-2">
                    <div class="card-body px-4 py-4">
                        <h5>History Penjualan</h5>
                        <div class="d-flex mb-3">
                            <p class="mb-0 text-muted">Produk: <strong>{{ $product->name }}</strong> ({{ strtoupper($product->code) }})</p>
                        </div>
                        
                        <div id="content-data">
                            @if($contents->total() == 0)
                                <div class="text-center py-5">
                                    <i class="fe fe-shopping-cart fs-40 text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Belum ada data penjualan untuk produk ini.</p>
                                </div>
                            @else
                                <div class="mt-3">
                                    @include('web.admin.product.sales-history-paginate')
                                </div>
                            @endif
                        </div>
                        <div class="ajax-load text-center" @if($contents->total() <= $limit) style="display:none" @endif>
                            <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var page = 1;
        var isLoading = false;
        var isEndOfData = false;

        $(window).on('scroll', function() {
            if (isLoading || isEndOfData) return;

            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 150) {
                loadMore();
            }
        });

        function loadMore() {
            if (isLoading || isEndOfData) return;
            
            page++;
            
            $.ajax({
                url:'?page=' + page,
                type:'get',
                beforeSend: function(){
                    isLoading = true;
                    $('.ajax-load').fadeIn();
                }
            })
            .done(function(data){
                if(data.html.trim() == ""){
                    isEndOfData = true;
                    $('.ajax-load').html('<p class="text-muted fs-12 mt-2">— Akhir dari data —</p>');
                    return;     
                }
                $('.ajax-load').hide();
                $('#content-data').append(data.html);
                isLoading = false;
                
                // Auto check if still more space to scroll
                if ($(window).height() >= $(document).height()) {
                    loadMore();
                }
            })
            .fail(function(){
                $('.ajax-load').html('<p class="text-danger fs-12 mt-2">Gagal memuat data, silakan coba lagi</p>');
                isLoading = false;
            });
        }
    </script>
</x-layouts.app>