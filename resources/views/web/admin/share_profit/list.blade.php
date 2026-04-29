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
            
            <!-- Floating Button -->
            <div class="d-flex justify-content-end">
                <a href="{{url('share-profit-add')}}" id="btn-float" class="shadow-sm">
                    <i class="fe fe-plus fs-30"></i>
                </a>
            </div>

            <!-- Page Title -->
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body py-3">
                    <h5 class="mb-1 font-weight-bold text-primary">Bagi Hasil</h5>
                    <p class="text-muted mb-0">Kelola distribusi keuntungan per periode</p>
                </div>
            </div>

            <!-- Search bar -->
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body p-2">
                    <form id="search-form" action="{{url('share-profit-list')}}" method="GET" class="mb-0">
                        <div class="input-group">
                            <input type="text" name="keyword" value="{{$keyword}}" class="form-control" placeholder="Cari periode..." style="border: 1px solid #eee;">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary px-3">
                                    <i class="fa fa-search"></i>
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
                {{ session('danger') }}
            </div>
            @endif

            <!-- List -->
            <div class="card no-border shadow-none custom-square">
                <div class="card-body p-0">
                    <div id="content-data">
                        @if($contents_count == 0)
                            <div class="text-center py-5">
                                <p class="text-muted mb-0">Tidak ada data ditemukan</p>
                            </div>
                        @endif
                        @include('web.admin.share_profit.paginate')
                    </div>
                </div>
            </div>

            <div class="ajax-load text-center my-4" style="display: none;">
                <p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Memuat data...</p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        count = "{{$contents_count}}"
        limit = "{{$limit}}"
        if(count <= limit){
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
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100){
            if($('.ajax-load').text() != "No more records found"){
                page++;
                loadMoreData(page, key);
            }
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
            if(data.html == "" || data.html == "\n"){
                $('.ajax-load').html("Tidak ada data lagi");
                return;     
            }
            $('.ajax-load').hide();
            $('#content-data').append(data.html);
        })
        .fail(function(jqXHR,ajaxOptions,thrownError){
            $('.ajax-load').html("Server error");
        });
    }
</script>
</x-layouts.app>