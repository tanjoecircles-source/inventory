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

            <!-- Form Filter Kategori & Berat Satuan -->
            <div class="card mt-2 mb-2 shadow-none border">
                <div class="card-body p-2">
                    <form id="product-filter-form" action="{{ url('product-list') }}" method="GET">
                        @if(!empty($keyword))
                            <input type="hidden" name="keyword" value="{{ $keyword }}">
                        @endif
                        <div class="row">
                            <div class="col-6 pr-1">
                                <label class="form-label text-muted fs-11 mb-1 font-weight-bold">
                                    <i class="fe fe-filter mr-1"></i>Filter Data
                                </label>
                                <select name="type" id="filter-type" class="form-control">
                                    <option value="">Semua Kategori</option>
                                    @foreach($type_list as $t)
                                        <option value="{{ $t->id }}" {{ $filter_type == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 pl-1">
                                <label class="form-label text-muted fs-11 mb-1 font-weight-bold">
                                    &nbsp;
                                </label>
                                <select name="satuan" id="filter-satuan" class="form-control">
                                    <option value="">Semua Berat</option>
                                    @foreach($satuan_list as $s)
                                        <option value="{{ $s->id }}" {{ $filter_satuan == $s->id ? 'selected' : '' }}>
                                            {{ $s->name }} gr
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(!empty($filter_type) || !empty($filter_satuan))
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                <span class="text-muted fs-11">
                                    <i class="fe fe-filter text-primary mr-1"></i>Filter Aktif: 
                                    @if(!empty($filter_type))
                                        <span class="badge badge-light border text-dark">{{ $type_list->firstWhere('id', $filter_type)->name ?? 'Kategori' }}</span>
                                    @endif
                                    @if(!empty($filter_satuan))
                                        <span class="badge badge-light border text-dark">{{ ($satuan_list->firstWhere('id', $filter_satuan)->name ?? '') }} gr</span>
                                    @endif
                                </span>
                                <a href="{{ url('product-list?clear=true') }}" class="btn btn-link text-danger p-0 fs-11 font-weight-semibold">
                                    <i class="fe fe-x-circle mr-1"></i>Reset
                                </a>
                            </div>
                        @endif
                    </form>
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
    var account = "{{$account_status}}";
    var count = parseInt("{{$contents_count}}") || 0;
    var limit = parseInt("{{$limit}}") || 10;
    var page = 1;
    var isLoading = false;
    var isEndOfData = false;
    var key = @json($keyword);
    var filterType = @json($filter_type);
    var filterSatuan = @json($filter_satuan);

    $(document).ready(function () {
        if(count <= limit){
            isEndOfData = true;
            $('.ajax-load').hide();
        }

        // Auto filter on dropdown change
        $('#filter-type, #filter-satuan').on('change', function() {
            $('#product-filter-form').submit();
        });
    });

    $(window).on('scroll', function() {
        if (isLoading || isEndOfData) return;

        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 150) {
            loadMore();
        }
    });

    function loadMore() {
        if (isLoading || isEndOfData) return;
        
        page++;
        
        $.ajax({
            url: '{{ route("product-list") }}',
            data: { 
                page: page, 
                keyword: key,
                type: filterType,
                satuan: filterSatuan
            },
            type: 'get',
            beforeSend: function(){
                isLoading = true;
                $('.ajax-load').fadeIn();
            }
        })
        .done(function(data){
            if(!data.html || data.html.trim() == ""){
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