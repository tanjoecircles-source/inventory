<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('employee')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('employee')
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
            $view = view('web.admin.employee.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.employee.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('employee')
                    ->select('id', 'name AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function comboOwner(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('employee')
                    ->select('id', 'name AS text')
                    ->whereIn('category', ['Owner', 'Investor'])
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function comboStaff(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('employee')
                    ->select('id', 'name AS text')
                    ->where(['category' => 'Staff'])
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        $data = ['param_url' => (isset($_GET['purchasing'])) ? $_GET['purchasing']:''];
        return view('web.admin.employee.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('name', 'phone','position'), [
            'name' => 'required',
            'phone' => 'required',
            'position' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'phone', 'position');
        DB::beginTransaction();
        $insert = Employee::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'position' => $data['position']
        ]);
        if ($insert){
            DB::commit();
            return redirect('employee-list')->with('success','Data has been created');    
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $data = Employee::where(['id' => $id])->first();
        return view('web.admin.employee.detail', $data);
    }

    public function edit($id)
    {
        $data = Employee::where(['id' => $id])->first();
        return view('web.admin.employee.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'phone', 'position'), [
            'name' => 'required',
            'phone' => 'required',
            'position' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'phone', 'position');
        DB::beginTransaction();
        $update = Employee::where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'position' => $data['position']
        ]);
        if ($update){
            DB::commit();
            return redirect('employee-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        $data = Employee::find($id);
        if (is_null($data)){
            return redirect('employee-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('employee-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('employee-list')->with('success','Data has been deleted.');
        }
    }
}
