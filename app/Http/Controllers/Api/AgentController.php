<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\AgentInfo;
use App\Models\User;
use Carbon\Carbon;

class AgentController extends Controller
{
    public function info()
    {
        if (Gate::denies('isAgent')) return response(['status' => false, 'message' => 'Selain Agent tidak dapat mengakses'], 400);

        $data = DB::table('users AS u')
                    ->leftJoin('agent AS s', 's.user', '=', 'u.id')
                    ->leftJoin('region AS r', 'r.id', '=', 's.region')
                    ->leftJoin('district AS d', 'd.id', '=', 's.district')
                    ->select(
                        's.*',
                        's.id AS agent_id',
                        'u.name AS agent_name',
                        'u.phone AS agent_phone',
                        'u.ifseller',
                        'r.name AS region_name',
                        'd.name AS district_name',
                    )
                    ->where('u.id', Auth::user()->id)
                    ->first();
        $personal = [
            'name' => $data->agent_name,
            'phone' => $data->agent_phone,
            'gender' => $data->gender,
            'tempat_lahir' => $data->place_of_birth,
            'tgl_lahir' => (!empty($data->date_of_birth)) ? date('d M Y', strtotime($data->date_of_birth)) : null,
            'alamat' => $data->address,
            'wilayah_id' => $data->region,
            'wilayah' => $data->region_name,
            'kota_id' => $data->district,
            'kota' => $data->district_name,
            'kode_pos' => $data->post_code,
            'bio' => $data->bio
        ];
        
        $result['id_seller'] = $data->agent_id;
        $result['personal'] = $personal;
        
        if($result)
            return response(['status' => true, 'message' => '', 'data' => $result], 200);
        else
            return response(['status' => false, 'message' => 'Data Empty', 'data' => []], 400);
    }

    public function update(Request $request)
    {
        if (Gate::denies('isAgent')) return response(['status' => false, 'message' => 'Selain Agent tidak dapat mengakses'], 400);

        $valid=validator($request->only('name','phone','gender','place_of_birth', 'date_of_birth', 'address', 'district', 'region', 'post_code', 'bio'), [
            'name'=>'required',
            'phone'=>'required',
            'gender'=>'required',
            'place_of_birth'=>'required',
            'date_of_birth'=>'required',
            'address'=>'required',
            'district'=>'required',
            'region'=>'required',
            'post_code'=>'required',
            'bio' => 'max:500'
        ]);
        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->first()], 400);
        
        $param = request()->only('name','gender','place_of_birth', 'date_of_birth', 'address', 'district', 'region', 'post_code', 'bio', 'phone');
        
        $exist= AgentInfo::where('user', Auth::user()->id)->count();
        if($exist > 0 ) {
            //update
            $result = AgentInfo::where('user', Auth::user()->id)->update([
                'name'=>$param['name'], 
                'gender'=>$param['gender'],
                'place_of_birth'=>$param['place_of_birth'],
                'date_of_birth'=>$param['date_of_birth'],
                'address'=>$param['address'],
                'region'=>$param['region'],
                'district'=>$param['district'],
                'post_code'=>$param['post_code'],
                'bio'=>$param['bio'],
                'author' => Auth::user()->id,
                'editor' => Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
        }else{
            //insert
            $result = AgentInfo::create([
                'user' =>Auth::user()->id,
                'name'=>Auth::user()->name, 
                'code' => $this->generate_code(8),
                'gender'=>$param['gender'],
                'place_of_birth'=>$param['place_of_birth'],
                'date_of_birth'=>$param['date_of_birth'],
                'address'=>$param['address'],
                'region'=>$param['region'],
                'district'=>$param['district'],
                'post_code'=>$param['post_code'],
                'bio'=>$param['bio'],
                'author' => Auth::user()->id,
                'editor' => Auth::user()->id,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        }
        $result = $result && User::where('id', Auth::user()->id)->update(['name'=>$param['name'], 'phone'=>$param['phone']]);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400); 
    } 

    public function generate_code($length = 6){
		do {
			$random_str = 'AGN-'.strtoupper(Str::random($length));
			$str_count = AgentInfo::where('code', $random_str)->count();
		} while($str_count !== FALSE && $str_count > 0);
		return $random_str;
    }
}
