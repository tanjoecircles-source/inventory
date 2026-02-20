<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\SellerInfo;
use Laravel\Passport\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use App\Mail\Register;
use Illuminate\Support\Str;
use Carbon\Carbon;
use ImageResize;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class UsersController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::denies('isAdmin')) return response(['status' => false, 'message' => 'Selain Admin tidak dapat mengakses'], 400);
        $param = request()->only('search','filter', 'offset', 'limit', 'order');
        $search = $param['search'];
        $filter = $param['filter'];
        $offset = $param['offset'];
        $limit = $param['limit'];
        $order_sort = !empty($param['order'][0]) ? $param['order'][0] : 'id';
        $order_mode = !empty($param['order'][1]) ? $param['order'][1] : 'desc';
        //get data list
        $list = DB::table('users')
            ->select('*')
            ->where(function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            })
            ->orderBy($order_sort, $order_mode)
            ->offset($offset)
            ->limit($limit);
        if(!empty($filter['type'])) $list->where('type', $filter['type']);
        $list = $list->get();

        //get data filtered total
        $filtered = DB::table('users')
            ->selectRaw('COUNT(DISTINCT id) AS total')
            ->where(function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
            });
        if(!empty($filter['type'])) $list->where('type', $filter['type']);
        $filtered = $filtered->first()->total;

        //get data total
        $total =  DB::table('users')
            ->selectRaw('COUNT(DISTINCT id) AS total');
        $total = $total->first()->total;

        $result['list'] = $list;
        $result['filtered'] = $filtered;
        $result['total'] = $total;
        if($result)
            return response(['status' => true, 'message' => '', 'data' => $result], 200);
        else
            return response(['status' => false, 'message' => 'Data Empty', 'data' => []], 400);
    }

    public function create(Request $request)
    {
        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array  $request
         * @return \Illuminate\Contracts\Validation\Validator
         */
        $valid = validator($request->only('email', 'name', 'phone', 'password', 'password_confirmation', 'term'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|confirmed|min:6',
            'password_confirmation' => 'required|string|min:6',
            'term' => 'required'
        ]);

        if ($valid->fails()) {
            return response(['status' => false, 'message' => $valid->errors()->all(), 'data' => null], 400);
        }

        $data = request()->only('email','name','password', 'phone', 'type', 'ifseller', 'term');
        
        $otp = strtoupper($this->generate_otp());
        
        $user_register = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'type' => !empty($data['type']) ? $data['type'] : 'agent',
            'ifseller' => !empty($data['ifseller']) ? $data['ifseller'] : 'independent',
            'term' => $data['term'],
            'otp' => $data['type'] == 'agent' ? $otp : null
        ]);
        if($user_register && $data['type'] == 'agent'){
            $email = $data['email'];
            $datamail = [
                'title' => 'Selamat, Anda telah berhasil melakukan Registrasi Akun',
                'url' => 'https://brocar.id',
                'otp' => $otp
            ];
            Mail::to($email)->send(new Register($datamail));
        }

        // And created user until here.
        $client = Client::where('password_client', 1)->first();

        // Is this $request the same request? I mean Request $request? Then wouldn't it mess the other $request stuff? Also how did you pass it on the $request in $proxy? Wouldn't Request::create() just create a new thing?
        $oauth = [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ];

        $request->request->add($oauth);
        $httpResponse = app()->handle(
            Request::create('/oauth/token', 'POST', $oauth)
        );
        $result = json_decode($httpResponse->getContent());  
        if ($data['type'] == 'agent' && $data['ifseller'] == 'independent') $result->description = 'Masukan kode OTP yang sudah dikirim ke email aktif anda ('.$data['email'].')';
        elseif($data['type'] == 'seller' && $data['ifseller'] == 'independent') $result->description = 'Diwajibkan Upload Foto Selfie Identitas';
        elseif($data['type'] == 'seller' && $data['ifseller'] == 'dealer') $result->description = 'Diwajibkan Upload Foto Selfie Identitas dan Foto Dealer';
        else  $result->description =  null;

        if ($httpResponse->getStatusCode() !== 200) {
            return response(['status' => false, 'message' => 'Gagal Registrasi', 'data' => null], 400);
        }        
        return response(['status' => true, 'message' => $data['type'] == 'seller' ? 'Verifikasi Akun Penjual' : 'Kode OTP sudah dikirim', 'data' => $result], 200);
    }

    public function create_seller_independent(Request $request)
    {
        DB::beginTransaction();
        $valid=validator($request->all(), [
            'email'=>'required|string|email|max:255',
            'photo' => 'required|image:jpg,png,jpeg,gif,svg|max:5120'
        ],
        [
            'photo.required' => 'Foto Selfie KTP tidak boleh kosong',
            'photo.image' => 'Foto Selfie KTP harus berupa gambar',
            'photo.max' => 'Foto Selfie KTP ukuran maksimal 5MB'
        ]);
        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->first()], 400);
        
        $param = request()->only('email','photo');
        $existuser = User::where('email', $param['email'])->first();
        $existseller = SellerInfo::where('user', $existuser->id ?? null)->first();
        $code = !empty($existseller) ? $existseller->seller_code : $this->generate_code_seller(8);
        if(!$existuser) return response(['status' => false, 'message' => 'Data Registrant Belum Terdaftar'], 400);

        if($request->file('photo')) {
            $photo = $this->upload_condition('seller', $code, $request->file('photo'));
        }
        
        if($existseller){
            File::delete(storage_path('app/public/'.$existseller->identity_photo));
            $result = SellerInfo::where(['user' => $existuser->id])->update([
                'code'=> $code, 
                'identity_photo' => $photo,
                'name' => $existuser->name
            ]);
        }else{ 
            $result = SellerInfo::create([
                'user' => $existuser->id,
                'code'=> $code, 
                'identity_photo' => $photo,
                'name' => $existuser->name
            ]);
            
            $otp = strtoupper($this->generate_otp());
            User::where('email', $param['email'])->update(['otp' => $otp]);
            $email = $param['email'];
            $datamail = [
                'title' => 'Selamat, Anda telah berhasil melakukan Registrasi Akun',
                'url' => 'https://brocar.id',
                'otp' => $otp
            ];
            Mail::to($email)->send(new Register($datamail));
        }
        
        if($result) {
            DB::commit();
            return response(['status' => true, 'message' => $existseller ? 'Berhasil menyimpan data' : 'Kode OTP sudah dikirim', 'data' => ['description' => $existseller ? null : 'Masukan kode OTP yang sudah dikirim ke email aktif anda ('.$param['email'].')']], 200);
        }else {
            DB::rollback();
            return response(['status' => false, 'message' => 'gagal menyimpan data', 'data' => null], 400);  
        }
    }
    
    public function create_seller_dealer(Request $request)
    {
        DB::beginTransaction();

        $valid=validator($request->all(), [
            'email'=>'required|string|email|max:255',
            'photo' => 'required|image:jpg,png,jpeg,gif,svg|max:5120',
            'photo_dealer' => 'required|image:jpg,png,jpeg,gif,svg|max:5120'
        ],
        [
            'photo.required' => 'Foto Selfie KTP tidak boleh kosong',
            'photo.image' => 'Foto Selfie KTP harus berupa gambar',
            'photo.max' => 'Foto Selfie KTP ukuran maksimal 5MB',
            'photo_dealer.required' => 'Foto Dealer tidak boleh kosong',
            'photo_dealer.image' => 'Foto Dealer harus berupa gambar',
            'photo_dealer.max' => 'Foto Dealer ukuran maksimal 5MB',
        ]);
        if($valid->fails()) return response(['status' => false, 'message' => $valid->errors()->first()], 400);
        
        $param = request()->only('email','photo');
        $existuser = User::where('email', $param['email'])->first();
        $existseller = SellerInfo::where('user', $existuser->id ?? null)->first();
        $code = !empty($existseller) ? $existseller->seller_code : $this->generate_code_seller(8);
        if(!$existuser) return response(['status' => false, 'message' => 'Data Registrant Belum Terdaftar'], 400);
        
        if($request->file('photo')) {
            $photo = $this->upload_condition('seller', $code, $request->file('photo'));
        }
        if($request->file('photo_dealer')) {
            $photo_dealer = $this->upload_condition('seller_dealer', $code, $request->file('photo_dealer'));
        }

        if($existseller) {
            File::delete(storage_path('app/public/'.$existseller->identity_photo));
            File::delete(storage_path('app/public/'.$existseller->identity_dealer_photo));
            $result = SellerInfo::where(['user' => $existuser->id])->update([
                'code'=> $code, 
                'identity_photo' => $photo,
                'identity_dealer_photo' => $photo_dealer,
                'name' => $existuser->name
            ]);
        }else {
            $result = SellerInfo::create([
                'user' => $existuser->id,
                'code'=> $code, 
                'identity_photo' => $photo,
                'identity_dealer_photo' => $photo_dealer,
                'name' => $existuser->name
            ]);
            
            $otp = strtoupper($this->generate_otp());
            User::where('email', $param['email'])->update(['otp' => $otp]);
            $email = $param['email'];
            $datamail = [
                'title' => 'Selamat, Anda telah berhasil melakukan Registrasi Akun',
                'url' => 'https://brocar.id',
                'otp' => $otp
            ];
            Mail::to($email)->send(new Register($datamail));
        }
        
        if($result){
            DB::commit();
            return response(['status' => true, 'message' => $existseller ? 'Berhasil menyimpan data' : 'Kode OTP sudah dikirim', 'data' => ['description' => $existseller ? null : 'Masukan kode OTP yang sudah dikirim ke email aktif anda ('.$param['email'].')']], 200);
        }else{
            DB::rollback();
            return response(['status' => false, 'message' => 'gagal menyimpan data', 'data' => null], 400);  
        }
    }

    public function otp_verification(Request $request)
    {
        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array  $request
         * @return \Illuminate\Contracts\Validation\Validator
         */
        $valid = validator($request->only('email', 'otp'), [
            'otp' => 'required|string|max:6',
            'email' => 'required|string|email|max:255',
        ]);

        if ($valid->fails()) {
            return response(['status' => false, 'message' => $valid->errors()->all(), 'data' => null], 400);
        }

        $data = request()->only('email','otp');
        $user = User::where(['email' => $data['email']])->first();
        if(empty($user)){
            return response(['status' => false, 'message' => 'Email tidak terdaftar'], 400);
        }

        if($user->otp == $data['otp']){
            User::where(['email' => $data['email']])->update(['email_verified_at' => Carbon::now()->toDateTimeString()]);
            return response(['status' => true, 'message' => 'Success', 'data' => null], 200);
        }else{
            return response(['status' => false, 'message' => 'Kode OTP tidak sesuai', 'data' => null], 400);
        }
    }

    public function generate_otp(){
		do {
            $end = 999999;
			$random_str = mt_rand(0, $end);
			$otp_count = User::where('otp', $random_str)->count();
		} while($otp_count !== FALSE && $otp_count > 0);
		return $random_str;
    }

    public function generate_code_seller($length = 6){
		do {
			$random_str = 'BRO-'.strtoupper(Str::random($length));
			$otp_count = SellerInfo::where('code', $random_str)->count();
		} while($otp_count !== FALSE && $otp_count > 0);
		return $random_str;
    }

    public function login(Request $request)
    {
        /**
         * Get a validator for an incoming registration request.
         *
         * @param  array  $request
         * @return \Illuminate\Contracts\Validation\Validator
         */
        $valid = validator($request->only('email', 'password'), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($valid->fails()) {
            return response(['status' => false, 'message' => $valid->errors()->all(), 'data' => null], 400);
        }

        $data = request()->only('email', 'password');
        // Check Email verification
        $user = User::where('email', $data['email'])->first();

        if(!$user){
            return response(['status' => false, 'message' => 'Email anda belum terdaftar', 'data' => null], 400);
        }

        if(!$user->email_verified_at){
            return response(['status' => false, 'message' => 'Anda belum melakukan verifikasi akun', 'data' => null], 400);
        }

        // And created user until here.
        $client = Client::where('password_client', 1)->first();

        // Is this $request the same request? I mean Request $request? Then wouldn't it mess the other $request stuff? Also how did you pass it on the $request in $proxy? Wouldn't Request::create() just create a new thing?
        $data = [
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ];

        $request->request->add($data);
        $httpResponse = app()->handle(
            Request::create('/oauth/token', 'POST', $data)
        );
        $result = json_decode($httpResponse->getContent());  
        if ($httpResponse->getStatusCode() !== 200) {
            return response(['status' => false, 'message' => 'Username atau Password tidak sesuai', 'data' => null], 400);
        }        
        return response(['status' => true, 'message' => 'Berhasil Login', 'data' => $result], 200);

        // Fire off the internal request. 
        // $token = Request::create(
        //     'oauth/token',
        //     'POST'
        // );

        // $request->request->add([
        //     'grant_type'    => 'password',
        //     'client_id'     => $client->id,
        //     'client_secret' => $client->secret,
        //     'username'      => $data['email'],
        //     'password'      => $data['password'],
        //     'scope'         => null,
        // ]);

        // // Fire off the internal request. 
        // $token = Request::create(
        //     'oauth/token',
        //     'POST'
        // );
        // return \Route::dispatch($token);
    }

    public function profile()
    {
        return response(['status' => true, 'message' => '', 'data' => Auth::user()], 200);
    }

    public function logout(Request $request)
    {
        $result = Auth::user()->token()->revoke();
        if($result){
            return response(['status' => true, 'message' => 'Success', 'data' => null], 200);
        }else{
            return response(['status' => false, 'message' => 'Gagal Logout', 'data' => null], 400);
        }
    }

    public function upload_condition($path, $code, $filedata){
        $fpath = $path;
        $fname = $code.'-'.Str::random(12).'-'.date('ymdhis').'.jpg';
        $convert = ImageResize::make($filedata)->encode('jpg', 75);
        ImageResize::make($convert)->fit($this->product_image_width, $this->product_image_height)->save(storage_path('app/public/'.$fpath.'/'.$fname));
        $result = $fpath.'/'.$fname;
        return $result;
    }
    
}
