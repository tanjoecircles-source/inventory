<x-layouts.public>
<x-header-red-3column notif="">
    @slot('back')
    <x-back  urlback="{{url('forgot-password')}}"></x-back>
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
                    <h4 class="text-white">Buat Password Baru</h4>        
                </div>
            </div>
        </div>
    </div>
</div>
<form id="login-form" name="login-form" action="{{url('forgot-password-submit')}}" method="POST" enctype="multipart/form-data" >
@csrf
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body p-0">
                    <div class="form-group">
                        <label class="form-label">Buat Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" value="" name="password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly')" placeholder="Masukan password">
                        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="off" readonly onfocus="this.removeAttribute('readonly')" placeholder="Masukan password konfirmasi">
                        @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror
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
                    <input type="hidden" value="{{$id}}" name="id">
                    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Buat Password Baru</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</x-layouts.public>