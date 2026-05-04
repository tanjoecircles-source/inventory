<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Share Profit Bulanan - {{ $detail->periode }}</title>
    <style>
        @page { size: A4; margin: 10mm 15mm; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; font-size: 9.5pt; line-height: 1.3; margin: 0; padding: 0; }
        .header { padding-bottom: 2px; margin-bottom: 12px; }
        .header h1 { font-size: 13pt; margin: 0; color: #333; }
        .header p { margin: 2px 0 0 0; font-size: 10pt; color: #666; }
        
        .section-title { font-size: 11pt; font-weight: bold; margin-top: 15px; margin-bottom: 8px; color: #000; padding-left: 8px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th { background-color: #f2f2f2; font-weight: bold; text-align: left; padding: 10px 8px; }
        td { padding: 6px 8px; border-bottom: 1px solid #eee; vertical-align: middle; }
        
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .total-row { background-color: #fafafa; font-weight: bold; }
        .total-row td { border-top: 1px solid #333; }
        .text-success { color: #28a745; }
        .text-error { color: #dc3545; }
        .summary-box { background-color: #E62129; color: #fff; padding: 8px 12px; margin-top: 10px; display: table; width: 100%; box-sizing: border-box; }
        .summary-box .label { font-size: 8pt; opacity: 0.8; margin-bottom: 2px; }
        .summary-box .value { font-size: 13pt; font-weight: bold; }
        
        .employee-table th { background-color: #f2f2f2; }
        .employee-table td { font-size: 9pt; }
        
        .footer { margin-top: 25px; font-size: 8pt; color: #888; }
        .signature-space { margin-top: 20px; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="float: left;">
            <h1>Rekap Share Profit</h1>
        </div>
        <div style="float: right; text-align: right;">
            <p style="margin: 0; font-size: 10pt;">Periode: <strong>{{ $detail->periode }}</strong></p>
        </div>
        <div style="clear: both;"></div>
    </div>
        <table>
            <thead>
                <tr>
                    <th>[+] Total Pemasukan</th>
                    <th class="text-right">Nominal (IDR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Penjualan Bahan (Green & Roasted Bean)</td>
                    <td class="text-right">{{ number_format($bean_recap->profit ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Operasional Kedai Kopi ({{ ($detail->profit_toko < 0) ? 'Loss' : 'Profit' }})</td>
                    <td class="text-right">{{ number_format($detail->profit_toko, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td class="text-success">Gross Revenue</td>
                    <td class="text-right text-success">{{ number_format(($bean_recap->profit ?? 0) + $detail->profit_toko, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

    @if(count($bean_spending) > 0)
    <table>
        <thead>
            <tr>
                <th>[-] Non Operational Cost (With Investor)</th>
                <th class="text-right">Nominal (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @php $total_spending = 0; @endphp
            @foreach($bean_spending as $spend)
            @php $total_spending += $spend->amount; @endphp
            <tr>
                <td>{{ $spend->name }}</td>
                <td class="text-right">{{ number_format($spend->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td class="text-error">Total Cost</td>
                <td class="text-right text-error">{{ number_format($total_spending, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    @endif

    <table>
        <thead>
            <tr>
                <th>[-] Investment / Saving (Non Investor)</th>
                <th class="text-right">Nominal (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @php $total_spending_non_investor = 0; @endphp
            @if(isset($bean_spending_non_investor) && count($bean_spending_non_investor) > 0)
                @foreach($bean_spending_non_investor as $spend)
                @php $total_spending_non_investor += $spend->amount; @endphp
                <tr>
                    <td>{{ $spend->name }}</td>
                    <td class="text-right">{{ number_format($spend->amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td>Potongan KUR (Co-Founders Liability)</td>
                    <td class="text-right">{{ number_format($detail->potongan_non_investor, 0, ',', '.') }}</td>
                </tr>
                @php $total_spending_non_investor = $detail->potongan_non_investor; @endphp
            @endif
            <tr class="total-row">
                <td class="text-error">Total Investment / Saving</td>
                <td class="text-right text-error">{{ number_format($total_spending_non_investor, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="summary-box">
        <div class="label">LABA BERSIH SIAP DIBAGIKAN (NET PROFIT SHARE)</div>
        <div class="value">Rp {{ number_format($detail->total_profit - $total_spending_non_investor, 0, ',', '.') }}</div>
    </div>

    <table class="employee-table">
        <thead>
            <tr>
                <th>Rincian Pembagian</th>
                <th class="text-right">Gross Revenue</th>
                <th class="text-right">Non Operational Cost</th>
                <th class="text-right">Investment / Saving</th>
                <th class="text-right">Net Diterima</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $gross_revenue = ($bean_recap->profit ?? 0) + $detail->profit_toko;
                $total_cost = isset($total_spending) ? $total_spending : 0;
                
                $sum_gross = 0;
                $sum_with_investor = 0;
                $sum_tabungan = 0;
                $sum_net = 0;
            @endphp
            @foreach($contents as $content)
            @php
                $percent = $detail->total_profit > 0 ? $content->sub_total / $detail->total_profit : 0;
                $gross_share = $gross_revenue * $percent;
                $with_investor_share = $total_cost * $percent;
                $tabungan = $content->tabungan_credit > 0 ? $content->tabungan_credit : 0;
                
                // Net Diterima is proportional Gross minus proportional Cost minus Tabungan
                // This perfectly matches ($content->sub_total - tabungan), which is $content->total
                $net_diterima = $gross_share - $with_investor_share - $tabungan;

                
                $sum_gross += $gross_share;
                $sum_with_investor += $with_investor_share;
                $sum_tabungan += $tabungan;
                $sum_net += $net_diterima;
            @endphp
            <tr>
                <td><strong>{{ $content->employee }} ({{ round($percent * 100, 2) }}%)</strong></td>
                <td class="text-right text-success">+ {{ number_format($gross_share, 0, ',', '.') }}</td>
                <td class="text-right text-error">- {{ number_format($with_investor_share, 0, ',', '.') }}</td>
                <td class="text-right text-error">- {{ $tabungan > 0 ? number_format($tabungan, 0, ',', '.') : '0' }}</td>
                <td class="text-right font-bold">Rp {{ number_format($net_diterima, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td class="text-right text-success">+ {{ number_format($sum_gross, 0, ',', '.') }}</td>
                <td class="text-right text-error">- {{ number_format($sum_with_investor, 0, ',', '.') }}</td>
                <td class="text-right text-error">- {{ number_format($sum_tabungan, 0, ',', '.') }}</td>
                <td class="text-right font-bold">Rp {{ number_format($sum_net, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Catatan:</strong><br>
        Laporan ini dihasilkan secara otomatis oleh Sistem Manajemen Tanjoe. 
        Data yang tercantum adalah final berdasarkan rekapan transaksi pada periode terkait.
        Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
