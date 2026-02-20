<x-layouts.app>
<x-header-white-3column back="&nbsp;">
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="no-border shadow-none custom-square mb-2" style="overflow-x:scroll;-ms-overflow-style: none;
            scrollbar-width: none;">
                <div class="" style="width:max-content">
                    <a href="" class="btn btn-primary btn-sm mr-1">Menunggu Konfirmasi ({{$contents_count}})</a>
                    <a href="#" class="btn btn-outline-primary btn-sm mr-1">Proses Visitasi (0)</a>
                    <a href="#" class="btn btn-outline-primary btn-sm mr-1">Konfirmasi Penjualan (0)</a>
                </div>
            </div>
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
            <div id="content-data">
                @if($contents_count == 0)
                    <h6 class="m-4 text-center">No matching records found</h6>
                @endif
                @include('web.seller.visitation_confirm.paginate')
            </div>
            <div class="ajax-load" style="display:none">
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