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
                    <form id="product-form" name="product-form" action="{{url('product-stock-update/'.$id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="card no-border shadow-none custom-square mb-3">
                        <div class="card-body px-2">
                            <div class="form-group">
                                <h3 class="form-label text-center">Jumlah Stok</h3>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" class="form-control form-control-lg text-center" name="stock" id="stock" value="{{$product->stock}}" placeholder="">
                                        @error('stock')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card text-center no-border shadow-none custom-square mb-7">
                        <div class="card-body py-0 px-2">
                            <input type="hidden" id="hpp_total" name="hpp_total" value="0">
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