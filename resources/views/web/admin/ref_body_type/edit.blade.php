<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('body-type-list')}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <form id="body-type-form" name="body-type-form" action="{{url('body-type-update/'.$id)}}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="card no-border shadow-none custom-square mt-4 mb-3">
                    <div class="card-body px-2 py-4">
                        <div class="form-group">
                            <label class="form-label">Nama Tipe Bodi</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$name}}" placeholder="Masukan nama lengkap">
                            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
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