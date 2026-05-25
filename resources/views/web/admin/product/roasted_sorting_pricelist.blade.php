<x-layouts.public header="">

<div class="container pt-3 pb-5">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="text-center email-style mb-3">
                <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:4rem;" alt="tanjoecoffee.com">
                <p class="text-muted text-center mt-1 mb-0 fs-12">Geser item list (ke atas/bawah) untuk mengurutkan tampilan price list.</p>
            </div>

            <div class="tabs-menu1 mb-3">
                <ul class="nav panel-tabs row text-center">
                    <li class="col p-0 mt-0 mx-2"><a href="#tab1" class="active" data-toggle="tab"><b>Filter</b></a></li>
                    <li class="col p-0 mt-0 mx-2"><a href="#tab2" data-toggle="tab"><b>Espresso</b></a></li>
                </ul>
            </div>

            <div class="tab-content">
                <!-- Tab 1: Roasted Filter -->
                <div class="tab-pane active" id="tab1">
                    <div id="sortable-list-filter" class="list-group">
                        @forelse($stok_filter as $value)
                            <div class="card mb-3 draggable-card shadow-sm" data-id="{{$value->id}}">
                                <div class="card-body px-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="drag-handle pr-3 text-muted" style="cursor: grab; display: flex; align-items: center; justify-content: center; width: 40px;">
                                            <i class="fe fe-move fs-20"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-left" style="max-width: 65%;">
                                                    <h6 class="mb-1 font-weight-semibold text-dark">{{$value->name}} <span class="text-warning fs-11 font-weight-normal"><i>{{$value->is_new}}</i></span></h6>
                                                    <p class="mb-0 text-muted fs-12"><i>{{$value->origin}} | {{$value->process}}</i></p>
                                                </div>
                                                <div class="text-right" style="max-width: 35%;">
                                                    <p class="mb-1 font-weight-bold">Rp {{str_replace(",", ".", number_format($value->price))}}</p>
                                                    <span class="badge badge-pill badge-{{$value->stock_color}} px-2 py-1 fs-10"><i class="fe {{$value->stock_icon}}"></i> {{$value->stock_lable}}</span>
                                                    <span class="badge badge-pill badge-order-index ml-1 px-2 py-1 fs-10">#{{$value->order_pricelist}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="mx-2 text-center text-muted">Tidak ada data produk filter aktif</p>
                        @endforelse
                    </div>
                </div>

                <!-- Tab 2: Espresso -->
                <div class="tab-pane" id="tab2">
                    <div id="sortable-list-espresso" class="list-group">
                        @forelse($stok_spro as $value)
                            <div class="card mb-3 draggable-card shadow-sm" data-id="{{$value->id}}">
                                <div class="card-body px-3 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="drag-handle pr-3 text-muted" style="cursor: grab; display: flex; align-items: center; justify-content: center; width: 40px;">
                                            <i class="fe fe-move fs-20"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="text-left" style="max-width: 65%;">
                                                    <h6 class="mb-1 font-weight-semibold text-dark">{{$value->name}} <span class="text-warning fs-11 font-weight-normal"><i>{{$value->is_new}}</i></span></h6>
                                                    <p class="mb-0 text-muted fs-12"><i>{{$value->category}}</i></p>
                                                </div>
                                                <div class="text-right" style="max-width: 35%;">
                                                    <p class="mb-1 font-weight-bold">Rp {{str_replace(",", ".", number_format($value->price))}}</p>
                                                    <span class="badge badge-pill badge-{{$value->stock_color}} px-2 py-1 fs-10"><i class="fe {{$value->stock_icon}}"></i> {{$value->stock_lable}}</span>
                                                    <span class="badge badge-pill badge-order-index ml-1 px-2 py-1 fs-10">#{{$value->order_pricelist}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="mx-2 text-center text-muted">Tidak ada data produk espresso aktif</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <a href="{{url('home')}}" class="btn btn-success btn-block"><i class="fe fe-check-circle"></i> Selesai</a>
        </div>
    </div>
</div>

<!-- SortableJS library for smooth drag n drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<style>
    .draggable-card.sortable-ghost {
        opacity: 0.4;
        background-color: #f0f3f8 !important;
        border: 2px dashed #007bff !important;
    }
    .draggable-card.sortable-chosen {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        transform: scale(1.02);
    }
    .draggable-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08) !important;
        background-color: #fafbfc;
    }
    .drag-handle:hover {
        color: #343a40 !important;
    }
</style>

<script>
$(document).ready(function() {
    var elFilter = document.getElementById('sortable-list-filter');
    var elEspresso = document.getElementById('sortable-list-espresso');
    
    // Initialize SortableJS for Roasted Filter
    if (elFilter) {
        Sortable.create(elFilter, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                updateOrderIndexes('#sortable-list-filter');
                autoSaveOrder('#sortable-list-filter');
            }
        });
    }

    // Initialize SortableJS for Espresso
    if (elEspresso) {
        Sortable.create(elEspresso, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onEnd: function(evt) {
                updateOrderIndexes('#sortable-list-espresso');
                autoSaveOrder('#sortable-list-espresso');
            }
        });
    }

    // Function to update the # order index numbers visually
    function updateOrderIndexes(selector) {
        $(selector + ' .draggable-card').each(function(index) {
            $(this).find('.badge-order-index').text('#' + (index + 1));
        });
    }

    // Auto-save sorted order to database
    function autoSaveOrder(selector) {
        var ids = [];
        $(selector + ' .draggable-card').each(function() {
            ids.push($(this).data('id'));
        });

        if (ids.length === 0) return;

        $('#save-status').show();

        $.ajax({
            url: "{{ route('product-sorting-priceroasted.save') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ids: ids
            },
            success: function(response) {
                $('#save-status').hide();
                if (response.success) {
                    notif({
                        msg: response.message || "Urutan pricelist berhasil disimpan",
                        type: "success",
                        position: "center"
                    });
                } else {
                    notif({
                        msg: response.message || "Gagal menyimpan urutan",
                        type: "error",
                        position: "center"
                    });
                }
            },
            error: function(xhr, status, error) {
                $('#save-status').hide();
                var errMsg = "Terjadi kesalahan saat memperbarui urutan";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                notif({
                    msg: errMsg,
                    type: "error",
                    position: "center"
                });
            }
        });
    }
});
</script>

</x-layouts.public>
