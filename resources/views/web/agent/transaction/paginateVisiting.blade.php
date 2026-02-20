@foreach ($contentVisitasi as $content)
<div class="card mb-3">
    <div class="card-body p-2 row" style="line-height:20px">
        <div class="col-4 pr-1">
            <a href="{{ url('transaction/detail/visitation/'.$content->id) }}">
                <img class="rounded shadow" src="{{ asset('storage/'.$content->detailProduct->photo_thumbnail) }}" alt="media1" width="100%" height="95px">
            </a>
        </div>
        <div class="col-8 pl-1">
            <a href="{{ url('transaction/detail/visitation/'.$content->id) }}">
                <p class="text-primary m-0 font-weight-semibold fs-12 ml-auto">Komisi {{$content->detailProduct->sales_commission}}</p>
                <p class="mb-0 p-0 font-weight-semibold fs-16">{{$content->detailProduct->price}}</p>
                <p class="text-default p-0 mb-0 d-block fs-14 h-30 mt-1">{{$content->detailProduct->name}}</p>
            </a>
            <div class="d-flex flex-row">
                <div class="flex-grow-1">
                    <button class="btn btn-xs btn-info text-white">Sedang divisitasi</button>
                </div>
                <div class="flex-grow-1 text-right">
                    <button class="btn btn-xs btn-outline-primary">{{$content->detailProduct->production_year}}</button>
                    @if($content->detailProduct->transmisi == "Manual")
                        <button class="btn btn-xs btn-outline-primary">M/T</button>
                    @else($content->detailProduct->transmisi == "Automatic")
                        <button class="btn btn-xs btn-outline-primary">A/T</button>
                    @endif
                </div>
            </div>   
        </div>
    </div>
</div>
@endforeach