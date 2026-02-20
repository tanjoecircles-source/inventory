<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefRegionController extends Controller
{
    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('region')
                    ->select('id', 'name AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }
}
