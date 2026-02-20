<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etalase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EtalaseController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::denies('isAgent')) return response(['status' => false, 'message' => 'Selain Agent tidak dapat mengakses'], 400);
        $agent = $this->agent_info();
        $param = request()->only('search','filter', 'offset', 'limit', 'order');
        $search = $param['search'];
        $filter = $param['filter'];
        $offset = $param['offset'];
        $limit = $param['limit'];
        $order_sort = !empty($param['order'][0]) ? $param['order'][0] : 'p.id';
        $order_mode = !empty($param['order'][1]) ? $param['order'][1] : 'desc';
        //get data list
        $list = DB::table('etalase AS et')
        ->join('product AS p', 'p.id', '=', 'et.product')
        ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
        ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
        ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
        ->leftJoin('seller AS s', 's.id', '=', 'p.seller_id')
        ->leftJoin('region AS r', 'r.id', '=', 's.region')
        ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
        ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
        ->select(
                'et.*',
                'et.id AS id_etalase',
                'et.status AS status_etalase',
                'p.id AS id_produk',
                'p.brand AS id_brand',
                'rb.name AS nama_brand', 
                'p.type AS id_tipe',
                'rpt.name AS nama_tipe',
                'p.production_year AS Tahun',
                'p.transmission AS transmisi',
                'p.fuel AS fuel',
                'p.price AS harga_jual',
                'p.sales_commission AS komisi',
                'p.vehicles_code AS id_kode_plat',
                'rvc.name AS nama_kode_plat',
                'p.name AS judul',
                'p.price AS price',
                'p.sales_commission AS sales_commission',
                'p.production_year AS production_year',
                'p.photo_thumbnail AS thumbnail',
                's.name AS seller_name',
                'r.name AS seller_region',
                'ua.name AS author', 
                'p.created_at AS created_date')
            ->whereRaw('1 = 1')
            ->where(['et.agent' => $agent->id])
            ->where(function($query) use ($search){
                $query->where('p.name', 'like', '%'.$search.'%')
                    ->orWhere('rb.name', 'like', '%'.$search.'%')
                    ->orWhere('rpt.name', 'like', '%'.$search.'%');
            })
            ->orderBy($order_sort, $order_mode)
            ->offset($offset)
            ->limit($limit);
        if(!empty($filter['brand'])){
            $list->where('p.brand', $filter['brand']);
        }
        $list = $list->get();

        //get data filtered total
        $filtered = DB::table('etalase AS et')
            ->join('product AS p', 'p.id', '=', 'et.product')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('seller AS s', 's.id', '=', 'p.seller_id')
            ->leftJoin('region AS r', 'r.id', '=', 's.region')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->selectRaw('COUNT(DISTINCT et.id) AS total')
            ->whereRaw('1 = 1')
            ->where(['et.agent' => $agent->id])
            ->where(function($query) use ($search){
                $query->where('p.name', 'like', '%'.$search.'%')
                    ->orWhere('rb.name', 'like', '%'.$search.'%')
                    ->orWhere('rpt.name', 'like', '%'.$search.'%');
            });
        if(!empty($filter['brand'])){
            $filtered->where('p.brand', $filter['brand']);
        }
        $filtered = $filtered->first()->total;

        //get data total
        $total =  DB::table('etalase AS et')
            ->join('product AS p', 'p.id', '=', 'et.product')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->whereRaw('1 = 1')
            ->where(['et.agent' => $agent->id])
            ->where(function($query) use ($search){
                $query->where('p.name', 'like', '%'.$search.'%')
                    ->orWhere('rb.name', 'like', '%'.$search.'%')
                    ->orWhere('rpt.name', 'like', '%'.$search.'%');
            })
            ->count();

        foreach($list AS $key => $value){
            $value->harga_jual_rp = $this->currency($value->harga_jual);
            $value->komisi_rp = $this->currency($value->komisi);
        }
        $result['list'] = $list;
        $result['filtered'] = $filtered;
        $result['total'] = $total;
        if($result)
            return response(['status' => true, 'message' => '', 'data' => $result], 200);
        else
            return response(['status' => false, 'message' => 'Data Empty', 'data' => []], 400);
    }
}
