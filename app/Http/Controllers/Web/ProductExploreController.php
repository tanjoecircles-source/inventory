<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\RefBodyType;
use App\Models\Etalase;
use App\Models\RefBrand;
use App\Models\RefVariant;

class ProductExploreController extends Controller
{
    public function search()
    {
        $data = [];
        return view('web.agent.product_explore.search', $data);
    }

    public function search_result(Request $request)
    {
        $data = $request['keyword'] ?? '';
        $request->session()->put('search_result', $data);
        return redirect('product-explore');
    }

    public function list(Request $request)
    {
        if(isset($_GET['clear'])) $request->session()->forget('search_result');
        $agent = $this->agent_info();
        $limit = 6;
        $search = session('search_result') ?? "";
        $contents = DB::table('product AS p')
                ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
                ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
                ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
                ->leftJoin('seller AS s', 's.id', '=', 'p.seller_id')
                ->leftJoin('region AS r', 'r.id', '=', 's.region')
                ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
                ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
                ->select('p.id AS id_produk',
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
                        'is_sold_out',
                        'p.created_at AS created_date')
                ->whereRaw('1 = 1')
                ->where(['p.status' => 'Active'])
                ->where(function($query) use ($search){
                    $query->where('p.name', 'like', '%'.$search.'%')
                        ->orWhere('rb.name', 'like', '%'.$search.'%')
                        ->orWhere('rpt.name', 'like', '%'.$search.'%');
                })
                ->orderBy('is_sold_out', 'DESC')
                ->paginate($limit);

        $counts = DB::table('product AS p')
                    ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
                    ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
                    ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
                    ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
                    ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
                    ->whereRaw('1 = 1')
                    ->where(['p.status' => 'Active'])
                    ->where(function($query) use ($search){
                        $query->where('p.name', 'like', '%'.$search.'%')
                            ->orWhere('rb.name', 'like', '%'.$search.'%');
                    })
                    ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->created_date = date('d M Y', strtotime($value->created_date));
                $value->price = $this->format_angka($value->price);
                $value->sales_commission = $this->format_angka($value->sales_commission);
                $value->etalase = Etalase::where(['product' => $value->id_produk, 'agent' => $agent->id])->count();
                if($value->is_sold_out == 'true'){
                    $value->style_thumb = 'opacity: 0.4';
                }else{
                    $value->style_thumb = 'opacity: unset';
                }
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.agent.product_explore.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.agent.product_explore.list', $data);
    }

    public function detail($id)
    {
        $agent = $this->agent_info();
        $detail = DB::table('product AS p')
            ->leftJoin('ref_color AS cl', 'cl.id', '=', 'p.color')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_variant AS rv', 'rv.id', '=', 'p.variant')
            ->leftJoin('ref_machine_capacity AS mc', 'mc.id', '=', 'p.machine_capacity')
            ->leftJoin('ref_mileage AS mg', 'mg.id', '=', 'p.mileage')
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
                    'cl.name AS warna',
                    'cl.hexa AS warna_hexa',
                    'mc.name AS kapasitas_mesin',
                    'mg.name AS jarak_tempuh',
                    'rpo.name AS tangan_ke',
                    'ua.name AS author', 
                    'p.is_sold_out',
                    'p.created_at AS created_date')
            ->where(['p.id' => $id])
            ->first();
        
        if($detail->is_sold_out == 'true'){
            $detail->style_thumb = 'opacity: 0.4';
        }else{
            $detail->style_thumb = 'opacity: unset';
        }

        $information = [
            'harga' => $this->format_angka($detail->price),
            'komisi' => $this->format_angka($detail->sales_commission),
            'kondisi' => $detail->condition,
            'brand' => $detail->nama_brand,
            'tipe' => $detail->nama_tipe,
            'varian' => $detail->nama_varian,
            'tranmisi' => $detail->transmission,
            'warna' => $detail->warna,
            'kode_warna' => $detail->warna_hexa,
            'jarak_tempuh' => $detail->jarak_tempuh,
            'tahun' => $detail->production_year,
            'kapasitas_mesin' => $detail->kapasitas_mesin, 
            'bahan_bakar' => $detail->fuel,
            'tipe_bodi' => $detail->nama_tipe_body,
            'kapasitas_penumpang' => $detail->passanger_capacity,
            'tangan_ke' => $detail->tangan_ke,
            'pajak' => $detail->end_of_tax == '1970-01-01' ? '-' : $detail->end_of_tax,
            'kode_plat' => $detail->nama_kode_plat,
            'judul' => $detail->judul_produk,
            'is_sold_out' => $detail->is_sold_out,
            'style_thumb' => $detail->style_thumb,
            'deskripsi' => $detail->summary
        ];
        $sales = [
            'harga' => $this->format_angka($detail->price),
            'komisi' => $this->format_angka($detail->sales_commission),
            'sistem_pembayaran' => $detail->payment_type
        ];
        if(!empty($detail->photo_exterior_front) && File::exists(storage_path('app/public/'.$detail->photo_exterior_front))) 
            $detail->photo_exterior_front = url('storage/'.$detail->photo_exterior_front);
        else
            $detail->photo_exterior_front = url('storage/noimages.jpg');

        if(!empty($detail->photo_exterior_back) && File::exists(storage_path('app/public/'.$detail->photo_exterior_back))) 
            $detail->photo_exterior_back = url('storage/'.$detail->photo_exterior_back);
        else
            $detail->photo_exterior_back = url('storage/noimages.jpg');

        if(!empty($detail->photo_exterior_left) && File::exists(storage_path('app/public/'.$detail->photo_exterior_left))) 
            $detail->photo_exterior_left = url('storage/'.$detail->photo_exterior_left);
        else
            $detail->photo_exterior_left = url('storage/noimages.jpg');

        if(!empty($detail->photo_exterior_right) && File::exists(storage_path('app/public/'.$detail->photo_exterior_right))) 
            $detail->photo_exterior_right = url('storage/'.$detail->photo_exterior_right);
        else
            $detail->photo_exterior_right = url('storage/noimages.jpg');

        if(!empty($detail->photo_interior_front) && File::exists(storage_path('app/public/'.$detail->photo_interior_front))) 
            $detail->photo_interior_front = url('storage/'.$detail->photo_interior_front);
        else
            $detail->photo_interior_front = url('storage/noimages.jpg');
        
        if(!empty($detail->photo_interior_center) && File::exists(storage_path('app/public/'.$detail->photo_interior_center))) 
            $detail->photo_interior_center = url('storage/'.$detail->photo_interior_center);
        else
            $detail->photo_interior_center = url('storage/noimages.jpg');

        if(!empty($detail->photo_interior_behind) && File::exists(storage_path('app/public/'.$detail->photo_interior_behind))) 
            $detail->photo_interior_behind = url('storage/'.$detail->photo_interior_behind);
        else
            $detail->photo_interior_behind = url('storage/noimages.jpg');
            
        if(!empty($detail->photo_machine) && File::exists(storage_path('app/public/'.$detail->photo_machine))) 
            $detail->photo_machine = url('storage/'.$detail->photo_machine);
        else
            $detail->photo_machine = url('storage/noimages.jpg');
            
        $photos = [
            $detail->photo_exterior_front,
            $detail->photo_exterior_back,
            $detail->photo_exterior_left,
            $detail->photo_exterior_right,
            $detail->photo_interior_front,
            $detail->photo_interior_center,
            $detail->photo_interior_behind,
            $detail->photo_machine
        ];
        
        $result['id_produk'] = $detail->id_produk;
        $result['info'] = $information;
        $result['sales'] = $sales;
        $result['foto'] = $photos;
        
        $result['etalase'] = Etalase::where(['product' => $detail->id_produk, 'agent' => $agent->id])->count();
        //echo "<pre>";print_r($result);die;
        return view('web.agent.product_explore.detail', $result);
    }

    public function etalase(Request $request){
        $agent = $this->agent_info();
        $id = $request->product_id;
        DB::table('etalase')->updateOrInsert([
                'agent' => $agent->id, 
                'product' => $id, 
                'author' => Auth::user()->id,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ],
            ['agent' => $agent->id, 'product' => $id]
        );
        $status = Etalase::where(['agent' => $agent->id, 'product' => $id])->count();
        $result = ['status' => $status, 'id' => $id];
        return $result;
    }

    public function unetalase(Request $request){
        $agent = $this->agent_info();
        $id = $request->product_id;
        DB::table('etalase')->where(['product' => $id, 'agent' => $agent->id])->delete();
        $status = Etalase::where(['agent' => $agent->id, 'product' => $id])->count();
        $count = Etalase::where(['agent' => $agent->id])->count();
        $result = ['status' => $status, 'count' => $count, 'id' => $id];
        return $result;
    }
}
