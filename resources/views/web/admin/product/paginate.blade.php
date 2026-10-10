
@foreach ($contents as $content)
<div class="card mb-3 position-relative">
    <div class="card-body p-2 row">
        <div class="col-12 px-4">
            <div class="d-flex" style="vertical-align:middle">
                <h5 class="mb-0 font-weight-semibold fs-16 mr-2">{{$content->price}}</h5>
                @php echo $content->recomended @endphp 
                @if($content->is_sold_out == 'false')
                    <span class="badge {{$content->published_style}} m-0 ml-auto px-2 py-1 fs-10" style="border-radius:4px">{{$content->published}}</span>
                @else
                    <span class="badge badge-default m-0 ml-auto px-2 py-1 fs-12" style="border-radius:4px">Terjual</span>
                @endif
            </div>
            <a href="{{ url('product-detail/'.$content->id_produk) }}" class="stretched-link text-default text-decoration-none">
                <label class="text-default p-0 mb-0 d-block mt-1 fs-14 h-40 cursor-pointer">{{$content->type.' - '.$content->judul}}</label>
            </a>
            <div class="mb-3">
                @if(Auth::user()->id == 1 || Auth::user()->id == 3)
                <a href="{{ url('product-stock-set/'.$content->id_produk) }}" class="btn btn-sm btn-dark px-2 py-1 mr-1" title="Atur Stock">
                    <i class="fe fe-settings"></i>
                </a>
                @endif
                <span class="fs-12 text-muted"> Stock : {{$content->stock}}</span>
            </div>
        </div>
    </div>
</div>
@endforeach