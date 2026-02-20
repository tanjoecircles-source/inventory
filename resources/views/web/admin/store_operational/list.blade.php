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
                    <a href="{{url('store-operational-add')}}" id="btn-float" class="shadow-sm">
                        <i class="fe fe-plus fs-30"></i>
                    </a>
                </div>
                <div class="card no-border shadow-none custom-square mb-0">
                    <div class="card-body px-2 py-3">
                        <div class="card-custom-icon text-center">
                            <h4 class="mb-0 font-weight-bold text-gray">{{$contents_count}}</h4>
                            <p class="text-dark">data</p>
                        </div>
                        <h4 class="mb-1 font-weight-bold text-primary">Operasional Toko</h4>
                        <span class="mb-1 text-muted">To Manage Store Operational</span>
                    </div>
                </div>
                <div class="card text-center no-border shadow-none custom-square mb-2">
                    <div class="card-body px-2 py-0">
                        <form id="search-form" class="mb-2" name="search-form" action="{{url('store-operational-list')}}" method="GET">
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
                            @include('web.admin.store_operational.paginate')
                        </div>
                    </div>
                </div>
                <div class="ajax-load text-center" style="">
                    <p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            count = "{{$contents_count}}"
            limit = "{{$limit}}"
            if(count <= 10){
                $('.ajax-load').hide();
            }
            alert_success = $("#alert_success").val();
            if(alert_success != undefined){
                notif({
                    msg: alert_success,
                    type: "success",
                    position: "center"
                });
            }
        });
        
        var page = 1;
        $(window).scroll(function(){
            var key = '{{$keyword}}';
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 1){
                page++;
                loadMoreData(page, key);
            }
        });
    
        function loadMoreData(page, key){
            $.ajax({
                url:'?page=' + page + '&keyword=' + key,
                type:'get',
                beforeSend: function(){
                    $('.ajax-load').show();
                }
            })
            .done(function(data){
                if(data.html == ""){
                    $('.ajax-load').html("No more records found");
                    return;     
                }
                $('.ajax-load').hide();
                $('#content-data').append(data.html);
            })
            .fail(function(jqXHR,ajaxOptions,thrownError){
                $('.ajax-load').html("server error");
            });
        }
    </script>
    </x-layouts.app>