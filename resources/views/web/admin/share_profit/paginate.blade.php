@foreach ($contents as $content)
    <a href="{{ url('share-profit-detail/'.$content->id) }}" class="d-flex align-items-center p-3 border-bottom" style="text-decoration: none; color: inherit;">
        <div class="mr-auto">
            <h6 class="mb-0 font-weight-bold text-dark">Periode {{$content->periode}}</h6>
            <div class="d-flex align-items-center mt-1">
                @if($content->status == 'Published')
                    <span class="badge badge-success">Published</span>
                @else
                    <span class="badge badge-warning">Draft</span>
                @endif
            </div>
        </div>
        <div class="text-right">
            <h6 class="font-weight-bold text-default">Rp {{number_format($content->total_profit, 0, ',', '.')}}</h6>
            <div class="text-muted">Ralisasi : Rp {{number_format($content->total_share, 0, ',', '.')}}</div>
        </div>
        <div class="ml-3">
            <i class="fe fe-chevron-right text-muted"></i>
        </div>
    </a>
@endforeach