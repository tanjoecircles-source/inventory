
@foreach ($contents as $content)
    <a href="{{ url('variant-detail/'.$content->rv_id) }}" class="d-flex p-4 border-bottom">
        <i class="fe fe-chevron-right my-1 fs-16 mr-2"></i>
        <h6 class="my-1 font-weight-semibold">{{$content->rv_name}}</h6>
        <span class="badge badge-pill badge-dark ml-auto my-0 mr-0">{{$content->rpt_name}}</span>
    </a>
@endforeach
