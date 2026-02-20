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
            <form id="brand-form" name="brand-form" action="{{url('profile-update-dealer/'.$seller->seller_id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Nama Delaer</label>
                        <input type="text" class="form-control" name="dealer_name" value="{{$seller->dealer_name}}" placeholder="Masukan Nama Dealer">
                        @error('dealer_name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Posisi/Jabatan Di Dealer</label>
                        <input type="text" class="form-control" name="dealer_position" value="{{$seller->dealer_position}}" placeholder="Contoh : Pemilik, Marketing, Admin, Dll">
                        @error('dealer_position')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Telp/HP Dealer</label>
                        <input type="text" class="form-control" name="dealer_phone" value="{{$seller->dealer_phone}}" placeholder="Masukan No Telp">
                        @error('dealer_phone')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status Dealer</label>
                        <div class="row">
                            <div class="col">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="dealer_status" value="Aktif" @if($seller->dealer_status == 'Aktif') checked="" @endif>
                                    <span class="custom-control-label">Aktif</span>
                                </label>
                            </div>
                            <div class="col">
                                <label class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="dealer_status" value="Tidak Aktif" @if($seller->dealer_status == 'Tidak Aktif') checked="" @endif>
                                    <span class="custom-control-label">Tidak Aktif</span>
                                </label>
                            </div>
                        </div>
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