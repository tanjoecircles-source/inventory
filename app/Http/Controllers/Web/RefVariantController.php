<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\RefVariant;
use App\Models\ProductType;
use Illuminate\Support\Facades\Auth;

class RefVariantController extends Controller
{
    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('ref_variant')
                    ->select('id', 'name AS text')
                    ->whereRaw('1 = 1')
                    ->where('product_type', $data['parent'])
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
        $contents = DB::table('ref_variant AS rv')
                    ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'rv.product_type')
                    ->select('rv.id AS rv_id', 'rv.name AS rv_name', 'rpt.name AS rpt_name', 'rv.created_at AS created_date')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('rv.name', 'like', '%'.$search.'%')
                                ->orWhere('rpt.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('rv.id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('ref_variant AS rv')
                ->leftJoin('ref_product_type AS rpt', 'rpt.id', '=', 'rv.product_type')
                ->where(function($contents) use ($search){
                    $contents->where('rv.name', 'like', '%'.$search.'%')
                            ->orwhere('rpt.name', 'like', '%'.$search.'%');
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
            $view = view('web.admin.ref_variant.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.ref_variant.list', $data);
    }

    public function add()
    {
        $data['product_type_list'] = ProductType::all();
        return view('web.admin.ref_variant.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('name', 'product_type'), [
            'product_type' => 'required',
            'name' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'product_type');

        DB::beginTransaction();
        $exist= RefVariant::where(['product_type' => $data['product_type'], 'name' => $data['name']])->count();
        if($exist>0) return redirect('variant-list')->with('danger', 'Gagal menyimpan, Data Sudah ada');
        $insert = RefVariant::create([
            'name' => $data['name'],
            'product_type' => $data['product_type']
        ]);
        if ($insert){
            DB::commit();
            return redirect('variant-list')->with('success', 'Berhasil menyimpan data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal menyimpan data');
        }
    }

    public function detail($id)
    {
        $data['detail'] = DB::table('ref_variant as rv')
                ->leftJoin('ref_product_type as pt','pt.id','=','rv.product_type')
                ->leftJoin('ref_brand as rb','rb.id','=','pt.brand')
                ->select('rv.*','rb.name as brand','pt.name as product_type')
                ->where('rv.id', $id)
                ->first();
        return view('web.admin.ref_variant.detail', $data);
    }

    public function edit($id)
    {
        $data = RefVariant::where(['id' => $id])->first();
        $data['product_type_list'] = ProductType::all();
        return view('web.admin.ref_variant.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'product_type'), [
            'name' => 'required',
            'product_type' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'product_type');
        DB::beginTransaction();
        $update = RefVariant::where('id', $id)->update([
            'name' => $data['name'],
            'product_type' => $data['product_type'],
        ]);
        if ($update){
            DB::commit();
            return redirect('variant-list')->with('success', 'Berhasil menyimpan data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal menyimpan data');
        }
    }

    public function delete($id)
    {
        $data = RefVariant::find($id);
        if (is_null($data)){
            return redirect('variant-detail/'.$id)->with('danger','Data tidak ditemukan');
        }elseif (!$data->delete()){
            return redirect('variant-detail/'.$id)->with('danger','Gagal menghapus data');
        }else{
            return redirect('variant-list')->with('success','Berhasil menghapus data');
        }
    }
}
