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
use App\Models\Visitation;
use App\Models\ProductParent;
use App\Models\ProductHpp;
use App\Models\RefSatuan;
use App\Models\RefProductType;
use App\Models\ProductPaymentType;
use Barryvdh\DomPDF\Facade\Pdf;
//use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductController extends Controller
{
    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('product AS p')
                    ->leftJoin('ref_product_type AS pt', 'pt.id', '=', 'p.type')
                    ->select('p.id AS id')
                    ->selectRaw('CONCAT(pt.name, " - ", p.name, " (", stock, " Pcs)") AS text')
                    ->whereRaw('1 = 1')
                    ->where('p.status', 'Active')
                    ->where(function($contents) use ($keyword){
                        $contents->where('p.name', 'like', '%'.$keyword.'%')
                            ->orWhere('pt.name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('pt.name', 'DESC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function combogb(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('product AS p')
                    ->leftJoin('ref_product_type AS pt', 'pt.id', '=', 'p.type')
                    ->select('p.id AS id')
                    ->selectRaw('CONCAT(pt.name, " - ", p.name, " (", stock, " Pcs)") AS text')
                    ->whereRaw('1 = 1')
                    ->where(['p.status' => 'Active', 'p.type' => 1])
                    ->where(function($contents) use ($keyword){
                        $contents->where('p.name', 'like', '%'.$keyword.'%')
                            ->orWhere('pt.name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('pt.name', 'DESC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function pricegb(){
        $stok_gb = DB::table('product as p')
                    ->select(
                            'p.id as id',
                            'p.name_pl as name',
                            'p.origin',
                            'p.elevation',
                            'p.varietal',
                            'p.process',
                            'p.processor',
                            'p.harvest',
                            'p.desc',
                            'p.price as price',
                            'p.price_grosir15 as price_grosir15',
                            'p.price_grosir50 as price_grosir50',
                            'p.is_new as is_new',
                            'p.stock as stock',
                            'p.photo_thumbnail as photo'
                            )
                    ->where([
                        'p.type' => '1',
                        'p.status' => 'Active',
                        'p.is_pricelist' => 'true'
                    ])
                    ->orderBy('order_pricelist', 'ASC')
                    ->get();
        
        foreach ($stok_gb as $key => $value) {
            $value->is_new = ($value->is_new == 'true') ? 'New' : '';
            
            $value->stock_lable = ($value->stock > 0) ? 'Ready' : 'Sold';
            $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
            $value->stock_color = ($value->stock > 0) ? 'info' : 'danger';
        }
        $data = ['stok_gb' => $stok_gb];
        return view('core.gb_pricelist', $data);
    }

    public function priceroasted(){
        $stok_filter = DB::table('product as p')
                    ->select(
                            'p.id as id',
                            'p.name_pl as name',
                            'p.origin',
                            'p.elevation',
                            'p.varietal',
                            'p.process',
                            'p.processor',
                            'p.harvest',
                            'p.desc',
                            'p.price as price',
                            'p.price_grosir15 as price_grosir15',
                            'p.price_grosir50 as price_grosir50',
                            'p.is_new as is_new',
                            'p.stock as stock',
                            'p.photo_thumbnail as photo'
                            )
                    ->where([
                        'p.type' => '2',
                        'p.status' => 'Active',
                        'p.is_pricelist' => 'true'
                    ])
                    ->orderBy('order_pricelist', 'ASC')
                    ->get();
        
        foreach ($stok_filter as $key => $value) {
            $value->is_new = ($value->is_new == 'true') ? 'New' : '';
            $value->stock_lable = ($value->stock > 0) ? 'Ready' : 'Sold Out';
            $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
            $value->stock_color = ($value->stock > 0) ? 'success' : 'danger';
        }

        $stok_spro = DB::table('product as p')
                    ->select(
                            'p.id as id',
                            'p.name_pl as name',
                            'p.category as category',
                            'p.origin',
                            'p.elevation',
                            'p.varietal',
                            'p.process',
                            'p.processor',
                            'p.harvest',
                            'p.desc',
                            'p.price as price',
                            'p.price_grosir15 as price_grosir15',
                            'p.price_grosir50 as price_grosir50',
                            'p.is_new as is_new',
                            'p.stock as stock',
                            'p.photo_thumbnail as photo'
                            )
                    ->where([
                        'p.type' => '3',
                        'p.status' => 'Active',
                        'p.is_pricelist' => 'true'
                    ])
                    ->orderBy('order_pricelist', 'ASC')
                    ->get();
        foreach ($stok_spro as $key => $value) {
            $value->is_new = ($value->is_new == 'true') ? 'New' : '';
            $value->stock_lable = ($value->stock > 0) ? 'Ready' : 'Pre Order';
            $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-thumbs-up';
            $value->stock_color = ($value->stock > 0) ? 'success' : 'warning';
        }

        $data = [
            'stok_filter' => $stok_filter,
            'stok_spro' => $stok_spro
        ];
        return view('core.roasted_pricelist', $data);
    }

    public function detail_json(Request $request){
        $contents = DB::table('product')
                    ->select('id', 'name', 'price', 'stock', 'origin', 'process', 'varietal', 'elevation')
                    ->where(['id' => $request->id])
                    ->first();
        return response()->json($contents);
    }

    public function search()
    {
        $data = [];
        return view('web.admin.product.search', $data);
    }

    public function search_result(Request $request)
    {
        $data = $request['keyword'] ?? '';
        $request->session()->put('search_result', $data);
        return redirect('product-list');
    }

    public function list(Request $request)
    {
        if(isset($_GET['clear'])) $request->session()->forget('search_result');
        $seller = $this->seller_info();
        $limit = 10;
        $search = session('search_result') ?? "";
        $contents = DB::table('product AS p')
                ->leftJoin('ref_product_type AS pt', 'pt.id', '=', 'p.type')
                ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
                ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
                ->select('p.id AS id_produk',
                        'pt.name AS type',
                        'p.name AS judul',
                        'p.price AS price',
                        'p.stock AS stock',
                        'p.photo_thumbnail AS thumbnail',
                        'ua.name AS author', 
                        'p.is_recomended',
                        'p.is_sold_out',
                        'p.status',
                        'p.created_at AS created_date')
                ->whereRaw('1 = 1')
                ->where(function($query) use ($search){
                    $query->where('p.name', 'like', '%'.$search.'%')
                        ->orWhere('pt.name', 'like', '%'.$search.'%');
                })
                ->orderBy('p.is_recomended', 'ASC')
                ->orderBy('p.id', 'DESC')
                ->paginate($limit);

        $counts = DB::table('product AS p')
                    ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
                    ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
                    ->whereRaw('1 = 1')
                    ->where(function($query) use ($search){
                        $query->where('p.name', 'like', '%'.$search.'%')
                            ->orWhere('p.code', 'like', '%'.$search.'%');
                    })
                    ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->created_date = date('d M Y', strtotime($value->created_date));
                $value->price = $this->format_angka($value->price);
                $value->published = $value->status == 'Active' ? 'Aktif' : 'Tidak Aktif';
                $value->published_style = $value->status == 'Active' ? 'badge-success' : 'badge-secondary';
                $value->recomended = $value->is_recomended == 'true' ? '<i class="fa fa-star fs-18 text-warning"></i>' : '';
            }
        }

        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts,
            'account_status' => 1
        ];
        if($request->ajax()){
            $view = view('web.admin.product.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.product.list', $data);
    }

    public function detail($id)
    {
        $detail = DB::table('product AS p')
            ->leftJoin('ref_product_type AS pt', 'pt.id', '=', 'p.type')
            ->leftJoin('product_group AS pg', 'pg.id', '=', 'p.group')
            ->leftJoin('ref_satuan AS rs', 'rs.id', '=', 'p.satuan')
            ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
            ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
            ->select('p.*',
                    'p.id AS id_produk',
                    'pt.name AS product_type',
                    'ua.name AS author', 
                    'pg.name AS product_parent',
                    'rs.name AS product_satuan',
                    'p.is_recomended',
                    'p.created_at AS created_date')
            ->where(['p.id' => $id])
            ->first();
        $profit = $detail->price - $detail->price_hpp;
        $profit15 = !empty($detail->price_grosir15) ? $detail->price_grosir15 - $detail->price_hpp : "";
        $profit50 = !empty($detail->price_grosir50) ? $detail->price_grosir50 - $detail->price_hpp : "";
        $information = [
            'kategori' => $detail->product_type,
            'product_parent' => $detail->product_parent,
            'nama' => $detail->name,
            'satuan' => $detail->product_satuan,
            'harga' => $this->format_angka($detail->price),
            'harga15' => !empty($detail->price_grosir15) ? $this->format_angka($detail->price_grosir15) : "",
            'harga50' => !empty($detail->price_grosir50) ? $this->format_angka($detail->price_grosir50) : "",
            'hpp' => $this->format_angka($detail->price_hpp),
            'profit' => $this->format_angka($profit),
            'profit15' => !empty($detail->price_grosir15) ? $this->format_angka($profit15) : "",
            'profit50' => !empty($detail->price_grosir50) ?$this->format_angka($profit50) : "",
            'code' => strtoupper($detail->code),
            'stock' => $detail->stock,
            'origin' => $detail->origin,
            'process' => $detail->process,
            'varietal' => $detail->varietal,
            'deskripsi' => $detail->summary,
            'status' => $detail->status,
            'published' => $detail->status == 'Active' ? 'Aktif' : 'Draft',
            'is_recomended' => $detail->is_recomended,
            'is_sold_out' => $detail->is_sold_out,
        ];
        // $qrCode = QrCode::size(150)->generate(strtoupper($detail->code));
        // $result['qrcode'] = $qrCode;
        $result['id_produk'] = $detail->id_produk;
        $result['info'] = $information;
        return view('web.admin.product.detail', $result);
    }

    public function add()
    {
        $data = [
            'parent_list' => ProductParent::where('status', 'Aktif')->get(),
            'satuan_list' => RefSatuan::all(),
            'type_list' => RefProductType::all()
        ];
        return view('web.admin.product.add', $data);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $valid = validator($data, [
            'name' => 'required|string|max:255',
            'product_parent' => 'required',
            'satuan' => 'required',
            'type' => 'required',
            'price_hpp' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'status' => 'required',
        ]);
        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        DB::beginTransaction();
        $insert = Product::create([
            'code' => strtolower($this->generate_code(8)),
            'name' => $data['name'],
            'group' => $data['product_parent'],
            'satuan' => $data['satuan'],
            'type' => $data['type'],
            'price_hpp' => preg_replace('/[^0-9]/', '', $data['price_hpp']),
            'price' => preg_replace('/[^0-9]/', '', $data['price']),
            'price_grosir15' => !empty($data['price_grosir15']) ? preg_replace('/[^0-9]/', '', $data['price_grosir15']) : "",
            'price_grosir50' => !empty($data['price_grosir50']) ? preg_replace('/[^0-9]/', '', $data['price_grosir50']) : "",
            'stock' => $data['stock'],
            'summary' => $data['summary'],
            'status' => $data['status'],
            'category' => $data['category'],
            'origin' => $data['origin'],
            'elevation' => $data['elevation'],
            'varietal' => $data['varietal'],
            'process' => $data['process'],
            'processor' => $data['processor'],
            'harvest' => $data['harvest'],
            'author' => Auth::user()->id,
            'editor' => Auth::user()->id,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        if ($insert){
            DB::commit();
            return redirect('product-list')->with('success','Informasi Produk Berhasil Disimpan');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Menyimpan Data');
        }
    }

    public function add_photo($id){
        $data = ['id' => $id];
        return view('web.admin.product.add-photo', $data);
    }

    public function add_photo_interior($id){
        $data = ['id' => $id];
        return view('web.admin.product.add-photo-interior', $data);
    }

    public function add_sales($id){
        $data = ['id' => $id];
        return view('web.admin.product.add-sales', $data);
    }

    public function create_sales(Request $request, $id){
        $input = $request->all();
        $valid = validator($request->all(), [
            'price' => 'required',
            'sales_commission' => 'required',
        ]);
        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        $result = Product::where('id', $id)->update([
            'price' => preg_replace('/[^0-9]/', '', $input['price']),
            'sales_commission' => preg_replace('/[^0-9]/', '', $input['sales_commission'])
        ]);
        if($result){
            $exist = ProductPaymentType::where('product', $id)->count();
            if($exist > 0) ProductPaymentType::where('product', $id)->delete();
            foreach($input['payment_type'] AS $value){
                ProductPaymentType::create([
                    'product' => $id,
                    'type' => $value,
                    'author' => Auth::user()->id
                ]);
            }
            $result = true;
        }
        if ($result){
            DB::commit();
            return redirect('product-list')->with('success','Data Berhasil Disimpan');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Menyimpan Data');
        }
    }

    public function edit_category($id){
        $detail = DB::table('product AS p')
            ->leftJoin('ref_color AS cl', 'cl.id', '=', 'p.color')
            ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'p.brand')
            ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'p.type')
            ->leftJoin('ref_variant AS rv', 'rv.id', '=', 'p.variant')
            ->leftJoin('ref_vehicles_code AS rvc', 'rvc.id', '=', 'p.vehicles_code')
            ->leftJoin('ref_machine_capacity AS mc', 'mc.id', '=', 'p.machine_capacity')
            ->leftJoin('ref_mileage AS mg', 'mg.id', '=', 'p.mileage')
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
                    'p.is_recomended',
                    'p.created_at AS created_date')
            ->where(['p.author' => Auth::user()->id, 'p.id' => $id])
            ->first();
        
        $check_product_trans = Visitation::where(['product' => $detail->id_produk])->count();
        $data = [
            'id' => $id,
            'name'=>$detail->name,
            'is_sold_out'=>$detail->is_sold_out,
            'in_trans' => $check_product_trans > 0 ? 'true' : 'false'
        ];
        return view('web.admin.product.edit-category', $data);
    }

    public function edit($id)
    {
        $data = [
            'id' => $id
        ];
        $data['detail'] = DB::table('product AS p')
                        ->leftJoin('product_group AS pg', 'pg.id', '=', 'p.group')
                        ->leftJoin('users AS ua', 'p.author', '=', 'ua.id')
                        ->leftJoin('users AS ue', 'p.editor', '=', 'ue.id')
                        ->select('p.*',
                                'p.id AS id_produk',
                                'pg.name AS product_parent',
                                'ua.name AS author', 
                                'p.is_recomended',
                                'p.created_at AS created_date')
                        ->where(['p.id' => $id])
                        ->first();
        $data['parent_list'] = ProductParent::where('status', 'Aktif')->get();
        $data['satuan_list'] = RefSatuan::all();
        $data['type_list'] = RefProductType::all();
        
        return view('web.admin.product.edit', $data);
    }

    public function edit_photo($id){
        $detail = DB::table('product AS p')
            ->select('p.*')
            ->where(['p.author' => Auth::user()->id, 'p.id' => $id])
            ->first();
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
        $data = [
            'id' => $id,
            'detail' => $detail
        ];
        return view('web.admin.product.edit-photo', $data);
    }

    public function edit_photo_interior($id){
        $detail = DB::table('product AS p')
            ->select('p.*')
            ->where(['p.author' => Auth::user()->id, 'p.id' => $id])
            ->first();
        
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
            
        $data = [
            'id' => $id,
            'detail' => $detail
        ];
        return view('web.admin.product.edit-photo-interior', $data);
    }

    public function edit_sales($id){
        $detail = DB::table('product AS p')
            ->select('p.*')
            ->where(['p.author' => Auth::user()->id, 'p.id' => $id])
            ->first();
        $payment = ProductPaymentType::where('product', $id)->get();
        $checked_cash = '';
        $checked_credit = '';
        foreach ( $payment as $el ) {
            if ($el->type == 'cash' ) $checked_cash = 'checked';
            if ($el->type == 'credit' )  $checked_credit = 'checked';
        }
        
        $data = [
            'id' => $id,
            'detail' => $detail,
            'payment_cash' => $checked_cash,
            'payment_credit' => $checked_credit
        ];
        return view('web.admin.product.edit-sales', $data);
    }

    public function update(Request $request, $id){
        $seller = $this->seller_info();
        $data = $request->all();
        $valid = validator($data, [
            'name' => 'required|string|max:255',
            'name_pl' => 'required|string|max:255',
            'product_parent' => 'required',
            'type' => 'required',
            'satuan' => 'required',
            'price_hpp' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'status' => 'required'
        ]);
        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        DB::beginTransaction();
        $update = Product::where(['id' => $id])->update([
            'name' => $data['name'],
            'name_pl' => $data['name_pl'],
            'group' => $data['product_parent'],
            'type' => $data['type'],
            'satuan' => $data['satuan'],
            'price_hpp' => preg_replace('/[^0-9]/', '', $data['price_hpp']),
            'price' => preg_replace('/[^0-9]/', '', $data['price']),
            'price_grosir15' => !empty($data['price_grosir15']) ? preg_replace('/[^0-9]/', '', $data['price_grosir15']) : "",
            'price_grosir50' => !empty($data['price_grosir50']) ? preg_replace('/[^0-9]/', '', $data['price_grosir50']) : "",
            'stock' => $data['stock'],
            'summary' => $data['summary'],
            'desc' => $data['desc'],
            'photo_thumbnail' => $data['photo_thumbnail'],
            'status' => $data['status'],
            'is_pricelist' => $data['is_pricelist'],
            'is_new' => $data['is_new'],
            'category' => $data['category'],
            'origin' => $data['origin'],
            'elevation' => $data['elevation'],
            'varietal' => $data['varietal'],
            'process' => $data['process'],
            'processor' => $data['processor'],
            'harvest' => $data['harvest'],
            'editor' => Auth::user()->id,
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        if ($update){
            DB::commit();
            return redirect('product-list')->with('success','Informasi Kendaraan Berhasil Disimpan');
            //return redirect('product-detail/'.$id)->with('success','Informasi Kendaraan Berhasil Disimpan');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal mengubah data');
        }
    }

    public function update_sales(Request $request, $id){
        $input = $request->all();
        $valid = validator($request->all(), [
            'price' => 'required',
            'sales_commission' => 'required',
            'payment_type' => 'required'
        ]);
        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        $result = Product::where('id', $id)->update([
            'price' => preg_replace('/[^0-9]/', '', $input['price']),
            'sales_commission' => preg_replace('/[^0-9]/', '', $input['sales_commission'])
        ]);
        if($result){
            $exist = ProductPaymentType::where('product', $id)->count();
            if($exist > 0) ProductPaymentType::where('product', $id)->delete();
            if(!empty($input['payment_type'])){
                foreach($input['payment_type'] AS $value){
                    ProductPaymentType::create([
                        'product' => $id,
                        'type' => $value,
                        'author' => Auth::user()->id
                    ]);
                }
            }
            $result = true;
        }
        if ($result){
            DB::commit();
            return redirect('product-edit-category/'.$id)->with('success','Data Berhasil Disimpan');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Menyimpan Data');
        }
    }

    public function hpp($id)
    {
        $data = ['id' => $id];
        $data['product'] = $detail = DB::table('product AS p')
                        ->leftJoin('ref_product_type AS pt', 'pt.id', '=', 'p.type')
                        ->leftJoin('ref_satuan AS rs', 'rs.id', '=', 'p.satuan')
                        ->select('p.*', 'pt.name AS tipe', 'rs.name AS satuan')
                        ->where(['p.id' => $id])
                        ->first();

        $hpp = DB::table('product_hpp AS ph')
                        ->select('*')
                        ->where(['ph.prod_id' => $id])
                        ->first();
        $data['nama_gb_1'] = !empty($hpp) ? $hpp->nama_gb_1 : ""; 
        $data['nama_gb_2'] = !empty($hpp) ? $hpp->nama_gb_2 : ""; 
        $data['harga_gb_1'] = !empty($hpp) ? $hpp->harga_gb_1 : "0"; 
        $data['harga_gb_2'] = !empty($hpp) ? $hpp->harga_gb_2 : "0";
        $data['cargo_1'] = !empty($hpp) ? $hpp->cargo_1 : "0"; 
        $data['cargo_2'] = !empty($hpp) ? $hpp->cargo_2 : "0";
        $data['roasting_1'] = !empty($hpp) ? $hpp->roasting_1 : "0";
        $data['roasting_2'] = !empty($hpp) ? $hpp->roasting_2 : "0";
        $data['loss_1'] = !empty($hpp) ? $hpp->loss_1 : "0";  
        $data['loss_2'] = !empty($hpp) ? $hpp->loss_2 : "0";  
        $data['ratio_1'] = !empty($hpp) ? $hpp->ratio_1 : "100";  
        $data['ratio_2'] = !empty($hpp) ? $hpp->ratio_2 : "0";  
        $data['netto'] = !empty($hpp) ? $hpp->netto : "0";  
        $data['pack'] = !empty($hpp) ? $hpp->pack : "0";  
        $data['box'] = !empty($hpp) ? $hpp->box : "0";  
        
        return view('web.admin.product.hpp', $data);
    }

    public function stock($id)
    {
        $data = ['id' => $id];
        $data['product'] = $detail = DB::table('product AS p')
                        ->leftJoin('ref_product_type AS pt', 'pt.id', '=', 'p.type')
                        ->leftJoin('ref_satuan AS rs', 'rs.id', '=', 'p.satuan')
                        ->select('p.*', 'pt.name AS tipe', 'rs.name AS satuan')
                        ->where(['p.id' => $id])
                        ->first();
        
        return view('web.admin.product.stock', $data);
    }

    public function update_hpp(Request $request, $id){
        $data = $request->all();
        $valid = validator($data, [
            'nama_gb_1' => 'required|string|max:255',
            'harga_gb_1' => 'required',
            'loss_1' => 'required',
            'ratio_1' => 'required',
            'netto' => 'required',
            'pack' => 'required',
            'hpp_total' => 'required'
        ]);
        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        DB::beginTransaction();
        $set_hpp = ProductHpp::updateOrCreate(
            ['prod_id' => $id], // kondisi pencarian (misalnya berdasarkan ID)
            [
                'nama_gb_1' => $request->nama_gb_1,
                'nama_gb_2' => $request->nama_gb_2,
                'harga_gb_1' => preg_replace('/[^0-9]/', '', $request->harga_gb_1),
                'harga_gb_2' => preg_replace('/[^0-9]/', '', $request->harga_gb_2),
                'cargo_1' => preg_replace('/[^0-9]/', '', $request->cargo_1),
                'cargo_2' => preg_replace('/[^0-9]/', '', $request->cargo_2),
                'roasting_1' => preg_replace('/[^0-9]/', '', $request->roasting_1),
                'roasting_2' => preg_replace('/[^0-9]/', '', $request->roasting_2),
                'loss_1' => preg_replace('/[^0-9]/', '', $request->loss_1),
                'loss_2' => preg_replace('/[^0-9]/', '', $request->loss_2),
                'ratio_1' => preg_replace('/[^0-9]/', '', $request->ratio_1),
                'ratio_2' => preg_replace('/[^0-9]/', '', $request->ratio_2),
                'netto' => preg_replace('/[^0-9]/', '', $request->netto),
                'pack' => preg_replace('/[^0-9]/', '', $request->pack),
                'box' => preg_replace('/[^0-9]/', '', $request->box),
                'hpp_total' => preg_replace('/[^0-9]/', '', $request->hpp_total),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]
        );
        $update = $set_hpp && Product::where(['id' => $id])->update(['price_hpp' => preg_replace('/[^0-9]/', '', $request->hpp_total)]);
        if ($update){
            DB::commit();
            return redirect('product-edit/'.$id)
                    ->with('success','Pengaturan HPP Berhasil Disimpan')
                    ->with('focus_hpp', 'price_hpp');
        }else{
            DB::rollback();
            return redirect('product-edit/'.$id)->with('danger', 'Gagal mengubah data')
                    ->with('focus_hpp', 'price_hpp');
        }
    }

    public function update_stock(Request $request, $id){
        $data = $request->all();
        $valid = validator($data, [
            'stock' => 'required'
        ]);
        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        DB::beginTransaction();
        $update = Product::where(['id' => $id])->update(['stock' => $request->stock]);
        if ($update){
            DB::commit();
            return redirect('product-detail/'.$id)
                    ->with('success','Update Stok Berhasil Disimpan');
        }else{
            DB::rollback();
            return redirect('product-detail/'.$id)->with('danger', 'Gagal mengubah data');
        }
    }

    public function publish($id)
    {
        $seller = $this->seller_info();
        $data = Product::find($id);
        if (is_null($data)) return redirect('product-detail/'.$id)->with('danger','Data tidak ditemukan');
        DB::beginTransaction();
        $update = Product::where(['id' => $id, 'seller_id' => $seller->id])->update(['status' => 'Active']);
        if ($update){
            DB::commit();
            return redirect('product-detail/'.$id)->with('success','Berhasil publikasi data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal publikasi data');
        }
        
    }

    public function choosed($id)
    {
        $data = Product::find($id);

        if (is_null($data)){
            return redirect('product-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }
        DB::beginTransaction();
        $update = Product::where(['id' => $id])->update(['is_recomended' => ($data->is_recomended == 'false') ? 'true' : 'false']);
        if ($update){
            DB::commit();
            return redirect('product-detail/'.$id)->with('success','Berhasil Memperbarui data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal perubahan data');
        }
    }

    public function print($id)
    {
        $detail = DB::table('product AS p')
            ->leftJoin('ref_product_type AS pt', 'pt.id', '=', 'p.type')
            ->leftJoin('product_group AS pg', 'pg.id', '=', 'p.group')
            ->leftJoin('ref_satuan AS rs', 'rs.id', '=', 'p.satuan')
            ->select('p.*',
                    'p.id AS id_produk',
                    'pt.name AS product_type',
                    'pg.name AS product_parent',
                    'rs.name AS product_satuan',
                    'p.is_recomended',
                    'p.created_at AS created_date')
            ->where(['p.id' => $id])
            ->first();
            
        $data = ['detail' => $detail];
        
        $pdf = Pdf::loadView('web.admin.product.print', $data);
        $pdf->set_paper('A6', 'potrait');
        return $pdf->stream(strtoupper(str_replace(" ", "-", $detail->name)).'-'.strtoupper($detail->code).'.pdf', array("Attachment" => false));
        
        //return view('web.admin.product.print', $data);
    }

    public function delete($id)
    {
        $data = Product::find($id);
        if (is_null($data)){
            return redirect('product-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('product-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('product-list')->with('success','Data has been deleted.');
        }
    }

    public function generate_code($length = 6){
		do {
			$random_str = Str::random($length);
			$count = Product::where('code', $random_str)->count();
		} while($count !== FALSE && $count > 0);
		return $random_str;
    }
}
