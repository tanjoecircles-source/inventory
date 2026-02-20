<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-primary" urlback="{{url('home')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-primary"></x-notification>
    @endslot
</x-header-white-3column>
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
<link href="{{ asset('assets/plugins/cropimage/cropimage.min.css') }}" rel="stylesheet" />
<!-- <link href="https://cdn.jsdelivr.net/gh/fabrice8/cropimage/cropimage.css" rel="stylesheet" /> -->
<div class="container bg-white mb-3">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card  no-border shadow-none border-0 custom-square mb-3">
                <div class="py-2 px-4">
                    <div class="d-flex flex-row">
                        <div id="user-thumbnail" class="avatar avatar-xxl brround d-block cover-image m-2" data-image-src="{{ $user->avatar }}" style="background: url('../../assets/images/users/6.jpg') center center;">
                            <button type="button" class="btn btn-sm rounded-circle btn-white rounded" style="width:24px;height:24px;padding-top:0.25px;padding-left:6px;position: absolute;bottom: 5px;right: 0;" data-toggle="modal" data-target="#confirm-image-source-dialog">
                                <i class="fa fa-camera" style="font-size:0.75rem;"></i>
                            </button>
                        </div>
                        <div class="py-2 mt-3">
                            <p class="mb-0 text-dark font-weight-semibold">{{$info->name ?? $user->name}}</p>
                            <p class="text-muted mb-0">{{$info->address ?? ""}}</p>
                            <p class="text-muted">{{$info->seller_phone ?? $user->phone}}</p>
                        </div>
                    </div>
                    @if (Gate::denies('isAdmin'))
                    <div class="row text-center mt-1">
                        <div class="col border-right px-0">
                            <h4 class="m-0 p-0">0</h4>
                            <p class="m-0 p-0">Produk</p>
                        </div>
                        <div class="col border-right px-0">
                            <h4 class="m-0 p-0">0</h4>
                            <p class="m-0 p-0">Pengikut</p>
                        </div>
                        <div class="col px-0">
                            <h4 class="m-0 p-0">0</h4>
                            <p class="m-0 p-0">Mengikuti</p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-10 pr-1">
                            <a href="{{url('profile-category')}}" class="btn btn-block btn-outline-primary">Ubah Profil</a>
                        </div>
                        <div class="col-2 pl-1">
                            <a href="#" class="btn btn-block btn-primary"><i class="fe fe-user-plus"></i></a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container bg-white mb-3">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body px-2 py-4">
                    <div class="d-flex title-bar">
                        <div class="mr-auto">
                            <p class="px-2 mb-2">Status Akun</p>
                            <h6 class="px-2 m-0 font-weight-bold">{{$user->type}}</h6>
                        </div>
                        <div class="ml-auto pt-3">
                            @if (Gate::denies('isAdmin'))
                                <a href="#" class="px-2 text-primary font-weight-semibold">Ubah</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container bg-white mb-7">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card text-center no-border shadow-none custom-square mb-0">
                <div class="card-body p-0">
                    <a href="{{url('employee-list')}}" class="d-flex p-4 border-bottom">
                        <i class="fe fe-users fs-16 mr-2"></i>
                        <h6 class="mb-1 font-weight-semibold">Teams</h6>
                    </a>
                    <a href="{{url('profile-edit-password')}}" class="d-flex p-4 border-bottom">
                        <i class="fe fe-settings fs-16 mr-2"></i>
                        <h6 class="mb-1 font-weight-semibold">Pengaturan Akun</h6>
                    </a>
                    <a href="#" class="d-flex p-4 border-bottom">
                        <i class="fe fe-info fs-16 mr-2"></i>
                        <h6 class="mb-1 font-weight-semibold">Pusat Bantuan</h6>
                    </a>
                    <a href="#" class="d-flex p-4">
                        <i class="fe fe-lock fs-16 mr-2"></i>
                        <h6 class="mb-1 font-weight-semibold">Keamanan</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <center>
            <a href="{{ url('logout') }}" class="text-center text-muted fs-15">
                <i class="fe fe-log-out fs-15 mr-1"></i> <span class="mb-1 font-weight-semibold">Keluar</span>
            </a>
            </center>
        </div>
    </div>
</div>

<!-- bottom sheet choose source picture -->
<!-- Modal -->
<div class="modal fade mx-auto" id="confirm-image-source-dialog" role="dialog" >
    <div class="modal-dialog mx-auto" style="position:absolute;bottom:64px;margin:0;width:100%;left:0;right:0;">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-center w-100 font-weight-bolder">Pilih Sumber Gambar</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-center">
            <div class="row ml-1 mr-1 mt-3 mb-3">
                <div class="col text-center">
                    <input type="file" class="d-none" accept="image/png, image/gif, image/jpeg" id="image-picker">
                    <button type="button" class="btn btn-outline-primary" id="btn-gallery">
                        <i class="fa fa-folder"></i> Galeri
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="btn-camera">
                        <i class="fa fa-camera"></i> Kamera
                    </button>
                </div>
            </div>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>

    </div>
</div>
<!-- end bottom sheet choose source picture -->

<!-- cam interface -->
<!-- Modal -->
<div class="modal fade" id="camera-dialog" role="dialog" >
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-center w-100 font-weight-bolder">Ambil Gambar dari Kamera</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-center">
            <div class="row mt-3">
                <div class="col text-center">
                    <div id="webcam" class="mx-auto"></div>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                <div class="col text-center">
                    <button type="button" class="btn btn-outline-primary" id="btn-camera" onclick="take_snapshot()">
                        <i class="fa fa-camera"></i> Ambil Gambar
                    </button>
                </div>
            </div>
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>

    </div>
</div>
<!-- end cam interface -->

<!-- image croper -->
<!-- Modal -->
<div class="modal" id="croper-image-dialog" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-center">Sesuaikan Gambar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body modal-body-1 img-container" style="height: 250px;overflow: auto;"></div>
            <div class="modal-body modal-body-2 d-none">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center justify-content-center mt-3">
                <button type="button" class="btn btn-outline-primary crop" id="btn-done-crop">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- end image croper -->

<!-- form upload -->
<form id="form-upload-photo" class="d-none" name="brand-form" action="{{route('profile-update-photo')}}" method="POST" enctype="multipart/form-data" >
    @csrf
    <input type="file" name="photo">
</form>
<!-- end form upload -->
<script src="{{ asset('assets/plugins/cropimage/cropimage.min.js') }}"></script>
<script src="{{ asset('assets/plugins/webcamjs/webcam.js') }}"></script>
<script>
    var imageCaptured = null;
    var imageSaved = null;

    $('#btn-camera').click(function(e){
        $('#confirm-image-source-dialog').modal('hide');
        $('#camera-dialog').modal('show');
    });
    
    $('#btn-gallery').click(function(e){
        $('#confirm-image-source-dialog').modal('hide');
        $("#image-picker").click();
    });

    $("#image-picker").change(function(e){
        var img = e.target.files[0];
        imageCaptured = URL.createObjectURL(img);
        launchImageCroper();
    });

    $('#camera-dialog').on('shown.bs.modal', function () {
        Webcam.set({
            width: 275,
            height: 275,
            image_format: 'jpeg',
            jpeg_quality: 90,
            //make rear cam
            // constraints: {
            //     facingMode: 'environment'
            // }
        });
        Webcam.attach( '#webcam' );
    });
    
    $('#camera-dialog').on('hidden.bs.modal', function () {
        Webcam.reset();
    });

    $('#croper-image-dialog').on('hidden.bs.modal', function(){
        $('#croper-image-dialog .modal-body-1').removeClass('d-none');
        $('#croper-image-dialog .modal-body-2').addClass('d-none');
        $('#croper-image-dialog #btn-done-crop').removeAttr('disabled');
    })

    function take_snapshot() {
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            // display results in page
            // document.getElementById('results').innerHTML = 
            //     '<h2>Here is your image:</h2>' + 
            //     '<img src="'+data_uri+'"/>';
            // console.log(data_uri);
            imageCaptured = data_uri;
            $('#camera-dialog').modal('hide');
            launchImageCroper();
        });
    }

    function base64toFile(dataurl, filename) {
        
        var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), 
        n = bstr.length, 
        u8arr = new Uint8Array(n);
        
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }

        mimes = [
            {
                mime : 'image/bmp',
                ext : 'bmp'
            },
            {
                mime : 'image/jpeg',
                ext : 'jpg'
            },
            {
                mime : 'image/gif',
                ext : 'gif'
            },
            {
                mime : 'image/svg+xml',
                ext : 'svg'
            },
            {
                mime : 'image/png',
                ext : 'png'
            },
        ];
        var ext = 'png';
        var i = 0;
        for(i = 0; i < mimes.length; i++){
            if (mime.toLowerCase() == mimes[i].mime.toLowerCase()){
                ext = mimes[i].ext;
                break;
            }
        }
    
        return new File([u8arr], filename+'.'+ext, {type:mime});
    }

    function launchImageCroper(){
        $('#croper-image-dialog #btn-done-crop').off('click');
        const cropOptions = {
            image: imageCaptured,
            // imgFormat: 'auto', // Formats: 3/2, 200x360, auto
            circleCrop: true,
            zoomable: true,
            // outBoundColor: 'white', // black, white
            btnDoneAttr: '#croper-image-dialog #btn-done-crop',
            background: 'transparent',
            /* Show seperation grid within cropping area */
            inBoundGrid: true
        }
        $('#croper-image-dialog .modal-body-1').cropimage(cropOptions, function(base64URL){
            imageSaved = base64URL;
            file = base64toFile(imageSaved, 'photo');
            
            // setTimeout(function(){
                var formData = new FormData($('#form-upload-photo')[0]);
                formData.set('photo', file);
                $('#croper-image-dialog .modal-body-1').addClass('d-none');
                $('#croper-image-dialog .modal-body-2').removeClass('d-none');
                $('#croper-image-dialog #btn-done-crop').attr('disabled', 'disabled');
                $.ajax({
                    url: $('#form-upload-photo').attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: $('#form-upload-photo').attr('method'),
                    dataType: 'json',
                    success: function(response) {
                        // do some stuff
                        $('#croper-image-dialog .modal-body-1').removeClass('d-none');
                        $('#croper-image-dialog .modal-body-2').addClass('d-none');
                        $('#croper-image-dialog #btn-done-crop').removeAttr('disabled');
                        if (response.status){
                            $('#croper-image-dialog').modal('hide');
                            $('#user-thumbnail')
                                .attr('data-image-src', response.thumbnail_url)
                                .css({
                                    background : 'url('+response.thumbnail_url+')'
                                });
                            notif({
                                msg: response.message,
                                type: "success",
                                position: "center"
                            });
                        }else{
                            notif({
                                msg: response.message,
                                type: "error",
                                position: "center"
                            });
                        }
                    },
                    error: function(e){
                        // $('#croper-image-dialog').modal('hide');
                        $('#croper-image-dialog .modal-body-1').removeClass('d-none');
                        $('#croper-image-dialog .modal-body-2').addClass('d-none');
                        $('#croper-image-dialog #btn-done-crop').removeAttr('disabled');
                        notif({
                            msg: "Terjadi Kesalah, coba ulangi kembali",
                            type: "error",
                            position: "center"
                        });
                    }
                });
            // }, 500);
        });
        $('#croper-image-dialog').modal('show');
    }
</script>
</x-layouts.app>