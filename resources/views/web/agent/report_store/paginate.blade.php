
@foreach ($contents as $content)
    <a href="{{ url('report-store-detail/'.$content->id) }}" class="card mb-2">
        <div class="card-body px-2 py-2">
            <div class="d-flex title-bar">
                <div class="mr-auto text-left">
                    <p class="mb-1 text-muted">{{$content->date}} · <i>{{$content->shift_name}}</i></p>
                    <span class="badge badge-pill badge-{{$content->status_color}} ml-auto mr-0 py-1 mt-1">{{$content->status_label}}</span>
                </div>
                <div class="ml-auto text-right">
                    <p class="mb-2">{{$content->emp_name}}</p>
                    <h5 class="font-weight-bold mb-0">Rp {{str_replace(",", ".", number_format($content->total))}}</h5>
                </div>
            </div>
        </div>
    </a>
@endforeach