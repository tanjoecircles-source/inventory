<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('sales-detail/'.$detail->id)}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <p class="px-2 mb-2">Kode Invoice</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->inv_code}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Tanggal Invoice</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{date('d M Y', strtotime($detail->inv_date))}}</h6>
                    </div>
                    <div class="form-group">
                        <p class="px-2 mb-2">Pelanggan</p>
                        <h6 class="px-2 m-0 font-weight-bold">{{$detail->cust_name}}</h6>
                    </div>
                </div>
            </div>
            
            <form id="setup-form" name="setup-form" action="{{url('sales-setup/'.$detail->id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-truck mr-1"></i> Pengiriman</h5>
            </div>
            <div class="card no-border shadow-none custom-square mt-0 mb-2">
                <div class="card-body px-2 py-4">
                    <!-- 1. Opsi Pengiriman -->
                    <div class="form-group">
                        <label class="form-label font-weight-semibold">Opsi Pengiriman</label>
                        <select class="form-control @error('inv_shipping_type') is-invalid @enderror" id="inv_shipping_type" name="inv_shipping_type">
                            <option value="Pickup di Toko" {{ in_array($detail->inv_shipping_type ?? '', ['', null, 'Pickup di Toko']) ? 'selected' : '' }}>Pickup di Toko</option>
                            <option value="Pengiriman Dalam Kota" {{ ($detail->inv_shipping_type ?? '') == 'Pengiriman Dalam Kota' ? 'selected' : '' }}>Pengiriman Dalam Kota</option>
                            <option value="Pengiriman Luar Kota" {{ ($detail->inv_shipping_type ?? '') == 'Pengiriman Luar Kota' ? 'selected' : '' }}>Pengiriman Luar Kota</option>
                        </select>
                        @error('inv_shipping_type')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <!-- 2. Ekspedisi dan Nomor Resi (Muncul selain opsi Pickup di Toko) -->
                    <div id="wrapper-ekspedisi-resi" style="{{ in_array($detail->inv_shipping_type ?? '', ['', null, 'Pickup di Toko']) ? 'display: none;' : '' }}">
                        <div class="form-group">
                            <label class="form-label font-weight-semibold">Ekspedisi</label>
                            <select class="form-control @error('inv_ekspedisi_id') is-invalid @enderror" id="inv_ekspedisi_id" name="inv_ekspedisi_id">
                                <option value="">-- Pilih Ekspedisi --</option>
                                @foreach($ekspedisi_list as $eksp)
                                <option value="{{ $eksp->id }}" {{ ($detail->inv_ekspedisi_id ?? '') == $eksp->id ? 'selected' : '' }}>
                                    {{ $eksp->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('inv_ekspedisi_id')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label font-weight-semibold">Nomor Resi</label>
                            <input type="text" class="form-control @error('inv_resi') is-invalid @enderror" id="inv_resi" name="inv_resi" placeholder="Masukkan nomor resi pengiriman" value="{{ $detail->inv_resi ?? '' }}">
                            @error('inv_resi')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- 3. Atur Biaya Pengiriman -->
                    <div class="form-group mb-0">
                        <label class="form-label font-weight-semibold">Atur Biaya Pengiriman</label>
                        <div class="input-icon mb-1">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('inv_expedition') is-invalid @enderror" id="inv_expedition" name="inv_expedition" value="{{ !empty($detail->inv_expedition) ? $detail->inv_expedition : 0 }}" {{ ($detail->inv_shipping_type ?? '') == 'Pickup di Toko' ? 'disabled' : '' }}>
                        </div>
                        <small id="pickup_notice" class="text-muted {{ ($detail->inv_shipping_type ?? '') == 'Pickup di Toko' ? '' : 'd-none' }}"><i class="fe fe-info mr-1"></i> Biaya pengiriman otomatis 0 untuk opsi Pickup di Toko</small>
                        @error('inv_expedition')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-minus-circle mr-1"></i> Pengurangan Biaya</h5>
            </div>
            {{-- <div class="card no-border shadow-none custom-square mt-0 mb-2">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Atur Diskon</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked @error('inv_discount') is-invalid @enderror" id="inv_discount" name="inv_discount" value="{{!empty($detail->inv_discount) ? $detail->inv_discount : 0}}">
                        </div>
                        @error('inv_discount')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div> --}}
            <div class="d-flex py-2 px-2 border-bottom">
                <h5 class="mb-1 font-weight-semibold flex-grow-1"><i class="fe fe-clipboard mr-1"></i> Keterangan Invoice</h5>
            </div>
            <div class="card no-border shadow-none custom-square mt-0 mb-2">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label font-weight-semibold">Tambahkan Keterangan pada Invoice</label>
                        <textarea class="form-control @error('inv_desc') is-invalid @enderror" id="inv_desc" name="inv_desc">{{$detail->inv_desc}}</textarea>    
                        @error('inv_desc')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block" id="btn-payment" name="btn-payment">Simpan</button>
                </div>
            </div>
            </form>
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

    function toggleShippingFields() {
        var shippingType = $('#inv_shipping_type').val();
        if (shippingType === 'Pickup di Toko') {
            $('#wrapper-ekspedisi-resi').slideUp(200);
            $('#inv_ekspedisi_id').val('');
            $('#inv_resi').val('');
            $('#inv_expedition').val('0').prop('disabled', true);
            $('#pickup_notice').removeClass('d-none');
        } else {
            $('#wrapper-ekspedisi-resi').slideDown(200);
            $('#inv_expedition').prop('disabled', false);
            $('#pickup_notice').addClass('d-none');
        }
    }

    $('#inv_shipping_type').on('change', function() {
        toggleShippingFields();
    });

    $('#setup-form').on('submit', function() {
        $('#inv_expedition').prop('disabled', false);
    });

    toggleShippingFields(); 

    $('#inv_cust').select2({
        "ajax" : {
            "url" : "{{url('customer-combo')}}",
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
        placeholder: 'Cari Pelanggan',
        // language: {
        //     inputTooShort: function () {
        //         return "Silakan masukkan 1 atau lebih karakter";
        //     }
        // },
        // minimumInputLength: 1
    });
    
});
</script>
</x-layouts.app>