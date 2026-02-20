@if(!empty($product))
    @foreach ($product as $key => $content)
        <div class="col-6 px-1">
            <a href="{{ url('product-explore-detail/'.$content->id) }}">
                <div class="card shadow-none border border-1" @if($content->is_sold_out == 'true') style="opacity:0.4" @endif>
                    <div class="">
                        @php
                        if (!empty($content->photo_exterior_front) && File::exists(storage_path('app/public/'.$content->photo_exterior_front))){
                            $photo = asset('storage/'.$content->photo_exterior_front);
                        }else{
                            $photo = url('assets/images/users/1.jpg');
                        }
                        @endphp
                        <img class="rounded shadow" src="{{ $photo }}" alt="media1" width="100%">
                    </div>
                    <div class="card-body p-2">
                        <p class="mb-1 font-weight-semibold fs-12 text-dark" style="height:50px">{{ $content->name }}</p>
                        <div class="mb-1 d-flex flex-row">
                            <div class="flex-grow-1">
                                <button class="btn btn-xs btn-outline-primary fs-10 p-0 pl-1 pr-1">{{$content->production_year}}</button>
                                @if($content->transmisi == "Manual")
                                    <button class="btn btn-xs btn-outline-primary fs-10 p-0 pl-1 pr-1">M/T</button>
                                @else($content->transmisi == "Automatic")
                                    <button class="btn btn-xs btn-outline-primary fs-10 p-0 pl-1 pr-1">A/T</button>
                                @endif
                            </div>
                        </div>
                        <p class="mb-0 text-primary font-weight-semibold fs-12 ml-auto">Komisi {{ 'Rp. '.number_format($content->sales_commission, 0, '', '.').',-' }}</p>
                        <p class="mb-1 font-weight-thin fs-10 text-dark">{{ 'Rp. '.number_format($content->price, 0, '', '.').',-' }}</p>
                        <p class="mb-2 font-weight-thin fs-8 text-mute">
                            <i class="fa fa-map-marker mr-1"></i>
                            <span>
                                {{-- @if (Gate::allows('isSeller') || Gate::allows('isSellerDealer'))
                                {{ $content->detailSeller->dealer_name}}
                                @else 
                                {{ $content->detailSeller->name}}
                                @endif --}}
                                @if (!empty($content->detailSeller->detailRegion->name))
                                    {{$content->detailSeller->detailRegion->name }}
                                @endif
                            </span>
                        </p>
                        @if($content->is_sold_out == 'true')
                            <button class="btn btn-dark btn-block m-0 ml-auto fs-12 mt-1" style="padding:2px 6px 4px;" disabled>Terjual</button>
                        @else
                            @if($content->detailEtalase()->where('agent', $agent_id)->count() == 0)
                                <a id="add_etalase_{{$content->id}}" onclick="addEtalase('{{$content->id}}')" class="btn btn-primary btn-block m-0 ml-auto fs-12 mt-1" style="padding:2px 6px 4px;"><span id="label-add-{{$content->id_produk}}">Tambah Etalase</span></a>
                            @else
                                <a id="rmv_etalase_{{$content->id}}" onclick="removeEtalase('{{$content->id}}')" class="btn btn-default btn-block m-0 ml-auto fs-12 mt-1" style="padding:2px 6px 4px;"><span id="label-rmv-{{$content->id_produk}}">Hapus Etalase</span></a>
                            @endif
                        @endif
                    </div>
                </div>
            </a>
        </div>
        
    @endforeach
@else
    <div class="row">
        <div class="col">
            <a href="#">
                <div class="card shadow-none border border-1">
                    <div class="">
                        <img src="{{ asset('storage/noimages.jpg') }}" width="100%">
                    </div>
                    <div class="card-body p-2">
                        <div class="m-0 mb-1 fs-13 text-primary font-weight-semibold" style="line-height:18px"><i class="fe fe-users"></i> 0 Agent</div>
                        <p class="text-dark fs-13 font-weight-semibold m-0" style="height:40px;line-height:20px">Tidak ada produk</p>
                        <small class="text-muted">Data masih kosong</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endif