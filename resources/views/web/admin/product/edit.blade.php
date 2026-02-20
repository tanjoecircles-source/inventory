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
                    <form id="product-form" name="product-form" action="{{url('product-update/'.$id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="card no-border shadow-none custom-square mb-3">
                        <div class="card-body px-2">
                            <div class="form-group">
                                <h5>Informasi Produk</h5>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Kategori</label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type" id="type" placeholder="Pilih Kategori">
                                    <option value="">Pilih</option>
                                    @foreach($type_list as $value)
                                        <option value="{{ $value->id }}" @if($detail->type == $value->id) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('type') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Group</label>
                                <select class="form-control @error('product_parent') is-invalid @enderror" name="product_parent" id="product_parent" placeholder="Pilih Group">
                                    @foreach($parent_list as $value)
                                        @if($detail->group == $value->id)
                                            <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('product_parent') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{$detail->name}}" placeholder="Masukan Judul Produk">
                                @error('name')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Produk Pricelist</label>
                                <input type="text" class="form-control" name="name_pl" id="name_pl" value="{{$detail->name_pl}}" placeholder="Masukan Judul Produk">
                                @error('name_pl')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <input type="text" class="form-control" name="category" id="category" value="{{$detail->category}}" placeholder="Category">
                                @error('category')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Origin</label>
                                <input type="text" class="form-control" name="origin" id="origin" value="{{$detail->origin}}" placeholder="Origin">
                                @error('origin')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Elevation</label>
                                <input type="text" class="form-control" name="elevation" id="elevation" value="{{$detail->elevation}}" placeholder="Elevation">
                                @error('elevation')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Varietal</label>
                                <input type="text" class="form-control" name="varietal" id="varietal" value="{{$detail->varietal}}" placeholder="Varietal">
                                @error('varietal')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Process</label>
                                <input type="text" class="form-control" name="process" id="process" value="{{$detail->process}}" placeholder="Process">
                                @error('process')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Processor</label>
                                <input type="text" class="form-control" name="processor" id="processor" value="{{$detail->processor}}" placeholder="Processor">
                                @error('processor')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harvest</label>
                                <input type="text" class="form-control" name="harvest" id="harvest" value="{{$detail->harvest}}" placeholder="Harvest">
                                @error('harvest')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Berat Satuan (Gram)</label>
                                <select class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="satuan" placeholder="Pilih Berat Satuan">
                                    <option value="">Pilih</option>
                                    @foreach($satuan_list as $value)
                                        <option value="{{ $value->id }}" @if($detail->satuan == $value->id) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                </select>
                                @error('satuan') <div class="text-primary fs-11">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="price" id="price" value="{{$detail->price}}" @if(Auth::user()->id != 1 && Auth::user()->id != 3) readonly @endif >
                                </div>
                                @error('price')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            @if($detail->type == '1' || $detail->type == '2' || $detail->type == '3')
                            <div class="form-group">
                                <label class="form-label">Harga @if($detail->type == '1') Grosir >15kg @else Bundling Min 2Pcs @endif </label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="price_grosir15" id="price_grosir15" value="{{$detail->price_grosir15}}" @if(Auth::user()->id != 1 && Auth::user()->id != 3) readonly @endif >
                                </div>
                                @error('price_grosir15')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            @endif
                            @if($detail->type == '1')
                            <div class="form-group">
                                <label class="form-label">Harga Grosir >50kg </label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="price_grosir50" id="price_grosir50" value="{{$detail->price_grosir50}}" @if(Auth::user()->id != 1 && Auth::user()->id != 3) readonly @endif >
                                </div>
                                @error('price_grosir50')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="form-label">Stock</label>
                                <input type="text" class="form-control" name="stock" id="stock" value="{{$detail->stock}}" @if(Auth::user()->id != 1 && Auth::user()->id != 3) readonly @endif>
                                @error('stock')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">HPP <a href="{{url('product-hpp-set/'.$id)}}"> <i class="fe fe-settings pull-right"></i></a></label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="price_hpp" id="price_hpp" value="{{$detail->price_hpp}}" @if(Auth::user()->id != 1 && Auth::user()->id != 3) readonly @endif>
                                </div>
                                @error('price_hpp')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">File Gambar</label>
                                <input type="text" class="form-control" name="photo_thumbnail" id="photo_thumbnail" value="{{$detail->photo_thumbnail}}" placeholder="Photo">
                                @error('photo_thumbnail')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Deskripsi Invoice</label>
                                <textarea class="form-control" name="summary" placeholder="Tulis Deskripsi yang tampil di invoice" rows="6">{{$detail->summary}}</textarea>
                                @error('summary')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Deskripsi Invoice</label>
                                <textarea class="form-control" name="desc" placeholder="Tulis Deskripsi yang tampil di Price List" rows="6">{{$detail->desc}}</textarea>
                                @error('desc')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Produk Baru</label>
                                <div class="row">
                                    <div class="col">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="is_new" id="true" value="true" {{($detail->is_new == 'true') ? 'checked' : ''}}>
                                            <span class="custom-control-label">Ya</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="is_new" id="false" value="false" {{($detail->is_new == 'false') ? 'checked' : ''}}>
                                            <span class="custom-control-label">Tidak</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="row">
                                    <div class="col">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="status" id="Active" value="Active" {{($detail->status == 'Active') ? 'checked' : ''}}>
                                            <span class="custom-control-label">Aktif</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="status" id="Inactive" value="Inactive" {{($detail->status == 'Inactive') ? 'checked' : ''}}>
                                            <span class="custom-control-label">Tidak Aktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Price List</label>
                                <div class="row">
                                    <div class="col">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="is_pricelist" id="Active" value="true" {{($detail->is_pricelist == 'true') ? 'checked' : ''}}>
                                            <span class="custom-control-label">Aktif</span>
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="is_pricelist" id="Inactive" value="false" {{($detail->is_pricelist == 'false') ? 'checked' : ''}}>
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
    @if (session('focus_hpp'))
    <script>
        $(document).ready(function() {
            const field = $('#price_hpp');
            if (field.length) {
                field.focus();
                $('html, body').animate({
                    scrollTop: field.offset().top - 100 // biar posisinya pas di tengah layar
                }, 500);
            }
        });
    </script>
    @endif
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
    });
    
    </script>
    </x-layouts.app>