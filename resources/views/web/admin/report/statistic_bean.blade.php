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
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto mt-2">
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <h5 class="mb-1 font-weight-bold text-dark">Statistik</h5>
                            <span class="mb-1 text-muted">for Sales analytic</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto mt-2">
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body py-2 px-0">
                    <div id="sales-chart" style="width:100%;height:500px"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto mt-2">
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body py-2 px-0">
                    <div id="profit-chart" style="width:100%;height:400px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
fetch('/report-statistic-bean-json')
  .then(res => res.json())
  .then(data => {

    const coloredSeries = data.series.map((s, i) => {
      const colors = ['#4454c3', '#2dce89', '#f72d66', '#fc7303', '#aa4cf2', '#ecb403']; // Income, Profit, Profit%
      return { ...s, color: colors[i] || '#999' }; // fallback warna abu
    });

    Highcharts.chart('sales-chart', {
      chart: { type: 'bar' },
      title: { text: 'Statistik Penjualan Berdasarkan Kategori' },
      xAxis: { categories: data.categories },
      yAxis: { title: { text: 'Total Penjualan (Rp)' } },
      series: coloredSeries
    });
});
fetch('/report-statistic-profit-json')
  .then(res => res.json())
  .then(data => {
    const coloredSeries = data.series.map((s, i) => {
      const colors = ['#4454c3', '#2dce89', '#f72d66']; // Income, Profit, Profit%
      return { ...s, color: colors[i] || '#999' }; // fallback warna abu
    });

    Highcharts.chart('profit-chart', {
      chart: { type: 'bar'},
      title: { text: 'Income & Profit' },
      xAxis: [{ categories: data.labels }],
      yAxis: [
        { // Kiri: nominal
          title: { text: 'Rupiah' },
          labels: { format: 'Rp {value:,.0f}' }
        },
        { // Kanan: persentase
          title: { text: 'Profit (%)' },
          labels: { format: '{value}%' },
          opposite: true
        }
      ],
      tooltip: {
        shared: true,
        valueDecimals: 2
      },
      series: coloredSeries 
    });
});
</script>
</x-layouts.app>