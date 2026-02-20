<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('product-list')}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <style>
    .dropify-wrapper {
        padding: 0;
        margin-bottom: 5px;
    }
    [class^="dropify-font-"]::before, [class*=" dropify-font-"]::before, .dropify-font::before, .dropify-wrapper .dropify-message span.file-icon::before {
        width: 100%;
        margin: 0px !important;
    }
    </style>

    <div class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <form id="product-photo-form" name="product-photo-form" action="{{url('product-create-photo/'.$id)}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="card no-border shadow-none custom-square mb-0">
                        <div class="card-body px-3 pb-0">
                            <div class="row mb-5">
                                <div class="col px-1">
                                    <h5>Foto Eksterior Kendaraan </h5>
                                    <span class="text-red fs-12">File bertanda (*) wajib diisi</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col px-1">
                                    <div class="form-group text-center">
                                        <input type="file" name="photo_exterior_front" class="uploader" data-height="100" />
                                        <label for="type" class="form-label">Depan <span class="text-red">*</span></label>
                                        @error('photo_exterior_front') <div class="text-danger fs-8">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col px-1">
                                    <div class="form-group text-center">
                                        <input type="file" name="photo_exterior_right" class="uploader" data-height="100" />
                                        <label for="type" class="form-label mt-0">Kanan <span class="text-red">*</span></label>
                                        @error('photo_exterior_right') <div class="text-danger fs-8">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col px-1">
                                    <div class="form-group text-center">
                                        <input type="file" name="photo_exterior_left" class="uploader" data-height="100" />
                                        <label for="type" class="form-label mt-0">Kiri</label>
                                        @error('photo_exterior_left') <div class="text-danger fs-8">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col px-1">
                                    <div class="form-group text-center">
                                        <input type="file" name="photo_exterior_back" class="uploader" data-height="100" />
                                        <label for="type" class="form-label mt-0">Belakang</label>
                                        @error('photo_exterior_back') <div class="text-danger fs-8">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card text-center no-border shadow-none custom-square mb-7">
                        <div class="card-body py-3 px-2">
                            <div class="row">
                                <div class="col">
                                    <a href="#" class="btn btn-outline-primary btn-block btn-lg" id="btn-back" name="btn-back">Sebelumnya</a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-add" name="btn-add">Selanjutnya</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
<script>
$(document).ready(function () {
    $('.uploader').dropify({
        messages: {
            'default': '',
            'replace': '',
            'remove': 'Ganti',
            'error': 'Kesalahan...'
        }
    });
});
</script>