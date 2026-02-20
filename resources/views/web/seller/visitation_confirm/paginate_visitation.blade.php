@foreach ($contentDisetujui as $content)
<div class="card mb-3">
    <div class="card-body p-2 row">
        <div class="col-4 pr-1">
            <img class="rounded shadow" src="{{ asset('storage/'.$content->photo_thumbnail) }}" alt="media1" width="100%">
        </div>
        <div class="col-8 pl-1">
            <h5 class="mb-0 font-weight-semibold fs-16">{{$content->price}}</h5>
            <label class="text-default p-0 mb-1 d-block mt-1 fs-14 h-40">{{$content->name}}</label>
            <div class="text-muted m-0 fs-14" style="line-height:18px"><i class="fe fe-users"></i> {{$content->agent_count}} Agent</div>
            <p class="text-primary m-0 font-weight-semibold fs-11">Komisi {{$content->sales_commission}}</p>
        </div>
    </div>
    <div class="card-footer p-2">
        <a href="{{ url('visitation-confirm/approved/'.$content->product_id) }}" class="btn btn-primary btn-block btn-sm">Lihat Detail</a>
    </div>
</div>
@endforeach