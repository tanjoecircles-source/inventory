<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RegionController extends Controller
{
    public function list(Request $request)
    {   
        $list = DB::table('region as rg')
            ->select('rg.*')
            ->get();
        return response(['status' => true, 'data' => $list], 200);
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);

        $valid=validator($request->only('name','code'), [
            'name'=>'required',
            'code'=>'required'
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        $param = request()->only('name','code');
        $exist= Region::where('name',$param['name'])->count();
        if($exist>0)return response(['status'=>false,'message'=>'Data yang sama di temukan'],400);
        $result = Region::create($param);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400);      
    }    

    public function update(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);
        
        $valid=validator($request->only('name','id','code'), [
            'name'=>'required',
            'id'=>'required',
            'code'=>'required'
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);

        $param = request()->only('name','id','code');
        $result = Region::where('id',$param['id'])->update(['name'=>$param['name'],'code'=>$param['code']]);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400); 
            
    }

    public function delete(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);

        $valid=validator($request->only('id'), [
            'id'=>'required'
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);

        $param = request()->only('id');
        $result=Region::where('id',$param['id'])->delete();

        if($result)
            return response(['status' => true, 'message' => 'berhasil menghapus data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menghapus data'], 400); 
    }

}
