<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('home')}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="d-flex justify-content-end mx-3">
                    <a href="{{url('store-purchasing-add')}}" id="btn-float" class="shadow-sm">
                        <i class="fe fe-plus fs-30"></i>
                    </a>
                </div>
                <div class="card no-border shadow-none custom-square mb-0">
                    <div class="card-body px-2 py-3">
                        <div class="card-custom-icon text-center">
                            <h4 class="mb-0 font-weight-bold text-gray">{{$contents_count}}</h4>
                            <p class="text-dark">data</p>
                        </div>
                        <h4 class="mb-1 font-weight-bold text-primary">Belanja Toko</h4>
                        <span class="mb-1 text-muted">To Manage Store Purchase</span>
                    </div>
                </div>
                <div class="card text-center no-border shadow-none custom-square mb-2">
                    <div class="card-body px-2 py-0">
                        <form id="search-form" class="mb-2" name="search-form" action="{{url('store-purchasing-list')}}" method="GET">
                            <div class="input-group">
                                <input type="text" name="keyword" value="{{$keyword}}" class="form-control br-tl-7 br-bl-7" placeholder="Type Keyword...">
                                <div class="input-group-append ">
                                    <button type="submit" class="btn btn-primary br-tr-7 br-br-7">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if(session()->has('success'))
                <input type="hidden" id="alert_success" value="{{ session('success') }}">
                @endif
                @if(session()->has('danger'))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fe fe-x mr-1" aria-hidden="true"></i> {{ session('danger') }}
                </div>
                @endif
                <div class="panel text-center no-border shadow-none custom-square">
                    <div class="panel-body px-0 py-2">
                        <div id="content-data">
                            @if($contents_count == 0)
                                <h6 class="m-4">No matching records found</h6>
                            @endif
                            @include('web.admin.store_purchasing.paginate')
                        </div>
                    </div>
                </div>
                <div class="ajax-load text-center py-4" style="display: none;">
                    <div class="spinner-border text-primary spinner-border-sm mr-2" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span class="text-muted font-weight-semibold">Memuat data...</span>
                </div>
                <div id="no-more-data" class="text-center py-4 text-muted" style="display: none;">
                    <i class="fe fe-check-circle mr-1"></i> Semua data telah ditampilkan
                </div>
            </div>
        </div>
    </div>
    <script>
        var page = 1;
        var isLoading = false;
        var stopLoading = false;
        var totalData = parseInt("{{$contents_count}}");
        var limit = parseInt("{{$limit}}");

        $(document).ready(function () {
            if(totalData <= limit){
                stopLoading = true;
                if(totalData > 0) {
                    $('#no-more-data').show();
                }
            }

            let alert_success = $("#alert_success").val();
            if(alert_success != undefined){
                notif({
                    msg: alert_success,
                    type: "success",
                    position: "center"
                });
            }
        });
        
        $(window).scroll(function(){
            if (stopLoading || isLoading) return;

            var key = '{{$keyword}}';
            // Check if user is near bottom (200px buffer)
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200){
                page++;
                loadMoreData(page, key);
            }
        });
    
        function loadMoreData(page, key){
            $.ajax({
                url:'?page=' + page + '&keyword=' + key,
                type:'get',
                beforeSend: function(){
                    isLoading = true;
                    $('.ajax-load').show();
                    $('#no-more-data').hide();
                }
            })
            .done(function(data){
                isLoading = false;
                $('.ajax-load').hide();

                if(data.html == "" || data.html.trim() == ""){
                    stopLoading = true;
                    if($('#content-data .list-item-animate').length > 0) {
                        $('#no-more-data').show();
                    }
                    return;     
                }
                
                $('#content-data').append(data.html);
                
                // Check if we've reached the total data
                // Need to see how many items are in the view (counting by class)
                var currentCount = $('#content-data > a').length;
                if(currentCount >= totalData){
                    stopLoading = true;
                    $('#no-more-data').show();
                }
            })
            .fail(function(jqXHR,ajaxOptions,thrownError){
                isLoading = false;
                $('.ajax-load').hide();
                console.error("Failed to load data:", thrownError);
            });
        }
    </script>
    </x-layouts.app>