<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\GbMap;
use App\Models\ProductParent;
use Illuminate\Support\Facades\Auth;

class GbMapController extends Controller
{
    public function add($id)
    {
        $data = [
            'id' => $id,
            'product' => ProductParent::where('status', 'Aktif')->where('type', 'Green')->get()
        ];
        return view('web.admin.gb_map.add', $data);
    }

    public function create(Request $request, $id)
    {
        $valid = validator($request->only('product'), [
            'product' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('product');
        DB::beginTransaction();
        $insert = GbMap::create([
            'location' => $id,
            'product' => $data['product'],
        ]);
        if ($insert){
            DB::commit();
            return redirect('map-storage')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function edit($id)
    {
        $data = GbMap::where(['id' => $id])->first();
        return view('web.admin.gb_map.edit', $data);
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
        $update = GbMap::where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
        if ($update){
            DB::commit();
            return redirect('gb-map-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        $data = GbMap::find($id);
        if (is_null($data)){
            return redirect('home')->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('home')->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('home')->with('success','Data has been deleted.');
        }
    }
}
