<x-layouts.public>
    <x-header-white-2column-center>
        @slot('left')
            <x-back backstyle="text-dark" urlback="{{url('qrcode-agent')}}"></x-back>
        @endslot
        @slot('right')
            <div class="text-center text-dark">Charity For Sumatera</div>
        @endslot
    </x-header-white-2column-center>
    <div class="bg-white pt-7">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <div class="card no-border shadow-none custom-square mb-3">
                        <div class="card-body px-2">
                            <div class="form-group">
                                <h5>Hitung Donasi</h5>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Price /cup</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="price" id="price" value="20000" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Services /cup</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="services" id="services" value="4375" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">HPP /cup</label>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon fs-15">Rp</span>
                                    <input type="text" class="form-control masked" name="hpp" id="hpp" value="3125" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Sold Qty</label>
                                <input type="number" class="form-control" name="sold" id="sold">
                            </div>
                        </div>
                    </div>

                    <div class="card text-center no-border shadow-none custom-square mb-7">
                        <div class="card-body py-0 px-2">
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Total Omset Penjualan</p>
                                <p class="px-2 ml-auto font-weight-bold">Rp <span id="tot-omset">0</span></p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Total Services</p>
                                <p class="px-2 ml-auto font-weight-bold">Rp <span id="tot-services">0</span></p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Total HPP</p>
                                <p class="px-2 ml-auto font-weight-bold">Rp <span id="tot-hpp">0</span></p>
                            </div>
                            <div class="d-flex mb-2 border-bottom">
                                <p class="px-2 mb-2">Total Deposit</p>
                                <p class="px-2 ml-auto font-weight-bold">Rp <span id="tot-deposit">0</span></p>
                            </div>
                            <div class="form-group mt-3">
                                <p>Total Donasi</p> <h3>Rp <span id="tot-donasi">0</span></h3>
                            </div>
                        </div>
                    </div>
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

        function hitung() {
        let price = parseInt($("#price").val().replace(/\D/g, '')) || 0;
        let services = parseInt($("#services").val().replace(/\D/g, '')) || 0;
        let hpp = parseInt($("#hpp").val().replace(/\D/g, '')) || 0;
        let sold = parseInt($("#sold").val()) || 0;

        let totalOmset = price * sold;
        let totalServices = services * sold;
        let totalHpp = hpp * sold;
        let totalDeposit = totalOmset - totalServices;
        let totalDonasi = totalDeposit - totalHpp;

        $("#tot-omset").text(totalOmset.toLocaleString("id-ID"));
        $("#tot-services").text(totalServices.toLocaleString("id-ID"));
        $("#tot-hpp").text(totalHpp.toLocaleString("id-ID"));
        $("#tot-deposit").text(totalDeposit.toLocaleString("id-ID"));
        $("#tot-donasi").text(totalDonasi.toLocaleString("id-ID"));
    }

    $("#sold, #price, #services, #hpp").on("input", hitung);
        
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