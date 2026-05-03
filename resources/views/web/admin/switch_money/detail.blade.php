<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('switch-money-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
    <div class="container mb-7">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="card no-border custom-square shadow-none mt-4 mb-4">
                    <div class="card-body py-3 px-2">
                        <div class="d-flex align-items-start">
                            <div class="flex-grow-1">
                                <h4 class="font-weight-bold mb-1 text-dark">Rincian Transaksi</h4>
                                <a href="javascript:void(0)" class="text-primary font-weight-bold" data-toggle="modal" data-target="#modal-note">Lihat Catatan</a>
                                
                                @if($detail->status == 'Draft')
                                <div class="mt-2">
                                    <a href="{{url('switch-money-edit/'.$detail->id)}}" class="btn btn-outline-dark btn-sm mr-1 py-1 px-3">
                                        <i class="fe fe-edit"></i> Edit
                                    </a>
                                    <a href="{{url('switch-money-delete/'.$detail->id)}}" class="btn btn-outline-danger btn-sm btn-confirm py-1 px-3" data-title="Transaksi Utama">
                                        <i class="fe fe-trash"></i> Hapus
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-muted mb-1 font-weight-bold fs-13">{{ date('d M Y', strtotime($detail->date)) }}</p>
                                <div class="d-flex align-items-center justify-content-end">
                                    @if($detail->status == 'Published')
                                    <button class="btn btn-outline-dark btn-xs py-0 px-2 font-weight-bold" onclick="copyToClipboard()">
                                        <i class="fe fe-copy"></i>
                                    </button>
                                    @endif
                                    <span class="badge badge-{{ $detail->status == 'Published' ? 'success' : 'dark' }} ml-2 my-0">
                                        {{ $detail->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-5 text-center">
                        <div class="card mb-0 no-border custom-square">
                            <div class="card-body text-center p-4">
                                <span><i class="fe fe-briefcase fs-20 text-blue"></i></span>
                                <p class="text-muted fs-12 mb-1">Bank Asal</p>
                                <h6 class="font-weight-bold mb-0">{{ $detail->from_bank->name }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 text-center d-flex align-items-center justify-content-center">
                        <i class="fe fe-arrow-right fs-20"></i>
                    </div>
                    <div class="col-5 text-center">
                        <div class="card mb-0 no-border custom-square">
                            <div class="card-body text-center p-4">
                                <span><i class="fe fe-briefcase fs-20 text-orange"></i></span>
                                <p class="text-muted fs-12 mb-1">Bank Tujuan</p>
                                <h6 class="font-weight-bold mb-0">{{ $detail->to_bank->name }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="font-weight-bold mb-0">Transaksi Nasabah</h6>
                        </div>
                        @if($detail->status == 'Draft')
                        <div class="text-right">
                            <a href="{{url('switch-money-item-add/'.$detail->id)}}" class="btn btn-dark btn-sm btn-pill">
                                <i class="fe fe-plus-circle"></i> Tambah
                            </a>
                        </div>
                        @endif
                    </div>
                    </div>
                </div>
                <div class="card no-border shadow-none custom-square mt-2 mb-2">
                    <div class="card-body p-2">
                        {{-- USER TRANSACTIONS LIST (ADDITION) --}}
                        
                        <div class="overflow-hidden">
                            @forelse($detail->items->where('type', 'addition') as $item)
                            <div class="d-flex align-items-center py-2 px-0 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 font-weight-bold">{{ $item->user_name }}</h6>
                                    <p class="mb-0 text-muted fs-11">{{ date('d/m/Y', strtotime($item->date)) }}</p>
                                </div>
                                <div class="text-right ml-3">
                                    <p class="mb-0 font-weight-bold">+ Rp {{ number_format($item->amount, 0, ',', '.') }}</p>
                                    @if($detail->status == 'Draft')
                                    <a href="{{url('switch-money-item-delete/'.$item->id)}}" class="text-danger fs-11 btn-confirm" data-title="Item {{ $item->user_name }}">Hapus</a>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="p-3 text-center">
                                <p class="text-muted mb-0 fs-12">Belum ada data penambahan</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex align-items-center mb-0">
                            <div class="flex-grow-1">
                                <h6 class="font-weight-bold mb-0">Transaksi Pengurangan</h6>
                            </div>
                            @if($detail->status == 'Draft')
                            <div class="text-right">
                                <a href="{{url('switch-money-item-deduction-add/'.$detail->id)}}" class="btn btn-dark btn-sm btn-pill">
                                    <i class="fe fe-plus-circle"></i> Tambah
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card no-border shadow-none custom-square my-2">
                    <div class="card-body p-2">

                        {{-- DEDUCTION LIST --}}
                        <div class="overflow-hidden">
                            @forelse($detail->items->where('type', 'deduction') as $item)
                            <div class="d-flex align-items-center py-2 px-0 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 font-weight-bold">{{ $item->user_name }}</h6>
                                    <p class="mb-0 text-muted fs-11">{{ date('d/m/Y', strtotime($item->date)) }}</p>
                                </div>
                                <div class="text-right ml-3">
                                    <p class="mb-0 font-weight-bold">- Rp {{ number_format($item->amount, 0, ',', '.') }}</p>
                                    @if($detail->status == 'Draft')
                                    <a href="{{url('switch-money-item-delete/'.$item->id)}}" class="text-danger fs-11 btn-confirm" data-title="Item {{ $item->user_name }}">Hapus</a>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="p-3 text-center">
                                <p class="text-muted mb-0 fs-12">Tidak ada data pengurangan</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="card no-border shadow-none custom-square my-2">
                    <div class="card-body p-2">
                        <div class="d-flex mb-1">
                            <div class="mr-auto text-muted">Total Transaksi Nasabah</div>
                            <div class="ml-auto font-weight-bold text-success">Rp {{ number_format($detail->items->where('type', 'addition')->sum('amount'), 0, ',', '.') }}</div>
                        </div>
                        <div class="d-flex mb-1">
                            <div class="mr-auto text-muted">Total Transaksi Pengurangan</div>
                            <div class="ml-auto font-weight-bold text-danger">Rp {{ number_format($detail->items->where('type', 'deduction')->sum('amount'), 0, ',', '.') }}</div>
                        </div>
                        <hr class="my-2">
                            <div class="d-flex">
                            <div class="mr-auto font-weight-bold fs-15">Saldo Pindah Dana</div>
                            <div class="ml-auto font-weight-bold fs-15">Rp {{ number_format($detail->total, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                @if($detail->status == 'Draft' && !$detail->items->isEmpty())
                <div class="mt-4">
                    <a href="{{url('switch-money-publish/'.$detail->id)}}" class="btn btn-primary btn-block py-2 font-weight-bold shadow-sm btn-confirm" data-title="Publikasikan transaksi ini?">
                        Publish
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <i class="fe fe-alert-circle fs-50 text-warning mb-3 d-block"></i>
                    <h5 class="font-weight-bold" id="confirm-title">Apakah anda yakin?</h5>
                    <p class="text-muted" id="confirm-body">Data yang sudah dipublikasikan tidak dapat diubah kembali.</p>
                    <div class="mt-4">
                        <button type="button" class="btn btn-light mr-2 px-4" data-dismiss="modal">Batal</button>
                        <a href="#" class="btn btn-dark px-4" id="confirm-action">Ya, Lanjutkan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Note -->
    <div class="modal fade" id="modal-note" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Catatan Header</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="p-3 bg-light rounded text-dark fs-14">
                        {{ $detail->note ?? 'Tidak ada catatan.' }}
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark px-4" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.btn-confirm', function(e){
            e.preventDefault();
            var title = $(this).data('title');
            var url = $(this).attr('href');
            
            if(url.indexOf('delete') !== -1) {
                $('#confirm-title').text('Hapus ' + title + '?');
                $('#confirm-body').text('Data ini akan dihapus secara permanen.');
            } else {
                $('#confirm-title').text('Publikasikan Transaksi?');
                $('#confirm-body').text('Data yang sudah dipublikasikan tidak dapat diubah kembali.');
            }
            
            $('#confirm-action').attr('href', url);
            $('#modal-confirm').modal('show');
        });

        function copyToClipboard() {
            var text = "*TANJOE COFFEE - PINDAH DANA*\n";
            text += "Tanggal: {{ date('d F Y', strtotime($detail->date)) }}\n";
            text += "Alur: {{ $detail->from_bank->name }} -> {{ $detail->to_bank->name }}\n\n";

            text += "*PENAMBAHAN (USER):*\n";
            @foreach($detail->items->where('type', 'addition') as $item)
            text += "- {{ $item->user_name }}: Rp {{ number_format($item->amount, 0, ',', '.') }}\n";
            @endforeach
            text += "Subtotal: Rp {{ number_format($detail->items->where('type', 'addition')->sum('amount'), 0, ',', '.') }}\n\n";

            @if($detail->items->where('type', 'deduction')->count() > 0)
            text += "*PENGURANGAN:*\n";
            @foreach($detail->items->where('type', 'deduction') as $item)
            text += "- {{ $item->user_name }}: Rp {{ number_format($item->amount, 0, ',', '.') }}\n";
            @endforeach
            text += "Subtotal: Rp {{ number_format($detail->items->where('type', 'deduction')->sum('amount'), 0, ',', '.') }}\n\n";
            @endif

            text += "*SALDO PINDAH DANA: Rp {{ number_format($detail->total, 0, ',', '.') }}*\n";
            @if($detail->note)
            text += "\nCatatan: {{ $detail->note }}";
            @endif

            var tempInput = document.createElement("textarea");
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);

            if(typeof notif === 'function') {
                notif({
                    msg: "Rincian teks berhasil disalin!",
                    type: "success",
                    position: "center"
                });
            } else {
                alert("Rincian teks berhasil disalin!");
            }
        }
    </script>
</x-layouts.app>
