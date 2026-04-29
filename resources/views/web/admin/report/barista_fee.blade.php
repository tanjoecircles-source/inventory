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
    .card-dashboard { border-radius: 8px; transition: transform 0.2s; border: none; }
    .card-dashboard:hover { transform: translateY(-5px); }
    .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    
    /* Dashtic inspired colors */
    .bg-primary-transparent { background-color: rgba(61, 90, 254, 0.1); color: #3d5afe; }
    .bg-success-transparent { background-color: rgba(0, 230, 118, 0.1); color: #00e676; }
    .bg-danger-transparent { background-color: rgba(255, 23, 68, 0.1); color: #ff1744; }
    .bg-warning-transparent { background-color: rgba(255, 196, 0, 0.1); color: #ffc400; }
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-10 mx-auto">
            <!-- Header Section -->
            <div class="d-flex align-items-center mb-4 mt-4">
                <div class="mr-auto">
                    <h4 class="mb-1 font-weight-bold">Laporan Gaji Karyawan</h4>
                    <p class="text-muted mb-0">Rekapitulasi penggajian per periode</p>
                </div>
                <div class="ml-auto">
                    <form id="report-period" name="report-period" action="{{url('report-period')}}" method="POST" class="mb-0">
                        @csrf
                        <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                            <div class="input-group-prepend">
                                <div class="input-group-text border-0" style="background: #fff;">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <input class="form-control border-0 font-weight-bold" id="report_daterange" type="text" readonly style="background: #fff; cursor: pointer; min-width: 200px;">
                        </div>
                        <input type="hidden" name="report_date_start" id="report_date_start" value="{{date('d-m-Y', strtotime($report_date_start))}}">
                        <input type="hidden" name="report_date_end" id="report_date_end" value="{{date('d-m-Y', strtotime($report_date_end))}}">
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-6 col-md-3 mb-3">
                    <div class="card shadow-sm card-dashboard h-100">
                        <div class="card-body p-3 text-center">
                            <div class="icon-box bg-blue mx-auto mb-3">
                                <i class="fe fe-dollar-sign text-white fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-11 text-uppercase font-weight-bold">Total Gaji Gross</h6>
                            <h5 class="font-weight-bold mb-0">Rp {{number_format($total_fee, 0, ',', '.')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card shadow-sm card-dashboard h-100">
                        <div class="card-body p-3 text-center">
                            <div class="icon-box bg-danger mx-auto mb-3">
                                <i class="fe fe-minus-circle text-white fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-11 text-uppercase font-weight-bold">Total Potongan</h6>
                            <h5 class="font-weight-bold mb-0">Rp {{number_format($total_potongan, 0, ',', '.')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card shadow-sm card-dashboard h-100">
                        <div class="card-body p-3 text-center">
                            <div class="icon-box bg-success mx-auto mb-3">
                                <i class="fe fe-check-circle text-white fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-11 text-uppercase font-weight-bold">Total Net Paid</h6>
                            <h5 class="font-weight-bold mb-0">Rp {{number_format($total_share, 0, ',', '.')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card shadow-sm card-dashboard h-100">
                        <div class="card-body p-3 text-center">
                            <div class="icon-box bg-warning mx-auto mb-3">
                                <i class="fe fe-calendar text-white fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-11 text-uppercase font-weight-bold">Periode</h6>
                            <h5 class="font-weight-bold mb-0">{{count($contents)}} <small class="text-muted">Bulan</small></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Data Section -->
            <div class="card no-border shadow-sm custom-square">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 font-weight-bold"><i class="fe fe-list mr-2"></i>History Penggajian</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase">Periode</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-right">Gaji Gross</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-right">Potongan</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-right">Net Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($contents) > 0)
                                    @foreach($contents as $it)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{$it->periode_name}}</div>
                                            <div class="fs-12 text-muted">{{date('d M', strtotime($it->start_date))}} - {{date('d M Y', strtotime($it->end_date))}}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="font-weight-bold text-dark">Rp {{number_format($it->total_fee, 0, ',', '.')}}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="text-danger">Rp {{number_format($it->total_potongan, 0, ',', '.')}}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="font-weight-bold text-success">Rp {{number_format($it->total_share, 0, ',', '.')}}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <img src="{{asset('assets/images/png/empty.png')}}" alt="empty" width="60" class="mb-2 op-3">
                                            <p class="text-muted">Tidak ada data penggajian ditemukan</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($contents->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-center">
                        {{ $contents->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var start = moment($('#report_date_start').val(), "DD-MM-YYYY");
    var end = moment($('#report_date_end').val(), "DD-MM-YYYY");

    function cb(start, end) {
        $('#report_daterange').val(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
        $('#report_date_start').val(start.format('DD-MM-YYYY'));
        $('#report_date_end').val(end.format('DD-MM-YYYY'));
    }

    $('#report_daterange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
           'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           '3 Bulan Terakhir': [moment().subtract(3, 'month'), moment()],
           'Tahun Ini': [moment().startOf('year'), moment().endOf('year')]
        },
        locale: {
            format: 'DD MMM YYYY',
            applyLabel: "Terapkan",
            cancelLabel: "Batal",
        }
    }, cb);

    cb(start, end);

    $('#report_daterange').on('apply.daterangepicker', function(ev, picker) {
        $('#report-period').submit();
    });
});
</script>
</x-layouts.app>
