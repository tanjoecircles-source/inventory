<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductParent;

class ProductParentController extends Controller
{
    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('product_group')
                    ->select('id')
                    ->selectRaw('CONCAT(type, " - ", name) AS text')
                    ->whereRaw('1 = 1')
                    ->where('status', 'Aktif')
                    ->where('type', 'Green')
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function comboall(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('product_group')
                    ->select('id')
                    ->selectRaw('CONCAT(type, " - ", name) AS text')
                    ->whereRaw('1 = 1')
                    ->where('status', 'Aktif')
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
        $contents = DB::table('product_group')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('product_group')
                ->where(function($contents) use ($search){
                    $contents->where('name', 'like', '%'.$search.'%');
                })
                ->orderBy('id', 'DESC')
                ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->created_at = date('d M Y', strtotime($value->created_at));
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.product_parent.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.product_parent.list', $data);
    }

    public function add()
    {
        $data = ['param_url' => (isset($_GET['purchasing'])) ? $_GET['purchasing']:''];
        return view('web.admin.product_parent.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('name', 'type', 'status'), [
            'name' => 'required',
            'type' => 'required',
            'status' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        
        $data = $request->only('name', 'type', 'status');
        DB::beginTransaction();
        $insert = ProductParent::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'status' => $data['status']
        ]);
        if ($insert){
            DB::commit();
            return redirect('product-parent-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $data = ProductParent::where(['id' => $id])->first();
        return view('web.admin.product_parent.detail', $data);
    }

    public function edit($id)
    {
        $data = ProductParent::where(['id' => $id])->first();
        return view('web.admin.product_parent.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'type', 'status'), [
            'name' => 'required',
            'type' => 'required',
            'status' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'type', 'status');
        DB::beginTransaction();
        $update = ProductParent::where('id', $id)->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'status' => $data['status'],
        ]);
        if ($update){
            DB::commit();
            return redirect('product-parent-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        $data = ProductParent::find($id);
        if (is_null($data)){
            return redirect('product-parent-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('product-parent-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('product-parent-list')->with('success','Data has been deleted.');
        }
    }
}
