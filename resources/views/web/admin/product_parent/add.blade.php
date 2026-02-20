<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('product-parent-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="product-parent-form" name="product-parent-form" action="{{url('product-parent-create')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" placeholder="Pilih Kategori">
                            <option value="">Pilih</option>
                            <option value="Green">Green</option>
                            <option value="Roasted Filter">Roasted Filter</option>
                            <option value="Roasted Espresso">Roasted Espresso</option>
                        </select>
                        @error('type') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="row">
                            <div class="col">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="status" id="status-active" value="Aktif" checked>
                                    <span class="custom-control-label">Aktif</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="status" id="status-inactive" value="Tidak Aktif">
                                    <span class="custom-control-label">Tidak Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-update" name="btn-update">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>