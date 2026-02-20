<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;

class ProductExploreController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::allows('isSeller')) return response(['status' => false, 'message' => 'seller tidak dapat mengakses'], 400);
        $param = request()->only('search','filter', 'offset', 'limit', 'order');
        $search = $param['search'];
        $filter = $param['filter'];
        $offset = $param['offset'];
        $limit = $param['limit'];
        $order_sort = !empty($param['order'][0]) ? $param['order'][0] : 'p.id';
        $order_mode = !empty($param['order'][1]) ? $param['order'][1] : 'desc';
        //get data list
        $list = DB::table('product AS p')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->select('p.id AS id_produk',
                    'p.brand AS id_brand',
                    'rb.name AS nama_brand', 
                    'p.type AS id_tipe',
                    'rpt.name AS nama_tipe',
                    'p.production_year AS Tahun',
                    'p.transmission AS transmisi',
                    'p.price AS harga_jual',
                    'p.sales_commission AS komisi',
                    'p.vehicles_code AS id_kode_plat',
                    'rvc.name AS nama_kode_plat',
                    'p.name AS judul',
                    'ua.name AS author', 
                    'p.created_at AS created_date')
            ->where('p.status', 'Active')
            ->where(function($query) use ($search){
                $query->where('p.name', 'like', '%'.$search.'%')
                    ->orWhere('rb.name', 'like', '%'.$search.'%')
                    ->orWhere('rpt.name', 'like', '%'.$search.'%');
            })
            ->orderBy($order_sort, $order_mode)
            ->offset($offset)
            ->limit($limit);
        if(!empty($filter['brand'])) $list->where('p.brand', $filter['brand']);
        if(!empty($filter['production_year'])) $list->where('p.production_year', $filter['production_year']);
        $list = $list->get();

        //get data filtered total
        $filtered = DB::table('product AS p')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->selectRaw('COUNT(DISTINCT p.id) AS total')
            ->where('p.status', 'Active')
            ->where(function($query) use ($search){
                $query->where('p.name', 'like', '%'.$search.'%')
                    ->orWhere('rb.name', 'like', '%'.$search.'%')
                    ->orWhere('rpt.name', 'like', '%'.$search.'%');
            });
        if(!empty($filter['brand'])) $filtered->where('p.brand', $filter['brand']);
        if(!empty($filter['production_year'])) $filtered->where('p.production_year', $filter['production_year']);
        $filtered = $filtered->first()->total;

        //get data total
        $total =  DB::table('product AS p')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->selectRaw('COUNT(DISTINCT p.id) AS total')
            ->where('p.status', 'Active');
        $total = $total->first()->total;

        $result['list'] = $list;
        $result['filtered'] = $filtered;
        $result['total'] = $total;
        if($result)
            return response(['status' => true, 'message' => '', 'data' => $result], 200);
        else
            return response(['status' => false, 'message' => 'Data Empty', 'data' => []], 400);
    }

    public function detail($id)
    {

        $detail = DB::table('product AS p')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_variant AS rv', 'rv.id', '=', 'p.variant')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('ref_body_type AS rbt', 'rbt.id', '=', 'p.body_type')
            ->leftJoin('ref_product_owner AS rpo', 'rpo.id', '=', 'p.owner')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->select('p.*',
                    'p.id AS id_produk',
                    'p.name AS judul_produk',
                    'rb.name AS nama_brand', 
                    'rpt.name AS nama_tipe',
                    'rv.name AS nama_varian',
                    'rbt.name AS nama_tipe_body',
                    'rvc.name AS nama_kode_plat',
                    'rpo.name AS tangan_ke',
                    'ua.name AS author', 
                    'p.created_at AS created_date')
            ->where(['p.id' => $id])
            ->first();
        
        if(empty($detail)) return response(['status' => false, 'message' => 'Data Tidak ditemukan'], 400);
        $information = [
            'kondisi' => $detail->condition,
            'brand' => $detail->nama_brand,
            'tipe' => $detail->nama_tipe,
            'varian' => $detail->nama_varian,
            'tranmisi' => $detail->transmission,
            'tahun' => $detail->production_year,
            'kapasitas_mesin' => $detail->machine_capacity, 
            'bahan_bakar' => $detail->fuel,
            'kilometer' => $detail->mileage,
            'tipe_bodi' => $detail->nama_tipe_body,
            'kapasitas_penumpang' => $detail->passanger_capacity,
            'tangan_ke' => $detail->tangan_ke,
            'kode_plat' => $detail->nama_kode_plat,
            'judul' => $detail->judul_produk,
            'deskripsi' => $detail->summary
        ];
        $sales = [
            'harga' => $this->currency($detail->price),
            'komisi' => $this->currency($detail->sales_commission),
            'sistem_pembayaran' => $detail->payment_type
        ];
        if(!empty($detail->photo_exterior_front) && File::exists(storage_path('app/public/'.$detail->photo_exterior_front))) 
            $detail->photo_exterior_front = url('storage/'.$detail->photo_exterior_front);
        else
            $detail->photo_exterior_front = 'Foto Exterior Depan Kosong';

        if(!empty($detail->photo_exterior_back) && File::exists(storage_path('app/public/'.$detail->photo_exterior_back))) 
            $detail->photo_exterior_back = url('storage/'.$detail->photo_exterior_back);
        else
            $detail->photo_exterior_back = 'Foto Exterior Belakang Kosong';

        if(!empty($detail->photo_exterior_left) && File::exists(storage_path('app/public/'.$detail->photo_exterior_left))) 
            $detail->photo_exterior_left = url('storage/'.$detail->photo_exterior_left);
        else
            $detail->photo_exterior_left = 'Foto Exterior Sisi Kiri Kosong';

        if(!empty($detail->photo_exterior_right) && File::exists(storage_path('app/public/'.$detail->photo_exterior_right))) 
            $detail->photo_exterior_right = url('storage/'.$detail->photo_exterior_right);
        else
            $detail->photo_exterior_right = 'Foto Exterior Sisi Kanan Kosong';

        if(!empty($detail->photo_interior_front) && File::exists(storage_path('app/public/'.$detail->photo_interior_front))) 
            $detail->photo_interior_front = url('storage/'.$detail->photo_interior_front);
        else
            $detail->photo_interior_front = 'Foto Interior Bagian Depan Kosong';
        
        if(!empty($detail->photo_interior_center) && File::exists(storage_path('app/public/'.$detail->photo_interior_center))) 
            $detail->photo_interior_center = url('storage/'.$detail->photo_interior_center);
        else
            $detail->photo_interior_center = 'Foto Interior Bagian Tengah Kosong';

        if(!empty($detail->photo_interior_behind) && File::exists(storage_path('app/public/'.$detail->photo_interior_behind))) 
            $detail->photo_interior_behind = url('storage/'.$detail->photo_interior_behind);
        else
            $detail->photo_interior_behind = 'Foto Interior Bagian Belakang Kosong';
            
        $photos = [
            $detail->photo_exterior_front,
            $detail->photo_exterior_back,
            $detail->photo_exterior_left,
            $detail->photo_exterior_right,
            $detail->photo_interior_front,
            $detail->photo_interior_center,
            $detail->photo_interior_behind
        ];

        $result['id_produk'] = $detail->id_produk;
        $result['informasi_kendaraan'] = $information;
        $result['informasi_penjualan'] = $sales;
        $result['foto'] = $photos;
        if($result)
            return response(['status' => true, 'message' => null, 'data' => $result], 200);
        else
            return response(['status' => false, 'message' => 'Data Empty', 'data' => []], 400);
    }
}
