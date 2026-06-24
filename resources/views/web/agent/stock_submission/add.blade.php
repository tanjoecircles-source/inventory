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
            <div class="row pt-4">
                <div class="col-12">
                    <h4 class="font-weight-bold mb-1">Buat Pengajuan Stok</h4>
                    <p class="text-muted fs-13">Isi informasi dasar untuk membuat draft pengajuan</p>
                </div>
            </div>

            <form action="{{ route('stock-submission-create') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="font-weight-bold">Tanggal</label>
                                    <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">Jenis</label>
                                    <select name="type" class="form-control" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="Roasted Filter">Roasted Filter</option>
                                        <option value="Roasted Espresso">Roasted Espresso</option>
                                        <option value="Bahan Lainnya">Bahan Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="fe fe-file-text"></i> Buat Draft Pengajuan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="h-100h"></div>
        </div>
    </div>
</div>

</x-layouts.app>