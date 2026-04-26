<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicProductController extends Controller
{
    public function list(Request $request)
    {
        $param = request()->only('search', 'filter', 'offset', 'limit', 'order');
        $search = $param['search'] ?? '';
        $filter = $param['filter'] ?? [];
        $offset = $param['offset'] ?? 0;
        $limit = $param['limit'] ?? 10;
        $order_sort = !empty($param['order'][0]) ? $param['order'][0] : 'p.id';
        $order_mode = !empty($param['order'][1]) ? $param['order'][1] : 'desc';

        // Query utama list product
        $query = DB::table('product AS p')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->select('p.id',
                    'p.code',
                    'p.name',
                    'p.name_pl',
                    'p.type',
                    'rpt.name AS type_name',
                    'p.category',
                    'p.summary',
                    'p.origin',
                    'p.elevation',
                    'p.varietal',
                    'p.process',
                    'p.processor',
                    'p.harvest',
                    'p.price',
                    'p.price_grosir15',
                    'p.price_grosir50',
                    'p.stock',
                    'p.is_recomended',
                    'p.is_new',
                    'p.photo_thumbnail',
                    'ua.name AS author_name',
                    'p.created_at')
            ->where('p.status', 'Active');

        // Pencarian teks
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('p.name', 'like', '%'.$search.'%')
                  ->orWhere('p.category', 'like', '%'.$search.'%')
                  ->orWhere('p.origin', 'like', '%'.$search.'%')
                  ->orWhere('rpt.name', 'like', '%'.$search.'%');
            });
        }

        // Filter tambahan
        if (!empty($filter['type'])) {
            $query->where('p.type', $filter['type']);
        }
        if (!empty($filter['process'])) {
            $query->where('p.process', $filter['process']);
        }

        // Clone query untuk menghitung total filtered
        $filteredQuery = clone $query;
        $filtered = $filteredQuery->count('p.id');

        // Eksekusi pagination dan order
        $list = $query->orderBy($order_sort, $order_mode)
            ->offset($offset)
            ->limit($limit)
            ->get();

        // Format data
        foreach ($list as $key => $value) {
            $value->price_rp = $this->currency($value->price);
            // Validasi foto
            if (!empty($value->photo_thumbnail)) {
                $value->photo_thumbnail = url('storage/'.$value->photo_thumbnail);
            } else {
                $value->photo_thumbnail = url('storage/noimages.jpg');
            }
        }

        // Total keseluruhan data aktif
        $total = DB::table('product')->where('status', 'Active')->count('id');

        $result['list'] = $list;
        $result['filtered'] = $filtered;
        $result['total'] = $total;

        if ($list->count() > 0) {
            return response(['status' => true, 'message' => 'Success', 'data' => $result], 200);
        } else {
            return response(['status' => false, 'message' => 'Data Empty', 'data' => []], 404);
        }
    }

    public function info(Request $request, $id)
    {
        $product = DB::table('product AS p')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->select('p.*', 'rpt.name AS type_name')
            ->where('p.id', $id)
            ->first();

        if (!$product) {
            return response(['status' => false, 'message' => 'Product not found'], 404);
        }

        // Format image URL
        if (!empty($product->photo_thumbnail)) {
            $product->photo_thumbnail = url('storage/'.$product->photo_thumbnail);
        } else {
            $product->photo_thumbnail = url('storage/noimages.jpg');
        }

        return response([
            'status' => true,
            'message' => 'Success',
            'data' => $product
        ], 200);
    }

    public function updateStock(Request $request)
    {
        $valid = validator($request->all(), [
            'id' => 'required|exists:product,id',
            'stock' => 'required|numeric|min:0',
            'token' => 'required'
        ]);

        if ($valid->fails()) {
            return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        }

        // Token validation
        $apiToken = env('API_PUBLIC_TOKEN', 'tanjoe_api_secret_2026');
        if ($request->input('token') !== $apiToken) {
            return response(['status' => false, 'message' => 'Invalid token'], 401);
        }

        $id = $request->input('id');
        $stock = $request->input('stock');

        $update = DB::table('product')->where('id', $id)->update([
            'stock' => $stock,
            'updated_at' => now()
        ]);

        if ($update) {
            return response(['status' => true, 'message' => 'Stock updated successfully'], 200);
        } else {
            return response(['status' => false, 'message' => 'Failed to update stock or stock remains the same'], 400);
        }
    }
}
