<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sales::select(
            'inv_category',
            'inv_code',
            'inv_date',
            'inv_cust',
            'inv_hpp',
            'inv_sub_total',
            'inv_discount',
            'inv_expedition',
            'inv_total',
            'inv_payment',
            'inv_status_payment',
            'inv_payment_date',
            'inv_payment_type',
            'inv_status',
            'inv_desc',
            'author',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Category',
            'Invoice Code',
            'Invoice Date',
            'Customer',
            'HPP',
            'Sub Total',
            'Discount',
            'Expedition',
            'Total',
            'Payment',
            'Payment Status',
            'Payment Date',
            'Payment Type',
            'Status',
            'Description',
            'Author',
            'Created At'
        ];
    }
}