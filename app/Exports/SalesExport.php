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
        $data = DB::table('sales AS sl')
            ->leftJoin('customer AS c', 'c.id', '=', 'sl.inv_cust')
            ->select('sl.inv_category',
                    'sl.inv_code',
                    'sl.inv_date',
                    'c.name AS customer',
                    'sl.inv_hpp AS hpp',
                    'sl.inv_sub_total AS subtotal',
                    'sl.inv_discount AS discount')
            ->where([
                'sl.inv_status' => 'publish', 
                ['sl.inv_date', '>=', $report_period->report_date_start],
                ['sl.inv_date', '<=', $report_period->report_date_end],
            ])
            ->orderBy('sl.inv_date', 'DESC')
            ->orderBy('sl.id', 'DESC')
            ->get();

        foreach ($data as $key => $value) {
            $value->total = $value->subtotal - $value->discount;
            $value->margin = $value->total - $value->hpp;
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Kode Invoice',
            'Tanggal',
            'Customer',
            'HPP',
            'Sub Total',
            'Discount',
            'Total',
            'Margin'
        ];
    }
}