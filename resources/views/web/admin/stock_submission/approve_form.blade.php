<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <a href="{{ route('admin-stock-submission-detail', ['app_id' => $submission->id]) }}" class="d-flex align-items-center">
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
            <div class="row pt-4">
                <div class="col-12">
                    <h4 class="font-weight-bold mb-1">Setujui Pengajuan Stok</h4>
                    <p class="text-muted fs-13">Pilih daftar belanja toko tujuan untuk item pengajuan</p>
                </div>
            </div>

            <!-- Info Pengajuan -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 font-weight-bold">Informasi Pengajuan</h6>
                                <span class="badge badge-warning">{{ $submission->status }}</span>
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

                            <!-- Daftar Item -->
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Item yang akan ditambahkan:</small>
                                @foreach($submission->items as $item)
                                <div class="d-flex justify-content-between border-bottom py-1">
                                    <span>{{ $item->product_name }}</span>
                                    <span class="font-weight-bold">{{ $item->quantity }} {{ $item->unit }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pilih Store Purchasing -->
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('admin-stock-submission-approve-process', ['app_id' => $submission->id]) }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body p-4">
                                <h6 class="font-weight-bold mb-3">Pilih Daftar Belanja Toko</h6>
                                
                                @if($store_purchasing->count() > 0)
                                <div class="form-group">
                                    <select name="store_purchasing_id" class="form-control" required>
                                        <option value="">-- Pilih Belanja Toko --</option>
                                        @foreach($store_purchasing as $sp)
                                        <option value="{{ $sp->id }}">
                                            [{{ $sp->pur_code }}] {{ date('d M Y', strtotime($sp->pur_date)) }} - {{ $sp->vendor_name ?? 'Tanpa Vendor' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fe fe-check-circle"></i> Konfirmasi Setujui & Pindahkan Item
                                </button>
                                @else
                                <div class="alert alert-warning">
                                    <i class="fe fe-alert-triangle"></i> Tidak ada daftar belanja toko dengan status Draft. 
                                    <a href="{{ url('store-purchasing-add') }}" class="btn btn-sm btn-primary mt-2">Buat Belanja Toko Baru</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="h-100h"></div>
        </div>
    </div>
</div>

</x-layouts.app>