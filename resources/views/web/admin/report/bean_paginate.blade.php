
@foreach ($contents as $content)
    <a href="{{ url('sales-detail/'.$content->id) }}" class="card mb-2">
        <div class="card-body px-2 py-2">
            <div class="d-flex title-bar">
                <div class="mr-auto text-left">
                    <p class="mb-1">#{{$content->inv_code}}</p>
                    <p class="mb-1 text-muted">Total</p>
                    <p class="mb-1 text-muted">HPP</p>
                    <p class="mb-1 text-muted">Profit</p>
                    <p class="mb-1 font-weight-semibold">{{$content->cust_name}}</p>
                </div>
                <div class="ml-auto text-right">
                    <p class="mb-1 text-muted">{{$content->inv_date}}</p>
                    <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->inv_total))}}</p>
                    <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->inv_hpp))}}</p>
                    <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->inv_profit))}}</p>
                    <p class="badge badge-pill badge-{{$content->inv_status_color}} ml-auto mr-0 py-1 mt-1">{{$content->inv_status_label}}</p>
                </div>
            </div>
            
        </div>
    </a>
@endforeach