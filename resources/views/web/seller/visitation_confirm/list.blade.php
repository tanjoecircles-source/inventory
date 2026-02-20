<x-layouts.app>

<x-header-white-1column>
    @slot('title')
        <div class="text-center text-dark">Penjualan</div>
    @endslot
</x-header-white-1column>

<style>
    .btn-secondary{
        background-color: #CACACA;
        border-color: #CACACA;
    }
    .btn-secondary:hover{
        background-color: #E62129;
        border-color: #E62129;
    }
    .btn-xs{
        font-size: 10px;
        padding: 0.1rem 0.25rem;
    }
    .flex-scroll-x {
        /* white-space: nowrap; */
        overflow-x: auto; 
        -webkit-overflow-scrolling: touch;
        /* display: block ruby; */
        -ms-overflow-style: none;  /* Internet Explorer 10+ */
        scrollbar-width: none;  /* Firefox */
    }
    .flex-scroll-x::-webkit-scrollbar { 
        display: none;  /* Safari and Chrome */
    }
    .nav-link{
        height: 37px;
    }
    .nav-tabs .nav-link {
        border-radius: 0.25rem;
        background-color: #CACACA;
        color: white;
    }
    .w-max-content{
        width: max-content;
    }
    .nav-tabs .nav-item:first-child{
        margin-left: 25px;
    }
    .nav-tabs .nav-item{
        margin-right: 3px;
    }
    .nav-tabs .nav-item:last-child{
        margin-right: 10px;
    }
</style>   
<div class="container" style="overflow-x: hidden;">
    <div class="row">
        <div class="col-lg-5 pl-0 pr-0 mb-3 mx-auto flex-scroll-x">
            <ul class="nav nav-tabs pb-3 w-max-content" id="myTab" role="tablist">
                <!-- <li class="nav-item" style="min-width: 0px;width: 20px;"></li> -->
                <li class="nav-item">
                    <a class="nav-link active" id="waiting-tab" data-toggle="tab" href="#waiting" role="tab" aria-controls="waiting" aria-selected="true">Menunggu Konfirmasi{{ $countMenunggu > 0 ? ' ('.$countMenunggu.')' : '' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="visitation-tab" data-toggle="tab" href="#visitation" role="tab" aria-controls="visitation" aria-selected="false">Proses Visitasi{{ $countDisetujui > 0 ? ' ('.$countDisetujui.')' : '' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reject-tab" data-toggle="tab" href="#reject" role="tab" aria-controls="reject" aria-selected="false">Ditolak{{ $countDitolak > 0 ? ' ('.$countDitolak.')' : '' }}</a>
                </li>
                <!-- <li class="nav-item" style="min-width: 0px;width: 20px;"></li> -->
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
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
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="waiting" role="tabpanel" aria-labelledby="waiting-tab">
                        <div id="waiting-content">
                            @if($countMenunggu == 0)
                                <h6 class="m-4 text-center">No matching records found</h6>
                            @endif
                            @include('web.seller.visitation_confirm.paginate_waiting')
                        </div>
                        <div class="ajax-load text-center">
                            <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="visitation" role="tabpanel" aria-labelledby="visitation-tab">
                        <div id="visitation-content">
                            @if($countDisetujui == 0)
                                <h6 class="m-4 text-center">No matching records found</h6>
                            @endif
                            @include('web.seller.visitation_confirm.paginate_visitation')
                        </div>
                        <div class="ajax-load text-center">
                            <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reject" role="tabpanel" aria-labelledby="reject-tab">
                        <div id="reject-content">
                            @if($countDitolak == 0)
                                <h6 class="m-4 text-center">No matching records found</h6>
                            @endif
                            @include('web.seller.visitation_confirm.paginate_reject')
                        </div>
                        <div class="ajax-load text-center">
                            <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        setTimeout(function(){
            $('.ajax-load').hide();
            onLoading = false;
        }, 1000);
    });
    var pageWaiting = 1;
    var pageVisiting = 1;
    var pageReject = 1;
    var onLoading = true;

    $(window).scroll(function(){
        if (
            $('#myTabContent #waiting').hasClass('active') 
            && $(window).scrollTop() >= $(document).height() - $(window).height() - 1
            && !onLoading
        ){
            pageWaiting++;
            loadMoreData('waiting', pageWaiting);
        }else if (
            $('#myTabContent #visitation').hasClass('active') 
            && $(window).scrollTop() >= $(document).height() - $(window).height() - 1
            && !onLoading
        ){
            pageVisiting++;
            loadMoreData('visitation', pageVisiting);
        }else if (
            $('#myTabContent #reject').hasClass('active') 
            && $(window).scrollTop() >= $(document).height() - $(window).height() - 1
            && !onLoading
        ){
            pageReject++;
            loadMoreData('reject', pageReject);
        }
    });

    function loadMoreData(category, page){
        onLoading = true;
        $.ajax({
            url:'?page=' + page + '&category='+category,
            type:'get',
            beforeSend: function(){
                $('#'+category+' .ajax-load').show();
            }
        })
        .done(function(data){
            if(data.html == ""){
                $('#'+category+' .ajax-load').html("No more records found").promise().then(function(){
                    onLoading = false;
                });
                return;     
            }
            $('.ajax-load').hide();
            $('#'+category+'-content').append(data.html).promise().then(function(){
                onLoading = false;
            });
        })
        .fail(function(jqXHR, ajaxOptions, thrownError){
            $('#'+category+' .ajax-load').html("server error");
            onLoading = false;
        });
    }
</script>
</x-layouts.app>