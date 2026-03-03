<?php

namespace App\Exports;

use App\Models\Sales;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $report_period = Setting::first();
        $data = DB::table('sales_items AS s')
            ->leftJoin('product AS p', 'p.id', '=', 's.itm_product')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('sales AS sl', 'sl.id', '=', 's.itm_inv_id')
            ->select('sl.inv_code',
                    'sl.inv_date',
                    'rpt.name AS product_type',
                    'p.name AS product_name',
                    's.itm_qty AS qty',
                    's.itm_price AS price',
                    's.itm_total AS total',
                    'p.price_hpp AS hpp')
            ->where([
                'sl.inv_status' => 'publish', 
                ['sl.inv_date', '>=', $report_period->report_date_start],
                ['sl.inv_date', '<=', $report_period->report_date_end],
            ])
            ->orderBy('sl.inv_date', 'DESC')
            ->orderBy('sl.id', 'DESC')
            ->get();

        foreach ($data as $key => $value) {
            $value->hpp = $value->hpp * $value->qty;
            $value->margin = $value->total - $value->hpp;
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Kode Invoice',
            'Tanggal',
            'Kategori',
            'Barang',
            'Qty',
            'Harga',
            'Total',
            'HPP',
            'Margin'
        ];
    }
}