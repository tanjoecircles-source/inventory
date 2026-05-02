
@foreach ($contents as $content)
    <a href="{{ url('roasting-detail/'.$content->id) }}" class="card mb-2">
        <div class="card-body px-2 py-2">
            <div class="d-flex title-bar">
                <div class="mr-auto text-left">
                    <p class="mb-1">#{{$content->code}}</p>
                    <p class="mb-1 text-muted">{{$content->date}}</p>
                </div>
                <div class="ml-auto text-right">
                    <p class="mb-2">{{$content->vendor_name}}</p>
                    <span class="badge badge-pill badge-light border py-1 mt-1">{{ number_format($content->total_qty, 2, ',', '.') }} Kg</span>
                    @if($content->status == 'Publish')
                        <span class="badge badge-pill badge-success ml-auto mr-0 py-1 mt-1">{{$content->status}}</span>
                    @else
                        <span class="badge badge-pill badge-dark ml-auto mr-0 py-1 mt-1">{{$content->status}}</span>
                    @endif
                </div>
            </div>
        </div>
    </a>
@endforeach