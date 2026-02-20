
@foreach ($contents as $content)
    <a href="{{ url('customer-detail/'.$content->id) }}" class="d-flex p-4 border-bottom">
        <i class="fe fe-chevron-right my-1 fs-16 mr-2"></i>
        <h6 class="my-1 font-weight-semibold">{{$content->name}}</h6>
        <span class="badge badge-pill badge-dark ml-auto my-0 mr-0">{{($content->phone != '-') ? '+62'.$content->phone : "Tidak ada nomor"}}</span>
    </a>
@endforeach