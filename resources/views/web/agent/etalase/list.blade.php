<x-layouts.app>
@if(session()->has('search_result'))
<x-header-white-search>
    @slot('search_input')
    <x-search-input searchform="{{url('product-explore-search-result')}}" searchclear="{{url('product-explore?clear=true')}}" searchresult="{{ session('search_result') }}"></x-search-input>
    @endslot
    @slot('notif')
    <x-share></x-share>
    @endslot
</x-header-white-search>
@else
<x-header-white-3column>
    @slot('back')
        <x-search searchstyle="text-dark" searchurl="{{url('product-explore-search')}}"></x-search>
    @endslot
    @slot('notif')
    <x-share sharestyle="text-dark" shareurl="{{url('share-catalogue')}}"></x-share>
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
            <h6 id="etalase-count">Etalase ({{$contents_count}})</h6>
            <div id="content-data">
                @if($contents_count == 0)
                    <h6 class="m-4 text-center">No matching records found</h6>
                @endif
                @include('web.agent.etalase.paginate')
            </div>
            <div class="ajax-load text-center">
                <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        profile_check = "{{$profile_check}}";
        count = "{{$contents_count}}";
        limit = "{{$limit}}";
        if(profile_check == false){
            url = "{{url('profile-agent-reminder')}}";
            $('#modal-md-center').modal({
                "backdrop": "static"
            }).find('.modal-dialog').load(url);
        }
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
            $('.ajax-load').html("server error");
        });
    }
</script>
</x-layouts.app>