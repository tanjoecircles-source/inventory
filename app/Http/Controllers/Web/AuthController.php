<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Models\OauthGoogle;
use Laravel\Passport\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\SellerInfo;
use App\Mail\Register;
use App\Models\AgentInfo;
use Carbon\Carbon;
use ImageResize;

class AuthController extends Controller
{
    public function index(){
        $data = [];
        //return view($this->device() ? 'core.login' : 'no_device', $data);
        return view('core.login', $data);
    }

    // private function google_client(){
    //     $client = new \Google\Client();
    //     $client->setAuthConfig(public_path('assets/oauth-client-google/client_secret_121604557497-a8ck7aq2jehgfe39fdp6drif6ccuuonn.apps.googleusercontent.com.json'));
    //     $client->setScopes('profile email');
    //     $url = url('callback-google-oauth');
    //     if (strpos($url, 'http://') !== false && strpos($url, 'localhost') == false){
    //         $url = str_replace('http://', 'https://', $url);
    //     }
    //     $client->setRedirectUri($url);
    //     return $client;
    // }

    private function auto_login_google(Request $request, $userId){
        $credentials = User::where('email', session('google')['email'])
            ->where('login_method', 'google')
            ->first();
        $oauthGoogle = new OauthGoogle();
        $oauthGoogle->user_id = $userId;
        $oauthGoogle->access_token = session('google')['access_token'];
        $oauthGoogle->id_token = session('google')['id_token'];
        $session = session('google');
        $oauthGoogle->save();
        Auth::login($credentials);
        if(Auth::check()){
            $request->session()->regenerate();
            session([
                'google' => [
                    'access_token' => $session['access_token'],
                    'id_token' => $session['id_token'],
                    'name' => $session['name'],
                    'email' => $session['email'],
                    'expires_in' => $session['expires_in']
                ]
            ]);
            return redirect()->intended('/home');
        }else{
            return redirect('login')->with('error_login', 'Gagal Login');
        }
    }

    public function login_google(){
        $client = $this->google_client();
        $auth_url = $client->createAuthUrl();
        return redirect()->to(filter_var($auth_url, FILTER_SANITIZE_URL));
    }

    // public function callback_google_oauth(Request $request){
    //     $client = $this->google_client();
    //     if (!isset($request->code)){
    //         return $this->login_google();
    //     }
    //     $client->authenticate($request->code);
    //     $accessToken = $client->getAccessToken();
    //     $idToken = $client->getOAuth2Service()->getIdToken();
    //     $googleService = new \Google\Service\Oauth2($client);
    //     $tokenData = $googleService->userinfo->get(); //get user info
    //     $expireIn = strtotime(date('Y-m-d H:i:s')) + $accessToken['expires_in'];
    //     //store session
    //     session([
    //         'google' => [
    //             'access_token' => $accessToken['access_token'],
    //             'id_token' => $accessToken['id_token'],
    //             'name' => $tokenData->givenName,
    //             'email' => $tokenData->email,
    //             'expires_in' => $expireIn
    //         ]
    //     ]);
    //     //create account or direct auto login
    //     if (User::where('email', $tokenData->email)->where('login_method', 'google')->count() > 0){
    //         $credentials = User::where('email', $tokenData->email)
    //             ->where('login_method', 'google')
    //             ->first();
    //         return $this->auto_login_google($request, $credentials->id);
    //     }else{
    //         return redirect('register');
    //     }
    // }

    function sendtele($pesan)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        $url = "https://api.telegram.org/bot".$token."/sendMessage?parse_mode=markdown&chat_id=".$chatId;
        $url = $url."&text=".urlencode($pesan);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    public function auth_process(Request $request)
    {
        $data = request()->only('email','password');
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);
        $user = User::where('email', $data['email'])->first();
        if(empty($user->email_verified_at)){
            return redirect()->back()->with('error_login', 'Anda belum melakukan verifikasi akun.');
        }
        
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $msg = $user->name." Login Invoice App\n".
                    "pada ".date('d M Y H:i');
            $this->sendtele($msg);
            return redirect()->intended('/home');
        }

        return redirect()->back()->with('error_login', 'Gagal Login');
    }

    public function register(){
        $data = [];
        return view('core.register', $data);
    }

    public function register_form(Request $request){
        $data['type'] = $request['type'];
        return redirect('register-form-'.$data['type']);
    }

    public function register_form_agent(){
        $data['type'] = 'agent';
        return view('core.register_form_agent', $data);
    }

    public function register_agent(Request $request){
        $valid = validator($request->only('email', 'name', 'phone', 'password', 'password_confirmation', 'term'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => !empty(session('google')) ? 'nullable' : 'required|string|confirmed|min:6',
            'password_confirmation' => !empty(session('google')) ? 'nullable' : 'required|string|min:6',
            'term' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = request()->only('email','name','password', 'phone', 'type', 'ifseller', 'term');
        
        $otp = strtoupper($this->generate_otp());

        DB::beginTransaction();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => !empty(session('google')) ? bcrypt('12312312321123xcv@12#') : bcrypt($data['password']),
            'phone' => $data['phone'],
            'type' => 'agent',
            'ifseller' => 'independent',
            'term' => $data['term'],
            'otp' => $otp,
            'email_verified_at' => !empty(session('google')) ? date('Y-m-d H:i:s') : null,
            'login_method' => !empty(session('google')) ? 'google' : 'default'
        ]);

        $result = $user && AgentInfo::create([
            'user' => $user->id,
            'code'=> $this->generate_code_seller(8), 
            'name' => $data['name']
        ]);

        if (!empty(session('google'))){
            DB::commit();
            return $this->auto_login_google($request, $user->id);
        }
        
        //send mail OTP
        $email = $data['email'];
        $datamail = [
            'title' => 'Selamat, Anda telah berhasil melakukan Registrasi Akun',
            'url' => 'https://brocar.id',
            'otp' => $otp
        ];
        Mail::to($email)->send(new Register($datamail));
        $request->session()->put('email', $email);
    

        $client = Client::where('password_client', 1)->first();

        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);
        
        if($result){
            DB::commit();
            $request->session()->forget('data_register');
            return redirect('register-otp/'.encrypt($user->id));
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Mendaftar Akun');
        }
    }

    public function register_form_seller(){
        $data['type'] = 'seller';
        return view('core.register_form_seller', $data);
    }

    public function register_seller(Request $request){
        $valid = validator($request->only('email', 'name', 'phone', 'password', 'password_confirmation', 'term'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => !empty(session('google')) ? 'nullable' : 'required|string|confirmed|min:6',
            'password_confirmation' => !empty(session('google')) ? 'nullable' : 'required|string|min:6',
            'term' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = request()->only('ifseller', 'email','name','password', 'phone', 'term');
        $otp = strtoupper($this->generate_otp());
        
        DB::beginTransaction();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => !empty(session('google')) ? bcrypt('12312312321123xcv@12#') : bcrypt($data['password']),
            'phone' => $data['phone'],
            'type' => 'seller',
            'ifseller' => $data['ifseller'],
            'otp' => $otp,
            'term' => $data['term'],
            'email_verified_at' => !empty(session('google')) ? date('Y-m-d H:i:s') : null,
            'login_method' => !empty(session('google')) ? 'google' : 'default'
        ]);

        $result = $user && SellerInfo::create([
            'user' => $user->id,
            'code'=> $this->generate_code_seller(8),
            'name' => $data['name'],
            'dealer_phone' => $data['phone']
        ]);

        if (!empty(session('google'))){
            DB::commit();
            return $this->auto_login_google($request, $user->id);
        }
        
        //send mail OTP
        $datamail = [
            'title' => 'Selamat, Anda telah berhasil melakukan Registrasi Akun Sebagai Penjual',
            'url' => 'https://brocar.id',
            'otp' => $otp
        ];
        Mail::to($data['email'])->send(new Register($datamail));

        $client = Client::where('password_client', 1)->first();
        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);
        if($result){
            DB::commit();
            return redirect('register-otp/'.encrypt($user->id));
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Mendaftar Akun');
        }
    }

    public function register_seller_confirm($id){
        $reg = session('data_register');
        if (!$reg) {
            return redirect()->back()->with('danger', 'Data tidak valid');
        }
        return view('core.register_form_seller_confirm_'.$id);
    }

    public function register_seller_confirm_submit(Request $request){
        $reg = session('data_register');
        if (!$reg) {
            return redirect()->back()->with('danger', 'Data tidak valid');
        }
        $data = request()->all();
        $data = array_merge($data, $reg);
        $data['seller_code'] = $this->generate_code_seller(8);
        if($data['ifseller'] == 'dealer'){
            $valid = validator($request->all(), [
                'identity' => 'required|image:jpg,png,jpeg,gif,svg|max:5120', 
                'dealer' => 'required|image:jpg,png,jpeg,gif,svg|max:5120',
                'term' => 'required'
            ]);
        }else{
            $valid = validator($request->all(), 
            [
                'identity' => 'required|image:jpg,png,jpeg,gif,svg|max:5120',
                'term' => 'required'
            ]);
        }

        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        
        if($request->file('identity')) {
            $identity = $this->upload_condition('seller', $data['seller_code'], $request->file('identity'));
        }
        if($request->file('dealer')) {
            $dealer = $this->upload_condition('seller_dealer', $data['seller_code'], $request->file('dealer'));
        }

        $otp = strtoupper($this->generate_otp());
        
        DB::beginTransaction();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'type' => 'seller',
            'ifseller' => $data['ifseller'],
            'otp' => $otp,
            'term' => $data['term'],
            'email_verified_at' => !empty(session('google')) ? date('Y-m-d H:i:s') : null,
            'login_method' => !empty(session('google')) ? 'google' : 'default'
        ]);

        $result = $user && SellerInfo::create([
            'user' => $user->id,
            'code'=> $data['seller_code'], 
            'identity_photo' => $identity ?? null,
            'identity_dealer_photo' => $dealer ?? null,
            'name' => $data['name']
        ]);

        if (!empty(session('google'))){
            DB::commit();
            return $this->auto_login_google($request, $user->id);
        }
        
        //send mail OTP
        $datamail = [
            'title' => 'Selamat, Anda telah berhasil melakukan Registrasi Akun',
            'url' => 'https://brocar.id',
            'otp' => $otp
        ];
        Mail::to($data['email'])->send(new Register($datamail));

        $client = Client::where('password_client', 1)->first();
        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $data['email'],
            'password'      => $data['password'],
            'scope'         => null,
        ]);
        if($result){
            DB::commit();
            $request->session()->forget('data_register');
            return redirect('register-otp/'.encrypt($user->id));
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Mendaftar Akun');
        }
    }

    public function register_otp($id){
        $data = User::where('id', decrypt($id))->first();
        $data['encrypt_id'] = $id;
        $dt = Carbon::create($data['updated_at']);
        $expired_time = $dt->addMinute(3);
        $data['expired_time'] = $expired_time->toDateTimeString();
        if (!$data) {
            return redirect('register_form_seller')->with('danger', 'User tidak valid');
        }
        return view('core.register_otp', $data);
    }

    public function register_otp_process(Request $request){

        $data = request()->all();
        $user = User::where(['id' => decrypt($data['id'])])->first();
        if(empty($user)){
            return redirect('register-otp/'.$data['id'])->with('error_email','Akun tidak valid');
        }

        //if($user->otp == $data['otp1'].$data['otp2'].$data['otp3'].$data['otp4'].$data['otp5'].$data['otp6']){
        if($user->otp == $data['otp']){
            User::where(['id' => decrypt($data['id'])])->update(['email_verified_at' => Carbon::now()->toDateTimeString()]);
            return redirect('login')->with('success_otp','Selamat, akun anda sudah aktif');
        }
        return redirect('register-otp')->with('error','Kode OTP tidak sesuai');
    }

    public function forgot_password(){
        $data = [];
        return view('core.forgot-password', $data);
    }

    public function forgot_password_email(Request $request){
        $valid = validator($request->only('email'), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = request()->only('email');
        $user = User::where('email', $data['email'])->first();
        if(empty($user->id)){
            return redirect()->back()->with('danger', 'Email anda tidak terdaftar.');
        }
        
        $otp = strtoupper($this->generate_otp());
        $update = User::where('email', $data['email'])->update(['otp' => $otp]);
        //send mail
        $email = $data['email'];
        $datamail = [
            'title' => 'Pengajuan Pemulihan Password untuk Akun '.$data['email'],
            'url' => 'https://brocar.id',
            'name' => $user['name'],
            'link_change' => url('forgot-password-change?id='.encrypt($user->id).'&otp='.encrypt($otp))
        ];
        $result = $update && Mail::to($email)->send(new ForgotPassword($datamail));
        if($result){
            return redirect('forgot-password')->with('success','Cek Email Untuk Pemulihan Password Anda');
        }else{
            return redirect()->back()->with('danger', 'Gagal Mendaftar Akun');
        }
    }

    public function forgot_password_change(){
        $id = $_GET['id'];
        $otp = $_GET['otp'];
        
        $user = User::where(['id' => decrypt($id), 'otp' => decrypt($otp)])->first();
        if(empty($user)){
            return redirect('forgot-password')->with('danger','Link Sudah Kedaluarsa');
        }
        $data = ['id' => $id];
        return view('core.forgot-password-change', $data);
    }

    public function forgot_password_submit(Request $request){

        $data = request()->all();
        $valid = validator($data, [
            'password' => 'required|string|confirmed|min:6',
            'password_confirmation' => 'required|string|min:6'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $user = User::where(['id' => decrypt($data['id'])])->first();
        if(empty($user)){
            return redirect('forgot-password')->with('danger','Akun tidak valid');
        }

        $result = User::where('id', decrypt($data['id']))->update([
            'password' => bcrypt($data['password_confirmation']),
            'otp' => strtoupper($this->generate_otp())
        ]);
        if($result){
            return redirect('login')->with('success','Berhasil Membuat Password Baru, Silakan login kembali.');
        }else{
            return redirect()->back()->with('danger', 'Gagal Membuat Password');
        }
    }

    public function account_verification(){
        $data = [];
        return view('core.account-verification', $data);
    }

    public function account_verification_email(Request $request){
        $valid = validator($request->only('email'), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = request()->only('email');
        $user = User::where('email', $data['email'])->first();
        if(empty($user->id)){
            return redirect()->back()->with('danger', 'Email anda tidak terdaftar.');
        }
        
        $otp = strtoupper($this->generate_otp());
        $update = User::where('email', $data['email'])->update(['otp' => $otp]);
        //send mail
        $email = $data['email'];
        $datamail = [
            'title' => 'Verifikasi Ulang Aktifasi Akun',
            'url' => 'https://brocar.id',
            'otp' => $otp
        ];
        
        $result = $update && Mail::to($email)->send(new Register($datamail));
        $request->session()->put('email', $email);
        if($result){
            return redirect('register-otp/'.encrypt($user->id));
        }else{
            return redirect()->back()->with('danger', 'Gagal Verifikasi Akun');
        }
    }

    public function logout(){
        Auth::logout();
        if (!empty(session('google'))){
            OauthGoogle::where('access_token', session('google')['access_token'])->delete();
        }
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('home');
    }

    public function generate_code_seller($length = 6){
		do {
			$random_str = 'BRO-'.strtoupper(Str::random($length));
			$otp_count = SellerInfo::where('code', $random_str)->count();
		} while($otp_count !== FALSE && $otp_count > 0);
		return $random_str;
    }

    public function generate_otp(){
		do {
            $end = 999999;
			$random_str = mt_rand(0, $end);
			$otp_count = User::where('otp', $random_str)->count();
		} while($otp_count !== FALSE && $otp_count > 0);
		return $random_str;
    }

    public function gb_pricelist(){
        $stok_gb = DB::table('product as p')
                    ->select(
                            'p.id as id',
                            'p.name_pl as name',
                            'p.origin',
                            'p.elevation',
                            'p.varietal',
                            'p.process',
                            'p.processor',
                            'p.harvest',
                            'p.desc',
                            'p.price as price',
                            'p.price_grosir15 as price_grosir15',
                            'p.price_grosir50 as price_grosir50',
                            'p.is_new as is_new',
                            'p.stock as stock',
                            'p.photo_thumbnail as photo'
                            )
                    ->where([
                        'p.type' => '1',
                        'p.status' => 'Active',
                        'p.is_pricelist' => 'true'
                    ])
                    ->orderBy('order_pricelist', 'ASC')
                    ->get();
        
        foreach ($stok_gb as $key => $value) {
            $value->is_new = ($value->is_new == 'true') ? 'New' : '';
            
            $value->stock_lable = ($value->stock > 0) ? 'Ready' : 'Sold';
            $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
            $value->stock_color = ($value->stock > 0) ? 'info' : 'danger';
        }
        $data = ['stok_gb' => $stok_gb];
        return view('core.gb_pricelist', $data);
    }

    public function roasted_pricelist(){
        $stok_filter = DB::table('product as p')
                    ->select(
                            'p.id as id',
                            'p.name_pl as name',
                            'p.origin',
                            'p.elevation',
                            'p.varietal',
                            'p.process',
                            'p.processor',
                            'p.harvest',
                            'p.desc',
                            'p.price as price',
                            'p.price_grosir15 as price_grosir15',
                            'p.price_grosir50 as price_grosir50',
                            'p.is_new as is_new',
                            'p.stock as stock',
                            'p.photo_thumbnail as photo'
                            )
                    ->where([
                        'p.type' => '2',
                        'p.status' => 'Active',
                        'p.is_pricelist' => 'true'
                    ])
                    ->orderBy('order_pricelist', 'ASC')
                    ->get();
        
        foreach ($stok_filter as $key => $value) {
            $value->is_new = ($value->is_new == 'true') ? 'New' : '';
            $value->stock_lable = ($value->stock > 0) ? 'Ready' : 'Sold Out';
            $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
            $value->stock_color = ($value->stock > 0) ? 'success' : 'danger';
        }

        $stok_spro = DB::table('product as p')
                    ->select(
                            'p.id as id',
                            'p.name_pl as name',
                            'p.category as category',
                            'p.origin',
                            'p.elevation',
                            'p.varietal',
                            'p.process',
                            'p.processor',
                            'p.harvest',
                            'p.desc',
                            'p.price as price',
                            'p.price_grosir15 as price_grosir15',
                            'p.price_grosir50 as price_grosir50',
                            'p.is_new as is_new',
                            'p.stock as stock',
                            'p.photo_thumbnail as photo'
                            )
                    ->where([
                        'p.type' => '3',
                        'p.status' => 'Active',
                        'p.is_pricelist' => 'true'
                    ])
                    ->orderBy('order_pricelist', 'ASC')
                    ->get();
        foreach ($stok_spro as $key => $value) {
            $value->is_new = ($value->is_new == 'true') ? 'New' : '';
            $value->stock_lable = ($value->stock > 0) ? 'Ready' : 'Pre Order';
            $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-thumbs-up';
            $value->stock_color = ($value->stock > 0) ? 'success' : 'warning';
        }

        $data = [
            'stok_filter' => $stok_filter,
            'stok_spro' => $stok_spro
        ];
        return view('core.roasted_pricelist', $data);
    }

    // public function upload_condition($path, $code, $filedata){
    //     $fpath = $path;
    //     $fname = $code.'-'.Str::random(12).'-'.date('ymdhis').'.jpg';
    //     $convert = ImageResize::make($filedata)->encode('jpg', 75);
    //     ImageResize::make($convert)->fit($this->product_image_width, $this->product_image_height)->save(storage_path('app/public/'.$fpath.'/'.$fname));
    //     $result = $fpath.'/'.$fname;
    //     return $result;
    // }
}
