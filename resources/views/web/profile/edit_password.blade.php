<x-layouts.app background="bg-white">
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('profile')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="brand-form" name="brand-form" action="{{url('profile-update-password/'.$id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Buat Password Baru</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Masukan password">
                        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Masukan password konfirmasi">
                        @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-update" name="btn-update">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>