
@foreach ($contents as $content)
    <a href="{{ url('bean-recap-detail/'.$content->id) }}" class="p-0 border-bottom">
        <div class="d-flex title-bar px-3 py-3">
            <div class="mr-auto text-left">
                <p class="font-weight-semibold mb-1">{{$content->periode}} </p>
                <span class="badge badge-pill badge-dark">{{$content->status}}</span>
            </div>
            <div class="ml-auto text-right">
                <h5 class="font-weight-bold ml-auto my-0 mr-0">Rp {{str_replace(",", ".", number_format($content->sisa_profit))}}</h5>
            </div>
        </div>
    </a>
@endforeach