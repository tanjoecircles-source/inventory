<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <a href="{{url('stock-submission-list')}}" class="d-flex align-items-center">
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

            <div class="row pt-4">
                <div class="col-12">
                    <h4 class="font-weight-bold mb-1">Detail Pengajuan Stok</h4>
                </div>
            </div>

            <!-- Status Card -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
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
                                    <span class="badge {{ $badgeClass }}">{{ $submission->status }}</span>
                                </div>
                                <small class="text-muted">{{ date('d M Y', strtotime($submission->created_at)) }}</small>
                            </div>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted d-block">Diajukan Oleh</small>
                                    <span class="font-weight-bold">{{ $submission->author }}</span>
                                </div>
                                <div class="col-6 text-right">
                                    <small class="text-muted d-block">Total Item</small>
                                    <span class="font-weight-bold">{{ $submission->items->count() }} Items</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Jenis</small>
                                    <span class="font-weight-bold">{{ $submission->type }}</span>
                                </div>
                                <div class="col-6 text-right">
                                    <small class="text-muted d-block">Tanggal</small>
                                    <span class="font-weight-bold">{{ date('d M Y', strtotime($submission->date)) }}</span>
                                </div>
                            </div>
                            @if($submission->submitted_at)
                            <div class="mt-2">
                                <small class="text-muted d-block">Diajukan Pada</small>
                                <span>{{ date('d M Y H:i', strtotime($submission->submitted_at)) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items List -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold">Daftar Item</h5>
                        @if($submission->status == 'Draft')
                        <a href="{{ route('stock-submission-item-add', ['app_id' => $submission->id]) }}" class="btn btn-sm btn-dark btn-pill">
                            <i class="fe fe-plus"></i> Tambah
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card text-center no-border shadow-none custom-square mb-2">
                <div class="card-body p-0">
                    @forelse($submission->items as $item)
                    <div class="card-body px-2 py-2 border-bottom">
                        <div class="d-flex title-bar">
                            <div class="mr-auto text-left">
                                <p class="mb-1">{{ $item->product_name }}</p>
                            </div>
                            <div class="ml-auto text-right">
                                <p class="text-muted mb-2">{{ $item->quantity }} {{ $item->unit }}</p>
                                @if($submission->status == 'Draft')
                                    <a href="{{ route('stock-submission-item-delete', ['app_id' => $submission->id, 'item_id' => $item->id]) }}" 
                                    class="btn btn-sm btn-danger ml-2"
                                    onclick="return confirm('Yakin ingin menghapus item ini?')">
                                        <i class="fe fe-trash-2"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fe fe-inbox fs-30 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada item. Silakan tambah item terlebih dahulu.</p>
                        
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-3">
                <div class="col-12">
                    @if($submission->status == 'Draft')
                        @if($submission->items->count() > 0)
                        <a href="{{ route('stock-submission-submit', ['app_id' => $submission->id]) }}" 
                           class="btn btn-dark btn-block"
                           onclick="return confirm('Yakin ingin mengajukan pengajuan ini?')">
                            <i class="fe fe-send"></i> Ajukan Pengajuan
                        </a>
                        @endif
                        <a href="{{ route('stock-submission-delete', ['app_id' => $submission->id]) }}" 
                           class="btn btn-danger btn-block mt-2"
                           onclick="return confirm('Yakin ingin menghapus pengajuan ini?')">
                            <i class="fe fe-trash-2"></i> Hapus Pengajuan
                        </a>
                    @endif

                    @if($submission->status == 'Menunggu Persetujuan')
                    <div class="alert alert-warning">
                        <i class="fe fe-clock"></i> Pengajuan sedang menunggu persetujuan dari admin.
                    </div>
                    @endif

                    @if($submission->status == 'Disetujui')
                    <div class="alert alert-success">
                        <i class="fe fe-check-circle"></i> Pengajuan telah disetujui.
                    </div>
                    @endif

                    @if($submission->status == 'Ditolak')
                    <div class="alert alert-danger">
                        <i class="fe fe-x-circle"></i> Pengajuan ditolak.
                    </div>
                    @endif
                </div>
            </div>

            <div class="h-100h"></div>
        </div>
    </div>
</div>

</x-layouts.app>