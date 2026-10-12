
@foreach ($contents as $content)
    <div class="d-flex p-4 border-bottom">
        <i class="fe fe-calendar my-1 fs-16 mr-2"></i>
        <div class="my-1 text-left">
            <h6 class="mb-0 font-weight-semibold">{{$content->name}}</h6>
            <span class="fs-13 text-muted">{{!empty($content->start_date) ? date('d M Y', strtotime($content->start_date)) : '-'}} - {{!empty($content->end_date) ? date('d M Y', strtotime($content->end_date)) : '-'}}</span>
        </div>
        <div class="ml-auto my-1">
            <a href="{{ url('periode-edit/'.$content->id) }}" class="btn btn-sm btn-dark mr-1">
                <i class="fe fe-edit-2"></i>
            </a>
            <a href="{{ url('periode-delete/'.$content->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus periode {{$content->name}}?')">
                <i class="fe fe-trash"></i>
            </a>
        </div>
    </div>
@endforeach