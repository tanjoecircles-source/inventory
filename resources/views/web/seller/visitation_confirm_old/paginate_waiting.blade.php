
@foreach ($listWaiting as $key => $content)
<div class="card mb-3">
    <div class="card-body p-2 row" data-toggle="collapse" href="#detail-waiting-{{$key}}">
        <div class="col-3 pr-1">
            <img class="rounded-circle img-thumbnail border" src="{!! url('assets/images/svgs/404.svg') !!}" alt="media1" style="width: 48px; height:48px;">
        </div>
        <div class="col-9 pl-1">
            <h5 class="mb-0 font-weight-semibold fs-16">{{$content->detailAgent->name}}</h5>
            <span class="text-muted fs-10">Jadwal Visitasi</span> <span class="text-dark fs-10">{{ date('d M Y, H:i', strtotime($content->date.' '.$content->time)).' WIB'}}</span>
        </div>
    </div>
    <div class="card-body p-2 collapse" id="detail-waiting-{{$key}}">
        <div class="row ml-1 mr-1 mb-3">
            <div class="col border mr-1">
                <span class="text-muted fs-10">Nama Pembeli</span><br>
                <span class="text-dark fs-12">{{ $content->customer_name }}</span>
            </div>
            <div class="col border">
                <span class="text-muted fs-10">Tempat Visitasi</span><br>
                <span class="text-dark fs-12">{{ $content->location }}</span><br>
                <span class="text-dark fs-12">{{ $content->customer_address }}</span>
            </div>
        </div>
        <div class="row ml-1 mr-1">
            <div class="col text-center">
                <button class="btn btn-block btn-dark fs-12 btn-confirm-visit" data-visitId="{{ $content->id }}" data-visitConfirm="0">Tolak</button>
            </div>
            <div class="col text-center">
            <button class="btn btn-block btn-primary fs-12 btn-confirm-visit" data-visitId="{{ $content->id }}" data-visitConfirm="1">Terima</button>
            </div>
        </div>
    </div>
</div>
@endforeach