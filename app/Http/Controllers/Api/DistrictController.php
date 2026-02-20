<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
class DistrictController extends Controller
{
    public function list(Request $request)
    {
        $list = DB::table('district as ds')
            ->leftJoin('region as rg','rg.id','=','ds.region')
            ->select('ds.*','rg.name as region_name')
            ->orderBy('ds.id','desc')
            ->get();
        return response(['status' => true, 'data' => $list], 200);
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);

        $valid=validator($request->only('name','code','region'), [
            'name'=>'required',
            'code'=>'required',
            'region'=>'required'
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        $param = request()->only('name','code','region');
        $exist= District::where('name',$param['name'])->count();
        if($exist>0)return response(['status'=>false,'message'=>'Data yang sama di temukan'],400);
        $result = District::create($param);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400); 
            
            
    }    

    public function update(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);
        
        $valid=validator($request->only('name','id','code','region'), [
            'name'=>'required',
            'id'=>'required',
            'region'=>'required',
            'code'=>'required'
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);

        $param = request()->only('name','id','code','region');
        $result = District::where('id',$param['id'])->update(['name'=>$param['name'],'code'=>$param['code'],'region'=>$param['region']]);
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
        $result=District::where('id',$param['id'])->delete();

        if($result)
            return response(['status' => true, 'message' => 'berhasil menghapus data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menghapus data'], 400); 
    }

}
