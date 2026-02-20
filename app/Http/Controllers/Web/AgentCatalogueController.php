<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AgentCatalogueController extends Controller
{
    public function index(Request $request){
        $code = $_GET['id'];
        $name = $_GET['name'];
        $info = DB::table('agent AS a')
                ->leftJoin('region AS r', 'r.id', '=', 'a.region')
                ->leftJoin('district AS d', 'd.id', '=', 'a.district')
                ->leftJoin('users AS u', 'u.id' , '=', 'a.user')
                ->select(
                    'a.*',
                    'a.id AS agent_id',
                    'r.name AS region_name',
                    'd.name AS district_name',
                    'u.avatar AS avatar',
                    'u.phone AS phone', 
                )
                ->where('a.code', $code)
                ->first();
        
        if(!empty($info->district_name)){
            $info->district_name = strtolower($info->district_name);
            $info->district_name = ucwords($info->district_name);
        }

        if(!empty($info)){
            if(!empty($info->district_name) && empty($info->region_name))
                $info->address = $info->district_name;
            elseif(!empty($info->region_name) && empty($info->district_name))
                $info->address = $info->region_name;
            elseif(!empty($info->district_name) && !empty($info->region_name))
                $info->address = $info->district_name.', '.$info->region_name;
            else
                $info->address = "Indonesia";
        }
        
        if(!empty($info->avatar) && File::exists(storage_path('app/public/user/thumbnail/'.$info->avatar))) 
            $info->avatar = url('storage/user/thumbnail/'.$info->avatar);
        else
            $info->avatar = url('assets/images/users/1.jpg');

        $info->template = 
"Halo Agent Brocar, 

Saya sedang mencari mobil impian, apakah anda bisa membantu?

Terima kasih.";
        $info->template = urlencode($info->template);

        $request->session()->forget('search_result');
        $limit = 10;
        $search = session('search_result') ?? "";
        $contents = DB::table('etalase AS et')
                ->join('product AS p', 'p.id', '=', 'et.product')
                ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
                ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
                ->leftJoin('ref_variant AS rv', 'rv.id', '=', 'p.variant')
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
                        'p.code AS kode_produk',
                        'p.brand AS id_brand',
                        'rb.name AS nama_brand', 
                        'p.type AS id_tipe',
                        'rpt.name AS nama_tipe',
                        'p.variant AS id_varian',
                        'rv.name AS nama_varian',
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
                ->where(['et.agent' => $info->agent_id])
                ->where(function($query) use ($search){
                    $query->where('p.name', 'like', '%'.$search.'%')
                        ->orWhere('rb.name', 'like', '%'.$search.'%')
                        ->orWhere('rpt.name', 'like', '%'.$search.'%');
                })
                ->orderBy('p.id', 'DESC')
                ->paginate($limit);

        $counts = DB::table('etalase AS et')
                    ->join('product AS p', 'p.id', '=', 'et.product')
                    ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
                    ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
                    ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
                    ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
                    ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
                    ->whereRaw('1 = 1')
                    ->where(['et.agent' => $info->agent_id])
                    ->where(function($query) use ($search){
                        $query->where('p.name', 'like', '%'.$search.'%')
                            ->orWhere('rb.name', 'like', '%'.$search.'%')
                            ->orWhere('rpt.name', 'like', '%'.$search.'%');
                    })
                    ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->nameurl = $name;
                $value->codeurl = $code;
                $value->agent_phone = $info->phone;
                $value->created_date = date('d M Y', strtotime($value->created_date));
                $value->kode_produk = '#'.strtoupper($value->kode_produk);
                $value->price = $this->format_angka($value->price);
                $value->sales_commission = $this->format_angka($value->sales_commission);
            }
        }
        $data = [
            'url' => urlencode('mitra?name='.$name.'&id='.$code),
            'info' => $info,
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        
        if($request->ajax()){
            $view = view('web.agent_catalogue.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.agent_catalogue.index', $data);
    }

    public function product()
    {
        $id=$_GET['id'];
        $nameurl=$_GET['name'];
        $codeurl=$_GET['code'];
        $agent = DB::table('agent AS a')
                ->leftJoin('region AS r', 'r.id', '=', 'a.region')
                ->leftJoin('district AS d', 'd.id', '=', 'a.district')
                ->leftJoin('users AS u', 'u.id' , '=', 'a.user')
                ->select(
                    'a.*',
                    'a.id AS agent_id',
                    'r.name AS region_name',
                    'd.name AS district_name',
                    'u.phone AS phone', 
                )
                ->where('a.code', $codeurl)
                ->first();
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
                    'p.code AS kode_produk',
                    'p.name AS judul_produk',
                    'p.transmission AS transmisi',
                    'p.production_year AS Tahun',
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
                    'p.created_at AS created_date')
            ->where(['p.id' => $id])
            ->first();

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
                        'p.transmission AS transmisi',
            'tahun' => $detail->production_year,
            'kapasitas_mesin' => $detail->kapasitas_mesin, 
            'bahan_bakar' => $detail->fuel,
            'tipe_bodi' => $detail->nama_tipe_body,
            'kapasitas_penumpang' => $detail->passanger_capacity,
            'tangan_ke' => $detail->tangan_ke,
            'pajak' => $detail->end_of_tax == '1970-01-01' ? '-' : $detail->end_of_tax,
            'kode_plat' => $detail->nama_kode_plat,
            'judul' => $detail->judul_produk,
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

        $agent->content_text = 
"Halo Agent Brocar, 

Saya tertarik diberikan informasi penjualan lebih detail tentang mobil ini:

kode unit : ".$detail->kode_produk."
Brand : ".$detail->nama_brand."
Tipe : ".$detail->nama_tipe."
Varian : ".$detail->nama_varian."
Tahun : ".$detail->Tahun."
Transmisi : ".$detail->transmisi."

Terima kasih.";
        $agent->content_text = urlencode($agent->content_text);

        $result['id_produk'] = $detail->id_produk;
        $result['info'] = $information;
        $result['sales'] = $sales;
        $result['foto'] = $photos;
        $result['meta_image'] = $detail->photo_exterior_right;
        $result['nameurl'] = $nameurl;
        $result['codeurl'] = $codeurl;
        $result['agent_phone'] = $agent->phone;
        $result['agent_content_text'] = $agent->content_text;
        return view('web.agent_catalogue.product', $result);
    }
}
