<x-layouts.app>
    <x-header-white-3column back="&nbsp;">
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <style>
        .accordionjs .acc_section .acc_head {
            background: #ffffff;
        }
        .accordionjs .acc_section.acc_active > .acc_head {
            border-radius: 0px;
        }

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
        
        /* Tampilan Khusus Mobile */
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
    
    <!-- Daterangepicker CSS & JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="card no-border shadow-none custom-square mb-3">
                    <div class="card-body py-3">
                        <i class="fe fe-settings card-custom-icon icon-dropshadow-primary text-primary fs-35"></i>
                        <h5 class="mb-1 font-weight-bold text-primary">Laporan</h5>
                        <span class="mb-1 text-muted">To analyze financial reports</span>
                    </div>
                </div>
                <div class="card no-border shadow-none custom-square mb-0">
                    <div class="card-body py-3">
                        <form id="report-period" name="report-period" action="{{url('report-period')}}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="form-group row">
                            <div class="col-12 px-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text px-2 text-default" style="background-color: var(--primary-color);">
                                            <i class="fa fa-calendar text-default tx-16 lh-0 op-6"></i>
                                        </div>
                                    </div>
                                    <input class="form-control form-control-sm" id="report_daterange" type="text" placeholder="Pilih Periode" readonly style="background: #fff; cursor: pointer;">
                                </div>
                                <input type="hidden" name="report_date_start" id="report_date_start" value="{{date('d-m-Y', strtotime($report_date_start))}}">
                                <input type="hidden" name="report_date_end" id="report_date_end" value="{{date('d-m-Y', strtotime($report_date_end))}}">
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="card no-border shadow-none custom-square mb-7">
                    <div class="card-body p-0">
                        <ul class="demo-accordion accordionjs m-0 custom-square">
                            <li class="custom-square">
                                <div><h3>Pemasukan</h3></div>
                                <div>
                                    <a href="{{url('report-bean-list')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Penjualan Coffee Bean & Alat Kopi</h6>
                                    </a>
                                    <a href="{{url('report-store-income')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Penjualan Toko Kopi</h6>
                                    </a>
                                    <a href="{{url('report-invest-list')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Investasi</h6>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div><h3>Pengeluaran</h3></div>
                                <div>
                                    <a href="{{url('report-purchasing-list')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Belanja Stok Coffee Bean & Alat Kopi</h6>
                                    </a>
                                    <a href="{{url('report-store-purchasing')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Belanja Stok Kedai</h6>
                                    </a>
                                    <a href="{{url('report-store-operational')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Operasional Kedai</h6>
                                    </a>
                                    <a href="{{url('report-barista-fee')}}" class="d-flex p-3">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Gaji Karyawan Kedai</h6>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div><h3>Rekap</h3></div>
                                <div>
                                    <a href="{{url('report-store-recap')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Toko Kopi</h6>
                                    </a>
                                    <a href="{{url('report-product-recap')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Coffee Bean & Alat Kopi (Produk)</h6>
                                    </a>
                                    <a href="{{url('report-product-recap-type')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Coffee Bean & Alat Kopi (Tipe)</h6>
                                    </a>
                                    <a href="{{url('report-product-recap-author')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Coffee Bean & Alat Kopi (Author)</h6>
                                    </a>
                                    <a href="{{url('report-profit-share')}}" class="d-flex p-3">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Sharing Profit</h6>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div><h3>Statistik</h3></div>
                                <div>
                                    <a href="{{url('report-statistic-bean')}}" class="d-flex p-3">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Penjualan Coffee Bean & Alat Kopi</h6>
                                    </a>
                                </div>
                            </li>
                            {{-- <li>
                                <div>
                                    <a href="{{url('report-summary')}}" class="d-flex p-3">
                                        <i class="fe fe-file fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Cash Summary</h6>
                                    </a>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var start = moment('{{date("Y-m-d", strtotime($report_date_start))}}');
            var end = moment('{{date("Y-m-d", strtotime($report_date_end))}}');

            $('#report_daterange').daterangepicker({
                startDate: start,
                endDate: end,
                locale: {
                    format: 'DD MMM YYYY'
                }
            }, function(start_date, end_date) {
                // Hidden input tetap format DD-MM-YYYY untuk backend
                $('#report_date_start').val(start_date.format('DD-MM-YYYY'));
                $('#report_date_end').val(end_date.format('DD-MM-YYYY'));

                // Submit otomatis saat tombol Apply ditekan!
                $('#report-period').submit();
            }).on('show.daterangepicker', function(ev, picker) {
                // Memindahkan area tombol ke posisi paling atas di dalam pop-up kalender
                picker.container.find('.drp-buttons').prependTo(picker.container);
            });
            
            // Set initial display value (DD MMM YYYY)
            $('#report_daterange').val(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
        });
    </script>
</x-layouts.app>