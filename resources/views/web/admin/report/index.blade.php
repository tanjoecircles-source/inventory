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
    </style>
    
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
                            <label class="col-3 px-1 form-label">Periode</label>
                            <div class="col-4 px-1">
                                <input class="form-control form-control-sm fc-datepicker" name="report_date_start" value="{{date('d-m-Y', strtotime($report_date_start))}}" type="text" placeholder="Tanggal Awal">
                            </div>
                            <div class="col-4 px-1">
                                <input class="form-control form-control-sm fc-datepicker" name="report_date_end" value="{{date('d-m-Y', strtotime($report_date_end))}}" type="text" placeholder="Tanggal Akhir">
                            </div>
                            <div class="col-1 px-1">
                                <button type="submit" class="btn btn-primary btn-sm py-1 px-2"><i class="fe fe-settings"></i></button>
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
                                    <a href="{{url('brand-list')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Investasi</h6>
                                    </a>
                                    <a href="{{url('brand-list')}}" class="d-flex p-3 border-bottom">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Kredit</h6>
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
                                    <a href="#" class="d-flex p-3">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Belanja Stok Kedai</h6>
                                    </a>
                                    <a href="#" class="d-flex p-3">
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
                                    <a href="#" class="d-flex p-3">
                                        <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                        <h6 class="mb-1 font-weight-semibold">Coffee Bean & Alat Kopi</h6>
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
    </x-layouts.app>
    