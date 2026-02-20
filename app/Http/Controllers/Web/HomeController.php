<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\News;
use App\Models\Product;
use App\Models\Etalase;
use App\Models\User;
use App\Models\GbMap;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $seller = $this->seller_info();
        $agent = $this->agent_info();

        $stok_gb = DB::table('product_group as pg')
                    ->selectRaw('pg.name as `group`')
                    ->selectRaw('SUM(rs.name * p.stock) as total_stock')
                    ->leftJoin('product as p', 'p.group', '=', 'pg.id')
                    ->leftJoin('ref_satuan as rs', 'rs.id', '=', 'p.satuan')
                    ->where(['pg.type' => 'Green', 'pg.status' => 'Aktif'])
                    ->groupBy('pg.id', 'pg.name')
                    ->orderByDesc('total_stock')
                    ->get();

        $stok_rsf = DB::table('product as p')
                    ->select('p.id', 'p.name AS name', 'p.price AS price', 'stock AS qty')
                    ->leftJoin('ref_satuan as rs', 'rs.id', '=', 'p.satuan')
                    ->where(['p.type' => '2', 'p.status' => 'Active'])
                    ->orderByDesc('p.name')
                    ->get();
        
        $stok_rss = DB::table('product as p')
                    ->select('p.id', 'p.name AS name', 'stock AS qty')
                    ->leftJoin('ref_satuan as rs', 'rs.id', '=', 'p.satuan')
                    ->where(['p.type' => '3', 'p.status' => 'Active'])
                    ->orderByDesc('p.name')
                    ->get();
            
        // if(!empty($stok_gb)){
        //     foreach ($stok_gb as $key => $value) {
        //         $value->price = $this->format_angka($value->price);
        //         $value->sales_commission = $this->format_angka($value->sales_commission);
        //     }
        // }
       
        $data = [
            'stok_gb' => $stok_gb,
            'stok_rsf' => $stok_rsf,
            'stok_rss' => $stok_rss,
            'product' => Product::where('status', 'Active')->orderBy('is_sold_out', 'DESC')->paginate(10),
            'agent_id' => $agent->id,
            'seller_total' => User::where(['type' => 'seller'])->whereNotNull('email_verified_at')->count(),
            'agent_total' => User::where(['type' => 'agent'])->whereNotNull('email_verified_at')->count(),
            'product_total' => Product::count(),
            'map_belakang_kiri' => GbMap::where('location', 'belakang-kiri')->get(),
            'map_belakang_kanan' => GbMap::where('location', 'belakang-kanan')->get(),
            'map_tengah_kiri' => GbMap::where('location', 'tengah-kiri')->get(),
            'map_tengah_kanan' => GbMap::where('location', 'tengah-kanan')->get(),
            'map_depan_kiri' => GbMap::where('location', 'depan-kiri')->get(),
            'map_depan_kanan' => GbMap::where('location', 'depan-kanan')->get()
        ];
        if (Gate::allows('isSeller') || Gate::allows('isSellerDealer')) return view('web.seller.home.index', $data);
        if (Gate::allows('isAgent')) return view('web.agent.home.index', $data);
        return view('web.admin.home.index', $data);
    }


    public function list_product(Request $request){
        $data = [
            'product' => Product::where('status', 'Active')->orderBy('is_sold_out', 'DESC')->paginate(10),
            'agent_id' => $this->agent_info()->id
        ];
        
        $view = view('web.agent.home.paginate_product', $data)->render();
        return response()->json(['html' => $view]);
    }

    public function menu(){
        if (Gate::denies('isAdmin')) return view('error_authorize');
        return view('web.admin.home.menu');
    }

    public function mapstorage(){
        $data = [
            'map_belakang_kiri' => DB::table('gb_map AS g')->where('location', '001-belakang-kiri')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_belakang_kanan' => DB::table('gb_map AS g')->where('location', '001-belakang-kanan')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_tengah_kiri' => DB::table('gb_map AS g')->where('location', '001-tengah-kiri')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_tengah_kanan' => DB::table('gb_map AS g')->where('location', '001-tengah-kanan')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_depan_kiri' => DB::table('gb_map AS g')->where('location', '001-depan-kiri')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_depan_kanan' => DB::table('gb_map AS g')->where('location', '001-depan-kanan')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_belakang_kiri_2' => DB::table('gb_map AS g')->where('location', '002-belakang-kiri')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_belakang_kanan_2' => DB::table('gb_map AS g')->where('location', '002-belakang-kanan')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_depan_kiri_2' => DB::table('gb_map AS g')->where('location', '002-depan-kiri')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get(),
            'map_depan_kanan_2' => DB::table('gb_map AS g')->where('location', '002-depan-kanan')->select('g.id AS id', 'p.name AS name')->leftJoin('product_group AS p', 'p.id', '=', 'g.product')->get()
        ];
        return view('web.admin.home.mapstorage', $data);
    }

    public function menurecipe(){
        $data = [];
        return view('web.admin.home.menurecipe', $data);
    }
}
