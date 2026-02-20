<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\SellerInfo;
use App\Models\User;
use Carbon\Carbon;

class SellerController extends Controller
{
    public function info()
    {
        if (Gate::denies('isSeller')) return response(['status' => false, 'message' => 'Selain Seller tidak dapat mengakses'], 400);

        $data = DB::table('users AS u')
                    ->leftJoin('seller AS s', 's.user', '=', 'u.id')
                    ->leftJoin('region AS r', 'r.id', '=', 's.region')
                    ->leftJoin('district AS d', 'd.id', '=', 's.district')
                    ->select(
                        's.*',
                        's.id AS seller_id',
                        'u.name AS seller_name',
                        'u.phone AS seller_phone',
                        'u.ifseller',
                        'r.name AS region_name',
                        'd.name AS district_name',
                    )
                    ->where('u.id', Auth::user()->id)
                    ->first();
        $personal = [
            'name' => $data->seller_name,
            'phone' => $data->seller_phone,
            'gender' => $data->gender,
            'tempat_lahir' => $data->place_of_birth,
            'tgl_lahir' => (!empty($data->date_of_birth)) ? date('d M Y', strtotime($data->date_of_birth)) : null,
            'alamat' => $data->address,
            'wilayah_id' => $data->region,
            'wilayah' => $data->region_name,
            'kota_id' => $data->district,
            'kota' => $data->district_name,
            'kode_pos' => $data->post_code
        ];
        
        $result['id_seller'] = $data->seller_id;
        $result['personal'] = $personal;

        if($data->ifseller == 'dealer'){
            $dealer = [
                'nama_dealer' => $data->dealer_name,
                'jabatan_anda' => $data->dealer_position,
                'phone_dealer' => $data->dealer_phone
            ];
            
            if(!empty($data->dealer_photo_ouside) && File::exists(storage_path('app/public/'.$data->dealer_photo_ouside))) 
                $data->dealer_photo_ouside = url('storage/'.$data->dealer_photo_ouside);
            else
                $data->dealer_photo_ouside = 'Foto Dealer Bagian Luar Kosong';
            
            if(!empty($data->dealer_photo_inside) && File::exists(storage_path('app/public/'.$data->dealer_photo_inside))) 
                $data->dealer_photo_inside = url('storage/'.$data->dealer_photo_inside);
            else
                $data->dealer_photo_inside = 'Foto Dealer Bagian dalam Kosong';

            if(!empty($data->dealer_photo_other) && File::exists(storage_path('app/public/'.$data->dealer_photo_other))) 
                $data->dealer_photo_other = url('storage/'.$data->dealer_photo_other);
            else
                $data->dealer_photo_other = 'Foto Dealer Bagian lainnya Kosong';

            $dealer['foto'] = [
                $data->dealer_photo_ouside,
                $data->dealer_photo_inside,
                $data->dealer_photo_other,
            ];
            $result['dealer'] = $dealer;
        }
        
        if($result)
            return response(['status' => true, 'message' => '', 'data' => $result], 200);
        else
            return response(['status' => false, 'message' => 'Data Empty', 'data' => []], 400);
    }

    public function update(Request $request)
    {
        if (Gate::denies('isSeller')) return response(['status' => false, 'message' => 'Selain Seller tidak dapat mengakses'], 400);

        $valid=validator($request->only('gender','place_of_birth', 'date_of_birth', 'address', 'district', 'region', 'post_code'), [
            'name'=>'required',
            'gender'=>'required',
            'place_of_birth'=>'required',
            'date_of_birth'=>'required',
            'address'=>'required',
            'district'=>'required',
            'region'=>'required',
            'post_code'=>'required'
        ]);
        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->first()], 400);
        
        $param = request()->only('name','gender','place_of_birth', 'date_of_birth', 'address', 'district', 'region', 'post_code', 'phone');
        
        $exist= SellerInfo::where('user', Auth::user()->id)->count();
        if($exist > 0 ) {
            //update
            $result = SellerInfo::where('user', Auth::user()->id)->update([
                'name'=>$param['name'], 
                'gender'=>$param['gender'],
                'place_of_birth'=>$param['place_of_birth'],
                'date_of_birth'=>$param['date_of_birth'],
                'address'=>$param['address'],
                'region'=>$param['region'],
                'district'=>$param['district'],
                'post_code'=>$param['post_code'],
                'author' => Auth::user()->id,
                'editor' => Auth::user()->id,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
            $result = $result && User::where('id', Auth::user()->id)->update(['name'=>$param['name'], 'phone'=>$param['phone']]);
        }else{
            //insert
            $result = SellerInfo::create([
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
                'author' => Auth::user()->id,
                'editor' => Auth::user()->id,
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
            $result = $result && User::where('id', Auth::user()->id)->update(['name'=>$param['name'], 'phone'=>$param['phone']]);
        }
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400); 
    } 

    public function update_dealer(Request $request)
    {
        if (Gate::denies('isSellerDealer')) return response(['status' => false, 'message' => 'Selain Seller Dealer tidak dapat mengakses'], 400);
        $valid=validator($request->only('id_seller', 'dealer_name','dealer_position', 'dealer_phone', 'dealer_photo_ouside', 'dealer_photo_inside', 'dealer_photo_other'), [
            'id_seller'=>'required',
            'dealer_name'=>'required',
            'dealer_position'=>'required',
            'dealer_phone'=>'required',
            'dealer_photo_ouside'=>'image|max:2560',
            'dealer_photo_inside'=>'image|max:2560',
            'dealer_photo_other'=>'image|max:2560',
        ]);
        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->all()], 400);
        
        $param = request()->only('id_seller', 'dealer_name','dealer_position', 'dealer_phone', 'dealer_photo_ouside', 'dealer_photo_inside', 'dealer_photo_other');
        
        $old = SellerInfo::where('id', $param['id_seller'])->first();
        if(!$old) return response(['status' => false, 'message' => 'Id seller tidak ditemukan'], 400);
        if($request->file('dealer_photo_ouside')) {
            if(File::exists(storage_path('app/public/'.$old['dealer_photo_ouside']))) File::delete(storage_path('app/public/'.$old['dealer_photo_ouside']));
            $dealer_photo_ouside = $request->file('dealer_photo_ouside')->store('seller_dealer/'.$old['code'], 'public');
        } else { 
            $dealer_photo_ouside = $old['dealer_photo_ouside'];
        }

        if($request->file('dealer_photo_inside')) {
            if(File::exists(storage_path('app/public/'.$old['dealer_photo_inside']))) File::delete(storage_path('app/public/'.$old['dealer_photo_inside']));
            $dealer_photo_inside = $request->file('dealer_photo_inside')->store('seller_dealer/'.$old['code'], 'public');
        } else { 
            $dealer_photo_inside = $old['dealer_photo_inside'];
        }

        if($request->file('dealer_photo_other')) {
            if(File::exists(storage_path('app/public/'.$old['dealer_photo_other']))) File::delete(storage_path('app/public/'.$old['dealer_photo_other']));
            $dealer_photo_other = $request->file('dealer_photo_other')->store('seller_dealer/'.$old['code'], 'public');
        } else { 
            $dealer_photo_other = $old['dealer_photo_other'];
        }
        //update
        $result = SellerInfo::where('id', $param['id_seller'])->update([
            'dealer_name' => $param['dealer_name'], 
            'dealer_position' => $param['dealer_position'],
            'dealer_phone' => $param['dealer_phone'],
            'dealer_photo_ouside' => $dealer_photo_ouside,
            'dealer_photo_inside' => $dealer_photo_inside,
            'dealer_photo_other' => $dealer_photo_other,
            'editor' => Auth::user()->id,
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        if($result)
            return response(['status' => true, 'message' => 'berhasil menyimpan data'], 200);
        else
            return response(['status' => false, 'message' => 'gagal menyimpan data'], 400); 
    } 

    public function generate_code($length = 6){
		do {
			$random_str = 'BRO-'.strtoupper(Str::random($length));
			$otp_count = SellerInfo::where('code', $random_str)->count();
		} while($otp_count !== FALSE && $otp_count > 0);
		return $random_str;
    }
}
