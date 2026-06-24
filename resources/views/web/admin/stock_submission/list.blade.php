<x-layouts.app>
<x-header-white-3column back="&nbsp;">
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
                        notif({ msg: "{{ session('success') }}", type: "success", position: "center" });
                    });
                </script>
            @endif
            @if(session()->has('danger'))
                <script>
                    $(function () {
                        notif({ msg: "{{ session('danger') }}", type: "error", position: "center" });
                    });
                </script>
            @endif

            <div class="row pt-4">
                <div class="col-12">
                    <h4 class="font-weight-bold mb-1">Approval Pengajuan Stok</h4>
                    <p class="text-muted fs-13">Kelola dan setujui pengajuan stok dari agen</p>
                </div>
            </div>

            <!-- Filter Status -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin-stock-submission-list') }}" class="btn btn-sm {{ !$filter_status ? 'btn-dark' : 'btn-outline-dark' }} mr-2">Semua</a>
                        <a href="{{ route('admin-stock-submission-list', ['status' => 'Menunggu Persetujuan']) }}" class="btn btn-sm {{ $filter_status == 'Menunggu Persetujuan' ? 'btn-warning' : 'btn-outline-warning' }}  mr-2 fs-11">Menunggu</a>
                        <a href="{{ route('admin-stock-submission-list', ['status' => 'Disetujui']) }}" class="btn btn-sm {{ $filter_status == 'Disetujui' ? 'btn-success' : 'btn-outline-success' }}  mr-2 fs-11">Disetujui</a>
                        <a href="{{ route('admin-stock-submission-list', ['status' => 'Ditolak']) }}" class="btn btn-sm {{ $filter_status == 'Ditolak' ? 'btn-danger' : 'btn-outline-danger' }}  mr-2 fs-11">Ditolak</a>
                        <a href="{{ route('admin-stock-submission-list', ['status' => 'Draft']) }}" class="btn btn-sm {{ $filter_status == 'Draft' ? 'btn-secondary' : 'btn-outline-secondary' }} mr-2 fs-11">Draft</a>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="row mb-3">
                <div class="col-12">
                    <form action="{{ route('admin-stock-submission-list') }}" method="GET">
                        @if($filter_status)
                        <input type="hidden" name="status" value="{{ $filter_status }}">
                        @endif
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari Author atau Jenis..." value="{{ $search ?? '' }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="fe fe-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List -->
            <div class="row">
                <div class="col-12">
                    <div id="content-data">
                        @if($submissions->total() == 0)
                        <div class="text-center py-5">
                            <i class="fe fe-inbox fs-40 text-muted"></i>
                            <p class="mt-3 text-muted">Tidak ada pengajuan stok</p>
                        </div>
                        @endif
                        @include('web.admin.stock_submission.paginate')
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
        var status = '{{ $filter_status ?? '' }}';
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100){
            isLoading = true;
            page++;
            loadMoreData(page, key, status);
        }
    });

    function loadMoreData(page, key, status){
        isLoading = true;
        $.ajax({
            url: '?page=' + page + '&search=' + key + '&status=' + status,
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
