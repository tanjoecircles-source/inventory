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
                    @forelse($submissions as $submission)
                    <a href="{{ route('admin-stock-submission-detail', ['app_id' => $submission->id]) }}" class="text-decoration-none">
                        <div class="card mb-3">
                            <div class="card-body p-2 row">
                                <div class="col-12 px-4">
                                    <div class="d-flex" style="vertical-align:middle">
                                        <h5 class="mb-0 font-weight-semibold fs-16 mr-2">{{ date('d M Y', strtotime($submission->date)) }}</h5>
                                        @php
                                            $badgeClass = '';
                                            switch($submission->status) {
                                                case 'Draft': $badgeClass = 'badge-secondary'; break;
                                                case 'Menunggu Persetujuan': $badgeClass = 'badge-warning'; break;
                                                case 'Disetujui': $badgeClass = 'badge-success'; break;
                                                case 'Ditolak': $badgeClass = 'badge-danger'; break;
                                                default: $badgeClass = 'badge-secondary';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }} m-0 ml-auto px-2 py-1 fs-10" style="border-radius:4px">{{ $submission->status }}</span>
                                    </div>
                                    <label class="text-default p-0 mb-0 d-block mt-1 fs-14 h-40">{{ $submission->type }}</label>
                                    <div class="d-flex justify-content-between">
                                        <div class="text-muted m-0 fs-11" style="line-height:15px">Item : {{ $submission->items_count }}</div>
                                        <div class="text-muted m-0 fs-11" style="line-height:15px">{{ $submission->author }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-5">
                        <i class="fe fe-inbox fs-40 text-muted"></i>
                        <p class="mt-3 text-muted">Tidak ada pengajuan stok</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="row">
                <div class="col-12">
                    {{ $submissions->appends(request()->query())->links() }}
                </div>
            </div>

            <div class="h-100h"></div>
        </div>
    </div>
</div>

</x-layouts.app>