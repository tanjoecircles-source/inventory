<x-layouts.public header="">
<div class="app-header header top-header shadow-none bg-white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="d-flex text-white title-bar">
                    <a class="header-brand" href="#">   
                        <a class="mt-2 py-1" href="{{url('/')}}"><i class="fe fe-arrow-left fs-20"></i></a>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@if(session()->has('success'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('success') }}",
                type: "success",
                position: "center"
            });
        });
    </script>
@endif
@if(session()->has('danger'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('danger') }}",
                type: "error",
                position: "center"
            });
        });
    </script>
@endif
<div class="container">
    <div class="row mt-7">
        <div class="col-lg-4 mx-auto">
            <div class="text-center email-style mb-3 mt-5">
                <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:4rem;" alt="tanjoecoffee.com">
            </div>
            @if(session()->has('success_otp'))
            <div class="alert alert-success" role="alert">
                <span>{{ session('success_otp') }}</span>
            </div>
            @endif
            @if(session()->has('error_login'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fe fe-info mr-1" aria-hidden="true"></i> {{ session('error_login') }}
            </div>
            @endif
            <p class="text-muted text-center">Silahkan Login</p>
            {{-- <div class="btn-list d-sm-flex">
                <a type="button" class="btn btn-default btn-lg btn-block" href="{{ route('login_google') }}"><img src="{{ asset('assets/images/png/google.png') }}" style="height:1.5rem;" alt="tanjoecoffee.com"> Akun Google</a>
            </div>
            <hr class="divider mt-6 mb-5"> --}}
            <form id="login-form" name="login-form" action="{{url('auth-process')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="form-group">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon"><i class="fe fe-user fs-16"></i></span>
                    <input type="text" class="form-control py-5 @error('email', 'post') is-invalid @enderror" name="email" id="email" placeholder="Masukan Email">
                </div>
                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <div class="input-icon input-lg mb-4">
                    <span class="input-icon-addon"><i class="fe fe-lock fs-16"></i></span>
                    <input type="password" class="form-control py-5 @error('password', 'post') is-invalid @enderror" name="password" id="password" placeholder="Masukan Password">
                </div>
                @error('password') <div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="fe fe-arrow-right"></i> Masuk</button>        
            </div>
            </form>
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