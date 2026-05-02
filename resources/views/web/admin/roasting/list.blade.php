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
                    <a href="{{url('roasting-add')}}" id="btn-float" class="shadow-sm">
                        <i class="fe fe-plus fs-30"></i>
                    </a>
                </div>
                <div class="card no-border shadow-none custom-square mb-0">
                    <div class="card-body px-4 py-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-left">
                                <h4 class="mb-1 font-weight-bold text-primary">Roasting</h4>
                                <p class="mb-0 text-muted">To Manage Roast Plan and Stock</p>
                            </div>
                            <div class="d-flex text-right">
                                <div class="mr-4">
                                    <h4 class="mb-0 text-center font-weight-bold text-gray">{{$contents_count}}</h4>
                                    <p class="text-dark text-center mb-0">data</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card no-border shadow-none custom-square mb-2">
                    <div class="card-body px-2 py-0">
                        <form id="search-form" class="mb-2" name="search-form" action="{{url('roasting-list')}}" method="GET">
                            <div class="d-flex">
                                <div class="p-2">
                                    <a role="button" class="btn btn-white" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fe fe-filter"></i>
                                        @if(!empty($startdate) || !empty($enddate) || !empty($status))
                                            <i class="fa fa-circle text-success" style="font-size:8px;vertical-align:top"></i>
                                        @endif
                                    </a>
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
                                <h5 class="mt-2">Filter Lanjutan</h5>
                                <div class="form-group row">
                                    <label class="col-md-3 col-sm-12 form-label">Rentang Tanggal</label>
                                    <div class="col-md-4 col-sm-6 mb-2">
                                        <input class="form-control form-control-sm fc-datepicker" name="startdate" value="{{$startdate}}" type="text" placeholder="Mulai">
                                    </div>
                                    <div class="col-md-4 col-sm-6 mb-2">
                                        <input class="form-control form-control-sm fc-datepicker" name="enddate" value="{{$enddate}}" type="text" placeholder="Selesai">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-sm-12 form-label">Status</label>
                                    <div class="col-md-9 col-sm-12">
                                        <select class="form-control form-control-sm filter-change" name="status">
                                            <option value="">Semua Status</option>
                                            <option value="Draft" @if($status == 'Draft') selected @endif>Draft</option>
                                            <option value="Publish" @if($status == 'Publish') selected @endif>Publish</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-sm-12 form-label">Urutan</label>
                                    <div class="col-md-9 col-sm-12">
                                        <select class="form-control form-control-sm filter-change" name="sort">
                                            <option value="terbaru" @if($sort == 'terbaru') selected @endif>Terbaru</option>
                                            <option value="terlama" @if($sort == 'terlama') selected @endif>Terlama</option>
                                            <option value="tertinggi" @if($sort == 'tertinggi') selected @endif>Qty Tertinggi</option>
                                            <option value="terendah" @if($sort == 'terendah') selected @endif>Qty Terendah</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 text-right mb-3">
                                        <button type="submit" class="btn btn-primary btn-sm px-4">Terapkan Filter</button>
                                        <a href="{{url('roasting-list')}}" class="btn btn-light btn-sm px-3">Reset</a>
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
                            @include('web.admin.roasting.paginate')
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
        var isLoading = false;
        var isEndOfData = false;

        $(window).on('scroll', function() {
            if (isLoading || isEndOfData) return;

            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 150) {
                loadMore();
            }
        });

        function loadMore() {
            if (isLoading || isEndOfData) return;
            
            page++;
            var key = '{{$keyword}}';
            var status = '{{$status}}';
            var sort = '{{$sort}}';
            var startdate = '{{$startdate}}';
            var enddate = '{{$enddate}}';
            
            $.ajax({
                url:'?page=' + page + '&keyword=' + key + '&status=' + status + '&sort=' + sort + '&startdate=' + startdate + '&enddate=' + enddate,
                type:'get',
                beforeSend: function(){
                    isLoading = true;
                    $('.ajax-load').fadeIn();
                }
            })
            .done(function(data){
                if(data.html.trim() == ""){
                    isEndOfData = true;
                    $('.ajax-load').html('<p class="text-muted fs-12 mt-2">— Akhir dari data —</p>');
                    return;     
                }
                $('.ajax-load').hide();
                $('#content-data').append(data.html);
                isLoading = false;
                
                // Auto check if still more space to scroll (rare case)
                if ($(window).height() >= $(document).height()) {
                    loadMore();
                }
            })
            .fail(function(){
                $('.ajax-load').html('<p class="text-danger fs-12 mt-2">Gagal memuat data, silakan coba lagi</p>');
                isLoading = false;
            });
        }
    </script>
</x-layouts.app>