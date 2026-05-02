@foreach ($contents as $content)
    <a href="{{ url('bean-recap-detail/'.$content->id) }}" class="p-0 border-bottom">
        <div class="d-flex title-bar px-3 py-3">
            <div class="mr-auto text-left">
                <p class="font-weight-semibold mb-1">{{$content->periode}}</p>
                <span class="badge badge-pill my-0 badge-{{ $content->status == 'Verified' ? 'success' : 'dark' }}" style="font-size: 10px;">{{$content->status}}</span>
            </div>
            <div class="ml-auto text-right">
                <h5 class="font-weight-bold ml-auto mb-2 mr-0">Rp {{str_replace(",", ".", number_format($content->sisa_profit))}}</h5>
                <p class="mb-0 fs-12">
                    <span class="text-success">Rp {{str_replace(",", ".", number_format($content->profit))}}</span> - 
                    <span class="text-danger">Rp {{str_replace(",", ".", number_format($content->total_potongan + $content->potongan_non_investor))}}</span>
                </p>
            </div>
        </div>
    </a>
@endforeach