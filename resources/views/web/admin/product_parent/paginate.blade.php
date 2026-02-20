
@foreach ($contents as $content)
    <a href="{{ url('product-parent-detail/'.$content->id) }}" class="d-flex p-4 border-bottom">
        <h6 class="my-1 font-weight-semibold">{{$content->type.' - '.$content->name}}</h6>
        <span class="badge badge-pill badge-{{($content->status == 'Aktif' ? 'success' : 'danger')}} ml-auto my-0 mr-0">{{$content->status}}</span>
    </a>
@endforeach