<x-layouts.public>
<x-header-red-3column notif="">
    @slot('back')
    <x-back urlback="{{url('register')}}"></x-back>
    @endslot
</x-header-red-3column>
<div class="card no-border shadow-none custom-square mb-3 bg-primary">
    <div class="card-body py-4 px-0">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <h4 class="text-white">Buat Akun</h4>        
                </div>
            </div>
        </div>
    </div>
</div>
<form id="login-form" name="login-form" action="{{url('register-agent')}}" method="POST" enctype="multipart/form-data" >
@csrf
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body p-0">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', session('google')['name'] ?? '') }}" placeholder="Masukan nama lengkap">
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        @php
                        $readonly = !empty(session('google')) ? 'readonly' : '';
                        @endphp
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', session('google')['email'] ?? '') }}" placeholder="Masukan alamat email" {!! $readonly !!}>
                        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Handphone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Masukan nomor handphone">
                        @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    @if(empty(session('google')))
                    <div class="form-group">
                        <label class="form-label">Buat Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukan password">
                        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Masukan password konfirmasi">
                        @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    @endif
                    <div class="form-group mb-0">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input @error('term') is-invalid @enderror" name="term" value="1">
                            <span class="custom-control-label">Saya setuju dengan semua ketentuan dan kebijakan yang berlaku</span>
                        </label>
                        @error('term')<div class="text-danger">{{ $message }}</div>@enderror
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