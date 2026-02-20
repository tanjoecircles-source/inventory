
@foreach ($contents as $content)
    <a href="{{ url('share-profit-detail/'.$content->id) }}" class="d-flex p-4 border-bottom">
        <h6 class="my-1 font-weight-semibold mr-3">{{$content->periode}} </h6>
        <span class="badge badge-pill badge-dark">{{$content->status}}</span>
        <h5 class="font-weight-bold ml-auto my-0 mr-0">Rp {{str_replace(",", ".", number_format($content->total_profit))}}</h5>
        
    </a>
@endforeach