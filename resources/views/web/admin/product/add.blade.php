<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('product-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="bg-white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <form id="product-form" name="product-form" action="{{url('product-create')}}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="card no-border shadow-none custom-square mb-3">
                    <div class="card-body px-2">
                        <div class="form-group">
                            <h5>Informasi Produk</h5>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kategori</label>
                            <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" placeholder="Pilih Kategori">
                                <option value="">Pilih Kategori</option>
                                @foreach($type_list as $value)
                                    <option value="{{ $value->id }}" @if(old('type') == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('type') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Group</label>
                            <select class="form-control @error('product_parent') is-invalid @enderror" name="product_parent" id="product_parent" placeholder="Pilih Group">
                                @foreach($parent_list as $value)
                                    @if(old('product_parent') == $value->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('product_parent') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Masukan Judul (Merek, Tipe, Variant, Tahun)">
                            @error('name')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" id="category" value="{{old('category')}}" placeholder="Category">
                            @error('category')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Origin</label>
                            <input type="text" class="form-control" name="origin" id="origin" value="{{old('origin')}}" placeholder="Origin">
                            @error('origin')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Elevation</label>
                            <input type="text" class="form-control" name="elevation" id="elevation" value="{{old('elevation')}}" placeholder="Elevation">
                            @error('elevation')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Varietal</label>
                            <input type="text" class="form-control" name="varietal" id="varietal" value="{{old('varietal')}}" placeholder="Varietal">
                            @error('varietal')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Process</label>
                            <input type="text" class="form-control" name="process" id="process" value="{{old('process')}}" placeholder="Process">
                            @error('process')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Processor</label>
                            <input type="text" class="form-control" name="processor" id="processor" value="{{old('processor')}}" placeholder="Processor">
                            @error('processor')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harvest</label>
                            <input type="text" class="form-control" name="harvest" id="harvest" value="{{old('harvest')}}" placeholder="Harvest">
                            @error('harvest')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tasting Notes</label>
                            <input type="text" class="form-control" name="tasting_notes" id="tasting_notes" value="{{old('tasting_notes')}}" placeholder="Tasting Notes">
                            @error('tasting_notes')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Berat Satuan (Gram)</label>
                            <select class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="satuan" placeholder="Pilih Berat Satuan">
                                <option value="">Pilih Berat Satuan</option>
                                @foreach($satuan_list as $value)
                                    <option value="{{ $value->id }}" @if(old('satuan') == $value->id) selected @endif>{{ $value->name }}</option>
                                @endforeach
                            </select>
                            @error('satuan') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Harga</label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon fs-15">Rp</span>
                                <input type="text" class="form-control masked" name="price" id="price" value="{{ old('price') }}">
                            </div>
                            @error('price')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group d-none" id="price-grosir-15">
                            <label class="form-label">Harga <span id="grosir-15" class="d-none"> Grosir >15kg</span><span id="bundling" class="d-none"> Bundling (Min 2Pcs)</span> </label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon fs-15">Rp</span>
                                <input type="text" class="form-control masked" name="price_grosir15" id="price_grosir15" value="{{ old('price_grosir15') }}">
                            </div>
                            @error('price_grosir15')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group d-none" id="price-grosir-50">
                            <label class="form-label">Harga Grosir >50kg </label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon fs-15">Rp</span>
                                <input type="text" class="form-control masked" name="price_grosir50" id="price_grosir50" value="{{ old('price_grosir50') }}">
                            </div>
                            @error('price_grosir50')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock</label>
                            <input type="text" class="form-control" name="stock" id="stock" value="{{ old('stock') }}">
                            @error('stock')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">HPP</label>
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon fs-15">Rp</span>
                                <input type="text" class="form-control masked" name="price_hpp" id="price_hpp" value="{{ old('price_hpp') }}">
                            </div>
                            @error('price_hpp')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Deskripsi Unit</label>
                            <textarea class="form-control" name="summary" placeholder="Tulis Deskripsi" rows="6">{{ old('summary') }}</textarea>
                            @error('summary')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="row">
                                <div class="col">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="status" id="Active" value="Active" checked>
                                        <span class="custom-control-label">Aktif</span>
                                    </label>
                                </div>
                                <div class="col">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="status" id="Inactive" value="Inactive">
                                        <span class="custom-control-label">Tidak Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card text-center no-border shadow-none custom-square mb-7">
                    <div class="card-body py-0 px-2">
                        <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-add" name="btn-add">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
 $(document).ready(function () {
    $('.masked').inputmask({
        rightAlign:false,
        radixPoint: ',',
        groupSeparator: ".",
        alias: "numeric",
        autoGroup: true,
        digits: 0
    });

    $('#product_parent').select2({
        "ajax" : {
            "url" : "{{url('product-parent-combo-all')}}",
            "type" : "POST",
            "dataType" : "json",
            "data": function (params) {
                var query = {
                    _token: "{{ csrf_token() }}",
                    search: params.term,
                    type: "public"
                }
                return query;
            }
        },
        placeholder: 'Cari Product',
    });

    $("#type").on('change', function(e) {
        var type = $(this).val();
        if(type == 1){
            $("#price-grosir-15").removeClass('d-none');
            $("#bundling").addClass('d-none');
            $("#grosir-15").removeClass('d-none');
            $("#price-grosir-50").removeClass('d-none');
        }else if(type == 2 || type == 3){
            $("#price-grosir-15").removeClass('d-none');
            $("#bundling").removeClass('d-none');
            $("#grosir-15").addClass('d-none');
            $("#price-grosir-50").addClass('d-none');
        }else{
            $("#price-grosir-15").addClass('d-none');
            $("#bundling").addClass('d-none');
            $("#grosir-15").addClass('d-none');
            $("#price-grosir-50").addClass('d-none');
        }
    });
});
</script>
</x-layouts.app>