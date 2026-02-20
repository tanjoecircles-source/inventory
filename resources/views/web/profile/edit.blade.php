<x-layouts.app background="bg-white">
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('profile-category')}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <form id="brand-form" name="brand-form" action="{{url('profil-update-user/'.$user->id)}}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="card no-border shadow-none custom-square mt-4 mb-3">
                    <div class="card-body px-2 py-4">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" placeholder="Masukan nama lengkap">
                            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Telp</label>
                            <input type="text" class="form-control @error('factory') is-invalid @enderror" name="factory" value="{{$user->phone}}" placeholder="Masukan alamat email">
                            @error('factory')<div class="text-danger">{{ $message }}</div>@enderror
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