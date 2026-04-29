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
    .icon-box { width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    
    .bg-blue-transparent { background-color: rgba(0, 123, 255, 0.1); color: #007bff; }
    .bg-green-transparent { background-color: rgba(40, 167, 69, 0.1); color: #28a745; }
    .bg-red-transparent { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .bg-orange-transparent { background-color: rgba(253, 126, 20, 0.1); color: #fd7e14; }
    
    .comparison-badge { font-size: 11px; padding: 2px 8px; border-radius: 10px; font-weight: bold; }
    .badge-up { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .badge-down { background-color: rgba(40, 167, 69, 0.1); color: #28a745; }
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-10 mx-auto">
            <!-- Header Section -->
            <div class="d-flex align-items-center mb-4 mt-4">
                <div class="mr-auto">
                    <h4 class="mb-1 font-weight-bold">Laporan Operasional Kedai</h4>
                    <p class="text-muted mb-0">Rekapitulasi biaya operasional harian</p>
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
            <div class="row mb-2">
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm card-dashboard h-80">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-orange-transparent mr-3">
                                    <i class="fe fe-activity fs-24"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 fs-12 text-uppercase font-weight-bold">Total Operasional Periode Ini</h6>
                                    <h3 class="font-weight-bold mb-0">Rp {{number_format($current_total, 0, ',', '.')}}</h3>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                @if($percent_change > 0)
                                    <span class="comparison-badge badge-up mr-2"><i class="fe fe-arrow-up mr-1"></i>{{number_format($percent_change, 1)}}%</span>
                                @else
                                    <span class="comparison-badge badge-down mr-2"><i class="fe fe-arrow-down mr-1"></i>{{number_format(abs($percent_change), 1)}}%</span>
                                @endif
                                <span class="text-muted fs-12">Dibandingkan bulan lalu (Rp {{number_format($prev_total, 0, ',', '.')}})</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card shadow-sm card-dashboard h-80">
                        <div class="card-body p-3 text-center">
                            <div class="icon-box bg-blue-transparent mx-auto mb-3">
                                <i class="fe fe-file-text fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-11 text-uppercase font-weight-bold">Biaya Rutin</h6>
                            <h5 class="font-weight-bold mb-0">{{$current_count}} <small class="text-muted">Item</small></h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card shadow-sm card-dashboard h-80">
                        <div class="card-body p-3 text-center">
                            <div class="icon-box bg-green-transparent mx-auto mb-3">
                                <i class="fe fe-trending-down fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-11 text-uppercase font-weight-bold">Rata-rata</h6>
                            <h5 class="font-weight-bold mb-0">Rp {{($current_count > 0) ? number_format($current_total / $current_count, 0, ',', '.') : 0}}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Data Section -->
            <div class="card no-border shadow-sm custom-square">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 font-weight-bold"><i class="fe fe-list mr-2"></i>Daftar Pengeluaran Operasional</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase">Nota / Vendor</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-center">Tanggal</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-right">Total</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-right">Status Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($contents) > 0)
                                    @foreach($contents as $it)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-primary">{{$it->op_code}}</div>
                                            <div class="fs-12 text-muted">{{$it->vendor_name}}</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="fs-13">{{date('d M Y', strtotime($it->op_date))}}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="font-weight-bold text-dark">Rp {{number_format($it->op_total, 0, ',', '.')}}</div>
                                        </td>
                                        <td class="text-right">
                                            @if($it->op_status_payment == 'Lunas')
                                                <span class="badge badge-success-light px-2 py-1">Lunas</span>
                                            @else
                                                <span class="badge badge-danger-light px-2 py-1">Belum Lunas</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <img src="{{asset('assets/images/png/empty.png')}}" alt="empty" width="60" class="mb-2 op-3">
                                            <p class="text-muted">Tidak ada data operasional ditemukan</p>
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
           '3 Bulan Terakhir': [moment().subtract(3, 'month'), moment()]
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
