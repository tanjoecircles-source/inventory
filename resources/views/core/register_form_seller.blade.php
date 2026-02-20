<x-layouts.public>
<x-header-red-3column notif="">
    @slot('back')
    <x-back urlback="{{url('register')}}"></x-back>
    @endslot
</x-header-red-3column>
<form id="form-register" name="form-register" action="{{url('register-seller')}}" method="POST" enctype="multipart/form-data" >
@csrf
<div class="card no-border shadow-none custom-square mb-3">
    <div class="card-body px-2">
        <div class="container">
            <div class="row ">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <h5>Informasi Akun</h5>
                    <div class="form-group">
                        <label class="form-control-label">Tipe Penjual</label> 
                        <div class="row">
                            <div class="col">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="ifseller" value="independent" checked="">
                                    <span class="custom-control-label">Mandiri</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="ifseller" value="dealer">
                                    <span class="custom-control-label">Dealer</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Nama Lengkap</label> 
                        <input class="form-control" id="name" name="name" placeholder="Masukan nama lengkap" type="text" value="{{ old('name', session('google')['name'] ?? '') }}">
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Email</label>
                        @php
                        $readonly = !empty(session('google')) ? 'readonly' : '';
                        @endphp 
                        <input class="form-control" id="email" name="email" placeholder="Masukan alamat email" type="text" value="{{ old('email', session('google')['email'] ?? '') }}" {!! $readonly !!}>
                        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>    
                    <div class="form-group">
                        <label class="form-control-label">No. Handphone</label> 
                        <input class="form-control" id="phone" name="phone" placeholder="Masukan nomor handphone" type="text" value="{{ old('phone') }}">
                        @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    @if(empty(session('google')))
                    <div class="form-group">
                        <label class="form-label">Buat Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password">
                        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation" placeholder="Masukan password konfirmasi">
                        @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    @endif
                    <div class="form-group mb-0 row">
                        <div class="col-lg-12">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input @error('term') is-invalid @enderror" name="term" id="term" value="1">
                                <span class="custom-control-label">Dengan membuat akun ini, Saya menyetujui semua <a href="#" class="text-primary">ketentuan dan kebijakan</a> yang berlaku.</span>
                            </label>
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
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Buat Akun</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</x-layouts.public>