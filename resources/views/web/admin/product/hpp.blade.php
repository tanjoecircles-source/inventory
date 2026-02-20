<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('product-detail/'.$product->id)}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <div class="card no-border shadow-none custom-square my-2">
                        <div class="card-body px-2 py-2">
                            <h5>Informasi Produk</h5>
                            <div class="my-4" id="moredetail">
                                <div class="d-flex mb-2 border-bottom">
                                    <p class="px-2 mb-2">Kategori</p>
                                    <p class="px-2 ml-auto font-weight-bold">{{$product->tipe}}</p>
                                </div>
                                <div class="d-flex mb-2 border-bottom">
                                    <p class="px-2 mb-2">Nama</p>
                                    <p class="px-2 ml-auto font-weight-bold">{{$product->name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="product-form" name="product-form" action="{{url('product-hpp-update/'.$id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="card no-border shadow-none custom-square mb-3">
                        <div class="card-body px-2">
                            <div class="form-group">
                                <h5>Pengaturan Bahan Produk</h5>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Green Bean</label>
                                <div class="row">
                                    <div class="col-6 pr-2">
                                        <input type="text" class="form-control" name="nama_gb_1" id="nama_gb_1" value="{{$nama_gb_1}}" placeholder="">
                                        @error('nama_gb_1')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-6 pl-2">
                                        <input type="text" class="form-control" name="nama_gb_2" id="nama_gb_2" value="{{$nama_gb_2}}" placeholder="">
                                        @error('nama_gb_2')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Green Bean</label>
                                <div class="row">
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">Rp</span>
                                            <input type="text" class="form-control masked" name="harga_gb_1" id="harga_gb_1" value="{{$harga_gb_1}}" placeholder="">
                                        </div>
                                        @error('harga_gb_1')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">Rp</span>
                                            <input type="text" class="form-control masked" name="harga_gb_2" id="harga_gb_2" value="{{$harga_gb_2}}" placeholder="">
                                        </div>
                                        @error('harga_gb_2')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Cargo</label>
                                <div class="row">
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">Rp</span>
                                            <input type="text" class="form-control masked" name="cargo_1" id="cargo_1" value="{{$cargo_1}}" placeholder="">
                                        </div>
                                        @error('cargo_1')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">Rp</span>
                                            <input type="text" class="form-control masked" name="cargo_2" id="cargo_2" value="{{$cargo_2}}" placeholder="">
                                        </div>
                                        @error('cargo_2')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jasa Roasting</label>
                                <div class="row">
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">Rp</span>
                                            <input type="text" class="form-control masked" name="roasting_1" id="roasting_1" value="{{$roasting_1}}" placeholder="">
                                        </div>
                                        @error('roasting_1')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">Rp</span>
                                            <input type="text" class="form-control masked" name="roasting_2" id="roasting_2" value="{{$roasting_2}}" placeholder="">
                                        </div>
                                        @error('roasting_2')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Penyusutan Pasca Roasting</label>
                                <div class="row">
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">gr</span>
                                            <input type="text" class="form-control masked" name="loss_1" id="loss_1" value="{{$loss_1}}" placeholder="">
                                        </div>
                                        @error('loss_1')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">gr</span>
                                            <input type="text" class="form-control masked" name="loss_2" id="loss_2" value="{{$loss_2}}" placeholder="">
                                        </div>
                                        @error('loss_2')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Rasio</label>
                                <div class="row">
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">%</span>
                                            <input type="text" class="form-control" name="ratio_1" id="ratio_1" value="{{$ratio_1}}" placeholder="">
                                        </div>
                                        @error('ratio_1')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-6 pr-2">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon fs-15">%</span>
                                            <input type="text" class="form-control" name="ratio_2" id="ratio_2" value="{{$ratio_2}}" placeholder="">
                                        </div>
                                        @error('ratio_2')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Netto Produk</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">gr</span>
                                    <input type="text" class="form-control masked" name="netto" id="netto" value="{{$netto}}" placeholder="">
                                </div>
                                @error('netto')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group mt-3">
                                <h5>Total Harga Bahan: Rp <span id="hasil_total">0</span></h5>
                            </div>
                        </div>
                        <div class="card-body px-2">
                            <div class="form-group">
                                <h5>Pengaturan Kemasan</h5>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Kemasan Kopi</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">gr</span>
                                    <input type="text" class="form-control" name="pack" id="pack" value="{{$pack}}" placeholder="">
                                </div>
                                @error('pack')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Box</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">gr</span>
                                    <input type="text" class="form-control" name="box" id="box" value="{{$box}}" placeholder="">
                                </div>
                                @error('box')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group mt-3">
                                <h5>Total Harga Kemasan: Rp <span id="hasil_packed">0</span></h5>
                            </div>
                        </div>
                    </div>

                    <div class="card text-center no-border shadow-none custom-square mb-7">
                        <div class="card-body py-0 px-2">
                            <div class="form-group mt-3">
                                <p>Total Harga Pokok Produk (HPP)</p> <h3>Rp <span id="hasil_kopi_packed">0</span></h3>
                            </div>
                            <input type="hidden" id="hpp_total" name="hpp_total" value="0">
                            <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-add" name="btn-add">Simpan Perhitungan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
     $(document).ready(function () {
        function toNumber(value) {
            // Hilangkan titik dan karakter non-angka
            let num = parseFloat(String(value).replace(/\D/g, ''));
            return isNaN(num) ? 0 : num;
        }

        function hitungTotal() {
            let harga_gb_1 = toNumber($('#harga_gb_1').val());
            let harga_gb_2 = toNumber($('#harga_gb_2').val());
            let cargo_1 = toNumber($('#cargo_1').val());
            let cargo_2 = toNumber($('#cargo_2').val());
            let roasting_1 = toNumber($('#roasting_1').val());
            let roasting_2 = toNumber($('#roasting_2').val());
            let loss_1 = toNumber($('#loss_1').val());
            let loss_2 = toNumber($('#loss_2').val());
            let netto = toNumber($('#netto').val());
            let ratio_1 = parseFloat($('#ratio_1').val()) || 0;
            let ratio_2 = parseFloat($('#ratio_2').val()) || 0;
            let pack = toNumber($('#pack').val());
            let box = toNumber($('#box').val());

            // Cegah pembagian dengan nol
            if (loss_1 <= 0) loss_1 = 1;
            if (loss_2 <= 0) loss_2 = 1;
            if (netto <= 0) netto = 1;

            // Hitung total per komposisi
            let total_1 = harga_gb_1 + cargo_1 + roasting_1;
            let total_2 = harga_gb_2 + cargo_2 + roasting_2;
            let roastedgr_1 = total_1 / loss_1;
            let roastedgr_2 = total_2 / loss_2;

            // Total blend sesuai rasio
            let mix_ratio = (roastedgr_1 * (ratio_1 / 100)) + (roastedgr_2 * (ratio_2 / 100));
            let total_blend = mix_ratio * netto;

            // Pastikan hasil bukan NaN atau Infinity
            if (isNaN(total_blend) || !isFinite(total_blend)) {
                total_blend = 0;
            }

            let total_packed = pack + box;

            let total_blend_packed = total_blend + total_packed;

            // Bulatkan hasil akhir
            total_blend = Math.round(total_blend);
            total_packed = Math.round(total_packed);
            total_blend_packed = Math.round(total_blend_packed);

            // Tampilkan hasil (dalam format rupiah)
            $('#hasil_total').text(total_blend.toLocaleString('id-ID'));
            $('#hasil_packed').text(total_packed.toLocaleString('id-ID'));
            $('#hasil_kopi_packed').text(total_blend_packed.toLocaleString('id-ID'));
            $('#hpp_total').val(total_blend_packed);
        }

        // Jalankan fungsi setiap kali pengguna mengetik / mengubah input
        $('input').on('input', hitungTotal);

        // Jalankan pertama kali saat halaman dimuat
        hitungTotal();
        
        $('.masked').inputmask({
            rightAlign:false,
            radixPoint: ',',
            groupSeparator: ".",
            alias: "numeric",
            autoGroup: true,
            digits: 0
        });
    });
    
    </script>
    </x-layouts.app>