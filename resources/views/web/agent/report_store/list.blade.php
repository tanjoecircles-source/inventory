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
                    <a href="{{url('report-store-add')}}" id="btn-float" class="shadow-sm">
                        <i class="fe fe-plus fs-30"></i>
                    </a>
                </div>
                <div class="card no-border shadow-none custom-square mb-0">
                    <div class="card-body px-2 py-3">
                        <div class="card-custom-icon text-center">
                            <h4 class="mb-0 font-weight-bold text-gray">{{$contents_count}}</h4>
                            <p class="text-dark">data</p>
                        </div>
                        <h4 class="mb-1 font-weight-bold text-primary">Laporan Kas Harian</h4>
                        <span class="mb-1 text-muted">To manage store daily cash report</span>
                    </div>
                </div>
                <div class="card text-center no-border shadow-none custom-square mb-2">
                    <div class="card-body px-2 py-0">
                        <form id="search-form" class="mb-2" name="search-form" action="{{url('report-store')}}" method="GET">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-dark br-7 mr-2" data-toggle="collapse" data-target="#filterBox">
                                        <i class="fe fe-filter"></i>
                                    </button>
                                </div>
                                <input type="text" name="keyword" value="{{$keyword}}" class="form-control br-7" placeholder="Type Keyword...">
                                <div class="input-group-append ">
                                    <button type="submit" class="btn btn-primary br-7 ml-2">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="collapse {{ ($status != 'all' || $employee_id != 'all' || $date_start != '' || $date_end != '' || $sort != 'date_desc') ? 'show' : '' }}" id="filterBox">
                                <div class="row text-left">
                                    <div class="col-6 mb-2">
                                        <label class="fs-12 mb-1">Personil</label>
                                        <select name="employee_id" class="form-control form-control-sm">
                                            <option value="all">Semua</option>
                                            @foreach($employees as $emp)
                                                <option value="{{$emp->id}}" {{ $employee_id == $emp->id ? 'selected' : '' }}>{{$emp->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label class="fs-12 mb-1">Status</label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua</option>
                                            <option value="draft" {{ $status == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="reported" {{ $status == 'reported' ? 'selected' : '' }}>Reported</option>
                                            <option value="verified" {{ $status == 'verified' ? 'selected' : '' }}>Verified</option>
                                        </select>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label class="fs-12 mb-1">Mulai Tanggal</label>
                                        <input type="text" name="date_start" value="{{$date_start}}" class="form-control form-control-sm fc-datepicker" placeholder="dd-mm-yyyy">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label class="fs-12 mb-1">Sampai Tanggal</label>
                                        <input type="text" name="date_end" value="{{$date_end}}" class="form-control form-control-sm fc-datepicker" placeholder="dd-mm-yyyy">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="fs-12 mb-1">Urutkan Berdasarkan</label>
                                        <select name="sort" class="form-control form-control-sm">
                                            <option value="date_desc" {{ $sort == 'date_desc' ? 'selected' : '' }}>Tanggal Terbaru</option>
                                            <option value="date_asc" {{ $sort == 'date_asc' ? 'selected' : '' }}>Tanggal Terlama</option>
                                            <option value="total_desc" {{ $sort == 'total_desc' ? 'selected' : '' }}>Nominal Terbesar</option>
                                            <option value="total_asc" {{ $sort == 'total_asc' ? 'selected' : '' }}>Nominal Terkecil</option>
                                        </select>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <button type="submit" class="btn btn-primary btn-block btn-sm">Terapkan Filter</button>
                                        <a href="{{url('report-store')}}" class="btn btn-light btn-block btn-sm">Reset</a>
                                    </div>
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
                            @include('web.agent.report_store.paginate')
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

            $('.fc-datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true,
                dateFormat: 'dd-mm-yy'
            });
        });
        
        var page = 1;
        var loading = false;
        var hasMore = true;

        $(window).scroll(function(){
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100){
                if(!loading && hasMore){
                    page++;
                    loadMoreData(page);
                }
            }
        });
    
        function loadMoreData(page){
            var key = '{{$keyword}}';
            var status = '{{$status}}';
            var emp = '{{$employee_id}}';
            var start = '{{$date_start}}';
            var end = '{{$date_end}}';
            var sort = '{{$sort}}';

            $.ajax({
                url:'?page=' + page + '&keyword=' + key + '&status=' + status + '&employee_id=' + emp + '&date_start=' + start + '&date_end=' + end + '&sort=' + sort,
                type:'get',
                beforeSend: function(){
                    loading = true;
                    $('.ajax-load').show();
                }
            })
            .done(function(data){
                loading = false;
                if(data.html == "" || data.html == undefined){
                    hasMore = false;
                    $('.ajax-load').html("No more records found");
                    $('.ajax-load').show();
                    return;     
                }
                $('.ajax-load').hide();
                $('#content-data').append(data.html);
            })
            .fail(function(jqXHR,ajaxOptions,thrownError){
                loading = false;
                $('.ajax-load').html("server error");
            });
        }
    </script>
    </x-layouts.app>