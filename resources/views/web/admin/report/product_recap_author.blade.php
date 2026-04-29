<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('report')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>

<style>
    /* Premium & Dashtic v1.0.0 Index 2 Styles */
    .dashboard-card { 
        border-radius: 12px; 
        border: none; 
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); 
        background: #fff;
    }
    .author-panel { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 20px; background: #fff; }
    .author-header { padding: 15px 20px; background: #f8f9ff; border-bottom: 1px solid #edf2f9; display: flex; align-items: center; border-radius: 15px 15px 0 0; }
    .author-avatar { width: 40px; height: 40px; background: #4454c3; color: white; display: flex; align-items: center; justify-content: center; border-radius: 10px; font-weight: bold; margin-right: 12px; }
    .type-row { padding: 10px 20px; display: flex; justify-content: space-between; border-bottom: 1px solid #f1f4f8; }
    .type-row:last-child { border-bottom: none; }
    .profit-green { color: #2dce89; font-weight: 600; }
    
    .badge-cat-green { background-color: #e6fcf5; color: #0ca678; border: 1px solid #c3fae8; }
    .badge-cat-filter { background-color: #fff9db; color: #f08c00; border: 1px solid #fff3bf; }
    .badge-cat-espresso { background-color: #fff0f6; color: #d6336c; border: 1px solid #ffdeeb; }
    .badge-cat-other { background-color: #e7f5ff; color: #1c7ed6; border: 1px solid #d0ebff; }

    .header-content { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; }
    .date-badge {
        background: #f0f3ff;
        color: #4454c3;
        padding: 6px 15px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 13px;
        border: 1px solid #e0e6ff;
    }
    
    .widget-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 24px;
    }

    @media (max-width: 768px) {
        .header-content { flex-direction: column; align-items: center; text-align: center; }
        .container { padding-left: 10px; padding-right: 10px; }
    }
</style>

@php
    if(!function_exists('getCategoryClass')){
        function getCategoryClass($typeName) {
            $name = strtolower($typeName);
            if (strpos($name, 'green') !== false) return 'badge-cat-green';
            if (strpos($name, 'filter') !== false) return 'badge-cat-filter';
            if (strpos($name, 'espresso') !== false) return 'badge-cat-espresso';
            return 'badge-cat-other';
        }
    }
@endphp

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-10 mx-auto">
            <!-- Header Section -->
            <div class="card no-border shadow-none custom-square mb-4">
                <div class="card-body py-3 px-4">
                    <div class="header-content">
                        <div class="header-title">
                            <h4 class="mb-1 font-weight-bold text-primary">Dashboard Capaian Author</h4>
                            <p class="mb-0 text-muted">Statistik performa user berdasarkan kategori produk</p>
                        </div>
                        <div class="header-date">
                            <div class="date-badge">
                                <i class="fe fe-calendar mr-2"></i>
                                {{ date('d M Y', strtotime($report_date_start)) }} - {{ date('d M Y', strtotime($report_date_end)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Cards -->
            <div class="row mb-4">
                @if(isset($author_summary) && $author_summary->count() > 0)
                <div class="col-md-6 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-left">
                                        <span class="fs-12 font-weight-semibold text-muted uppercase">TOP CONTRIBUTOR</span>
                                        <h3 class="mb-0 mt-1 text-dark font-weight-bold">{{ $author_summary[0]->author_name }}</h3>
                                        <p class="mb-0 text-muted fs-12 mt-1">Volume: <span class="font-weight-bold">{{ number_format($author_summary[0]->total_qty / 1000, 2) }} Kg</span></p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="widget-icon bg-light float-right">
                                        <i class="fe fe-award text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="mt-0 text-left">
                                        <span class="fs-12 font-weight-semibold text-muted uppercase">TOTAL PROFIT</span>
                                        <h3 class="mb-0 mt-1 text-success font-weight-bold">Rp {{ number_format($author_summary->sum('total_profit'), 0, ',', '.') }}</h3>
                                        <p class="mb-0 text-muted fs-12 mt-1">From <span class="font-weight-bold">{{ $author_summary->count() }} Authors</span></p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="widget-icon bg-light float-right">
                                        <i class="fe fe-users text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Chart Section -->
            <div class="card no-border shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-3 p-md-4">
                    <div id="author-chart" style="width:100%;height:400px"></div>
                </div>
            </div>

            <!-- Summary Table -->
            <div class="card no-border shadow-sm mb-4 mt-4" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                    <h5 class="card-title font-weight-bold mb-0">Tabel Ringkasan Author</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter text-nowrap mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4">Author</th>
                                    <th class="text-center">Total Volume (Beans)</th>
                                    <th class="text-right px-4">Total Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($author_summary as $summary)
                                <tr>
                                    <td class="px-4 font-weight-semibold">{{ $summary->author_name }}</td>
                                    <td class="text-center">{{ number_format($summary->total_qty / 1000, 2) }} Kg</td>
                                    <td class="text-right px-4 font-weight-bold">Rp {{ number_format($summary->total_profit, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Individual Author Panels -->
            <h5 class="font-weight-bold mb-3 text-dark mt-5 px-1"><i class="fe fe-grid mr-2 text-primary"></i> Capaian Individual Author</h5>
            <div class="row">
                @php $groupedItems = $items->groupBy('author_name'); @endphp
                @foreach($groupedItems as $authorName => $authorItems)
                <div class="col-md-6">
                    <div class="card author-panel">
                        <div class="author-header">
                            <div class="author-avatar">{{ substr($authorName, 0, 1) }}</div>
                            <h6 class="mb-0 font-weight-bold">{{ $authorName }}</h6>
                        </div>
                        <div class="author-body">
                            @foreach($authorItems as $item)
                            <div class="type-row">
                                <span class="badge {{ getCategoryClass($item->type_name) }}">{{ $item->type_name }}</span>
                                <span class="small font-weight-semibold">
                                    <span class="profit-green">Rp {{ number_format($item->total_profit, 0, ',', '.') }}</span> 
                                    <span class="text-muted">
                                        (@if(strtolower($item->type_name) == 'tools') {{ number_format($item->raw_qty) }} pcs @else {{ number_format($item->total_qty / 1000, 2) }} Kg @endif)
                                    </span>
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Detailed Table -->
            <div class="card no-border shadow-sm mb-7" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-transparent border-bottom-0 pt-4 px-4 d-flex align-items-center">
                    <h5 class="card-title font-weight-bold mb-0 text-muted">Rincian Per Kategori</h5>
                    <div class="ml-auto">
                        <button class="btn btn-sm btn-light no-border" onclick="window.print()"><i class="fe fe-printer mr-1"></i> Cetak</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover v-center text-nowrap mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4">Author</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Qty/Volume</th>
                                    <th class="text-right px-4">Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="px-4">{{ $item->author_name }}</td>
                                    <td><span class="badge {{ getCategoryClass($item->type_name) }}">{{ $item->type_name }}</span></td>
                                    <td class="text-center">
                                        @if(strtolower($item->type_name) == 'tools') {{ number_format($item->raw_qty) }} pcs @else {{ number_format($item->total_qty / 1000, 2) }} Kg @endif
                                    </td>
                                    <td class="text-right px-4 font-weight-bold">Rp {{ number_format($item->total_profit, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const rawData = @json($items);
        const filteredData = rawData.filter(d => d.total_qty > 0);
        
        const authors = [...new Set(filteredData.map(item => item.author_name))];
        const types = [...new Set(filteredData.map(item => item.type_name))];
        
        const series = types.map(type => {
            return {
                name: type,
                data: authors.map(author => {
                    const found = filteredData.find(d => d.author_name === author && d.type_name === type);
                    return found ? parseFloat(found.total_qty) / 1000 : 0;
                })
            };
        });

        Highcharts.chart('author-chart', {
            chart: { type: 'column', backgroundColor: 'transparent', zoomType: 'x' },
            title: { text: 'Perbandingan Volume Penjualan per Tipe Produk', style: { fontSize: '15px', fontWeight: 'bold' } },
            subtitle: { text: 'Klik dan geser pada grafik untuk zoom | Satuan: Kg' },
            xAxis: { categories: authors, crosshair: true },
            yAxis: { min: 0, title: { text: 'Berat (Kg)' } },
            tooltip: {
                headerFormat: '<span style="font-size:12px"><b>{point.key}</b></span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.2f} Kg</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.1,
                    borderWidth: 0,
                    dataLabels: { enabled: true, format: '{point.y:.1f}', style: { fontSize: '10px' } }
                }
            },
            legend: { layout: 'horizontal', align: 'center', verticalAlign: 'bottom', itemStyle: { fontWeight: 'normal', fontSize: '11px' } },
            credits: { enabled: false },
            series: series
        });
    });
</script>
</x-layouts.app>
