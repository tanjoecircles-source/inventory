<x-layouts.app>
<x-header-white-2column-center>
    @slot('left')
    @endslot
    @slot('right')
        <div class="text-center text-dark">Scan QR</div>
    @endslot
</x-header-white-2column-center>

<style>
    #fullscreen{
        background: #565656;
    }
</style>

<div class="container container-qrcode">
    <div class="row">
        <div class="col-lg-5 p-0 mx-auto">
            <h5 class="text-white mb-3 mt-3 text-center">Scan Code QR yang ada di<br>handphone penjual</h5>
            <div id="qr-reader" class="w-100"></div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="qrcode-info" role="dialog" >
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-center w-100 font-weight-bolder">Info</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-center"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
        </div>
      </div>

    </div>
</div>
<!-- end bottom sheet confirm -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    const html5QrCode = new Html5Qrcode("qr-reader");

    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code scanned = ${decodedText}`, decodedResult);
        data = JSON.parse(decodedText);
        if (data.url == undefined){
            $('#qrcode-info .modal-body').html('Terjadi kesalahan, coba ulangi kembali');
        }
        html5QrCode.stop().then((ignore) => {
            location.href = data.url;
        }).catch((err) => {
            $('#qrcode-info .modal-body').html('Terjadi kesalahan, coba ulangi kembali');
        });
    }
    // var html5QrcodeScanner = new Html5QrcodeScanner(
    //     "qr-reader", { fps: 10, qrbox: 250 });
    // html5QrcodeScanner.render(onScanSuccess);

    
    // const qrCodeSuccessCallback = (decodedText, decodedResult) => {
    //     /* handle success */
    // };
    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

    // If you want to prefer front camera
    // html5QrCode.start({ facingMode: "user" }, config, onScanSuccess);

    // If you want to prefer back camera
    html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess);

    // Select front camera or fail with `OverconstrainedError`.
    // html5QrCode.start({ facingMode: { exact: "user"} }, config, onScanSuccess);

    // Select back camera or fail with `OverconstrainedError`.
    // html5QrCode.start({ facingMode: { exact: "environment"} }, config, onScanSuccess);
</script>
</x-layouts.app>