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
                    @forelse($submissions as $submission)
                    <a href="{{ route('stock-submission-detail', ['app_id' => $submission->id]) }}" class="text-decoration-none">
                        <div class="card mb-3">
                            <div class="card-body p-2 row">
                                <div class="col-12 px-4">
                                    <div class="d-flex" style="vertical-align:middle">
                                        <h5 class="mb-0 font-weight-semibold fs-16 mr-2">{{ date('d M Y', strtotime($submission->date)) }}</h5>
                                        @php
                                            $badgeClass = '';
                                            switch($submission->status) {
                                                case 'Draft':
                                                    $badgeClass = 'badge-secondary';
                                                    break;
                                                case 'Menunggu Persetujuan':
                                                    $badgeClass = 'badge-warning';
                                                    break;
                                                case 'Disetujui':
                                                    $badgeClass = 'badge-success';
                                                    break;
                                                case 'Ditolak':
                                                    $badgeClass = 'badge-danger';
                                                    break;
                                                default:
                                                    $badgeClass = 'badge-secondary';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }} m-0 ml-auto px-2 py-1 fs-10" style="border-radius:4px">{{ $submission->status }}</span>
                                    </div>
                                    <label class="text-default p-0 mb-0 d-block mt-1 fs-14 h-40">{{ $submission->type }}</label>
                                    <div class="d-flex justify-content-between">
                                        <div class="text-muted m-0 fs-11" style="line-height:15px">Item : {{ $submission->items_count }}</div>
                                        <div class="text-muted m-0 fs-11" style="line-height:15px">Author :{{ $submission->author }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-5">
                        <i class="fe fe-inbox fs-40 text-muted"></i>
                        <p class="mt-3 text-muted">Belum ada pengajuan stok</p>
                        <a href="{{ route('stock-submission-add') }}" class="btn btn-primary">Buat Pengajuan Baru</a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="row px-3">
                <div class="col-12">
                    {{ $submissions->links() }}
                </div>
            </div>

            <div class="h-100h"></div>
        </div>
    </div>
</div>

</x-layouts.app>