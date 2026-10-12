<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;

class PeriodeController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('periode')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('periode')
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
            $view = view('web.admin.periode.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.periode.list', $data);
    }

    public function combo(Request $request){
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('periode')
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
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $data = ['param_url' => (isset($_GET['purchasing'])) ? $_GET['purchasing']:''];
        return view('web.admin.periode.add', $data);
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $valid = validator($request->only('name', 'start_date', 'end_date'), [
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'start_date', 'end_date', 'param_url');
        DB::beginTransaction();
        $insert = Periode::create([
            'name' => $data['name'],
            'start_date' => date('Y-m-d', strtotime(str_replace('/', '-', $data['start_date']))),
            'end_date' => date('Y-m-d', strtotime(str_replace('/', '-', $data['end_date'])))
        ]);
        if ($insert){
            DB::commit();
            if($data['param_url'] == 'true'){
                return redirect('purchasing-add')->with('success','Data has been created');
            }else{
                return redirect('periode-list')->with('success','Data has been created');
            }
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function edit($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $periode = Periode::find($id);
        if (is_null($periode)){
            return redirect('periode-list')->with('danger','Something Wrong, data not found.');
        }
        $data = [
            'periode' => $periode,
            'param_url' => (isset($_GET['purchasing'])) ? $_GET['purchasing']:''
        ];
        return view('web.admin.periode.edit', $data);
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $valid = validator($request->only('name', 'start_date', 'end_date'), [
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'start_date', 'end_date');
        DB::beginTransaction();
        $update = Periode::where('id', $id)->update([
            'name' => $data['name'],
            'start_date' => date('Y-m-d', strtotime(str_replace('/', '-', $data['start_date']))),
            'end_date' => date('Y-m-d', strtotime(str_replace('/', '-', $data['end_date'])))
        ]);
        if ($update){
            DB::commit();
            return redirect('periode-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        $data = Periode::find($id);
        if (is_null($data)){
            return redirect('periode-list')->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('periode-list')->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('periode-list')->with('success','Data has been deleted.');
        }
    }
}
