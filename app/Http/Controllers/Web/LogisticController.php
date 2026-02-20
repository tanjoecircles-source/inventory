<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Logistic;
use Illuminate\Support\Facades\Auth;

class LogisticController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('logistic_invoice')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('inv_code', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('logistic_invoice')
                ->where(function($contents) use ($search){
                    $contents->where('inv_code', 'like', '%'.$search.'%');
                })
                ->orderBy('id', 'DESC')
                ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->inv_date = date('d M Y', strtotime($value->inv_date));
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.logistic_invoice.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.logistic_invoice.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('logistic_invoice')
                    ->select('id', 'inv_code AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('inv_code', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('inv_code', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        return view('web.admin.logistic_invoice.add');
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('inv_code', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment'), [
            'inv_code' => 'required',
            'inv_date' => 'required',
            'inv_source' => 'required',
            'inv_total' => 'required',
            'inv_status_payment' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('inv_code', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment');
        DB::beginTransaction();
        $insert = Logistic::create([
            'inv_code' => $data['inv_code'],
            'inv_date' => date('Y-m-d', strtotime($data['inv_date'])),
            'inv_source' => $data['inv_source'],
            'inv_total' => $data['inv_total'],
            'inv_status_payment' => $data['inv_status_payment']
        ]);
        if ($insert){
            DB::commit();
            return redirect('logistic-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail(Request $request, $id)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('logistic_items')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('itm_name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('logistic_items')
                ->where(function($contents) use ($search){
                    $contents->where('itm_name', 'like', '%'.$search.'%');
                })
                ->orderBy('id', 'DESC')
                ->count();

        // if(!empty($contents)){
        //     foreach ($contents as $key => $value) {
        //         $value->inv_date = date('d M Y', strtotime($value->inv_date));
        //     }
        // }
        $data = [
            'invoice' => Logistic::where(['id' => $id])->first(),
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.logistic_items.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }

        return view('web.admin.logistic_invoice.detail', $data);
    }

    public function edit($id)
    {
        $data = Logistic::where(['id' => $id])->first();
        $data->inv_date = date('d-m-Y', strtotime($data->inv_date));
        return view('web.admin.logistic_invoice.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('inv_code', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment'), [
            'inv_code' => 'required',
            'inv_date' => 'required',
            'inv_source' => 'required',
            'inv_total' => 'required',
            'inv_status_payment' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('inv_code', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment');
        DB::beginTransaction();
        $update = Logistic::where('id', $id)->update([
            'inv_code' => $data['inv_code'],
            'inv_date' => date('Y-m-d', strtotime($data['inv_date'])),
            'inv_source' => $data['inv_source'],
            'inv_total' => $data['inv_total'],
            'inv_status_payment' => $data['inv_status_payment']
        ]);
        if ($update){
            DB::commit();
            return redirect('logistic-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        $data = Logistic::find($id);
        if (is_null($data)){
            return redirect('logistic-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('logistic-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('logistic-list')->with('success','Data has been deleted.');
        }
    }
}
