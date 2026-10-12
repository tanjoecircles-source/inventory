
@foreach ($contents as $content)
    <a href="{{ url('ekspedisi-edit/'.$content->id) }}" class="d-flex px-4 py-2 border-bottom">
        <p class="my-1 font-weight-semibold">{{$content->name}}</p>
    </a>
@endforeach