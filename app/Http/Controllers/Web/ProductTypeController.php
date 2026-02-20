<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\ProductType;
use App\Models\RefBrand;
use Illuminate\Support\Facades\Auth;

class ProductTypeController extends Controller
{
    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('ref_product_type')
                    ->select('id', 'name AS text')
                    ->whereRaw('1 = 1')
                    ->where('brand', $data['parent'])
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('ref_product_type AS rpt')
                    ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'rpt.brand')
                    ->select('rpt.id AS rpt_id', 'rpt.name AS rpt_name', 'rb.name AS rb_name', 'rpt.created_at AS created_date')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('rpt.name', 'like', '%'.$search.'%')
                                ->orWhere('rb.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('rpt.id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('ref_product_type AS rpt')
                ->leftJoin('ref_brand AS rb', 'rb.id', '=', 'rpt.brand')
                ->where(function($contents) use ($search){
                    $contents->where('rpt.name', 'like', '%'.$search.'%')
                            ->orwhere('rb.name', 'like', '%'.$search.'%');
                })
                ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->created_date = date('d M Y', strtotime($value->created_date));
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.ref_product_type.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.ref_product_type.list', $data);
    }

    public function add()
    {
        $data['brand_list'] = RefBrand::all(); 
        return view('web.admin.ref_product_type.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('name', 'brand'), [
            'name' => 'required',
            'brand' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'brand');
        
        DB::beginTransaction();
        $exist= ProductType::where(['brand' => $data['brand'], 'name' => $data['name']])->count();
        if($exist>0) return redirect('product-type-list')->with('danger', 'Gagal menyimpan, Data Sudah ada');
        $insert = ProductType::create([
            'name' => $data['name'],
            'brand' => $data['brand']
        ]);
        if ($insert){
            DB::commit();
            return redirect('product-type-list')->with('success', 'Berhasil menyimpan data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal menyimpan data');
        }
    }

    public function detail($id)
    {
        $data['detail'] = DB::table('ref_product_type as pt')
                ->leftJoin('ref_brand as rb','rb.id','=','pt.brand')
                ->select('pt.*','rb.name as brand')
                ->where('pt.id', $id)
                ->first();
        return view('web.admin.ref_product_type.detail', $data);
    }

    public function edit($id)
    {
        $data = ProductType::where(['id' => $id])->first();
        $data['brand_list'] = RefBrand::all();
        return view('web.admin.ref_product_type.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'brand'), [
            'name' => 'required',
            'brand' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'brand');
        DB::beginTransaction();
        $update = ProductType::where('id', $id)->update([
            'name' => $data['name'],
            'brand' => $data['brand'],
        ]);
        if ($update){
            DB::commit();
            return redirect('product-type-list')->with('success', 'Berhasil menyimpan data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal menyimpan data');
        }
    }
    
    public function delete($id)
    {
        $data = ProductType::find($id);
        if (is_null($data)){
            return redirect('product-type-detail/'.$id)->with('danger','Data tidak ditemukan');
        }elseif (!$data->delete()){
            return redirect('product-type-detail/'.$id)->with('danger','Gagal menghapus data');
        }else{
            return redirect('product-type-list')->with('success','Berhasil menghapus data');
        }
    }
}
