
@foreach ($contents as $content)
    <a href="{{ url('store-purchasing-detail/'.$content->id) }}" class="card mb-2">
        <div class="card-body px-2 py-2">
            <div class="d-flex title-bar">
                <div class="mr-auto text-left">
                    <p class="mb-1">#{{$content->pur_code}}</p>
                    <p class="mb-1 text-muted">{{$content->pur_date}}</p>
                    <span class="badge badge-pill badge-{{($content->pur_category == "Offline") ? "light" : "success"}} ml-auto mr-0 py-1 mt-1">{{$content->pur_category}}</span>&nbsp;<span class="badge badge-pill ml-auto mr-0 py-1 mt-1">{{$content->pur_status}}</span>
                </div>
                <div class="ml-auto text-right">
                    <p class="mb-2">{{$content->vendor_name}}</p>
                    <h5 class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->pur_total))}}</h5>
                    <span class="badge badge-pill badge-{{$content->payment_color}} ml-auto mr-0 py-1 mt-1">{{$content->status_payment}}</span>
                </div>
            </div>
        </div>
    </a>
@endforeach