<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('report')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <h5 class="mb-1 font-weight-bold text-primary">Purchasing</h5>
                            <span class="mb-1 text-muted">Coffee Bean & Alat Kopi</span>
                        </div>
                        <div class="ml-auto text-right">
                            <h3 class="mb-1 font-weight-bold text-gray pull-right">Rp {{str_replace(",", ".", number_format($sales_total))}}</h3>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Jumlah</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($sales_amount))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">HPP</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($sales_hpp))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Profit</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($sales_profit))}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mt-2 mb-0">
                <div class="card-body p-2">
                    <form id="filter-form" name="search-form" action="{{url('report-purchasing-list')}}" method="GET">
                        <div class="d-flex title-bar py-1">
                            <div class="mr-auto text-left">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Download Laporan <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#"><i class="fa fa-file-excel-o"></i> Berdasarkan Invoice</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="fa fa-file-excel-o"></i> Berdasarkan Produk</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="fa fa-file-excel-o"></i> Berdasarkan Pelanggan</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <select class="form-control form-control-sm" name="filter-payment" id="payment-status" placeholder="Semua Tagihan">
                                    @if($keyword == 'all')
                                    <option value="all" selected>Semua Tagihan</option>
                                    <option value="unpaid">Belum Lunas</option>
                                    <option value="paid">Lunas</option>
                                    @endif
                                    @if($keyword == 'Belum Lunas')
                                    <option value="all">Semua Tagihan</option>
                                    <option value="unpaid" selected>Belum Lunas</option>
                                    <option value="paid">Lunas</option>
                                    @endif
                                    @if($keyword == 'Lunas')
                                    <option value="all">Semua Tagihan</option>
                                    <option value="unpaid">Belum Lunas</option>
                                    <option value="paid" selected>Lunas</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(session()->has('success'))
            <input type="hidden" id="alert_success" value="{{ session('success') }}">
            @endif
            @if(session()->has('danger'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fe fe-x mr-1" aria-hidden="true"></i> {{ session('danger') }}
            </div>
            @endif
            <div class="panel text-center">
                <div class="panel-body px-0 py-2">
                    <div id="content-data">
                        @if($contents_count == 0)
                            <h6 class="m-4">No matching records found</h6>
                        @endif
                        @include('web.admin.report.purchasing_paginate')
                    </div>
                </div>
            </div>
            <div class="ajax-load text-center" style="">
                <p><i class="fa fa-circle-o-notch fa-spin fs-14"></i> Proses menampilkan ...</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        count = "{{$contents_count}}"
        limit = "{{$limit}}"
        if(count <= 10){
            $('.ajax-load').hide();
        }
        alert_success = $("#alert_success").val();
        if(alert_success != undefined){
            notif({
                msg: alert_success,
                type: "success",
                position: "center"
            });
        }
    });

    $("#payment-status").change(function(){
        $("#filter-form").submit();
    }); 

    var page = 1;
    $(window).scroll(function(){
        var key = '{{$keyword}}';
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 1){
            page++;
            loadMoreData(page, key);
        }
    });

    function loadMoreData(page, key){
        $.ajax({
            url:'?page=' + page + '&filter-payment=' + key,
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
</x-layouts.app>