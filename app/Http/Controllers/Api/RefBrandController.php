<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RefBrand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RefBrandController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::allows('isAgent')) return response(['status' => false, 'message' => 'Agent tidak dapat mengakses'], 400);
        
        $list = DB::table('ref_brand as rb')
            ->select('rb.*')
            ->get();
        return response(['status' => true, 'data' => $list], 200);
    }
    
    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);

        $valid=validator($request->only('name','factory'), [
            'name'=>'required',
            'factory'=>'required'
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        $param = request()->only('name','factory');
        $result = RefBrand::create($param);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400); 
            
            
    }    

    public function update(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);
        
        $valid=validator($request->only('name','factory','id'), [
            'name'=>'required',
            'factory'=>'required',
            'id'=>'required'
        ]);

        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);

        $param = request()->only('name','factory','id');
        $result = RefBrand::where('id',$param['id'])->update(['name'=>$param['name'], 'factory'=>$param['factory']]);
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
        $result=RefBrand::where('id',$param['id'])->delete();

        if($result)
            return response(['status' => true, 'message' => 'berhasil menghapus data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menghapus data'], 400); 
    }

}
