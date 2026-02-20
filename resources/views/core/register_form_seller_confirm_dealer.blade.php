<x-layouts.public>
<x-header-red-3column notif="">
    @slot('back')
    <x-back urlback="{{url('register-form-seller')}}"></x-back>
    @endslot
</x-header-red-3column>
<form id="form-register" name="form-register" action="{{url('register-seller-confirm-submit')}}" method="POST" enctype="multipart/form-data" >
@csrf
<div class="card no-border shadow-none custom-square mb-3">
    <div class="card-body px-2">
        <div class="container">
            <div class="row ">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <h5>Verifikasi Identitas Penjual</h5>
                    <div class="form-group wd-xs-300">
                        <label class="form-control-label">Foto Selfie KTP</label> 
                        <input type="file" name="identity" class="upload-verification" id="identity" data-height="160" />
                        @error('identity')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group wd-xs-300">
                        <label class="form-control-label">Foto Dealer</label> 
                        <input type="file" name="dealer" class="upload-verification" id="dealer" data-height="160" />
                        @error('dealer')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="form-group mb-0 row">
                        <div class="col-lg-12">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input @error('term') is-invalid @enderror" name="term" id="term" value="1">
                                <span class="custom-control-label">Saya setuju dengan semua ketentuan dan kebijakan yang berlaku</span>
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
            <div class="row px-2">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col">
                            <a href="{{url('register-form-seller')}}" class="btn btn-outline-primary btn-lg btn-block mb-3">Sebelumnya</a>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Buat Akun</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script>
$(document).ready(function(){            
    $('.upload-verification').dropify({
        messages: {
            'default': 'Pilih File',
            'replace': 'Ganti File',
            'remove': 'Hapus',
            'error': 'Kesalahan...'
        }
    });
});
</script>
</x-layouts.public>