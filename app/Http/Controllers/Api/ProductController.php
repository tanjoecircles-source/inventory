<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\SellerInfo;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::denies('isSeller')) return response(['status' => false, 'message' => 'Selain seller tidak dapat mengakses'], 400);
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
            ->whereRaw('1 = 1')
            ->where(['p.author' => Auth::user()->id])
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
        $filtered = DB::table('product AS p')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->selectRaw('COUNT(DISTINCT p.id) AS total')
            ->whereRaw('1 = 1')
            ->where(['p.author' => Auth::user()->id])
            ->where(function($query) use ($search){
                $query->where('p.name', 'like', '%'.$search.'%')
                    ->orWhere('rb.name', 'like', '%'.$search.'%');
            });
        if(!empty($filter['brand'])){
            $filtered->where('p.brand', $filter['brand']);
        }
        $filtered = $filtered->first()->total;

        //get data total
        $total =  DB::table('product AS p')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->selectRaw('COUNT(DISTINCT p.id) AS total')
            ->where(['p.author' => Auth::user()->id]);
        $total = $total->first()->total;
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

    public function detail($id)
    {

        $detail = DB::table('product AS p')
            ->leftJoin('ref_color AS rc', 'rc.id', '=', 'p.color')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_variant AS rv', 'rv.id', '=', 'p.variant')
            ->leftJoin('ref_machine_capacity AS rmc', 'rmc.id', '=', 'p.machine_capacity')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('ref_body_type AS rbt', 'rbt.id', '=', 'p.body_type')
            ->leftJoin('ref_product_owner AS rpo', 'rpo.id', '=', 'p.owner')
            ->leftJoin('ref_mileage AS rml', 'rml.id', '=', 'p.mileage')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->select('p.*',
                    'p.id AS id_produk',
                    'p.name AS judul_produk',
                    'rc.name AS warna',
                    'rb.name AS nama_brand', 
                    'rpt.name AS nama_tipe',
                    'rv.name AS nama_varian',
                    'rbt.name AS nama_tipe_body',
                    'rmc.name AS nama_kapsitas',
                    'rvc.name AS nama_kode_plat',
                    'rpo.name AS tangan_ke',
                    'rml.name AS kilometer',
                    'ua.name AS author', 
                    'p.created_at AS created_date')
            ->where(['p.author' => Auth::user()->id, 'p.id' => $id])
            ->first();
        
        if(empty($detail)) return response(['status' => false, 'message' => 'Data Tidak ditemukan'], 400);
        $information = [
            'kondisi' => $detail->condition,
            'warna' => $detail->warna,
            'brand' => $detail->nama_brand,
            'tipe' => $detail->nama_tipe,
            'varian' => $detail->nama_varian,
            'tranmisi' => $detail->transmission,
            'tahun' => $detail->production_year,
            'kapasitas_mesin' => $detail->nama_kapsitas, 
            'bahan_bakar' => $detail->fuel,
            'kilometer' => $detail->kilometer,
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

    public function create(Request $request)
    {
        if (Gate::denies('isSeller')) return response(['status' => false, 'message' => 'Selain seller tidak dapat mengakses'], 400);
        
        $valid = validator($request->only(
            'condition', 'owner', 'brand', 'name', 'type', 'type', 'variant', 'body_type', 'vehicles_code',
            'transmission', 'production_year', 'machine_capacity', 'fuel', 'end_of_tax', 
            'passanger_capacity', 'mileage', 'price', 'sales_commission', 'payment_type'), [
            'condition' => 'required',
            'owner' => 'required',
            'brand' => 'required',
            'name' => 'required',
            'type' => 'required',
            'variant' => 'required',
            'body_type' => 'required',
            'vehicles_code' => 'required',
            'transmission' => 'required',
            'production_year' => 'required',
            'machine_capacity' => 'required',
            'fuel' => 'required',
            'end_of_tax' => 'required',
            'passanger_capacity' => 'required',
            'mileage' => 'required',
        ]);

        if ($valid->fails()) {
            return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        }

        $data = request()->only(
            'condition', 'owner', 'brand', 'name', 'type', 'variant', 'body_type', 
            'vehicles_code', 'transmission', 'production_year', 'machine_capacity', 
            'fuel', 'end_of_tax', 'passanger_capacity', 'mileage' ,'summary'
        );
        $seller = SellerInfo::where('user', Auth::user()->id)->select('id')->first();
        if(empty($seller)) return response(['status' => false, 'message' => 'Jangan lupa lengkapi profil dulu ya'], 400);

        $result = Product::create([
            'code' => strtolower($this->generate_code(8)),
            'seller_id' =>  $seller->id,
            'condition' => !empty($data['condition']) ? $data['condition'] : 'Bekas',
            'owner' => $data['owner'],
            'brand' => $data['brand'],
            'name' => $data['name'],
            'type' => $data['type'],
            'variant' => $data['variant'],
            'body_type' => $data['body_type'],
            'vehicles_code' => $data['vehicles_code'],
            'transmission' => !empty($data['transmission']) ? $data['transmission'] : 'Manual',
            'production_year' => $data['production_year'],
            'machine_capacity' => $data['machine_capacity'],
            'fuel' => $data['fuel'],
            'end_of_tax' => $data['end_of_tax'],
            'passanger_capacity' => $data['passanger_capacity'],
            'mileage' => $data['mileage'],
            'summary' => $data['summary'],
            'author' => Auth::user()->id,
            'editor' => Auth::user()->id,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        if($result)
            return response(['status' => true, 'message' => 'Berhasil Menyimpan Data', 'product_id' => $result->id], 200);
        else
            return response(['status' => false, 'message' => 'Gagal Menyimpan Data', 'product_id' => null], 400);
    }

    public function update_sales(Request $request)
    {
        if (Gate::denies('isSeller')) return response(['status' => false, 'message' => 'Selain seller tidak dapat mengakses'], 400);
        
        $valid = validator($request->all(), [
            'id' => 'required',
            'price' => 'required',
            'sales_commission' => 'required',
            'payment_type' => 'required',
        ]);

        if ($valid->fails()) {
            return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        }

        $data = request()->all();
        
        $result = Product::where('id', $data['id'])->update([
            'price' => $data['price'],
            'sales_commission' => $data['sales_commission'],
            'payment_type' => $data['payment_type'],
            'author' => Auth::user()->id,
            'editor' => Auth::user()->id,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        if($result)
            return response(['status' => true, 'message' => 'Berhasil Menyimpan Data'], 200);
        else
            return response(['status' => false, 'message' => 'Gagal Menyimpan Data'], 400);
    }

    public function update_photo(Request $request)
    {
        if (Gate::denies('isSeller')) return response(['status' => false, 'message' => 'Hanya seller yang bisa mengakses'], 400);
        
        $valid=validator($request->all(), [
            'id'=>'required',
            'photo_exterior_front' => 'image|max:2560',
            'photo_exterior_back' => 'image|max:2560',
            'photo_exterior_left' => 'image|max:2560',
            'photo_exterior_right' => 'image|max:2560',
            'photo_interior_front' => 'image|max:2560',
            'photo_interior_center' => 'image|max:2560',
            'photo_interior_behind' => 'image|max:2560',
        ]);
        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        
        $param = request()->only('id');
        $old = Product::where('id', $param['id'])->first();
        if($request->file('photo_exterior_front')) {
            if(File::exists(storage_path('app/public/'.$old['photo_exterior_front']))) File::delete(storage_path('app/public/'.$old['photo_exterior_front']));
            $photo_exterior_front = $request->file('photo_exterior_front')->store('product/'.$old['code'], 'public');
        } else { 
            $photo_exterior_front = $old['photo_exterior_front'];
        }

        if($request->file('photo_exterior_back')) {
            if(File::exists(storage_path('app/public/'.$old['photo_exterior_back']))) File::delete(storage_path('app/public/'.$old['photo_exterior_back']));
            $photo_exterior_back = $request->file('photo_exterior_back')->store('product/'.$old['code'], 'public');
        } else { 
            $photo_exterior_back = $old['photo_exterior_back'];
        }

        if($request->file('photo_exterior_left')) {
            if(File::exists(storage_path('app/public/'.$old['photo_exterior_left']))) File::delete(storage_path('app/public/'.$old['photo_exterior_left']));
            $photo_exterior_left = $request->file('photo_exterior_left')->store('product/'.$old['code'], 'public');
        } else { 
            $photo_exterior_left = $old['photo_exterior_left'];
        }

        if($request->file('photo_exterior_right')) {
            if(File::exists(storage_path('app/public/'.$old['photo_exterior_right']))) File::delete(storage_path('app/public/'.$old['photo_exterior_right']));
            $photo_exterior_right = $request->file('photo_exterior_right')->store('product/'.$old['code'], 'public');
        } else { 
            $photo_exterior_right = $old['photo_exterior_right'];
        }

        if($request->file('photo_interior_front')) {
            if(File::exists(storage_path('app/public/'.$old['photo_interior_front']))) File::delete(storage_path('app/public/'.$old['photo_interior_front']));
            $photo_interior_front = $request->file('photo_interior_front')->store('product/'.$old['code'], 'public');
        } else { 
            $photo_interior_front = $old['photo_interior_front'];
        }

        if($request->file('photo_interior_center')) {
            if(File::exists(storage_path('app/public/'.$old['photo_interior_center']))) File::delete(storage_path('app/public/'.$old['photo_interior_center']));
            $photo_interior_center = $request->file('photo_interior_center')->store('product/'.$old['code'], 'public');
        } else { 
            $photo_interior_center = $old['photo_interior_center'];
        }

        if($request->file('photo_interior_behind')) {
            if(File::exists(storage_path('app/public/'.$old['photo_interior_behind']))) File::delete(storage_path('app/public/'.$old['photo_interior_behind']));
            $photo_interior_behind = $request->file('photo_interior_behind')->store('product/'.$old['code'], 'public');
        } else { 
            $photo_interior_behind = $old['photo_interior_behind'];
        }
        
        $result = Product::where('id',$param['id'])->update([
            'photo_exterior_front' => $photo_exterior_front,
            'photo_exterior_back' => $photo_exterior_back,
            'photo_exterior_left' => $photo_exterior_left,
            'photo_exterior_right' => $photo_exterior_right,
            'photo_interior_front' => $photo_interior_front,
            'photo_interior_center' => $photo_interior_center,
            'photo_interior_behind' => $photo_interior_behind
        ]);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data', 'product_id' => $param['id']], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data', 'product_id' => null], 400); 
            
    }

    public function publish(Request $request)
    {
        if (Gate::denies('isSeller')) return response(['status' => false, 'message' => 'Selain seller tidak dapat mengakses'], 400);
        
        $valid = validator($request->all(), [
            'id' => 'required'
        ]);
        if ($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        
        $result = Product::where('id', request()->only('id'))->update(['status' => 'Active']);
        if($result)
            return response(['status' => true, 'message' => 'Berhasil Menyimpan Data'], 200);
        else
            return response(['status' => false, 'message' => 'Gagal Menyimpan Data'], 400);
    }

    public function generate_code($length = 6){
		do {
			$random_str = Str::random($length);;
			$otp_count = Product::where('code', $random_str)->count();
		} while($otp_count !== FALSE && $otp_count > 0);
		return $random_str;
    }
}
