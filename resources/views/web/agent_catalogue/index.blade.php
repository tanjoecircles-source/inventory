<x-layouts.public metatitle="{{$info->code}}" metadesc="{{$info->name}}" metaimage="{{$info->avatar}}">
<x-header-red-1column>
    @slot('title')
    <img src="{{ asset('assets/images/brand/logo-white.png') }}" class="icon-blue" style="height:1.5rem;" alt="Brocar logo">
    @endslot
</x-header-red-1column>
<div class="card text-center user-contact-list no-border shadow-none border-0 border-radius-0 mt-7" style="border-radius:0px">
    <div class="p-3">
        <div class="avatar avatar-xxl brround d-block cover-image mx-auto" data-image-src="{{ $info->avatar }}" style="background: url(&quot;{{url('storage/nouser.png')}}&quot;) center center;">	</div>
        <div class="wrapper mt-3">
            <p class="mb-0 text-dark font-weight-semibold fs-16">{{$info->name}}</p>
            <small class="text-muted mb-0">{{$info->address}}</small>
            <p class="text-primary"><i class="fe fe-smartphone"></i> {{$info->phone}}</p>
        </div>
        <div class="rating-stars block" id="rating">
            <input type="number" readonly="readonly" class="rating-value d-none" name="rating-stars-value" id="rating-stars-value" value="1">
            <div class="rating-stars-container">
                <div class="rating-star is--active">
                    <i class="fa fa-star"></i>
                </div>
                <div class="rating-star is--active">
                    <i class="fa fa-star fs-11"></i>
                </div>
                <div class="rating-star is--active">
                    <i class="fa fa-star"></i>
                </div>
                <div class="rating-star is--active">
                    <i class="fa fa-star"></i>
                </div>
                <div class="rating-star">
                    <i class="fa fa-star"></i>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <a href="https://api.whatsapp.com/send/?phone=62{{$info->phone}}&text&type=phone_number&app_absent=0&text={{$info->template}}" target="_blank" class="btn btn-success mr-1" href="#"><i class="fa fa-whatsapp mr-1" style="font-size:15px"></i> Whatsapp</a>
            <a class="btn btn-outline-dark" href="#"><i class="fe fe-user mr-1" style="font-size:15px"></i>Lihat Profil</a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <h6 id="etalase-count" class="text-center mb-2">Tersedia Stok Unit ({{$contents_count}}) </h6>
            <div id="content-data" class="row px-2 mt-5">
                @if($contents_count == 0)
                    <h6 class="m-4 text-center">No matching records found</h6>
                @endif
                @include('web.agent_catalogue.paginate')
            </div>
            <div class="ajax-load text-center">
                <h5><p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
            </div>
        </div>
    </div>
</div>
</x-layouts.public>

<script>
    $(document).ready(function () {
        count = "{{$contents_count}}"
        limit = "{{$limit}}"
        urlparam = "{{$url}}";
        paramurl =  decodeURIComponent(urlparam);
        if(count <= 10){
            $('.ajax-load').hide();
        }
    });
    var page = 1;
    $(window).scroll(function(){
        var key = '{{$keyword}}';
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 1){
            page++;
            loadMoreData(paramurl, page, key);
        }
    });

    function loadMoreData(paramurl, page, key){
        $.ajax({
            url: paramurl + '&page=' + page + '&keyword=' + key,
            type:'get',
            beforeSend: function(){
                $('.ajax-load').show();
            }
        })
        .done(function(data){
            if(data.html == ""){
                $('.ajax-load').html("No more records found");
                return;     
            }
            $('.ajax-load').hide();
            $('#content-data').append(data.html);
        })
        .fail(function(jqXHR,ajaxOptions,thrownError){
            $('.ajax-load').html("server error");
        });
    }
</script>