<x-layouts.app>
@if(session()->has('search_result'))
<x-header-white-search>
    @slot('search_input')
    <x-search-input searchform="{{url('product-explore-search-result')}}" searchclear="{{url('product-explore?clear=true')}}" searchresult="{{ session('search_result') }}"></x-search-input>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-search>
@else
<x-header-white-3column>
    @slot('back')
        <x-search searchstyle="text-dark" searchurl="{{url('product-explore-search')}}"></x-search>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
@endif
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            {{-- <div class="d-flex justify-content-end">
                <a href="{{url('product-add')}}" id="btn-float" class="shadow-sm">
                    <i class="fe fe-filter fs-30"></i>
                </a>
            </div> --}}
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
                            type: "danger",
                            position: "center"
                        });
                    });
                </script>
            @endif
            <div id="content-data">
                @if($contents_count == 0)
                    <h6 class="m-4 text-center">No matching records found</h6>
                @endif
                @include('web.agent.product_explore.paginate')
            </div>
            <div class="ajax-load text-center">
                <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        count = "{{$contents_count}}"
        limit = "{{$limit}}"
        if(count <= 6){
            $('.ajax-load').hide();
        }
    });
    var page = 1;
    var onLoading = false;
    var noMoreData = false;
    $(document.body).on('touchmove', onScroll); // for mobile
    $(window).on('scroll', onScroll); 
    
    function onScroll(e){
        var key = '{{$keyword}}';
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 75 && !onLoading
            && !noMoreData){
            page++;
            loadMoreData(page, key);
        }
    };

    function loadMoreData(page, key){
        onLoading = true;
        $.ajax({
            url:'?page=' + page + '&keyword=' + key,
            type:'get',
            beforeSend: function(){
                $('.ajax-load').show();
            }
        })
        .done(function(data){
            if(data.html == ""){
                noMoreData = true;
                $('.ajax-load').html("No more records found").promise().then(function(){
                    onLoading = false;
                });
                return;     
            }
            $('.ajax-load').hide();
            $('#content-data').append(data.html).promise().then(function(){
                onLoading = false;
            });
        })
        .fail(function(jqXHR,ajaxOptions,thrownError){
            $('.ajax-load').html("server error");
            onLoading = false;
        });
    }
</script>
</x-layouts.app>