<x-layouts.app>

@if(session()->has('search_result'))
<x-header-white-search>
    @slot('search_input')
    <x-search-input searchform="{{url('product-search-result')}}" searchclear="{{url('product-list?clear=true')}}" searchresult="{{ session('search_result') }}"></x-search-input>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-search>
@else
<x-header-white-3column>
    @slot('back')
        <x-search searchstyle="text-dark" searchurl="{{url('product-search')}}"></x-search>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
@endif
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            @if(Auth::user()->id == 1)
            <div class="d-flex justify-content-end">
                <a href="{{url('product-add')}}" id="btn-float" class="shadow-sm">
                    <i class="fe fe-plus fs-30"></i>
                </a>
            </div>
            <div class="panel panel-primary mb-0">
                <div class="panel-body px-2 py-2">
                    <div class="row">
                    <div class="col-6 px-1">
                    <a class="btn btn-dark btn-sm btn-block" href="{{url('product-list')}}" class="active">List</a></li>
                    </div>
                    <div class="col-6 px-1">
                    <a class="btn btn-outline-dark btn-sm btn-block" href="{{url('product-parent-list')}}">Parent</a></li>
                    </div>
                </div>
                </div>
            </div>
            @endif
            @if(session()->has('success'))
                <script>
                    $(function () {
                        notif({
                            msg: "{{ session('success') }}",
                            type: "success",
                            position: "center"
                        });
                    });
                </script>
            @endif
            @if(session()->has('danger'))
                <script>
                    $(function () {
                        notif({
                            msg: "{{ session('danger') }}",
                            type: "error",
                            position: "center"
                        });
                    });
                </script>
            @endif
            <div id="content-data" class="mt-2">
                @if($contents_count == 0)
                    <h6 class="m-4 text-center">No matching records found</h6>
                @endif
                @include('web.admin.product.paginate')
            </div>
            <div class="ajax-load text-center">
                <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        account = "{{$account_status}}";
        count = "{{$contents_count}}";
        limit = "{{$limit}}";
        
        if(count <= 10){
            $('.ajax-load').hide();
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
            $('.ajax-load').hide();
        });
    }
</script>
</x-layouts.app>