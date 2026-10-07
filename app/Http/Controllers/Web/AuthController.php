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
use App\Models\ProductImage;
use Carbon\Carbon;
use ImageResize;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index(){
        $data = [];
        //return view($this->device() ? 'core.login' : 'no_device', $data);
        return view('core.login', $data);
    }

    private function get_google_oauth_config(){
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $redirectUri = env('GOOGLE_REDIRECT_URI');

        if (empty($clientId) || empty($clientSecret)) {
            $jsonPath = public_path('assets/oauth-client-google/client_secret_121604557497-a8ck7aq2jehgfe39fdp6drif6ccuuonn.apps.googleusercontent.com.json');
            if (file_exists($jsonPath)) {
                $json = json_decode(file_get_contents($jsonPath), true);
                if (isset($json['web'])) {
                    $clientId = $clientId ?: ($json['web']['client_id'] ?? null);
                    $clientSecret = $clientSecret ?: ($json['web']['client_secret'] ?? null);
                }
            }
        }

        if (empty($redirectUri)) {
            $redirectUri = url('callback-google-oauth');
        }

        return [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
        ];
    }

    private function auto_login_google(Request $request, $userId){
        $credentials = User::where('id', $userId)->first();
        if (!$credentials && session('google.email')) {
            $credentials = User::where('email', session('google')['email'])
                ->where('login_method', 'google')
                ->first();
        }

        if (!$credentials) {
            return redirect('login')->with('error_login', 'Akun tidak ditemukan.');
        }

        try {
            if (session('google.access_token')) {
                $oauthGoogle = new OauthGoogle();
                $oauthGoogle->user_id = $userId;
                $oauthGoogle->access_token = session('google')['access_token'] ?? '';
                $oauthGoogle->id_token = session('google')['id_token'] ?? '';
                $oauthGoogle->save();
            }
        } catch (\Exception $e) {
            Log::warning('OauthGoogle save error: ' . $e->getMessage());
        }

        Auth::login($credentials, true);
        if(Auth::check()){
            $request->session()->regenerate();
            $destination = session('google_auth_redirect', url('home'));
            session()->forget('google_auth_redirect');
            return redirect()->to($destination);
        }else{
            return redirect('login')->with('error_login', 'Gagal Login');
        }
    }

    public function login_google(Request $request){
        $config = $this->get_google_oauth_config();

        if ($request->has('redirect')) {
            $redirect = $request->get('redirect');
            if ($redirect === 'checkout' || $redirect === 'shop-checkout') {
                session(['google_auth_redirect' => url('shop-checkout')]);
            } elseif ($redirect === 'shop') {
                session(['google_auth_redirect' => url('shop')]);
            } else {
                session(['google_auth_redirect' => $redirect]);
            }
        } else {
            $prev = url()->previous();
            if ($prev && !str_contains($prev, 'login') && !str_contains($prev, 'register')) {
                session(['google_auth_redirect' => $prev]);
            } else {
                session(['google_auth_redirect' => url('home')]);
            }
        }

        $state = Str::random(40);
        session(['oauth2state' => $state]);

        $params = [
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'access_type' => 'offline',
            'state' => $state,
            'prompt' => 'select_account',
        ];

        $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);

        return redirect()->away($authUrl);
    }

    public function callback_google_oauth(Request $request){
        if (!$request->has('code')) {
            return redirect()->route('login')->with('error_login', 'Gagal otentikasi Google (Kode otorisasi tidak ditemukan).');
        }

        $config = $this->get_google_oauth_config();

        try {
            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'code' => $request->get('code'),
                'client_id' => $config['client_id'],
                'client_secret' => $config['client_secret'],
                'redirect_uri' => $config['redirect_uri'],
                'grant_type' => 'authorization_code',
            ]);

            if (!$response->successful()) {
                Log::error('Google OAuth Token Error', ['status' => $response->status(), 'body' => $response->body()]);
                return redirect()->route('login')->with('error_login', 'Gagal mendapatkan token dari Google: ' . $response->body());
            }

            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'] ?? null;
            $idToken = $tokenData['id_token'] ?? null;
            $expiresIn = isset($tokenData['expires_in']) ? (time() + $tokenData['expires_in']) : (time() + 3600);

            $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');
            if (!$userResponse->successful()) {
                Log::error('Google OAuth UserInfo Error', ['status' => $userResponse->status(), 'body' => $userResponse->body()]);
                return redirect()->route('login')->with('error_login', 'Gagal mengambil data profil Google.');
            }

            $googleUser = $userResponse->json();
            $email = $googleUser['email'] ?? null;
            $name = $googleUser['name'] ?? ($googleUser['given_name'] ?? 'User');
            $picture = $googleUser['picture'] ?? null;

            if (empty($email)) {
                return redirect()->route('login')->with('error_login', 'Email Google tidak ditemukan.');
            }

            session([
                'google' => [
                    'access_token' => $accessToken,
                    'id_token' => $idToken,
                    'name' => $name,
                    'email' => $email,
                    'expires_in' => $expiresIn,
                    'picture' => $picture,
                ]
            ]);

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt(Str::random(24) . '@!#123'),
                    'phone' => null,
                    'address' => null,
                    'type' => 'user',
                    'ifseller' => 'independent',
                    'term' => 'true',
                    'otp' => strtoupper(Str::random(6)),
                    'email_verified_at' => Carbon::now(),
                    'login_method' => 'google',
                ]);
            } else {
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = Carbon::now();
                }
                $user->login_method = 'google';
                $user->save();
            }

            try {
                if ($accessToken) {
                    $oauthGoogle = new OauthGoogle();
                    $oauthGoogle->user_id = $user->id;
                    $oauthGoogle->access_token = $accessToken;
                    $oauthGoogle->id_token = $idToken ?: '';
                    $oauthGoogle->save();
                }
            } catch (\Exception $e) {
                Log::warning('OauthGoogle save error: ' . $e->getMessage());
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            $destination = session('google_auth_redirect', url('home'));
            session()->forget('google_auth_redirect');

            return redirect()->to($destination);

        } catch (\Exception $e) {
            Log::error('Google OAuth Exception: ' . $e->getMessage());
            return redirect()->route('login')->with('error_login', 'Terjadi kesalahan saat login Google: ' . $e->getMessage());
        }
    }

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
            if ($request->filled('redirect')) {
                $redir = $request->get('redirect');
                if ($redir === 'checkout' || $redir === 'shop-checkout') {
                    return redirect('shop-checkout');
                } elseif ($redir === 'shop') {
                    return redirect('shop');
                }
                return redirect($redir);
            }
            return redirect()->intended('/home');
        }

        return redirect()->back()->with('error_login', 'Gagal Login');
    }

    public function register(){
        $data['type'] = 'user';
        return view('core.register_form_user', $data);
    }

    public function register_form(Request $request){
        $data['type'] = $request['type'];
        return redirect('register-form-'.$data['type']);
    }

    public function register_form_agent(){
        $data['type'] = 'agent';
        return view('core.register_form_agent', $data);
    }

    public function register_form_user(){
        $data['type'] = 'user';
        return view('core.register_form_user', $data);
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
    

        if($result){
            DB::commit();
            $request->session()->forget('data_register');
            return redirect('register-otp/'.encrypt($user->id));
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Mendaftar Akun');
        }
    }

    public function register_user(Request $request){
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

        $data = request()->only('email','name','password', 'phone', 'term');
        
        $otp = strtoupper($this->generate_otp());

        DB::beginTransaction();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => !empty(session('google')) ? bcrypt('12312312321123xcv@12#') : bcrypt($data['password']),
            'phone' => $data['phone'],
            'type' => 'user',
            'ifseller' => 'independent',
            'term' => $data['term'],
            'otp' => $otp,
            'email_verified_at' => !empty(session('google')) ? date('Y-m-d H:i:s') : null,
            'login_method' => !empty(session('google')) ? 'google' : 'default'
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
    

        if($user){
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
        
        // Load images for each product
        $productIds = $stok_gb->pluck('id')->toArray();
        $images = ProductImage::whereIn('product_id', $productIds)
                    ->orderBy('sort_order', 'ASC')
                    ->get()
                    ->groupBy('product_id');
        
        foreach ($stok_gb as $key => $value) {
            $value->is_new = ($value->is_new == 'true') ? 'New' : '';
            
            $value->stock_lable = ($value->stock > 0) ? 'Ready' : 'Sold';
            $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
            $value->stock_color = ($value->stock > 0) ? 'info' : 'danger';
            
            // Attach images to product
            $productImages = $images->get($value->id, collect());
            $value->images = $productImages->map(function($img) {
                $img->image_url = url('storage/public/' . $img->image_path);
                return $img;
            });
            
            // If no images from product_images table, use the photo_thumbnail fallback
            if ($productImages->isEmpty() && !empty($value->photo)) {
                $defaultImg = new \stdClass();
                $defaultImg->image_url = asset('assets/images/products/noimage.png');
                $defaultImg->is_primary = 'true';
                $value->images = collect([$defaultImg]);
            }
        }
        $data = ['stok_gb' => $stok_gb];
        return view('core.gb_pricelist', $data);
    }

    public function gb_offer(){
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
        
        // Load images for each product
        $productIds = $stok_gb->pluck('id')->toArray();
        $images = ProductImage::whereIn('product_id', $productIds)
                    ->orderBy('sort_order', 'ASC')
                    ->get()
                    ->groupBy('product_id');
        
        foreach ($stok_gb as $key => $value) {
            $value->is_new = ($value->is_new == 'true') ? 'New' : '';
            
            $value->stock_lable = ($value->stock > 0) ? 'Ready' : 'Sold';
            $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
            $value->stock_color = ($value->stock > 0) ? 'info' : 'danger';
            
            // Attach images to product
            $productImages = $images->get($value->id, collect());
            $value->images = $productImages->map(function($img) {
                $img->image_url = url('storage/public/' . $img->image_path);
                return $img;
            });
            
            // If no images from product_images table, use the photo_thumbnail fallback
            if ($productImages->isEmpty() && !empty($value->photo)) {
                $defaultImg = new \stdClass();
                $defaultImg->image_url = asset('assets/images/products/noimage.png');
                $defaultImg->is_primary = 'true';
                $value->images = collect([$defaultImg]);
            }
        }
        $data = ['stok_gb' => $stok_gb];
        return view('core.gb_offer', $data);
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
                            'p.order_pricelist',
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
                            'p.order_pricelist',
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

        // Load images for all products (filter + espresso)
        $allProducts = $stok_filter->merge($stok_spro);
        $productIds = $allProducts->pluck('id')->unique()->toArray();
        $allImages = ProductImage::whereIn('product_id', $productIds)
                    ->orderBy('sort_order', 'ASC')
                    ->get()
                    ->groupBy('product_id');

        $attachImages = function($products, $stockLabelReady, $stockLabelEmpty, $stockColor) use ($allImages) {
            foreach ($products as $value) {
                $value->is_new = ($value->is_new == 'true') ? 'New' : '';
                $value->order_pricelist = empty($value->order_pricelist) ? 0 : $value->order_pricelist;
                $value->stock_lable = ($value->stock > 0) ? $stockLabelReady : $stockLabelEmpty;
                $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
                $value->stock_color = ($value->stock > 0) ? $stockColor : 'danger';
                
                $productImages = $allImages->get($value->id, collect());
                $value->images = $productImages->map(function($img) {
                    $img->image_url = url('storage/public/' . $img->image_path);
                    return $img;
                });
                
                if ($productImages->isEmpty() && !empty($value->photo)) {
                    $defaultImg = new \stdClass();
                    $defaultImg->image_url = asset('assets/images/products/no-image.png');
                    $defaultImg->is_primary = 'true';
                    $value->images = collect([$defaultImg]);
                }
            }
        };

        $attachImages($stok_filter, 'Ready', 'Sold Out', 'success');
        $attachImages($stok_spro, 'Ready', 'Pre Order', 'success');

        $data = [
            'stok_filter' => $stok_filter,
            'stok_spro' => $stok_spro
        ];
        return view('core.roasted_pricelist', $data);
    }

    public function roastedb2b_pricelist(){
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
                            'p.order_pricelist',
                            'p.desc',
                            'p.price_grosir50 as price',
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
                            'p.order_pricelist',
                            'p.desc',
                            'p.price_grosir50 as price',
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

        // Load images for all products (filter + espresso)
        $allProducts = $stok_filter->merge($stok_spro);
        $productIds = $allProducts->pluck('id')->unique()->toArray();
        $allImages = ProductImage::whereIn('product_id', $productIds)
                    ->orderBy('sort_order', 'ASC')
                    ->get()
                    ->groupBy('product_id');

        $attachImages = function($products, $stockLabelReady, $stockLabelEmpty, $stockColor) use ($allImages) {
            foreach ($products as $value) {
                $value->is_new = ($value->is_new == 'true') ? 'New' : '';
                $value->price = empty($value->price) ? 0 : $value->price;
                $value->order_pricelist = empty($value->order_pricelist) ? 0 : $value->order_pricelist;
                $value->stock_lable = ($value->stock > 0) ? $stockLabelReady : $stockLabelEmpty;
                $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
                $value->stock_color = ($value->stock > 0) ? $stockColor : 'danger';
                
                $productImages = $allImages->get($value->id, collect());
                $value->images = $productImages->map(function($img) {
                    $img->image_url = url('storage/public/' . $img->image_path);
                    return $img;
                });
                
                if ($productImages->isEmpty() && !empty($value->photo)) {
                    $defaultImg = new \stdClass();
                    $defaultImg->image_url = asset('assets/images/products/no-image.png');
                    $defaultImg->is_primary = 'true';
                    $value->images = collect([$defaultImg]);
                }
            }
        };

        $attachImages($stok_filter, 'Ready', 'Sold Out', 'success');
        $attachImages($stok_spro, 'Ready', 'Pre Order', 'success');

        $data = [
            'stok_filter' => $stok_filter,
            'stok_spro' => $stok_spro
        ];
        return view('core.roastedb2b_pricelist', $data);
    }

    public function roasted_offer(){
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
                            'p.order_pricelist',
                            'p.desc',
                            'p.price_grosir50 as price',
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
                            'p.order_pricelist',
                            'p.desc',
                            'p.price_grosir50 as price',
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

        // Load images for all products (filter + espresso)
        $allProducts = $stok_filter->merge($stok_spro);
        $productIds = $allProducts->pluck('id')->unique()->toArray();
        $allImages = ProductImage::whereIn('product_id', $productIds)
                    ->orderBy('sort_order', 'ASC')
                    ->get()
                    ->groupBy('product_id');

        $attachImages = function($products, $stockLabelReady, $stockLabelEmpty, $stockColor) use ($allImages) {
            foreach ($products as $value) {
                $value->is_new = ($value->is_new == 'true') ? 'New' : '';
                $value->price = empty($value->price) ? 0 : $value->price;
                $value->order_pricelist = empty($value->order_pricelist) ? 0 : $value->order_pricelist;
                $value->stock_lable = ($value->stock > 0) ? $stockLabelReady : $stockLabelEmpty;
                $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
                $value->stock_color = ($value->stock > 0) ? $stockColor : 'danger';
                
                $productImages = $allImages->get($value->id, collect());
                $value->images = $productImages->map(function($img) {
                    $img->image_url = url('storage/public/' . $img->image_path);
                    return $img;
                });
                
                if ($productImages->isEmpty() && !empty($value->photo)) {
                    $defaultImg = new \stdClass();
                    $defaultImg->image_url = asset('assets/images/products/no-image.png');
                    $defaultImg->is_primary = 'true';
                    $value->images = collect([$defaultImg]);
                }
            }
        };

        $attachImages($stok_filter, 'Ready', 'Sold Out', 'success');
        $attachImages($stok_spro, 'Ready', 'Pre Order', 'success');

        $data = [
            'stok_filter' => $stok_filter,
            'stok_spro' => $stok_spro
        ];
        return view('core.roasted_offer', $data);
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
