<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\Sales;
use App\Models\SalesItem;
use App\Models\Product;

class ReportProductController extends Controller
{
    public function recapQty(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $report_period = Setting::first();
        $start = $report_period->report_date_start;
        $end = $report_period->report_date_end;

        $items = DB::table('sales_items AS si')
            ->join('sales AS s', 's.id', '=', 'si.itm_inv_id')
            ->join('product AS p', 'p.id', '=', 'si.itm_product')
            ->leftJoin('ref_product_type AS rt', 'rt.id', '=', 'p.type')
            ->leftJoin('ref_satuan AS rs', 'rs.id', '=', 'p.satuan')
            ->select(
                'p.name as product_name',
                'p.code as product_code',
                'rt.name as type_name',
                DB::raw('SUM(si.itm_qty * CAST(rs.name AS UNSIGNED)) as total_qty'),
                DB::raw('SUM(si.itm_qty) as raw_qty'),
                DB::raw('SUM(
                    (si.itm_total / NULLIF(s.inv_sub_total, 0)) * (s.inv_sub_total - s.inv_hpp - s.inv_discount)
                ) as total_profit')
            )
            ->where([
                's.inv_status' => 'publish',
            ])
            ->whereBetween('s.inv_date', [$start, $end])
            ->groupBy('si.itm_product', 'p.name', 'p.code', 'rt.name')
            ->orderBy('total_qty', 'DESC')
            ->get();

        $data = [
            'items' => $items,
            'report_date_start' => $start,
            'report_date_end' => $end,
        ];

        return view('web.admin.report.product_recap_qty', $data);
    }

    public function recapByType(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $report_period = Setting::first();
        $start = $report_period->report_date_start;
        $end = $report_period->report_date_end;

        $items = DB::table('sales_items AS si')
            ->join('sales AS s', 's.id', '=', 'si.itm_inv_id')
            ->join('product AS p', 'p.id', '=', 'si.itm_product')
            ->join('ref_product_type AS rt', 'rt.id', '=', 'p.type')
            ->leftJoin('ref_satuan AS rs', 'rs.id', '=', 'p.satuan')
            ->select(
                'rt.name as type_name',
                DB::raw('SUM(si.itm_qty * CAST(rs.name AS UNSIGNED)) as total_qty'),
                DB::raw('SUM(si.itm_qty) as raw_qty'),
                DB::raw('SUM(
                    (si.itm_total / NULLIF(s.inv_sub_total, 0)) * (s.inv_sub_total - s.inv_hpp - s.inv_discount)
                ) as total_profit')
            )
            ->where([
                's.inv_status' => 'publish',
            ])
            ->whereBetween('s.inv_date', [$start, $end])
            ->groupBy('p.type', 'rt.name')
            ->orderBy('total_qty', 'DESC')
            ->get();

        $data = [
            'items' => $items,
            'report_date_start' => $start,
            'report_date_end' => $end,
        ];

        return view('web.admin.report.product_recap_type', $data);
    }

    public function recapByAuthor(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $report_period = Setting::first();
        $start = $report_period->report_date_start;
        $end = $report_period->report_date_end;

        $items = DB::table('sales_items AS si')
            ->join('sales AS s', 's.id', '=', 'si.itm_inv_id')
            ->join('users AS u', 'u.id', '=', 's.author')
            ->join('product AS p', 'p.id', '=', 'si.itm_product')
            ->join('ref_product_type AS rt', 'rt.id', '=', 'p.type')
            ->leftJoin('ref_satuan AS rs', 'rs.id', '=', 'p.satuan')
            ->select(
                'u.name as author_name',
                'rt.name as type_name',
                DB::raw('SUM(si.itm_qty * CAST(rs.name AS UNSIGNED)) as total_qty'),
                DB::raw('SUM(si.itm_qty) as raw_qty'),
                DB::raw('SUM(
                    (si.itm_total / NULLIF(s.inv_sub_total, 0)) * (s.inv_sub_total - s.inv_hpp - s.inv_discount)
                ) as total_profit')
            )
            ->where([
                's.inv_status' => 'publish',
            ])
            ->whereBetween('s.inv_date', [$start, $end])
            ->groupBy('s.author', 'u.name', 'p.type', 'rt.name')
            ->orderBy('total_qty', 'DESC')
            ->get();

        // Summary for chart
        $author_summary = DB::table('sales_items AS si')
            ->join('sales AS s', 's.id', '=', 'si.itm_inv_id')
            ->join('users AS u', 'u.id', '=', 's.author')
            ->join('product AS p', 'p.id', '=', 'si.itm_product')
            ->leftJoin('ref_satuan AS rs', 'rs.id', '=', 'p.satuan')
            ->select(
                'u.name as author_name',
                DB::raw('SUM(si.itm_qty * CAST(rs.name AS UNSIGNED)) as total_qty'),
                DB::raw('SUM(si.itm_qty) as raw_qty'),
                DB::raw('SUM(
                    (si.itm_total / NULLIF(s.inv_sub_total, 0)) * (s.inv_sub_total - s.inv_hpp - s.inv_discount)
                ) as total_profit')
            )
            ->where(['s.inv_status' => 'publish'])
            ->whereBetween('s.inv_date', [$start, $end])
            ->groupBy('s.author', 'u.name')
            ->orderBy('total_qty', 'DESC')
            ->get();

        $data = [
            'items' => $items,
            'author_summary' => $author_summary,
            'report_date_start' => $start,
            'report_date_end' => $end,
        ];

        return view('web.admin.report.product_recap_author', $data);
    }
}
