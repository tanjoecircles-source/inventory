<x-layouts.public metadesc="register">
<x-header-red-3column notif="">
    @slot('back')
    <x-back urlback="{{url('login')}}"></x-back>
    @endslot
</x-header-red-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mt-5 mb-5">
                <div class="card-body p-2">
                    <h3 class="mb-1 font-weight-semibold text-black">Pilih </h3>
                    <h3 class="mb-1 font-weight-semibold text-primary">Tipe Akun</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="login-form" name="login-form" action="{{url('register-form')}}" method="POST" enctype="multipart/form-data" >
@csrf
<div class="container">
    <div class="row px-2">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card mt-7">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <label class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="type" value="agent" checked="">
                            <span class="custom-control-label"></span>
                        </label>
                        <div class="ml-3">
                            <h6 class="font-weight-semibold mb-0">Agen</h6>
                            <small class="text-muted">Cari stok dan siap bantu jual mobil terbaik</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body py-3">
                    <div class="d-flex">
                        <label class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="type" value="seller">
                            <span class="custom-control-label"></span>
                        </label>
                        <div class="ml-3">
                            <h6 class="font-weight-semibold mb-0">Penjual</h6>
                            <small class="text-muted">Siapkan stok mobil kamu untuk dijualkan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="bottom-bar" class="shadow-none">
    <div class="bg-white text-primary mt-2">
        <div class="container">
            <div class="row px-2">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Mulai Buat Akun</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</x-layouts.public>