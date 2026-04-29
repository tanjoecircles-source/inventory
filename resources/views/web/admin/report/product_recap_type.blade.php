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
    /* Category Badge Styles */
    .badge-cat-green { background-color: #e6fcf5; color: #0ca678; border: 1px solid #c3fae8; }
    .badge-cat-filter { background-color: #fff9db; color: #f08c00; border: 1px solid #fff3bf; }
    .badge-cat-espresso { background-color: #fff0f6; color: #d6336c; border: 1px solid #ffdeeb; }
    .badge-cat-other { background-color: #e7f5ff; color: #1c7ed6; border: 1px solid #d0ebff; }
</style>

@php
    function getCategoryClass($typeName) {
        $name = strtolower($typeName);
        if (strpos($name, 'green') !== false) return 'badge-cat-green';
        if (strpos($name, 'filter') !== false) return 'badge-cat-filter';
        if (strpos($name, 'espresso') !== false) return 'badge-cat-espresso';
        return 'badge-cat-other';
    }
@endphp

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body py-3 px-4">
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <h5 class="mb-1 font-weight-bold text-primary">Rekap Berdasarkan Tipe Produk</h5>
                            <span class="mb-1 text-muted">Periode: {{ date('d M Y', strtotime($report_date_start)) }} - {{ date('d M Y', strtotime($report_date_end)) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter text-nowrap mb-0 border-top">
                            <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-bold">Tipe Produk</th>
                                    <th class="text-center font-weight-bold">Volume</th>
                                    <th class="text-right font-weight-bold">Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                <tr>
                                    <td>
                                        <span class="badge {{ getCategoryClass($item->type_name) }}">{{ $item->type_name }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if(strtolower($item->type_name) == 'tools')
                                            <span class="font-weight-semibold">{{ number_format($item->raw_qty) }} pcs</span>
                                        @else
                                            <span class="font-weight-semibold">{{ number_format($item->total_qty / 1000, 2) }} Kg</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <h6 class="mb-0 font-weight-semibold">Rp {{ number_format($item->total_profit, 0, ',', '.') }}</h6>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <img src="{{ asset('assets/images/no-data.png') }}" alt="No Data" style="width: 100px; opacity: 0.5;">
                                        <p class="text-muted mt-3">Tidak ada data penjualan pada periode ini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($items->count() > 0)
                            <tfoot class="bg-light border-top-2">
                                <tr>
                                    <td class="font-weight-bold py-3">TOTAL</td>
                                    <td class="text-center font-weight-bold text-primary py-3">
                                        {{ number_format($items->sum('total_qty') / 1000, 2) }} Kg
                                    </td>
                                    <td class="text-right font-weight-bold text-primary py-3">
                                        Rp {{ number_format($items->sum('total_profit'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
