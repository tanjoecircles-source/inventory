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
                <a href="{{url('sales-add')}}" id="btn-float" class="shadow-sm">
                    <i class="fe fe-plus fs-30"></i>
                </a>
            </div>
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body px-2 py-3">
                    <div class="card-custom-icon text-center">
                        <h4 class="mb-0 font-weight-bold text-gray">{{$contents_count}}</h4>
                        <p class="text-dark">data</p>
                    </div>
                    <h4 class="mb-1 font-weight-bold text-primary">Penjualan</h4>
                    <span class="mb-1 text-muted">For managing Sales</span>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mb-2">
                <div class="card-body px-2 py-0">
                    <form id="search-form" class="mb-2" name="search-form" action="{{url('sales-list-paid')}}" method="GET">
                        <div class="d-flex">
                            <div class="p-2">
                                <a role="button" class="btn btn-white" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fe fe-filter"></i>@if(!empty($author_filtered) || !empty($startdate_filtered) || !empty($enddate_filtered))<i class="fa fa-circle text-success" style="font-size:8px;vertical-align:top"></i>@endif</a>
                            </div>
                            <div class="p-2 flex-grow-1">
                                <div class="input-group">
                                    <input type="text" name="keyword" value="{{$keyword}}" class="form-control br-tl-7 br-bl-7" placeholder="Type Keyword...">
                                    <div class="input-group-append ">
                                        <button type="submit" class="btn btn-primary br-tr-7 br-br-7">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse col-lg-12" role="tabpanel" aria-labelledby="headingOne">
                            <h5>Filter</h5>
                            <div class="form-group row">
                                <label class="col-md-2 col-sm-12 form-label" for="example-email">Invoice Date</label>
                                <div class="col-md-5 col-sm-6">
                                    <input class="form-control form-control-sm fc-datepicker" name="startdate" value="{{$startdate_filtered}}" type="text" placeholder="Tanggal Awal">
                                </div>
                                <div class="col-md-5 col-sm-6">
                                    <input class="form-control form-control-sm fc-datepicker" name="enddate" value="{{$enddate_filtered}}" type="text" placeholder="Tanggal Akhir">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-sm-12 form-label" for="example-email">Author</label>
                                <div class="col-md-10 col-sm-12">
                                    <select class="form-control @error('author') is-invalid @enderror" name="author" id="author" placeholder="Pilih Author">
                                        <option value="" @if($author_filtered == '') selected @endif>Semua Author</option>
                                        @foreach($author as $value)
                                            @php
                                            if(!empty($author_filtered) && $author_filtered == $value->id){
                                                $selected_author = 'selected';
                                            }else{
                                                $selected_author = '';
                                            }
                                            @endphp
                                            <option value="{{ $value->id }}" {{$selected_author}}>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-10 col-sm-12">
                                    <button type="submit" class="btn btn-primary br-tr-7 br-br-7">
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-primary mb-0">
                <div class="panel-body px-2 py-0">
                    <div class="row">
                    <div class="col-6 px-1">
                    <a class="btn btn-outline-dark btn-sm btn-block" href="{{url('sales-list')}}" class="active">Faktur</a></li>
                    </div>
                    <div class="col-6 px-1">
                    <a class="btn btn-dark btn-sm btn-block" href="{{url('sales-list-paid')}}">Arsip</a></li>
                    </div>
                </div>
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
                        @include('web.admin.sales.paginate_paid')
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
        var startdate = '{{$startdate_filtered}}';
        var enddate = '{{$enddate_filtered}}';
        var author = '{{$author_filtered}}';

        // Check if user is near bottom (200px buffer)
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200){
            page++;
            loadMoreData(page, key, startdate, enddate, author);
        }
    });

    function loadMoreData(page, key, startdate, enddate, author){
        $.ajax({
            url:'?page=' + page + '&keyword=' + key + '&startdate=' + startdate + '&enddate=' + enddate + '&author=' + author,
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
                if($('#content-data > a').length > 0) {
                    $('#no-more-data').show();
                }
                return;     
            }
            
            $('#content-data').append(data.html);
            
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