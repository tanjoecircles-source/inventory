<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BaristaFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Logistic;
use App\Models\Periode;
use App\Models\Setting;
use App\Models\Sales;
use App\Models\Purchasing;
use App\Models\StorePurchasing;
use App\Models\StoreOperational;
use App\Models\ReportStore;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(){
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $data = Setting::first();
        return view('web.admin.report.index', $data);
    }

    public function setPeriod(Request $request)
    {
        $valid = validator($request->only('report_date_start', 'report_date_end'), [
            'report_date_start' => 'required',
            'report_date_end' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('report_date_start', 'report_date_end');
        DB::beginTransaction();
        $update = Setting::where('id', '1')->update([
            'report_date_start' => date('Y-m-d', strtotime($data['report_date_start'])),
            'report_date_end' => date('Y-m-d', strtotime($data['report_date_end'])),
        ]);
        if ($update){
            DB::commit();
            return redirect('report')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function beanList(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['filter-payment'])) ? $_GET['filter-payment'] : "all";
        $report_period = Setting::first();
        $contents = DB::table('sales AS s')
                    ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                    ->select('s.*', 'c.name AS cust_name')
                    ->where([
                        's.inv_status' => 'publish', 
                        ['s.inv_date', '>=', $report_period->report_date_start],
                        ['s.inv_date', '<=', $report_period->report_date_end],
                    ]);
                    if($search != 'all'){
                        $contents = $contents->where(['s.inv_status_payment' => $search]);
                    }
                    $contents = $contents->orderBy('s.inv_date', 'DESC')->paginate($limit);
        $counts = DB::table('sales AS s')
                    ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                    ->select('s.inv_id')
                    ->where([
                        's.inv_status' => 'publish', 
                        ['s.inv_date', '>=', $report_period->report_date_start],
                        ['s.inv_date', '<=', $report_period->report_date_end],
                    ]);
                    if($search != 'all'){
                        $counts = $counts->where(['s.inv_status_payment' => $search]);
                    }
                    $counts = $counts->orderBy('s.inv_date', 'DESC')->count();
        
        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->inv_date = date('d M Y', strtotime($value->inv_date));
                if($value->inv_status_payment == 'paid'){
                    $value->inv_status_color = 'success';
                    $value->inv_status_label = 'Paid'; 
                }else{
                    $value->inv_status_color = 'danger';
                    $value->inv_status_label = 'Unpaid'; 
                }
                $value->inv_profit = ((INT)$value->inv_total - (INT)$value->inv_expedition) - (INT)$value->inv_hpp; 
                
            }
        }
        //summary
        $sales_total = Sales::where([['inv_date', '>=', $report_period->report_date_start], ['inv_date', '<=', $report_period->report_date_end], 'inv_status' => 'publish']);
        if($search != 'all'){
            $sales_total = $sales_total->where(['inv_status_payment' => $search]);
        }
        $sales_sub_total = $sales_total->sum('inv_sub_total');
        $sales_discount = $sales_total->sum('inv_discount');
        $sales_total = (INT)$sales_sub_total - (INT)$sales_discount;

        $sales_hpp = Sales::where([['inv_date', '>=', $report_period->report_date_start], ['inv_date', '<=', $report_period->report_date_end], 'inv_status' => 'publish']);
        if($search != 'all'){
            $sales_hpp = $sales_hpp->where(['inv_status_payment' => $search]);
        }
        $sales_hpp = $sales_hpp->sum('inv_hpp');
        $sales_expedition = Sales::where([['inv_date', '>=', $report_period->report_date_start], ['inv_date', '<=', $report_period->report_date_end], 'inv_status' => 'publish']);
        if($search != 'all'){
            $sales_expedition = $sales_expedition->where(['inv_status_payment' => $search]);
        }
        $sales_expedition = $sales_expedition->sum('inv_expedition');

        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts,
            'sales_amount' => (INT)$sales_total,
            'sales_hpp' => $sales_hpp,
            'sales_expedition' => $sales_expedition,
            'sales_total' => $sales_total,
            'sales_profit' => (INT)$sales_total - (INT)$sales_hpp
        ];
        if($request->ajax()){
            $view = view('web.admin.report.bean_paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.report.bean_list', $data);
    }

    public function productPrint()
    {
        
        $report_period = Setting::first();
        $item = DB::table('sales_items AS s')
            ->leftJoin('product AS p', 'p.id', '=', 's.itm_product')
            ->leftJoin('sales AS sl', 'sl.id', '=', 's.itm_inv_id')
            ->select('s.*',
                    'sl.*',
                    'p.name AS product_name',
                    'p.type AS product_type',
                    'p.price_hpp')
            ->where([
                'sl.inv_status' => 'publish', 
                ['sl.inv_date', '>=', $report_period->report_date_start],
                ['sl.inv_date', '<=', $report_period->report_date_end],
            ])
            ->orderBy('sl.inv_date', 'DESC')
            ->orderBy('sl.id', 'DESC')
            ->get();
        $itm_totals = 0;
        foreach ($item as $key => $value) {
            $itm_totals += $value->itm_total;
            $value->itm_hpp = (INT)$value->price_hpp * (FLOAT)$value->itm_qty;
        }
        $data = [
            'item' => $item
        ];
        $pdf = Pdf::loadView('web.admin.report.product_print', $data);
        $pdf->set_paper('LEGAL', 'potrait');
        return $pdf->stream('product_report.pdf', array("Attachment" => false));
        
        //return view('web.admin.sales.print', $data);
    }

    public function purchasingList(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['filter-payment'])) ? $_GET['filter-payment'] : "all";
        if($search == 'paid'){
            $search = 'Lunas';
        }elseif($search == 'unpaid'){
            $search = 'Belum Lunas';
        }else{
            $search = 'all';
        }
        $report_period = Setting::first();
        
        //DB::enableQueryLog();
        $contents = DB::table('purchasing AS s')
                    ->leftJoin('vendor AS c', 'c.id', '=', 's.pur_vendor')
                    ->select('s.*', 'c.name AS vendor_name')
                    ->where([
                        's.pur_status' => 'publish', 
                        ['s.pur_date', '>=', $report_period->report_date_start],
                        ['s.pur_date', '<=', $report_period->report_date_end],
                    ]);
                    if($search != 'all'){
                        $contents = $contents->where(['s.pur_status_payment' => $search]);
                    }
                    $contents = $contents->orderBy('s.pur_date', 'DESC')->paginate($limit);
        //dd(DB::getQueryLog());die;

        $counts = DB::table('purchasing AS s')
                    ->leftJoin('vendor AS c', 'c.id', '=', 's.pur_vendor')
                    ->select('s.id')
                    ->where([
                        's.pur_status' => 'publish', 
                        ['s.pur_date', '>=', $report_period->report_date_start],
                        ['s.pur_date', '<=', $report_period->report_date_end],
                    ]);
                    if($search != 'all'){
                        if($search == 'Belum+Lunas'){
                            $search = 'Belum Lunas';
                        }
                        $counts = $counts->where(['s.pur_status_payment' => $search]);
                    }
                    $counts = $counts->orderBy('s.pur_date', 'DESC')->count();
        
        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->pur_date = date('d M Y', strtotime($value->pur_date));
                if($value->pur_status_payment == 'Lunas'){
                    $value->pur_status_color = 'success';
                }else{
                    $value->pur_status_color = 'danger';
                }
                $value->pur_profit = 0;
                
            }
        }
        //summary
        $sales_total = Purchasing::where([['pur_date', '>=', $report_period->report_date_start], ['pur_date', '<=', $report_period->report_date_end], 'pur_status' => 'publish']);
        if($search != 'all'){
            $sales_total = $sales_total->where(['pur_status_payment' => $search]);
        }
        $sales_total = $sales_total->sum('pur_total');
        

        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts,
            'sales_amount' => (INT)$sales_total,
            'sales_hpp' => 0,
            'sales_expedition' => 0,
            'sales_total' => $sales_total,
            'sales_profit' => (INT)$sales_total
        ];

        if($request->ajax()){
            $view = view('web.admin.report.purchasing_paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.report.purchasing_list', $data);
    }

    public function storeIncome(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['filter-status'])) ? $_GET['filter-status'] : "all";
        $report_period = Setting::first();
        $contents = DB::table('report_store AS rs')
                    ->leftJoin('employee AS e', 'e.id', '=', 'rs.employee_id')
                    ->leftJoin('shift_store AS sf', 'sf.id', '=', 'rs.shift_id')
                    ->select('rs.*', 'e.name AS emp_name', 'sf.name AS shift_name')
                    ->where([
                        ['rs.date', '>=', $report_period->report_date_start],
                        ['rs.date', '<=', $report_period->report_date_end],
                    ]);
                    if($search != 'all'){
                        $contents = $contents->where(['rs.status' => $search]);
                    }
                    $contents = $contents->orderBy('rs.date', 'DESC')->orderBy('rs.id', 'DESC')->paginate($limit);

        $counts = DB::table('report_store AS rs')
                    ->leftJoin('employee AS e', 'e.id', '=', 'rs.employee_id')
                    ->select('rs.id')
                    ->where([
                        ['rs.date', '>=', $report_period->report_date_start],
                        ['rs.date', '<=', $report_period->report_date_end],
                    ]);
                    if($search != 'all'){
                        $counts = $counts->where(['rs.status' => $search]);
                    }
                    $counts = $counts->count();

        
        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->date = date('d M Y', strtotime($value->date));
                if($value->status == 'verified'){
                    $value->status_color = 'danger';
                    $value->status_label = 'Verified';
                }elseif($value->status == 'reported'){
                    $value->status_color = 'success';
                    $value->status_label = 'Reported';
                }else{
                    $value->status_color = 'dark';
                    $value->status_label = 'Draft';
                }
            }
        }
        //summary
        $cash = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        if($search != 'all'){
            $cash = $cash->where(['status' => $search]);
        }
        $cash = $cash->sum('cash');
        $qris = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        if($search != 'all'){
            $qris = $qris->where(['status' => $search]);
        }
        $qris = $qris->sum('qris');
        $spending = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        if($search != 'all'){
            $spending = $spending->where(['status' => $search]);
        }
        $spending = $spending->sum('spending');

        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts,
            'cash' => $cash,
            'qris' => $qris,
            'spending' => $spending,
            'sales_total' => (INT)$cash + (INT)$qris
        ];
        if($request->ajax()){
            $view = view('web.admin.report.store_income_paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.report.store_income', $data);
    }

    public function recap(Request $request)
    {
        $report_period = Setting::first();
        $period_set = DB::table('periode AS rs')
                    ->select('rs.id')
                    ->where([
                        ['rs.start_date', '=', $report_period->report_date_start],
                        ['rs.end_date', '=', $report_period->report_date_end],
                    ])->first();
        
        //income
        $cash = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        $cash = $cash->sum('cash');
        
        $qris = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        $qris = $qris->sum('qris');

        $income_total = (INT)$cash + (INT)$qris;

        //outcome
        $spending = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        $spending = $spending->sum('spending');

        $purchasing = StorePurchasing::where([['pur_date', '>=', $report_period->report_date_start], ['pur_date', '<=', $report_period->report_date_end]]);
        $purchasing = $purchasing->sum('pur_total');
        
        $operational = StoreOperational::where([['op_date', '>=', $report_period->report_date_start], ['op_date', '<=', $report_period->report_date_end], ['op_status_payment', 'Lunas']]);
        $operational = $operational->sum('op_total');
        if(empty($period_set->id)){
            $staff_fee =  '0';
            $staff_fee_desc = 'Periode Perlu Disesuaikan';
        }else{
            $staff_fee = BaristaFee::where([['periode_id', $period_set->id], ['status', 'Published']])->get();
            $staff_fee = $staff_fee->sum('total_fee');
            $staff_fee_desc = '';
        }

        $outcome_total = (INT)$spending + (INT)$purchasing + (INT)$operational + (INT)$staff_fee;
        $profit = (INT)$income_total - (int)$outcome_total;

        $data = [
            'cash' => $cash,
            'qris' => $qris,
            'income_total' => $income_total,
            'spending' => $spending,
            'purchasing' => $purchasing,
            'operational' => $operational,
            'staff_fee' => $staff_fee,
            'staff_fee_desc' => $staff_fee_desc,
            'outcome_total' => $outcome_total,
            'profit' => $profit

        ];
        return view('web.admin.report.store_recap', $data);
    }

    public function profitShare()
    {
        // $report_period = Setting::first();
        // $period_set = DB::table('periode AS rs')
        //             ->select('rs.id')
        //             ->where([
        //                 ['rs.start_date', '=', $report_period->report_date_start],
        //                 ['rs.end_date', '=', $report_period->report_date_end],
        //             ])->first();
        
        // //income
        // $cash = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        // $cash = $cash->sum('cash');
        
        // $qris = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        // $qris = $qris->sum('qris');

        // $income_total = (INT)$cash + (INT)$qris;

        // //outcome
        // $spending = ReportStore::where([['date', '>=', $report_period->report_date_start], ['date', '<=', $report_period->report_date_end]]);
        // $spending = $spending->sum('spending');

        // $purchasing = StorePurchasing::where([['pur_date', '>=', $report_period->report_date_start], ['pur_date', '<=', $report_period->report_date_end]]);
        // $purchasing = $purchasing->sum('pur_total');
        
        // $operational = StoreOperational::where([['op_date', '>=', $report_period->report_date_start], ['op_date', '<=', $report_period->report_date_end], ['op_status_payment', 'Lunas']]);
        // $operational = $operational->sum('op_total');
        // if(empty($period_set->id)){
        //     $staff_fee =  '0';
        //     $staff_fee_desc = 'Periode Perlu Disesuaikan';
        // }else{
        //     $staff_fee = BaristaFee::where([['periode_id', $period_set->id], ['status', 'Published']])->get();
        //     $staff_fee = $staff_fee->sum('total_fee');
        //     $staff_fee_desc = '';
        // }

        // $outcome_total = (INT)$spending + (INT)$purchasing + (INT)$operational + (INT)$staff_fee;
        // $profit = (INT)$income_total - (int)$outcome_total;

        // $data = [
        //     'cash' => $cash,
        //     'qris' => $qris,
        //     'income_total' => $income_total,
        //     'spending' => $spending,
        //     'purchasing' => $purchasing,
        //     'operational' => $operational,
        //     'staff_fee' => $staff_fee,
        //     'staff_fee_desc' => $staff_fee_desc,
        //     'outcome_total' => $outcome_total,
        //     'profit' => $profit

        // ];
        $data = [];
        return view('web.admin.report.profit_share', $data);
    }

    public function statisticBean(Request $request)
    {
        $data = [];
        return view('web.admin.report.statistic_bean', $data);
    }

    public function statisticBeanJson()
    {
        //$now = Carbon::now();
        $report_period = Setting::first();
        $start = $report_period->report_date_start;
        $end = $report_period->report_date_end; 
        $data = DB::table('sales_items as si')
                    ->join('product as p', 'si.itm_product', '=', 'p.id')
                    ->join('ref_product_type as rp', 'p.type', '=', 'rp.id')
                    ->join('sales as s', 'si.itm_inv_id', '=', 's.id')
                    ->select(
                        DB::raw("
                            CASE
                                WHEN DAY(s.inv_date) >= 5
                                    THEN DATE_FORMAT(DATE(s.inv_date), '%M')
                                ELSE DATE_FORMAT(DATE_SUB(DATE(s.inv_date), INTERVAL 1 MONTH), '%M')
                            END as month
                        "),
                        'rp.name as category',
                        DB::raw('SUM(si.itm_total) as total')
                    )
                    ->whereBetween('s.inv_date', [$start, $end])
                    ->whereIn('rp.id', [1, 2, 3, 5])
                    ->where('s.inv_status', 'Publish')
                    ->groupBy('month', 'rp.name')
                    ->orderBy(DB::raw('YEAR(s.inv_date)'))
                    ->orderBy(DB::raw('MONTH(s.inv_date)'))
                    ->orderBy('category')
                    ->get();

        $months = $data->pluck('month')->unique()->values();     // daftar periode unik
        $categories = $data->pluck('category')->unique()->values(); // daftar kategori unik

        $chartData = [
            'categories' => $months,
            'series' => []
        ];

        // Inisialisasi array kosong untuk tiap kategori
        foreach ($categories as $cat) {
            $chartData['series'][$cat] = array_fill(0, count($months), 0);
        }

        // Isi nilai total ke posisi bulan yang sesuai
        foreach ($data as $row) {
            $index = $months->search($row->month);
            if ($index !== false) {
                $chartData['series'][$row->category][$index] = (float) $row->total;
            }
        }

        // Ubah ke format final Highcharts
        $chartData['series'] = collect($chartData['series'])
            ->map(fn($d, $k) => ['name' => $k, 'data' => $d])
            ->values();

        return response()->json($chartData);
    }

    public function statisticProfitJson()
    {
        $report_period = Setting::first();
        $start = $report_period->report_date_start;
        $end = $report_period->report_date_end; 

        $data = DB::table('sales as s')
            ->select(
                DB::raw("
                    CASE
                        WHEN DAY(s.inv_date) >= 5
                            THEN DATE_FORMAT(DATE(s.inv_date), '%M')
                        ELSE DATE_FORMAT(DATE_SUB(DATE(s.inv_date), INTERVAL 1 MONTH), '%M')
                    END as label
                "),
                DB::raw('SUM(s.inv_total - s.inv_expedition) as total_income'),
                DB::raw('SUM(s.inv_total - s.inv_expedition - s.inv_hpp) as total_profit')
            )
            ->whereBetween('s.inv_date', [$start, $end])
            ->groupBy('label')
            ->orderBy(DB::raw('MONTH(s.inv_date)'))
            ->get();

        // Hitung persentase profit untuk tiap bulan
        $data = $data->map(function ($item) {
            $income = (float) $item->total_income;
            $profit = (float) $item->total_profit;
            $item->profit_percentage = $income > 0 ? round(($profit / $income) * 100, 2) : 0;
            return $item;
        });

        // Format data untuk Highcharts
        $labels = $data->pluck('label');
        $incomes = $data->pluck('total_income');
        $profits = $data->pluck('total_profit');
        $percentages = $data->pluck('profit_percentage');

        $chartData = [
            'labels' => $labels,
            'series' => [
                ['name' => 'Total Income', 'type' => 'column', 'data' => $incomes],
                ['name' => 'Total Profit', 'type' => 'column', 'data' => $profits],
                ['name' => 'Profit %', 'type' => 'line', 'yAxis' => 1, 'data' => $percentages],
            ],
        ];

        return response()->json($chartData);
    }

    public function summary(Request $request)
    {
        $sales = Sales::where(['inv_status' => 'publish', 'inv_status_payment' => 'paid'])->sum('inv_sub_total');
        $purchasing = Purchasing::where(['pur_status' => 'publish', 'pur_status_payment' => 'Lunas'])->sum('pur_sub_total');
        $balance = (INT)$sales - (INT)$purchasing;
        

        $data = [
            'sales' => $sales,
            'purchasing' => $purchasing,
            'balance' => $balance,
        ];
        
        
        return view('web.admin.report.summary', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('logistic_invoice')
                    ->select('id', 'inv_code AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('inv_code', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('inv_code', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        return view('web.admin.logistic_invoice.add');
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('inv_code', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment'), [
            'inv_code' => 'required',
            'inv_date' => 'required',
            'inv_source' => 'required',
            'inv_total' => 'required',
            'inv_status_payment' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('inv_code', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment');
        DB::beginTransaction();
        $insert = Logistic::create([
            'inv_code' => $data['inv_code'],
            'inv_date' => date('Y-m-d', strtotime($data['inv_date'])),
            'inv_source' => $data['inv_source'],
            'inv_total' => $data['inv_total'],
            'inv_status_payment' => $data['inv_status_payment']
        ]);
        if ($insert){
            DB::commit();
            return redirect('logistic-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail(Request $request, $id)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('logistic_items')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('itm_name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('logistic_items')
                ->where(function($contents) use ($search){
                    $contents->where('itm_name', 'like', '%'.$search.'%');
                })
                ->orderBy('id', 'DESC')
                ->count();

        // if(!empty($contents)){
        //     foreach ($contents as $key => $value) {
        //         $value->inv_date = date('d M Y', strtotime($value->inv_date));
        //     }
        // }
        $data = [
            'invoice' => Logistic::where(['id' => $id])->first(),
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.logistic_items.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }

        return view('web.admin.logistic_invoice.detail', $data);
    }

    public function edit($id)
    {
        $data = Logistic::where(['id' => $id])->first();
        $data->inv_date = date('d-m-Y', strtotime($data->inv_date));
        return view('web.admin.logistic_invoice.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('inv_code', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment'), [
            'inv_code' => 'required',
            'inv_date' => 'required',
            'inv_source' => 'required',
            'inv_total' => 'required',
            'inv_status_payment' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('inv_code', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment');
        DB::beginTransaction();
        $update = Logistic::where('id', $id)->update([
            'inv_code' => $data['inv_code'],
            'inv_date' => date('Y-m-d', strtotime($data['inv_date'])),
            'inv_source' => $data['inv_source'],
            'inv_total' => $data['inv_total'],
            'inv_status_payment' => $data['inv_status_payment']
        ]);
        if ($update){
            DB::commit();
            return redirect('logistic-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
}
