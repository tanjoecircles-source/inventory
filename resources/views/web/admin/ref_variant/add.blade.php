<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('variant-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="variant-form" name="variant-form" action="{{url('variant-create')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Tipe Produk</label>
                        <select class="form-control" name="product_type" id="product_type" placeholder="Pilih Tipe Produk">
                            <option value="" selected>Pilih Tipe Produk</option>
                            @foreach($product_type_list as $value)
                                @if(old('product_type') == $value->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                @else
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('product_type') <div class="text-primary fs-12">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Varian</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Cth: Varian G, Varian E, Exccees ...">
                        @error('name')<div class="text-primary fs-12">{{ $message }}</div>@enderror
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
