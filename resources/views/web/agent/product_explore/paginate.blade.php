
@foreach ($contents as $content)
<div class="card mb-3">
    <div class="card-body p-2 row" style="line-height:20px;{{$content->style_thumb}}">
        <div class="col-4 pr-1">
            <a href="{{ url('product-explore-detail/'.$content->id_produk) }}">
                <img class="rounded shadow" src="{{ asset('storage/'.$content->thumbnail) }}" alt="media1" width="100%" height="105px">
            </a>
        </div>
        <div class="col-8 pl-1">
            <a href="{{ url('product-explore-detail/'.$content->id_produk) }}">
            <div class="d-flex">
                <p class="mb-0 p-0 font-weight-semibold fs-16">{{$content->price}}</p>
                <p class="text-dark m-0 fs-13 ml-auto"><i class="fa fa-map-marker"></i> {{$content->seller_region}}</p>
            </div>
            <p class="text-default p-0 mb-0 d-block fs-14 h-40 mt-1">{{$content->judul}}</p>
            </a>
            <div class="d-flex flex-row">
                <div class="flex-grow-1">
                    <div class="text-muted m-0 fs-12" style="line-height:15px">{{$content->production_year}} · {{$content->transmisi}} · {{$content->fuel}}</div>
                    <p class="text-primary m-0 font-weight-semibold fs-12 ml-auto">Komisi {{$content->sales_commission}}</p>
                </div>
                <div class="">
                    @if($content->is_sold_out == 'true')
                        <span class="badge badge-default mt-2">Terjual</span>
                    @else
                        @if($content->etalase == 0)
                            <a id="add_etalase_{{$content->id_produk}}" onclick="addEtalase('{{$content->id_produk}}')" class="btn btn-primary btn-block m-0 ml-auto fs-12 mt-1" style="padding:2px 6px 4px;"><span id="label-add-{{$content->id_produk}}"><i class="fe fe-plus"></i> Etalase</span></a>
                        @else
                            <a id="rmv_etalase_{{$content->id_produk}}" onclick="removeEtalase('{{$content->id_produk}}')" class="btn btn-white btn-block m-0 ml-auto fs-12 mt-1" style="padding:2px 6px 4px;"><span id="label-rmv-{{$content->id_produk}}"><i class="fe fe-trash"></i> Hapus</span></a>
                        @endif
                    @endif
                </div>
            </div>   
        </div>
    </div>
</div>
<script>
function addEtalase(id){
    $.ajax({
        url:"{{url('product-explore-etalase')}}",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data : {product_id:id},
        type:'post',
        beforeSend: function(){
            setTimeout($('#label-add-'+id).replaceWith('<i class="fa fa-circle-o-notch fa-spin" style="font-size:12px"></i> proses...'), 10000);
        }
    })
    .done(function(data){
        if(data.status == 1){
            $('#add_etalase_'+data.id).replaceWith('<a href="#" id="rmv_etalase_'+data.id+'" onclick="removeEtalase(\''+data.id+'\')" class="btn btn-white btn-block m-0 ml-auto fs-12 mt-1" style="padding:2px 6px 4px;"><span id="label-rmv-'+data.id+'"><i class="fe fe-trash"></i> Hapus</span></a>');
        }
    })
    .fail(function(jqXHR,ajaxOptions,thrownError){
        return false;
    });
}

function removeEtalase(id){
    $.ajax({
        url:"{{url('product-explore-unetalase')}}",
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data : {product_id:id},
        type:'post',
        beforeSend: function(){
            setTimeout($('#label-rmv-'+id).replaceWith('<i class="fa fa-circle-o-notch fa-spin" style="font-size:12px"></i> proses...'), 10000);
        }
    })
    .done(function(data){
        if(data.status == 0){
            $('#rmv_etalase_'+data.id).replaceWith('<a href="#" id="add_etalase_'+data.id+'" onclick="addEtalase(\''+data.id+'\')" class="btn btn-primary btn-block m-0 ml-auto fs-12 mt-1" style="padding:2px 6px 4px;"><span id="label-add-'+data.id+'"><i class="fe fe-plus"></i> Etalase</span></a>');
        }
    })
    .fail(function(jqXHR,ajaxOptions,thrownError){
        return false;
    });
}
</script>
@endforeach