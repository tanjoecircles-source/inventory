<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublicSalesController extends Controller
{
    public function list(Request $request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('keyword', '');
        $startdate = $request->input('startdate', '');
        $enddate = $request->input('enddate', '');
        $author = $request->input('author', '');
        $status = $request->input('status', '');
        $sort = $request->input('sort', 'terbaru');

        $query = DB::table('sales AS s')
                    ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                    ->leftJoin('users AS u', 'u.id', '=', 's.author')
                    ->select('s.*', 'c.name AS cust_name', 'u.name AS inv_author')
                    ->where(['s.inv_status_payment' => 'unpaid'])
                    ->where(function($q) use ($search){
                        $q->where('s.inv_code', 'like', '%'.$search.'%')
                          ->orWhere('c.name', 'like', '%'.$search.'%');
                    });

        if(!empty($startdate)){
            $query->where('s.inv_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if(!empty($enddate)){
            $query->where('s.inv_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if(!empty($author)){
            $query->where(['s.author' => $author]);
        }
        if(!empty($status)){
            $query->where(['s.inv_status' => $status]);
        }

        // Sorting Logic
        if ($sort == 'tertinggi') {
            $query->orderByRaw('CAST(s.inv_total AS UNSIGNED) DESC');
        } elseif ($sort == 'terendah') {
            $query->orderByRaw('CAST(s.inv_total AS UNSIGNED) ASC');
        } elseif ($sort == 'terlama') {
            $query->orderBy('s.inv_date', 'ASC')->orderBy('s.id', 'ASC');
        } else {
            $query->orderBy('s.inv_date', 'DESC')->orderBy('s.id', 'DESC');
        }

        $contents = $query->paginate($limit);

        foreach ($contents as $value) {
            $value->inv_date_formatted = date('d M Y', strtotime($value->inv_date));
            if($value->inv_status_payment == 'unpaid' && $value->inv_payment > 0){
                $value->status_payment_label = 'Bayar Sebagian';
            }else{
                $value->status_payment_label = $value->inv_status_payment;
            }
            $value->csurl = Str::slug($value->cust_name);
            $value->dturl = Str::slug($value->inv_date);
            $value->authurl = Str::slug($value->inv_author);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'contents' => $contents->items(),
                'pagination' => [
                    'total' => $contents->total(),
                    'per_page' => $contents->perPage(),
                    'current_page' => $contents->currentPage(),
                    'last_page' => $contents->lastPage(),
                    'from' => $contents->firstItem(),
                    'to' => $contents->lastItem(),
                ]
            ]
        ], 200);
    }

    public function listPaid(Request $request)
    {
        $limit = $request->input('limit', 10);
        $search = $request->input('keyword', '');
        $startdate = $request->input('startdate', '');
        $enddate = $request->input('enddate', '');
        $author = $request->input('author', '');

        $query = DB::table('sales AS s')
                    ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                    ->leftJoin('users AS u', 'u.id', '=', 's.author')
                    ->select('s.*', 'c.name AS cust_name', 'u.name AS inv_author')
                    ->where(['s.inv_status_payment' => 'paid'])
                    ->where(function($q) use ($search){
                        $q->where('s.inv_code', 'like', '%'.$search.'%')
                          ->orWhere('c.name', 'like', '%'.$search.'%');
                    });

        if(!empty($startdate)){
            $query->where('s.inv_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if(!empty($enddate)){
            $query->where('s.inv_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if(!empty($author)){
            $query->where(['s.author' => $author]);
        }

        $contents = $query->orderBy('s.inv_date', 'DESC')->paginate($limit);

        foreach ($contents as $value) {
            $value->inv_date_formatted = date('d M Y', strtotime($value->inv_date));
            $value->inv_status_color = 'success';
            $value->inv_status_label = 'Paid'; 
            $value->csurl = Str::slug($value->cust_name);
            $value->dturl = Str::slug($value->inv_date);
            $value->authurl = Str::slug($value->inv_author);
        }

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'contents' => $contents->items(),
                'pagination' => [
                    'total' => $contents->total(),
                    'per_page' => $contents->perPage(),
                    'current_page' => $contents->currentPage(),
                    'last_page' => $contents->lastPage(),
                    'from' => $contents->firstItem(),
                    'to' => $contents->lastItem(),
                ]
            ]
        ], 200);
    }

    public function detail(Request $request, $id)
    {
        $invoice = DB::table('sales AS s')
            ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
            ->leftJoin('users AS u', 'u.id', '=', 's.author')
            ->select('s.*', 'c.name AS cust_name', 'u.name AS inv_author')
            ->where(['s.id' => $id])
            ->first();

        if (!$invoice) {
            return response()->json([
                'status' => false,
                'message' => 'Invoice not found',
                'data' => null
            ], 404);
        }

        $items = DB::table('sales_items AS s')
            ->leftJoin('product AS p', 'p.id', '=', 's.itm_product')
            ->select('s.*', 'p.name AS product_name', 'p.price AS product_price', 'p.price_hpp AS price_hpp')
            ->where(['s.itm_inv_id' => $id])
            ->orderBy('id', 'DESC')
            ->get();

        $itm_total = 0;
        $itm_hpp = 0;
        foreach ($items as $value) {
            $itm_total += $value->itm_total;
            $itm_hpp += (int)$value->price_hpp * (float)$value->itm_qty;
        }

        $invoice->must_pay = (int)$invoice->inv_total - (int)$invoice->inv_payment;
        $invoice->inv_date_formatted = date('d M Y', strtotime($invoice->inv_date));
        
        $data = [
            'invoice' => $invoice,
            'items' => $items,
            'summary' => [
                'inv_hpp' => $itm_hpp,
                'inv_sub_total' => $itm_total,
                'inv_total' => (int)$itm_total - (int)$invoice->inv_discount + (int)$invoice->inv_expedition,
            ]
        ];

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $data
        ], 200);
    }
}
