<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\News;

class NewsController extends Controller
{
    public function list()
    {
        if (Gate::allows('isSeller')) return response(['status' => false, 'message' => 'seller tidak dapat mengakses'], 400);
        
        $list = DB::table('news as n')
            ->select('n.*')
            ->orderBy('id', 'DESC')
            ->get();

        foreach($list as $key => $value){
            $value->photo_url = url('storage/'.$value->photo);
        }
        return response(['status' => true, 'data' => $list], 200);
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);
        $valid=validator($request->all(), [
            'name'=>'required',
            'description'=>'required',
            'photo' => 'required|image|max:2560'
        ]);
        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        
        $param = request()->only('name','description');
        $exist = News::where('name', $param['name'])->count();
        if($exist > 0) return response(['status' => false, 'message' => 'Data sudah terdaftar'], 400);

        $photo = ($request->file('photo')) ? $request->file('photo')->store('news', 'public') : null;

        $params = array_merge(['photo' => $photo], $param);
        $result = News::create($params);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400);  
    }    

    public function update(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Hanya Admin yang bisa mengakses'], 400);
        
        $valid=validator($request->only('name','photo', 'description', 'id'), [
            'name'=>'required',
            'description'=>'required',
            'id'=>'required'
        ]);
        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        $param = request()->only('name','description','id');
        $old = News::where('id', $param['id'])->first();
        if($request->file('photo')) {
            File::delete(storage_path('app/public/'.$old['photo']));
            $photo = $request->file('photo')->store('news', 'public');
        } else { 
            $photo = $old['photo'];
        }
        
        $result = News::where('id',$param['id'])->update(['name'=>$param['name'], 'photo'=>$photo, 'description' => $param['description']]);
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

        $result=News::where('id', request()->only('id'))->delete();
        if($result)
            return response(['status' => true, 'message' => 'berhasil menghapus data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menghapus data'], 400); 
    }
}
