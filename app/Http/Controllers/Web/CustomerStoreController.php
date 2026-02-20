<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerStoreController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('customer')
                    ->select('*')
                    ->where(['category' => 'toko'])
                    ->where(function($contents) use ($search){
                        $contents->where('name', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('customer')
                ->where(['category' => 'toko'])
                ->where(function($contents) use ($search){
                    $contents->where('name', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%');
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
            $view = view('web.agent.customer.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.agent.customer.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('customer')
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
        $data = ['param_url' => (isset($_GET['sales'])) ? $_GET['sales']:''];
        return view('web.agent.customer.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('name', 'phone'), [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'phone', 'param_url');
        DB::beginTransaction();
        $insert = Customer::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'category' => 'toko'
        ]);
        if ($insert){
            DB::commit();    
            return redirect('customer-store-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $data = Customer::where(['id' => $id])->first();
        return view('web.agent.customer.detail', $data);
    }

    public function edit($id)
    {
        $data = Customer::where(['id' => $id])->first();
        return view('web.agent.customer.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'phone'), [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'phone');
        DB::beginTransaction();
        $update = Customer::where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
        if ($update){
            DB::commit();
            return redirect('customer-store-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        $data = Customer::find($id);
        if (is_null($data)){
            return redirect('customer-store-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('customer-store-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('customer-store-list')->with('success','Data has been deleted.');
        }
    }
}
