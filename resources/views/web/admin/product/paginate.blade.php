
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
            <div class="mt-0">
                <a href="{{ url('product-stock-set/'.$content->id_produk) }}" class="position-relative text-muted fs-12 d-inline-block text-decoration-none" style="z-index: 2;" title="Atur Stock">
                    <span class="">
                        Stock : {{$content->stock}}
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach