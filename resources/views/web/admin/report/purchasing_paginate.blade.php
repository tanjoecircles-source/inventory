
@foreach ($contents as $content)
    <a href="{{ url('sales-detail/'.$content->id) }}" class="card mb-2">
        <div class="card-body px-2 py-2">
            <div class="d-flex title-bar">
                <div class="mr-auto text-left">
                    <p class="mb-1">#{{$content->pur_code}}</p>
                    <p class="mb-1 text-muted">Total</p>
                    <p class="mb-1 font-weight-semibold">{{$content->vendor_name}}</p>
                </div>
                <div class="ml-auto text-right">
                    <p class="mb-1 text-muted">{{$content->pur_date}}</p>
                    <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->pur_total))}}</p>
                    <p class="badge badge-pill badge-{{$content->pur_status_color}} ml-auto mr-0 py-1 mt-1">{{$content->pur_status_payment}}</p>
                </div>
            </div>
            
        </div>
    </a>
@endforeach