<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\RefVariant;
class RefVariantController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::allows('isAgent')) return response(['status' => false, 'message' => 'seller tidak dapat mengakses'], 400);
        
        $list = DB::table('ref_variant as va')
            ->leftJoin('ref_product_type as pt','pt.id','=','va.product_type')
            ->select('va.*','pt.name as region_name')
            ->orderBy('va.id','desc')
            ->get();
        return response(['status' => true, 'data' => $list], 200);
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);

        $valid=validator($request->only('product_type','name'), [
            'product_type'=>'required',
            'name'=>'required'
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        $param = request()->only('product_type','name');
        $exist= RefVariant::where('name',$param['name'])->count();
        if($exist>0)return response(['status'=>false,'message'=>'Data yang sama di temukan'],400);
        $result = RefVariant::create($param);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400);      
    }    
    public function update(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);
        
        $valid=validator($request->only('name','id','product_type'), [
            'name'=>'required',
            'id'=>'required',
            'product_type'=>'required'
            
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);

        $param = request()->only('name','id','product_type');
        $result = RefVariant::where('id',$param['id'])->update(['name'=>$param['name'],'product_type'=>$param['product_type']]);
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
        $result=RefVariant::where('id',$param['id'])->delete();

        if($result)
            return response(['status' => true, 'message' => 'berhasil menghapus data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menghapus data'], 400); 
    }
}
