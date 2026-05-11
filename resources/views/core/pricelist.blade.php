<x-layouts.public header="">

<div class="container">
    <div class="row mt-7">
        <div class="col-lg-4 mx-auto">
            <div class="text-center email-style mb-3 mt-5">
                <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:4rem;" alt="tanjoecoffee.com">
            </div>
            
            <div class="font-weight-semibold fs-15 mb-4 mt-5 text-center">Daftar Produk dan Harga<br>Kopi Aceh Gayo</div>
            <div class="row">
                <div class="col-6 pr-2">
                    <div class="card overflow-hidden">
                        <a href="{{ url('greenbeans') }}" target="_blank"><img src="{{ asset('assets/images/products/greenbean.png') }}" alt="image" class="img-height"></a>
                        <div class="card-body p-2">
                            <a href="{{ url('greenbeans') }}" target="_blank" class="card-title mb-1 mt-0 fs-15 font-weight-semibold">Green Bean</a>
                            <p class="card-text fs-12 text-muted mb-2">Daftar Produk dan Harga Green Beans</p>
                            <a href="https://wa.me/?text=Berikut%20Daftar%20Harga%20Green%20Bean%20Aceh%20Gayo%20Toko%20Kopi%20Tanjoe%20{{ urlencode('https://app.tanjoecoffee.com/greenbeans') }}" target="_blank" class="btn btn-dark btn-sm"><i class="fe fe-share"></i></a>
                            <a id="copyurlgreen" class="btn btn-white btn-sm"><i class="fe fe-copy"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-6 pl-2">
                    <div class="card overflow-hidden">
                        <a href="{{ url('roastedbeans') }}" target="_blank"><img src="{{ asset('assets/images/products/roasted.png') }}" alt="image" class="img-height"></a>
                        <div class="card-body p-2">
                            <a href="{{ url('roastedbeans') }}" target="_blank" class="card-title mb-1 mt-0 fs-15 font-weight-semibold">Roasted Bean</a>
                            <p class="card-text fs-12 text-muted mb-2">Daftar Produk dan Harga Roasted Beans</p>
                            <a href="https://wa.me/?text=Berikut%20Daftar%20Harga%20Roasted%20Bean%20Aceh%20Gayo%20Toko%20Kopi%20Tanjoe%20{{ urlencode('https://app.tanjoecoffee.com/roastedbeans') }}" target="_blank" class="btn btn-dark btn-sm"><i class="fe fe-share"></i></a>
                            <a id="copyurlroasted" class="btn btn-white btn-sm"><i class="fe fe-copy"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('copyurlgreen').addEventListener('click', async () => {
    try {
        await navigator.clipboard.writeText('https://app.tanjoecoffee.com/greenbeans');
        $(function () {
            notif({
                msg: "URL Daftar Harga Berhasil Disalin.",
                type: "success",
                position: "center"
            });
        });
    } catch (err) {
        alert('Gagal menyalin URL.');
        console.error(err);
    }
});

document.getElementById('copyurlroasted').addEventListener('click', async () => {
    try {
        await navigator.clipboard.writeText('https://app.tanjoecoffee.com/roastedbeans');
        $(function () {
            notif({
                msg: "URL Daftar Harga Berhasil Disalin.",
                type: "success",
                position: "center"
            });
        });
    } catch (err) {
        alert('Gagal menyalin URL.');
        console.error(err);
    }
});
</script>
</x-layouts>
