<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('product-type-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="product-type-form" name="product-type-form" action="{{url('product-type-update/'.$id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Merek/Brand</label>
                        <select class="form-control" name="brand" id="brand" placeholder="Pilih Brand">
                            <option value="" selected>Pilih Brand</option>
                            @foreach($brand_list as $value)
                                @if($brand == $value->id)
                                    <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                @else
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('brand') <div class="text-primary fs-12">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tipe Produk</label>
                        <input type="text" class="form-control" name="name" value="{{$name}}" placeholder="Cth: Avanza, Xenia, Brio, Jazz ...">
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