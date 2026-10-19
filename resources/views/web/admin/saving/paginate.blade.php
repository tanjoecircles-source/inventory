@foreach ($contents as $content)
    <div class="card mb-0 border-bottom shadow-none" style="border-radius: 0px; overflow: hidden;">
        <div class="card-body px-3 py-3">
            <div class="d-flex align-items-center">
                <!-- Content -->
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bold text-dark fs-16">{{$content->periode}}</h6>
                        @if($content->status == 'Published')
                            <span class="badge badge-success badge-pill px-2 py-1"><i class="fe fe-check mr-1"></i>Published</span>
                        @else
                            <span class="badge badge-warning badge-pill px-2 py-1"><i class="fe fe-clock mr-1"></i>Draft</span>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-end">
                        <div class="text-left">
                            <span class="text-muted d-block mb-1 fs-12">Total Tabungan</span>
                            <h6 class="mb-0 text-primary">Rp {{number_format($content->total_tabungan, 0, ',', '.')}}</h6>
                            @if($content->total_potongan > 0)
                            <span class="text-danger d-block fs-11">Potongan Rp {{number_format($content->total_potongan, 0, ',', '.')}}</span>
                            <span class="font-weight-bold d-block fs-12">Sisa Rp {{number_format($content->sisa_tabungan, 0, ',', '.')}}</span>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="text-muted d-block mb-1 fs-12">{{$content->created_at}}</span>
                            <h6 class="mb-0 text-blue fs-12">Profit Rp {{number_format($content->total_profit, 0, ',', '.')}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Clickable Area -->
            <a href="{{ url('saving-detail/'.$content->id) }}" class="stretched-link"></a>
        </div>
    </div>
@endforeach
