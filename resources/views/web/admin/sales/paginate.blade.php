
@foreach ($contents as $content)
    <a href="{{ url('sales-detail/'.$content->id) }}" class="card mb-2">
        <div class="card-body px-2 py-2">
            <div class="d-flex title-bar">
                <div class="mr-auto text-left">
                    <p class="mb-1">#{{$content->inv_code}}</p>
                    <p class="mb-1 text-muted">{{$content->inv_date}}</p>
                    <span class="badge badge-pill badge-{{($content->inv_category == "Offline") ? "light" : "success"}} ml-auto mr-0 py-1 mt-1">{{$content->inv_category}}</span>&nbsp;<span class="badge badge-pill badge-dark ml-auto mr-0 py-1 mt-1">{{$content->inv_status}}</span>
                </div>
                <div class="ml-auto text-right">
                    <p class="mb-2">{{$content->cust_name}}</p>
                    <h5 class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->inv_total))}}</h5>
                    <p class="text-muted mt-1">Created by. {{$content->inv_author}}</p>
                </div>
            </div>
        </div>
    </a>
@endforeach