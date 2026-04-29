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
    .card-dashboard {
        border-radius: 8px;
        transition: transform 0.2s;
    }
    .card-dashboard:hover {
        transform: translateY(-5px);
    }
    .icon-box {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .bg-primary-transparent { background-color: rgba(120, 140, 254, 0.1); color: #3d5afe; }
    .bg-success-transparent { background-color: rgba(0, 230, 118, 0.1); color: #00e676; }
    .bg-danger-transparent { background-color: rgba(255, 23, 68, 0.1); color: #ff1744; }
    .bg-warning-transparent { background-color: rgba(255, 196, 0, 0.1); color: #ffc400; }
    
    .daterangepicker { border-radius: 8px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .daterangepicker .drp-buttons .btn { border-radius: 4px; }
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-10 mx-auto">
            <!-- Header Section -->
            <div class="d-flex align-items-center mb-4 mt-4">
                <div class="mr-auto">
                    <h4 class="mb-1 font-weight-bold">Dashboard Investasi</h4>
                    <p class="text-muted mb-0">Total akumulasi modal dan kewajiban</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-6 col-md-3 mb-3">
                    <div class="card no-border shadow-sm card-dashboard h-100">
                        <div class="card-body p-3">
                            <div class="icon-box bg-primary mb-3">
                                <i class="fe fe-trending-up fs-20 text-white"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-12 text-uppercase font-weight-bold">Total Investasi</h6>
                            <h5 class="font-weight-bold mb-0">Rp {{number_format($total_invest, 0, ',', '.')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card no-border shadow-sm card-dashboard h-100">
                        <div class="card-body p-3">
                            <div class="icon-box bg-success mb-3">
                                <i class="fe fe-check-circle fs-20 text-white"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-12 text-uppercase font-weight-bold">Total Terbayar</h6>
                            <h5 class="font-weight-bold mb-0">Rp {{number_format($total_payment, 0, ',', '.')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card no-border shadow-sm card-dashboard h-100">
                        <div class="card-body p-3">
                            <div class="icon-box bg-blue mb-3">
                                <i class="fe fe-alert-circle text-white fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-12 text-uppercase font-weight-bold">Sisa Kewajiban</h6>
                            <h5 class="font-weight-bold mb-0">Rp {{number_format($remaining, 0, ',', '.')}}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card no-border shadow-sm card-dashboard h-100">
                        <div class="card-body p-3">
                            <div class="icon-box bg-warning mb-3">
                                <i class="fe fe-users text-white fs-20"></i>
                            </div>
                            <h6 class="text-muted mb-1 fs-12 text-uppercase font-weight-bold">Investor</h6>
                            <h5 class="font-weight-bold mb-0">{{$total_investors}} <small class="text-muted">Orang</small></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Data Section -->
            <div class="card no-border shadow-sm custom-square">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 font-weight-bold"><i class="fe fe-list mr-2"></i>Daftar Investasi</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase">Investor</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-center">Periode</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-right">Modal</th>
                                    <th class="border-0 font-weight-bold fs-12 text-uppercase text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($contents) > 0)
                                    @foreach($contents as $it)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{$it->name}}</div>
                                            <div class="fs-12 text-muted">{{$it->phone}}</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="fs-13">{{$it->start_date}}</div>
                                            <div class="fs-11 text-muted">Hingga {{$it->due_date}}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="font-weight-bold">Rp {{number_format($it->total_invest, 0, ',', '.')}}</div>
                                            <div class="fs-11 text-success">Margin {{$it->margin}}%</div>
                                        </td>
                                        <td class="text-right">
                                            @php 
                                                $percent = ($it->total_invest > 0) ? ($it->total_payment / $it->total_invest) * 100 : 0;
                                                $status_color = ($percent >= 100) ? 'success' : 'primary';
                                            @endphp
                                            <div class="progress progress-xs mb-1">
                                                <div class="progress-bar bg-{{$status_color}}" role="progressbar" style="width: {{$percent}}%"></div>
                                            </div>
                                            <div class="fs-11 font-weight-bold text-{{$status_color}}">{{number_format($percent, 1)}}% Terbayar</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <img src="{{asset('assets/images/png/empty.png')}}" alt="empty" width="60" class="mb-2 op-3">
                                            <p class="text-muted">Tidak ada data investasi ditemukan</p>
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

</x-layouts.app>
