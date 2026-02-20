<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\RefBrand;
use Illuminate\Support\Facades\Auth;

class RefBrandController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('ref_brand')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('ref_brand')
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
            $view = view('web.admin.ref_brand.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.ref_brand.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('ref_brand')
                    ->select('id', 'name AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        return view('web.admin.ref_brand.add');
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('name', 'factory'), [
            'name' => 'required',
            'factory' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'factory');
        
        DB::beginTransaction();
        $insert = RefBrand::create([
            'name' => $data['name'],
            'factory' => $data['factory']
        ]);
        if ($insert){
            DB::commit();
            return redirect('brand-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $data = RefBrand::where(['id' => $id])->first();
        return view('web.admin.ref_brand.detail', $data);
    }

    public function edit($id)
    {
        $data = RefBrand::where(['id' => $id])->first();
        return view('web.admin.ref_brand.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'factory'), [
            'name' => 'required',
            'factory' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'factory');
        DB::beginTransaction();
        $update = RefBrand::where('id', $id)->update([
            'name' => $data['name'],
            'factory' => $data['factory'],
        ]);
        if ($update){
            DB::commit();
            return redirect('brand-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        $data = RefBrand::find($id);
        if (is_null($data)){
            return redirect('brand-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('brand-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('brand-list')->with('success','Data has been deleted.');
        }
    }
}
