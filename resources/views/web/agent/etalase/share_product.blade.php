<div class="modal-content" style="border-radius:0px;height:100% !important">
    <div class="modal-body">
        <div class="row">
            <div class="col-3">
                <a href="#" onclick="copyText('{{$link}}')" class="text-center">
                    <center>
                    <i class="fa fa-copy fs-20 text-center bg-gray-200 text-gray p-3" style="border-radius:50%;width:45px;height:45px"></i>
                    <p class="d-block fs-13 text-center font-weight-semibold" style="line-height:30px">Copy URL</p>
                    </center>
                </a>
            </div>
            <div class="col-3">
                <a href="whatsapp://send?text={{html_entity_decode($link_encode)}}" data-action="share/whatsapp/share" class="text-center">
                    <center>
                    <i class="fa fa-whatsapp fs-20 text-center bg-success text-white p-3" style="border-radius:50%;width:45px;height:45px"></i>
                    <p class="d-block fs-13 text-center font-weight-semibold" style="line-height:30px">Whastapp</p>
                    </center>
                </a>
            </div>
            <div class="col-3">
                <a href="https://twitter.com/intent/tweet?url={{html_entity_decode($link_encode)}}&text=Brocar - Jual Mobil Istimewa" >
                    <center>
                    <i class="fa fa-twitter fs-20 text-center bg-info text-white p-3" style="border-radius:50%;width:45px;height:45px"></i>
                    <p class="d-block fs-13 text-center font-weight-semibold" style="line-height:30px">Twitter</p>
                    </center>
                </a>
            </div>
            <div class="col-3">
                <a href="https://www.facebook.com/sharer/sharer.php?u=#url" class="text-center">
                    <center>
                    <i class="fa fa-instagram fs-20 text-center bg-primary text-white p-3" style="border-radius:50%;width:45px;height:45px"></i>
                    <p class="d-block fs-13 text-center font-weight-semibold" style="line-height:30px">Instagram</p>
                    </center>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
function copyText(text) {
    navigator.clipboard.writeText(text);
    notif({
        msg: "Berhasil Copy URL",
        type: "success",
        position: "center"
    });
}
</script>