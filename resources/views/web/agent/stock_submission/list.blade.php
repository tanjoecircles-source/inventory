<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <a href="{{url('home')}}" class="d-flex align-items-center">
        <i class="fe fe-arrow-left fs-20 text-dark"></i>
    </a>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>

<div class="container">
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
                            type: "error",
                            position: "center"
                        });
                    });
                </script>
            @endif
            <!-- FAB Button -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('stock-submission-add') }}" id="btn-float" class="shadow-sm">
                    <i class="fe fe-plus fs-30"></i>
                </a>
            </div>
            <div class="row pt-4">
                <div class="col-12">
                    <h4 class="font-weight-bold mb-1">Pengajuan Stok Bahan</h4>
                    <p class="text-muted fs-13">Daftar Riwayat dan Status Pengajuan Stok Bahan Baku</p>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-12">
                    <form action="{{ route('stock-submission-list') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Author atau Status..." value="{{ $search ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fe fe-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Submissions -->
            <div class="row">
                <div class="col-12">
                    <div id="content-data">
                        @if($submissions->total() == 0)
                        <div class="text-center py-5">
                            <i class="fe fe-inbox fs-40 text-muted"></i>
                            <p class="mt-3 text-muted">Belum ada pengajuan stok</p>
                            <a href="{{ route('stock-submission-add') }}" class="btn btn-primary">Buat Pengajuan Baru</a>
                        </div>
                        @endif
                        @include('web.agent.stock_submission.paginate')
                    </div>
                </div>
            </div>

            <div class="ajax-load text-center" style="">
                <p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
            </div>

            <div class="h-100h"></div>
        </div>
    </div>
</div>
<script>
    var page = 1;
    var stopLoading = false;
    var isLoading = false;

    $(document).ready(function () {
        var count = parseInt("{{ $submissions->total() }}") || 0;
        var limit = parseInt("{{ $submissions->perPage() }}") || 10;
        if(count <= limit){
            $('.ajax-load').hide();
            stopLoading = true;
        }
    });

    $(window).scroll(function(){
        if (stopLoading || isLoading) return;
        var key = '{{ $search ?? '' }}';
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100){
            isLoading = true;
            page++;
            loadMoreData(page, key);
        }
    });

    function loadMoreData(page, key){
        isLoading = true;
        $.ajax({
            url: '?page=' + page + '&search=' + key,
            type: 'get',
            beforeSend: function(){
                $('.ajax-load').show();
            }
        })
        .done(function(data){
            if(data.html == undefined || data.html == "" || data.html.trim() == ""){
                $('.ajax-load').html("No more records found");
                $('.ajax-load').show();
                stopLoading = true;
                isLoading = false;
                return;
            }
            $('.ajax-load').hide();
            $('#content-data').append(data.html);
            isLoading = false;
        })
        .fail(function(jqXHR,ajaxOptions,thrownError){
            $('.ajax-load').html("server error");
            stopLoading = true;
            isLoading = false;
        });
    }
</script>
</x-layouts.app>
