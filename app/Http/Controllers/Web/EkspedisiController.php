<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Ekspedisi;
use Illuminate\Support\Facades\Auth;

class EkspedisiController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('ekspedisi')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('ekspedisi')
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
            $view = view('web.admin.ekspedisi.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.ekspedisi.list', $data);
    }

    public function add()
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        return view('web.admin.ekspedisi.add');
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $valid = validator($request->only('name'), [
            'name' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        DB::beginTransaction();
        $insert = Ekspedisi::create([
            'name' => $request->name
        ]);
        if ($insert){
            DB::commit();
            return redirect('ekspedisi-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function edit($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $ekspedisi = Ekspedisi::find($id);
        if (is_null($ekspedisi)){
            return redirect('ekspedisi-list')->with('danger','Something Wrong, data not found.');
        }
        $data = ['ekspedisi' => $ekspedisi];
        return view('web.admin.ekspedisi.edit', $data);
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $valid = validator($request->only('name'), [
            'name' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        DB::beginTransaction();
        $update = Ekspedisi::where('id', $id)->update([
            'name' => $request->name
        ]);
        if ($update){
            DB::commit();
            return redirect('ekspedisi-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function delete($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $data = Ekspedisi::find($id);
        if (is_null($data)){
            return redirect('ekspedisi-list')->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('ekspedisi-list')->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('ekspedisi-list')->with('success','Data has been deleted.');
        }
    }
}