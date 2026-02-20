<x-layouts.app>

<x-header-white-1column>
    @slot('title')
        <div class="text-center text-dark">Transaksi</div>
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
        margin-right: 25px;
    }
</style>   
<div class="container" style="overflow-x: hidden;">
    <div class="row">
        <div class="col-lg-5 pl-0 pr-0 mb-3 mx-auto flex-scroll-x">
            <ul class="nav nav-tabs pb-3 w-max-content" id="myTab" role="tablist">
                <!-- <li class="nav-item" style="min-width: 0px;width: 20px;"></li> -->
                <li class="nav-item">
                    <a class="nav-link active" id="waiting-tab" data-toggle="tab" href="#waiting" role="tab" aria-controls="waiting" aria-selected="true">Menunggu Konfirmasi{{ $waitingCount > 0 ? ' ('.$waitingCount.')' : '' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="visitation-tab" data-toggle="tab" href="#visitation" role="tab" aria-controls="visitation" aria-selected="false">Visitasi{{ $visitingCount > 0 ? ' ('.$visitingCount.')' : '' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="seller-confirm-tab" data-toggle="tab" href="#seller-confirm" role="tab" aria-controls="seller-confirm" aria-selected="false">Konfirmasi Penjualan{{ $confirmCount > 0 ? ' ('.$confirmCount.')' : '' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sold-tab" data-toggle="tab" href="#sold" role="tab" aria-controls="sold" aria-selected="false">Selesai{{ $soldCount > 0 ? ' ('.$soldCount.')' : '' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cancel-tab" data-toggle="tab" href="#cancel" role="tab" aria-controls="cancel" aria-selected="false">Dibatalkan{{ $cancelCount > 0 ? ' ('.$cancelCount.')' : '' }}</a>
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
                            @if($waitingCount == 0)
                                <h6 class="m-4 text-center">No matching records found</h6>
                            @endif
                            @include('web.agent.transaction.paginate')
                        </div>
                        <div class="ajax-load text-center">
                            <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="visitation" role="tabpanel" aria-labelledby="visitation-tab">
                        <div id="visitation-content">
                            @if($visitingCount == 0)
                                <h6 class="m-4 text-center">No matching records found</h6>
                            @endif
                            @include('web.agent.transaction.paginateVisiting')
                        </div>
                        <div class="ajax-load text-center">
                            <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="seller-confirm" role="tabpanel" aria-labelledby="seller-confirm-tab">
                        <div id="seller-confirm-content">
                            @if($confirmCount == 0)
                                <h6 class="m-4 text-center">No matching records found</h6>
                            @endif
                            @include('web.agent.transaction.paginateConfirm')
                        </div>
                        <div class="ajax-load text-center">
                            <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="sold" role="tabpanel" aria-labelledby="sold-tab">
                        <div id="sold-content">
                            @if($soldCount == 0)
                                <h6 class="m-4 text-center">No matching records found</h6>
                            @endif
                            @include('web.agent.transaction.paginateSold')
                        </div>
                        <div class="ajax-load text-center">
                            <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="cancel" role="tabpanel" aria-labelledby="cancel-tab">
                        <div id="cancel-content">
                            @if($cancelCount == 0)
                                <h6 class="m-4 text-center">No matching records found</h6>
                            @endif
                            @include('web.agent.transaction.paginateCancel')
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
    var pageConfirm = 1;
    var pageSold = 1;
    var pageCancel = 1;
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
            $('#myTabContent #seller-confirm').hasClass('active') 
            && $(window).scrollTop() >= $(document).height() - $(window).height() - 1
            && !onLoading
        ){
            pageConfirm++;
            loadMoreData('seller-confirm', pageConfirm);
        }else if (
            $('#myTabContent #sold').hasClass('active') 
            && $(window).scrollTop() >= $(document).height() - $(window).height() - 1
            && !onLoading
        ){
            pageSold++;
            loadMoreData('sold', pageSold);
        }else if (
            $('#myTabContent #cancel').hasClass('active') 
            && $(window).scrollTop() >= $(document).height() - $(window).height() - 1
            && !onLoading
        ){
            pageCancel++;
            loadMoreData('cancel', pageCancel);
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