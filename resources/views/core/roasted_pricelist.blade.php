<x-layouts.public header="">

@if(session()->has('success'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('success') }}",
                type: "success",
                position: "center"
            });
        });
    </script>
@endif
@if(session()->has('danger'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('danger') }}",
                type: "error",
                position: "center"
            });
        });
    </script>
@endif
<div class="container">
    <div class="row mt-3">
        <div class="col-lg-6 mx-auto">
            <div class="text-center email-style mb-3 mt-3">
                <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:4rem;" alt="tanjoecoffee.com">
            </div>
            
            <h4 class="text-center my-0 py-0">Coffee Pricelist</h4>
            <p class="text-muted text-center">Roasted Beans Aceh Gayo</p>
            
            
            <div class="tabs-menu1 mb-2">
                <ul class="nav panel-tabs row text-center">
                    <li class="col p-0 mt-0 mx-2"><a href="#tab1" class="active" data-toggle="tab"><b>Filter</b></a></li>
                    <li class="col p-0 mt-0 mx-2"><a href="#tab2" data-toggle="tab"><b>Espresso</b></a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    @forelse($stok_filter as $value)
                    <div class="card mb-3">
                        <div class="card-body px-2 py-2">
                            <div class="d-flex title-bar">
                                <div class="mr-auto text-left">
                                    <h6 class="mb-1">{{$value->name}} <span class="text-warning fs-11 font-weight-normal"><i>{{$value->is_new}}</i></span></h6>
                                    <p class="mb-2"><span class="text-muted fs-12"><i>Gayo {{$value->process}}</i></span></p>
                                    <a class="mb-1 btn btn-dark btn-sm text-white" role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse{{$value->id}}" aria-expanded="true" aria-controls="collapseOne1"><i class="fe fe-info"></i> More Info</a>
                                </div>
                                <div class="ml-auto text-right">
                                    <p class="mb-2"><b>Rp {{str_replace(",", ".", number_format($value->price))}}</b></p>
                                    <span class="badge badge-pill badge-{{$value->stock_color}} ml-auto mr-0 py-1 mb-2 my-1"><i class="fe {{$value->stock_icon}}"></i> {{$value->stock_lable}}</span>
                                </div>
                            </div>
                        </div>
                        <div id="collapse{{$value->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                            <div class="card-body px-2 pt-1 pb-3">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <a class="img-open" imgdata="{{ asset('assets/images/products/'.$value->photo) }}" imgtitle="{{$value->name}}">
                                            <img src="{{ asset('assets/images/products/'.$value->photo) }}" alt="image" class="w-100 rounded">
                                        </a>
                                        <div class="modal" id="modal-{{$value->id}}">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content modal-content-demo">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">{{$value->name}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="{{ asset('assets/images/products/'.$value->photo) }}" alt="image" class="w-100 rounded">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 fs-12 pl-0">
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Origin</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->origin}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Elevation</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->elevation}} MASL</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Varietal</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->varietal}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Process</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->process}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Processor</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->processor}}</b></p>
                                            </div>
                                        </div>
                                        <div class="d-flex border-bottom">
                                            <div class="mr-auto text-left">
                                                <p class="my-1">Harvest</p>
                                            </div>
                                            <div class="ml-auto text-right">
                                                <p class="my-1"><b>{{$value->harvest}}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fs-14">
                                    <div class="col-sm-12">
                                        <p class="my-2 text-justify">{!!$value->desc!!}</p>
                                        <hr class="my-2">
                                        <table class="table table-striped">
                                            <tr>
                                                <td><b>Price Type</b></td>
                                                <td class="text-right"><b>Price</b></td>
                                            </tr>
                                            <tr>
                                                <td>Retail (1 Pack)</td>
                                                <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price))}}/Pack</td>
                                            </tr>
                                            <tr>
                                                <td>Bundling (2 Pack)</td>
                                                <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price_grosir15))}}/Pack</td>
                                            </tr>
                                        </table>
                                        <a class="btn btn-success btn-block" href="https://wa.me/6281330998147?text=Halo,%20Saya%20Ingin%20Menanyakan%20Produk%20Green%20Beans%20Kopi%20Gayo%20{{$value->name}}." target="_blank"><i class="fa fa-whatsapp"></i> WhatsApp Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p class="mx-2 text-center">Tidak ada data</p>
                    @endforelse
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="card">
                        @forelse($stok_spro as $value)
                        <div class="card mb-3">
                            <div class="card-body px-2 py-2">
                                <div class="d-flex title-bar">
                                    <div class="mr-auto text-left">
                                        <h6 class="mb-1">{{$value->name}} <span class="text-warning fs-11 font-weight-normal"><i>{{$value->is_new}}</i></span></h6>
                                        <p class="mb-2"><span class="text-muted fs-12"><i>{{$value->category}}</i></span></p>
                                        <a class="mb-1 btn btn-dark btn-sm text-white" role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse{{$value->id}}" aria-expanded="true" aria-controls="collapseOne1"><i class="fe fe-info"></i> More Info</a>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="mb-2"><b>Rp {{str_replace(",", ".", number_format($value->price))}}</b></p>
                                        <span class="badge badge-pill badge-{{$value->stock_color}} ml-auto mr-0 py-1 mb-2 my-1"><i class="fe {{$value->stock_icon}}"></i> {{$value->stock_lable}}</span>
                                    </div>
                                </div>
                            </div>
                            <div id="collapse{{$value->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne1">
                                <div class="card-body px-2 pt-1 pb-3">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <a class="img-open" imgdata="{{ asset('assets/images/products/'.$value->photo) }}" imgtitle="{{$value->name}}">
                                                <img src="{{ asset('assets/images/products/'.$value->photo) }}" alt="image" class="w-100 rounded">
                                            </a>
                                            <div class="modal" id="modal-{{$value->id}}">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content modal-content-demo">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">{{$value->name}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('assets/images/products/'.$value->photo) }}" alt="image" class="w-100 rounded">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-light" data-dismiss="modal" type="button">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7 fs-12 pl-0">
                                            <div class="d-flex border-bottom">
                                                <div class="mr-auto text-left">
                                                    <p class="my-1">Origin</p>
                                                </div>
                                                <div class="ml-auto text-right">
                                                    <p class="my-1"><b>{{$value->origin}}</b></p>
                                                </div>
                                            </div>
                                            <div class="d-flex border-bottom">
                                                <div class="mr-auto text-left">
                                                    <p class="my-1">Elevation</p>
                                                </div>
                                                <div class="ml-auto text-right">
                                                    <p class="my-1"><b>{{$value->elevation}} MASL</b></p>
                                                </div>
                                            </div>
                                            <div class="d-flex border-bottom">
                                                <div class="mr-auto text-left">
                                                    <p class="my-1">Varietal</p>
                                                </div>
                                                <div class="ml-auto text-right">
                                                    <p class="my-1"><b>{{$value->varietal}}</b></p>
                                                </div>
                                            </div>
                                            <div class="d-flex border-bottom">
                                                <div class="mr-auto text-left">
                                                    <p class="my-1">Process</p>
                                                </div>
                                                <div class="ml-auto text-right">
                                                    <p class="my-1"><b>{{$value->process}}</b></p>
                                                </div>
                                            </div>
                                            <div class="d-flex border-bottom">
                                                <div class="mr-auto text-left">
                                                    <p class="my-1">Processor</p>
                                                </div>
                                                <div class="ml-auto text-right">
                                                    <p class="my-1"><b>{{$value->processor}}</b></p>
                                                </div>
                                            </div>
                                            <div class="d-flex border-bottom">
                                                <div class="mr-auto text-left">
                                                    <p class="my-1">Harvest</p>
                                                </div>
                                                <div class="ml-auto text-right">
                                                    <p class="my-1"><b>{{$value->harvest}}</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fs-14">
                                        <div class="col-sm-12">
                                            <p class="my-2 text-justify">{!!$value->desc!!}</p>
                                            <hr class="my-2">
                                            <table class="table table-striped">
                                                <tr>
                                                    <td><b>Price Type</b></td>
                                                    <td class="text-right"><b>Price</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Retail (1 Pack)</td>
                                                    <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price))}}/Pack</td>
                                                </tr>
                                                <tr>
                                                    <td>Bundling (2 Pack)</td>
                                                    <td class="text-right font-weight-semibold">Rp {{str_replace(",", ".", number_format($value->price_grosir15))}}/Pack</td>
                                                </tr>
                                            </table>
                                            <a class="btn btn-success btn-block" href="https://wa.me/6281330998147?text=Halo,%20Saya%20Ingin%20Menanyakan%20Produk%20Green%20Beans%20Kopi%20Gayo%20{{$value->name}}." target="_blank"><i class="fa fa-whatsapp"></i> WhatsApp Order</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p class="mx-2 text-center">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
</x-layouts>