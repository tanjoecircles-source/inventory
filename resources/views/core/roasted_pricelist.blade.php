<x-layouts.public header="">

<style>
    .gb-slider .swiper-slide {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
    }
    .gb-slider .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    .gb-slider .swiper-slide:hover img {
        transform: scale(1.05);
    }
    .gb-slider .swiper-button-next,
    .gb-slider .swiper-button-prev {
        width: 30px;
        height: 30px;
        background: rgba(0,0,0,0.4);
        border-radius: 50%;
    }
    .gb-slider .swiper-button-next::after,
    .gb-slider .swiper-button-prev::after {
        font-size: 14px;
        color: #fff;
    }
    .gb-slider .swiper-pagination {
        position: absolute;
        bottom: 5px;
    }
    .gb-slider .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
    }
    .gb-slider .swiper-pagination-bullet-active {
        background: #E62129;
    }
    .img-count-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 10px;
        z-index: 10;
    }

    /* Full Image Modal */
    #modalFullImage .modal-dialog {
        max-width: 95vw;
        margin: 10px auto;
    }
    #modalFullImage .modal-content {
        background: rgba(0,0,0,0.92);
        border: none;
        border-radius: 12px;
        min-height: 80vh;
    }
    #modalFullImage .modal-header {
        border: none;
        padding: 10px 15px;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 15;
    }
    #modalFullImage .modal-header .close {
        color: #fff;
        opacity: 0.8;
        text-shadow: none;
        font-size: 28px;
    }
    #modalFullImage .modal-body {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        overflow: hidden;
        position: relative;
        min-height: 70vh;
    }
    #modalFullImage .modal-body .img-container {
        width: 100%;
        height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }
    #modalFullImage .modal-body .img-container img {
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        transition: transform 0.25s ease;
        cursor: grab;
    }
    #modalFullImage .modal-body .img-container img.dragging {
        cursor: grabbing;
    }
    .zoom-controls {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 20;
        background: rgba(0,0,0,0.5);
        padding: 8px 16px;
        border-radius: 25px;
    }
    .zoom-controls .btn-zoom {
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .zoom-controls .btn-zoom:hover {
        background: rgba(255,255,255,0.3);
    }
    .zoom-controls .zoom-label {
        color: rgba(255,255,255,0.7);
        font-size: 12px;
        display: flex;
        align-items: center;
        min-width: 40px;
        justify-content: center;
    }
    .nav-arrows {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 10px;
        z-index: 10;
        pointer-events: none;
    }
    .nav-arrows .nav-arrow {
        pointer-events: auto;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .nav-arrows .nav-arrow:hover {
        background: rgba(255,255,255,0.3);
    }
    .stock-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        z-index: 10;
    }
</style>

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

<div class="container">
    <div class="row mt-3">
        <div class="col-lg-6 mx-auto">
            <div class="text-center email-style mb-3 mt-3">
                <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:4rem;" alt="tanjoecoffee.com">
            </div>
            
            <h4 class="text-center my-0 py-0">Coffee Pricelist</h4>
            <p class="text-muted text-center">Roasted Beans Aceh Gayo</p>
            
            <div class="tabs-menu1 mb-2">
                <ul class="nav panel-tabs row text-center">
                    <li class="col p-0 mt-0 mx-2"><a href="#tab1" class="active" data-toggle="tab"><b>Filter</b></a></li>
                    <li class="col p-0 mt-0 mx-2"><a href="#tab2" data-toggle="tab"><b>Espresso</b></a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    @forelse($stok_filter as $value)
                    <div class="card mb-3">
                        <div class="card-body px-2 py-2">
                            <div class="d-flex title-bar">
                                <div class="mr-auto text-left">
                                    <h6 class="mb-1">{{$value->name}} <span class="text-warning fs-11 font-weight-normal"><i>{{$value->is_new}}</i></span></h6>
                                    <p class="mb-2"><span class="text-muted fs-12"><i>{{$value->origin}} - {{$value->process}}</i></span></p>
                                    <a class="mb-1 btn btn-dark btn-sm text-white" role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse{{$value->id}}" aria-expanded="true" aria-controls="collapseOne1"><i class="fe fe-info"></i> More Info</a>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class="mb-2"><b>Rp {{str_replace(",", ".", number_format($value->price))}}</b></p>
                                    <span class="badge badge-pill badge-{{$value->stock_color}} ml-auto mr-0 py-1 mb-2 my-1"><i class="fe {{$value->stock_icon}}"></i> {{$value->stock_lable}}</span><br>
                                </div>
                            </div>
                        </div>
                        <div id="collapse{{$value->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                            <div class="card-body px-2 pt-1 pb-3">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="swiper gb-slider position-relative rounded">
                                            <div class="swiper-wrapper">
                                                @forelse($value->images as $img)
                                                <div class="swiper-slide" data-img="{{ $img->image_url }}" data-product="{{$value->name}}" data-index="{{$loop->index}}" data-images='{{json_encode($value->images->pluck('image_url'))}}'>
                                                    <img src="{{ $img->image_url }}" alt="{{$value->name}}">
                                                </div>
                                                @empty
                                                <div class="swiper-slide" data-img="{{ asset('assets/images/products/no-image.png') }}" data-product="{{$value->name}}" data-index="0" data-images='["{{ asset('assets/images/products/no-image.png') }}"]'>
                                                    <img src="{{ asset('assets/images/products/no-image.png') }}" alt="{{$value->name}}">
                                                </div>
                                                @endforelse
                                            </div>
                                            <div class="swiper-pagination"></div>
                                            @if(count($value->images) > 1)
                                            <span class="img-count-badge"><i class="fe fe-image"></i> {{count($value->images)}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-7 fs-12 pl-0">
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Origin</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->origin}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Elevation</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->elevation}} MASL</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Varietal</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->varietal}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Process</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->process}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Processor</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->processor}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Harvest</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->harvest}}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fs-14">
                                    <div class="col-sm-12">
                                        <p class="my-2 text-justify">{!!$value->desc!!}</p>
                                        <hr class="my-2">
                                        <table class="table table-striped">
                                            <tr>
                                                <td><b>Price Type</b></td>
                                                <td class="text-right"><b>Price</b></td>
                                            </tr>
                                            <tr>
                                                <td>Retail (1 Pack)</td>
                                                <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price))}}/Pack</td>
                                            </tr>
                                            <tr>
                                                <td>Bundling (2 Pack)</td>
                                                <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price_grosir15))}}/Pack</td>
                                            </tr>
                                        </table>
                                        <a class="btn btn-success btn-block" href="https://wa.me/6285974607547?text=Halo,%20Saya%20Ingin%20Menanyakan%20Produk%20Roasted%20Beans%20Kopi%20Gayo%20{{$value->name}}." target="_blank"><i class="fa fa-whatsapp"></i> WhatsApp Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p class="mx-2 text-center">Tidak ada data</p>
                    @endforelse
                </div>
                <div class="tab-pane" id="tab2">
                    @forelse($stok_spro as $value)
                    <div class="card mb-3">
                        <div class="card-body px-2 py-2">
                            <div class="d-flex title-bar">
                                <div class="mr-auto text-left">
                                    <h6 class="mb-1">{{$value->name}} <span class="text-warning fs-11 font-weight-normal"><i>{{$value->is_new}}</i></span></h6>
                                    <p class="mb-2"><span class="text-muted fs-12"><i>{{$value->category}}</i></span></p>
                                    <a class="mb-1 btn btn-dark btn-sm text-white" role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse{{$value->id}}" aria-expanded="true" aria-controls="collapseOne1"><i class="fe fe-info"></i> More Info</a>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class="mb-2"><b>Rp {{str_replace(",", ".", number_format($value->price))}}</b></p>
                                    <span class="badge badge-pill badge-{{$value->stock_color}} ml-auto mr-0 py-1 mb-2 my-1"><i class="fe {{$value->stock_icon}}"></i> {{$value->stock_lable}}</span>
                                </div>
                            </div>
                        </div>
                        <div id="collapse{{$value->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                            <div class="card-body px-2 pt-1 pb-3">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="swiper gb-slider position-relative rounded">
                                            <div class="swiper-wrapper">
                                                @forelse($value->images as $img)
                                                <div class="swiper-slide" data-img="{{ $img->image_url }}" data-product="{{$value->name}}" data-index="{{$loop->index}}" data-images='{{json_encode($value->images->pluck('image_url'))}}'>
                                                    <img src="{{ $img->image_url }}" alt="{{$value->name}}">
                                                </div>
                                                @empty
                                                <div class="swiper-slide" data-img="{{ asset('assets/images/products/noimages.png') }}" data-product="{{$value->name}}" data-index="0" data-images='["{{ asset('assets/images/products/noimages.png') }}"]'>
                                                    <img src="{{ asset('assets/images/products/noimages.png') }}" alt="{{$value->name}}">
                                                </div>
                                                @endforelse
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                            <div class="swiper-pagination"></div>
                                            @if(count($value->images) > 1)
                                            <span class="img-count-badge"><i class="fe fe-image"></i> {{count($value->images)}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-7 fs-12 pl-0">
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Origin</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->origin}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Elevation</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->elevation}} MASL</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Varietal</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->varietal}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Process</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->process}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Processor</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->processor}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Harvest</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->harvest}}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fs-14">
                                    <div class="col-sm-12">
                                        <p class="my-2 text-justify">{!!$value->desc!!}</p>
                                        <hr class="my-2">
                                        <table class="table table-striped">
                                            <tr>
                                                <td><b>Price Type</b></td>
                                                <td class="text-right"><b>Price</b></td>
                                            </tr>
                                            <tr>
                                                <td>Retail (1 Pack)</td>
                                                <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price))}}/Pack</td>
                                            </tr>
                                            <tr>
                                                <td>Bundling (2 Pack)</td>
                                                <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price_grosir15))}}/Pack</td>
                                            </tr>
                                        </table>
                                        <a class="btn btn-success btn-block" href="https://wa.me/6285974607547?text=Halo,%20Saya%20Ingin%20Menanyakan%20Produk%20Roasted%20Beans%20Espresso%20Based%20Kopi%20Gayo%20{{$value->name}}." target="_blank"><i class="fa fa-whatsapp"></i> WhatsApp Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p class="mx-2 text-center">Tidak ada data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Full Image Modal with Zoom -->
<div class="modal fade" id="modalFullImage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="modalImageTitle"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container" id="imgContainer">
                    <img id="fullScreenImg" src="" alt="">
                    <div class="nav-arrows">
                        <div class="nav-arrow" id="prevImage"><i class="fe fe-chevron-left"></i></div>
                        <div class="nav-arrow" id="nextImage"><i class="fe fe-chevron-right"></i></div>
                    </div>
                </div>
                <div class="zoom-controls">
                    <button class="btn-zoom" id="zoomOut" title="Zoom Out"><i class="fe fe-minus"></i></button>
                    <span class="zoom-label" id="zoomLevel">100%</span>
                    <button class="btn-zoom" id="zoomIn" title="Zoom In"><i class="fe fe-plus"></i></button>
                    <button class="btn-zoom" id="zoomReset" title="Reset"><i class="fe fe-maximize"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize Swiper for each product's slider
    $('.gb-slider').each(function() {
        var swiper = new Swiper(this, {
            loop: false,
            navigation: {
                nextEl: $(this).find('.swiper-button-next')[0],
                prevEl: $(this).find('.swiper-button-prev')[0],
            },
            pagination: {
                el: $(this).find('.swiper-pagination')[0],
                clickable: true,
            },
        });
    });

    // Modal zoom variables
    var currentZoom = 1;
    var minZoom = 0.5;
    var maxZoom = 5;
    var isDragging = false;
    var startX, startY, translateX = 0, translateY = 0;
    var modalImages = [];
    var modalCurrentIndex = 0;

    // Click slide to open modal
    $(document).on('click', '.gb-slider .swiper-slide', function() {
        var imgUrl = $(this).data('img');
        var productName = $(this).data('product');
        var index = parseInt($(this).data('index')) || 0;
        var imagesData = $(this).data('images');
        
        if (typeof imagesData === 'string') {
            try {
                modalImages = JSON.parse(imagesData);
            } catch(e) {
                modalImages = [imgUrl];
            }
        } else if (Array.isArray(imagesData)) {
            modalImages = imagesData;
        } else {
            modalImages = [imgUrl];
        }
        
        modalCurrentIndex = index;
        openFullImage(modalImages[modalCurrentIndex], productName);
    });

    function openFullImage(src, title) {
        resetZoom();
        $('#fullScreenImg').attr('src', src);
        $('#modalImageTitle').text(title || '');
        $('#modalFullImage').modal('show');
    }

    // Navigation prev/next in modal
    $('#prevImage').on('click', function(e) {
        e.stopPropagation();
        if (modalImages.length <= 1) return;
        modalCurrentIndex = (modalCurrentIndex - 1 + modalImages.length) % modalImages.length;
        resetZoom();
        $('#fullScreenImg').attr('src', modalImages[modalCurrentIndex]);
    });

    $('#nextImage').on('click', function(e) {
        e.stopPropagation();
        if (modalImages.length <= 1) return;
        modalCurrentIndex = (modalCurrentIndex + 1) % modalImages.length;
        resetZoom();
        $('#fullScreenImg').attr('src', modalImages[modalCurrentIndex]);
    });

    // Keyboard navigation
    $(document).on('keydown', function(e) {
        if (!$('#modalFullImage').hasClass('show')) return;
        if (e.key === 'ArrowLeft') $('#prevImage').click();
        if (e.key === 'ArrowRight') $('#nextImage').click();
        if (e.key === 'Escape') $('#modalFullImage').modal('hide');
    });

    // Zoom controls
    $('#zoomIn').on('click', function(e) {
        e.stopPropagation();
        setZoom(currentZoom + 0.25);
    });

    $('#zoomOut').on('click', function(e) {
        e.stopPropagation();
        setZoom(currentZoom - 0.25);
    });

    $('#zoomReset').on('click', function(e) {
        e.stopPropagation();
        resetZoom();
    });

    // Mouse wheel zoom
    $('#imgContainer').on('wheel', function(e) {
        e.preventDefault();
        if (e.originalEvent.deltaY < 0) {
            setZoom(currentZoom + 0.25);
        } else {
            setZoom(currentZoom - 0.25);
        }
    });

    // Double-click to zoom
    $('#imgContainer').on('dblclick', function(e) {
        e.preventDefault();
        if (currentZoom > 1.5) {
            resetZoom();
        } else {
            setZoom(2.5);
        }
    });

    // Drag to pan when zoomed
    $('#fullScreenImg').on('mousedown', function(e) {
        if (currentZoom <= 1) return;
        isDragging = true;
        startX = e.clientX - translateX;
        startY = e.clientY - translateY;
        $(this).addClass('dragging');
    });

    $(document).on('mousemove', function(e) {
        if (!isDragging) return;
        translateX = e.clientX - startX;
        translateY = e.clientY - startY;
        updateTransform();
    });

    $(document).on('mouseup', function() {
        isDragging = false;
        $('#fullScreenImg').removeClass('dragging');
    });

    // Touch support for drag
    $('#fullScreenImg').on('touchstart', function(e) {
        if (currentZoom <= 1) return;
        var touch = e.originalEvent.touches[0];
        isDragging = true;
        startX = touch.clientX - translateX;
        startY = touch.clientY - translateY;
    });

    $(document).on('touchmove', function(e) {
        if (!isDragging) return;
        var touch = e.originalEvent.touches[0];
        translateX = touch.clientX - startX;
        translateY = touch.clientY - startY;
        updateTransform();
    });

    $(document).on('touchend', function() {
        isDragging = false;
    });

    // Reset on modal close
    $('#modalFullImage').on('hidden.bs.modal', function() {
        resetZoom();
    });

    function setZoom(zoom) {
        currentZoom = Math.min(Math.max(zoom, minZoom), maxZoom);
        updateTransform();
        $('#zoomLevel').text(Math.round(currentZoom * 100) + '%');
    }

    function resetZoom() {
        currentZoom = 1;
        translateX = 0;
        translateY = 0;
        updateTransform();
        $('#zoomLevel').text('100%');
    }

    function updateTransform() {
        $('#fullScreenImg').css('transform', 'translate(' + translateX + 'px, ' + translateY + 'px) scale(' + currentZoom + ')');
    }
});
</script>
</x-layouts>