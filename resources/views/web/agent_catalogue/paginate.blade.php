
@foreach ($contents as $content)
@php
$content->template = 
"Halo Agent Brocar, 

Saya tertarik diberikan informasi penjualan lebih detail tentang mobil ini:

kode unit : ".$content->kode_produk."
Brand : ".$content->nama_brand."
Tipe : ".$content->nama_tipe."
Varian : ".$content->nama_varian."
Tahun : ".$content->Tahun."
Transmisi : ".$content->transmisi."

Terima kasih.";
$content->template = urlencode($content->template);
@endphp
<div class="col-6 px-1">
    <div class="card mb-3" id="card-{{$content->id_produk}}">
        <div class="card-body p-0">
            <div class="">
                <a href="{{ url('mitra-product?name='.$content->nameurl.'&code='.$content->codeurl.'&id='.$content->id_produk) }}">
                    <img class="shadow" src="{{ asset('storage/'.$content->thumbnail) }}" alt="media1" width="100%" style="border-radius: 3px 3px 0px 0px !important;">
                </a>
            </div>
        </div>
        <div class="card-body p-2" style="line-height:20px">
            <a href="{{ url('mitra-product?name='.$content->nameurl.'&code='.$content->codeurl.'&id='.$content->id_produk) }}">
                <p class="mt-2 mb-0 p-0 font-weight-semibold fs-16">{{$content->price}}</p>
                <p class="text-dark m-0 fs-13 ml-auto"><i class="fa fa-map-marker"></i> {{$content->seller_region}}</p>
                <p class="text-default p-0 my-1 d-block fs-14" style="height:52px">{{$content->judul}}</p>
            </a>
            <div class="text-muted my-2 fs-12" style="line-height:15px">{{$content->production_year}} · {{$content->transmisi}} · {{$content->fuel}}</div>
            <a href="https://api.whatsapp.com/send/?phone=62{{$content->agent_phone}}&text&type=phone_number&app_absent=0&text={{$content->template}}" target="_blank" class="btn btn-primary btn-block m-0 ml-auto fs-12 mt-1" style="padding:2px 6px 4px;"><i class="fe fe-help-circle"></i> Info Unit</a>
            
        </div>
    </div>
</div>
@endforeach