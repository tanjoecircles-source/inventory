<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('report')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>

<!-- Daterangepicker CSS & JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<style>
    /* Customisasi Daterangepicker: Tombol di atas & Mobile Friendly */
    .daterangepicker .drp-buttons {
        border-top: none;
        border-bottom: 1px solid #eee;
        padding: 12px 10px;
        text-align: right;
        background: #f8f9fa;
    }
    .daterangepicker .drp-buttons .btn {
        font-weight: bold;
        padding: 6px 15px;
    }
    @media (max-width: 576px) {
        .daterangepicker {
            width: 100% !important;
            left: 0 !important;
            right: 0 !important;
            border-radius: 0;
            margin-top: 0;
        }
        .daterangepicker .drp-calendar.left,
        .daterangepicker .drp-calendar.right {
            width: 100%;
            max-width: 100%;
            float: none;
            padding: 10px;
        }
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <!-- Summary Header -->
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <h5 class="mb-1 font-weight-bold text-primary">Penjualan</h5>
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

            <!-- Date Filter & Actions -->
            <div class="card no-border shadow-none custom-square mt-2 mb-0">
                <div class="card-body p-2 px-4">
                    <!-- Global Date Picker Form -->
                    <form id="report-period" name="report-period" action="{{url('report-period')}}" method="POST" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text p-1">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6 text-primary"></i>
                                </div>
                            </div>
                            <input class="form-control form-control-sm font-weight-bold" id="report_daterange" type="text" placeholder="Pilih Periode" readonly style="background: #fff; cursor: pointer;">
                        </div>
                        <input type="hidden" name="report_date_start" id="report_date_start" value="{{date('d-m-Y', strtotime($report_date_start))}}">
                        <input type="hidden" name="report_date_end" id="report_date_end" value="{{date('d-m-Y', strtotime($report_date_end))}}">
                    </form>

                    <!-- Payment Status & Download Actions -->
                    <form id="filter-form" name="search-form" action="{{url('report-bean-list')}}" method="GET">
                        <div class="d-flex title-bar py-1">
                            <div class="mr-auto text-left">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Download Laporan <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url('report-product-export')}}"><i class="fa fa-file-excel-o"></i> Berdasarkan Invoice</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{url('report-product-print')}}"><i class="fa fa-file-excel-o"></i> Berdasarkan Produk</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="fa fa-file-excel-o"></i> Berdasarkan Pelanggan</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <select class="form-control form-control-sm" name="filter-payment" id="payment-status">
                                    <option value="all" @if($keyword == 'all') selected @endif>Semua Tagihan</option>
                                    <option value="unpaid" @if($keyword == 'unpaid') selected @endif>Belum Lunas</option>
                                    <option value="paid" @if($keyword == 'paid') selected @endif>Lunas</option>
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
                        @include('web.admin.report.bean_paginate')
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
        // 1. DATE RANGE PICKER
        var start = moment('{{date("Y-m-d", strtotime($report_date_start))}}');
        var end = moment('{{date("Y-m-d", strtotime($report_date_end))}}');

        $('#report_daterange').daterangepicker({
            startDate: start,
            endDate: end,
            locale: {
                format: 'DD MMM YYYY'
            }
        }, function(start_date, end_date) {
            $('#report_date_start').val(start_date.format('DD-MM-YYYY'));
            $('#report_date_end').val(end_date.format('DD-MM-YYYY'));
            $('#report-period').submit();
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find('.drp-buttons').prependTo(picker.container);
        });
        
        $('#report_daterange').val(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));

        // 2. ALERT
        var alert_success = $("#alert_success").val();
        if(alert_success != undefined){
            notif({
                msg: alert_success,
                type: "success",
                position: "center"
            });
        }

        // 3. PAGINATION
        var count = "{{$contents_count}}";
        if(count <= 10){
            $('.ajax-load').hide();
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