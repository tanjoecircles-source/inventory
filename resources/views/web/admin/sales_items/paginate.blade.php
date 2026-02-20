
@foreach ($contents as $content)
    <a href="{{url('sales-item-detail/'.$content->id.'?inv='.$content->itm_inv_id)}}" class="">
    <div class="card-body px-2 py-2 border-bottom">
        <div class="d-flex title-bar">
            <div class="mr-auto text-left">
                <p class="mb-1">{{$content->product_name}}</p>
            </div>
            <div class="ml-auto text-right">
                <p class="text-muted mb-2">{{$content->itm_qty}} x {{str_replace(",", ".", number_format($content->itm_price))}}</p>
                <p class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->itm_total))}}</p>
            </div>
        </div>
    </div>
    </a>
@endforeach