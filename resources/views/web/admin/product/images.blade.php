<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('product-detail/'.$id_produk)}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <style>
        .image-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e9ecef;
            margin-bottom: 15px;
            background: #f8f9fa;
        }
        .image-item .img-thumb {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }
        .image-item .badge-primary {
            position: absolute;
            top: 5px;
            left: 5px;
            z-index: 2;
        }
        .image-item .image-actions {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 2;
            display: flex;
            gap: 4px;
        }
        .image-item .image-actions .btn {
            padding: 2px 8px;
            font-size: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .image-item .image-info {
            padding: 8px 10px;
            font-size: 12px;
            color: #6c757d;
            background: #fff;
            border-top: 1px solid #e9ecef;
        }
        #imageGallery {
            min-height: 100px;
        }
        .upload-placeholder {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #fafafa;
        }
        .upload-placeholder:hover {
            border-color: #E62129;
            background: #fff5f5;
        }
        .upload-placeholder i {
            font-size: 40px;
            color: #adb5bd;
        }
        .upload-placeholder p {
            margin-top: 10px;
            color: #6c757d;
        }
        .image-item {
            touch-action: none;
        }
        .image-item.ui-sortable-helper {
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transform: scale(1.02);
        }
        .image-item.ui-state-highlight {
            border: 2px dashed #E62129;
            background: #fff5f5;
            min-height: 150px;
        }
        .btn-spinner {
            display: none;
        }
        .loading .btn-text {
            display: none;
        }
        .loading .btn-spinner {
            display: inline-block;
        }
    </style>

    @if(session()->has('success'))
        <script>
            $(function () {
                notif({msg: "{{ session('success') }}", type: "success", position: "center"});
            });
        </script>
    @endif
    @if(session()->has('danger'))
        <script>
            $(function () {
                notif({msg: "{{ session('danger') }}", type: "error", position: "center"});
            });
        </script>
    @endif

    <div class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <div class="card no-border shadow-none custom-square mb-2">
                        <div class="card-body px-3">
                            <div class="row mb-3">
                                <div class="col">
                                    <h5 class="mb-0">Foto Produk</h5>
                                    <small class="text-muted">{{ $product->name }}</small>
                                </div>
                            </div>

                            <!-- Upload Area -->
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="upload-placeholder" id="uploadTrigger" onclick="document.getElementById('fileInput').click()">
                                        <i class="fe fe-camera"></i>
                                        <p class="mb-0">Klik untuk upload foto (max 5MB per file)</p>
                                        <small class="text-muted">Format: JPEG, PNG, JPG, WebP</small>
                                    </div>
                                    <form id="uploadForm" style="display:none;">
                                        @csrf
                                        <input type="file" id="fileInput" name="images[]" accept="image/jpeg,image/png,image/jpg,image/webp" multiple style="display:none;">
                                    </form>
                                </div>
                            </div>

                            <!-- Upload Progress -->
                            <div class="row mb-3 d-none" id="uploadProgress">
                                <div class="col">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small id="progressText">Mengupload...</small>
                                        <small id="progressPercent">0%</small>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" id="progressBar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Gallery -->
                            <div class="row" id="imageGallery">
                                @forelse($product->images as $image)
                                <div class="col-6 col-md-4 col-lg-3 image-item-wrap" data-id="{{ $image->id }}">
                                    <div class="image-item">
                                        @if($image->is_primary == 'true')
                                        <span class="badge badge-danger badge-primary">Utama</span>
                                        @endif
                                        <div class="image-actions">
                                            @if($image->is_primary != 'true')
                                            <button type="button" class="btn btn-sm btn-success btn-set-primary" data-id="{{ $image->id }}" title="Jadikan Utama">
                                                <i class="fe fe-check-circle"></i>
                                            </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-image" data-id="{{ $image->id }}" title="Hapus">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                        </div>
                                        <img src="{{ url('storage/public/'.$image->image_path) }}" alt="Product Image" class="img-thumb">
                                        <div class="image-info">
                                            <small><i class="fe fe-move"></i> Seret untuk urutkan</small>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col text-center py-4">
                                    <p class="text-muted mb-0">Belum ada foto</p>
                                </div>
                                @endforelse
                            </div>

                            @if(count($product->images) > 0)
                            <div class="row mt-3">
                                <div class="col">
                                    <button type="button" class="btn btn-outline-primary btn-block" id="btnSaveOrder">
                                        <i class="fe fe-save"></i> Simpan Urutan
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card no-border shadow-none custom-square mb-5">
                        <div class="card-body px-3 text-muted fs-12">
                            <i class="fe fe-info mr-1"></i>
                            <span>Tips: Foto pertama yang diupload akan otomatis menjadi foto utama. Klik <i class="fe fe-check-circle text-success"></i> untuk mengubah foto utama.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-left">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus foto ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    var deleteImageId = null;
    var productId = {{ $id_produk }};

    $(document).ready(function() {
        // Function to initialize sortable
        function initSortable() {
            $('#imageGallery').sortable({
                handle: '.image-item',
                placeholder: 'image-item ui-state-highlight col-6 col-md-4 col-lg-3',
                opacity: 0.7,
                update: function() {
                    // Enable save button when order changes
                    $('#btnSaveOrder').prop('disabled', false).removeClass('btn-outline-primary').addClass('btn-primary');
                }
            });
        }

        // Load jQuery UI Touch Punch from CDN, then initialize sortable
        // This ensures Touch Punch is loaded after jQuery UI is loaded and executed
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js')
            .always(function() {
                initSortable();
            });

        // File upload handler
        $('#fileInput').on('change', function() {
            var files = this.files;
            if (files.length === 0) return;

            var formData = new FormData();
            for (var i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            // Show progress
            $('#uploadProgress').removeClass('d-none');
            $('#progressBar').css('width', '0%');
            $('#progressPercent').text('0%');
            $('#uploadTrigger').addClass('loading');

            $.ajax({
                url: '{{ url("product-images-upload") }}/' + productId,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            $('#progressBar').css('width', percent + '%');
                            $('#progressPercent').text(percent + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    $('#uploadProgress').addClass('d-none');
                    $('#uploadTrigger').removeClass('loading');
                    $('#fileInput').val('');

                    if (response.success) {
                        notif({msg: response.message, type: 'success', position: 'center'});
                        // Reload images
                        location.reload();
                    }
                },
                error: function(xhr) {
                    $('#uploadProgress').addClass('d-none');
                    $('#uploadTrigger').removeClass('loading');
                    $('#fileInput').val('');
                    
                    var msg = 'Gagal upload foto';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    notif({msg: msg, type: 'error', position: 'center'});
                }
            });
        });

        // Set primary image
        $(document).on('click', '.btn-set-primary', function() {
            var btn = $(this);
            var imageId = btn.data('id');
            
            btn.prop('disabled', true).html('<i class="fe fe-loader"></i>');

            $.ajax({
                url: '{{ url("product-images-set-primary") }}/' + imageId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        notif({msg: response.message, type: 'success', position: 'center'});
                        location.reload();
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fe fe-check-circle"></i>');
                    var msg = 'Gagal mengubah foto utama';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    notif({msg: msg, type: 'error', position: 'center'});
                }
            });
        });

        // Delete image confirmation
        $(document).on('click', '.btn-delete-image', function() {
            deleteImageId = $(this).data('id');
            $('#modalConfirmDelete').modal('show');
        });

        $('#btnConfirmDelete').on('click', function() {
            if (!deleteImageId) return;
            
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fe fe-loader"></i> Menghapus...');

            $.ajax({
                url: '{{ url("product-images-delete") }}/' + deleteImageId,
                type: 'GET',
                success: function(response) {
                    $('#modalConfirmDelete').modal('hide');
                    if (response.success) {
                        notif({msg: response.message, type: 'success', position: 'center'});
                        location.reload();
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('Hapus');
                    var msg = 'Gagal menghapus foto';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    notif({msg: msg, type: 'error', position: 'center'});
                }
            });
        });

        // Save order
        $('#btnSaveOrder').on('click', function() {
            var imageIds = [];
            $('.image-item-wrap').each(function() {
                imageIds.push($(this).data('id'));
            });

            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fe fe-loader"></i> Menyimpan...');

            $.ajax({
                url: '{{ url("product-images-reorder") }}/' + productId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    image_ids: imageIds
                },
                success: function(response) {
                    if (response.success) {
                        notif({msg: response.message, type: 'success', position: 'center'});
                        btn.removeClass('btn-primary').addClass('btn-outline-primary').html('<i class="fe fe-save"></i> Simpan Urutan');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="fe fe-save"></i> Simpan Urutan');
                    var msg = 'Gagal menyimpan urutan';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    notif({msg: msg, type: 'error', position: 'center'});
                }
            });
        });
    });
    </script>
</x-layouts.app>