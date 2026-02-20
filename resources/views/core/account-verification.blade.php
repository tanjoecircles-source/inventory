<x-layouts.public>
<x-header-red-3column notif="">
    @slot('back')
    <x-back  urlback="{{url('login')}}"></x-back>
    @endslot
</x-header-red-3column>
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
<div class="card no-border shadow-none custom-square mb-3 bg-primary">
    <div class="card-body py-4 px-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <h4 class="text-white">Gagal Verifikasi Akun?</h4>        
                </div>
            </div>
        </div>
    </div>
</div>
<form id="login-form" name="login-form" action="{{url('account-verification-email')}}" method="POST" enctype="multipart/form-data" >
@csrf
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body p-0">
                    <div class="form-group">
                        <label class="form-label">Masukkan email terdaftar untuk mengulang aktifasi akun</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukan alamat email">
                        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="">
                        <a href="{{url('login')}}" class="btn btn-link box-shadow-0 px-0 mb-3"><i class="fe fe-arrow-left"></i> Coba Login kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="bottom-bar" class="shadow-none">
    <div class="bg-white text-primary mt-2">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Kirim ulang OTP ke Email</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</x-layouts.public>