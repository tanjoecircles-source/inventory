<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
use App\Models\SellerInfo;
use App\Models\AgentInfo;
use App\Models\Customer;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        $info = [];

        if(Gate::allows('isSeller') || Gate::allows('isSellerDealer')) {
            $info = $this->seller_info();
        }
        if(Gate::allows('isAgent')) {
            $info = $this->agent_info();
        }

        if(!empty($info)){
            if(!empty($info->district_name) && empty($info->region_name))
                $info->address = $info->district_name;
            elseif(!empty($info->region_name) && empty($info->district_name))
                $info->address = $info->region_name;
            elseif(!empty($info->district_name) && !empty($info->region_name))
                $info->address = $info->district_name.', '.$info->region_name;
            else
                $info->address = "Alamat Kosong";
        }

        if(!empty($user->avatar) && File::exists(storage_path('app/public/user/thumbnail/'.$user->avatar))) 
            $user->avatar = url('storage/public/user/thumbnail/'.$user->avatar);
        else
            $user->avatar = url('assets/images/users/1.jpg');

        $data = [
            'info' => $info,
            'user' => $user
        ];
        return view('web.profile.index', $data);
    }

    public function reminder(){
        $data = [];
        return view('web.profile.reminder', $data);
    }

    public function agent_reminder(){
        $data = [];
        return view('web.profile.reminder_agent', $data);
    }

    public function category(){
        $seller = $this->seller_info();
        $agent = $this->agent_info();
        $info = false;
        $dealer = false;
        if(Gate::allows('isSeller') || Gate::allows('isSellerDealer')) {
            $info = !empty($seller->name) && !empty($seller->gender) && !empty($seller->place_of_birth) && !empty($seller->date_of_birth) && !empty($seller->address) && !empty($seller->district) && !empty($seller->region) ? true : false;
            $dealer = !empty($seller->dealer_name) && !empty($seller->dealer_position) && !empty($seller->dealer_phone) ? true : false;
        }
        if(Gate::allows('isAgent')) {
            $info = !empty($agent->name) && !empty($agent->gender) && !empty($agent->place_of_birth) && !empty($agent->date_of_birth) && !empty($agent->address) && !empty($agent->district) && !empty($agent->region) ? true : false;
            $dealer = false;
        }
        if(!Gate::allows('isSeller') && !Gate::allows('isSellerDealer') && !Gate::allows('isAgent')) {
            $user = Auth::user();
            $info = !empty($user->name) && !empty($user->phone) && !empty($user->address) ? true : false;
        }
        $data = [
            'info' => $info,
            'dealer' => $dealer
        ];
        return view('web.profile.category', $data);
    }

    public function edit()
    {
        $user = Auth::user();
        $info = null;
        $view = 'web.profile.edit';
        if(Gate::allows('isSeller') || Gate::allows('isSellerDealer')) {
            $info = $this->seller_info();
            $view = 'web.profile.edit_seller';
        }

        if(Gate::allows('isAgent')) {
            $info = $this->agent_info();
            $view = 'web.profile.edit_agent';
        }
        
        if(!empty($info)) {
            $info->date_of_birth = !empty($info->date_of_birth) ? date('d-m-Y', strtotime($info->date_of_birth)) : date('d-m-Y');
        }
        

        $data = [
            'info' => $info,
            'user' => $user,
            'region' => Region::all(),
            'district' => District::all(),
        ];
        return view($view, $data);
    }

    public function update_seller(Request $request, $id)
    {
        $valid = validator($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'address' => 'required',
            'region' => 'required',
            'district' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        DB::beginTransaction();
        $update = SellerInfo::where('id', $id)->update([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'place_of_birth' => $data['place_of_birth'],
            'date_of_birth' => date('Y-m-d', strtotime($data['date_of_birth'])),
            'address' => $data['address'],
            'region' => $data['region'],
            'district' => $data['district'],
            'post_code' => $data['post_code']
        ]);
        $update2 = User::where('id', Auth::user()->id)->update([
            'name' => $data['name'],
            'phone' => $data['phone']
        ]);
        if ($update && $update2){
            DB::commit();
            return redirect('profile-category')->with('success','Berhasil mengubah data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal mengubah data');
        }
    }

    public function edit_dealer()
    {
        $data = [
            'seller' => $this->seller_info()
        ];
        return view('web.profile.edit_dealer', $data);
    }

    public function update_dealer(Request $request, $id)
    {
        $valid = validator($request->all(), [
            'dealer_name' => 'required',
            'dealer_phone' => 'required',
            'dealer_position' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        DB::beginTransaction();
        $update = SellerInfo::where('id', $id)->update([
            'dealer_name' => $data['dealer_name'],
            'dealer_position' => $data['dealer_position'],
            'dealer_phone' => $data['dealer_phone'],
            'dealer_status' => $data['dealer_status']
        ]);
        if ($update){
            DB::commit();
            return redirect('profile-category')->with('success','Berhasil mengubah data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal mengubah data');
        }
    }

    public function update_agent(Request $request, $id)
    {
        $valid = validator($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'place_of_birth' => 'required',
            'date_of_birth' => 'required',
            'address' => 'required',
            'region' => 'required',
            'district' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        DB::beginTransaction();
        $update = AgentInfo::where('id', $id)->update([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'place_of_birth' => $data['place_of_birth'],
            'date_of_birth' => date('Y-m-d', strtotime($data['date_of_birth'])),
            'address' => $data['address'],
            'region' => $data['region'],
            'district' => $data['district'],
            'post_code' => $data['post_code']
        ]);
        $update2 = User::where('id', Auth::user()->id)->update([
            'name' => $data['name'],
            'phone' => $data['phone']
        ]);
        if ($update && $update2){
            DB::commit();
            return redirect('profile-category')->with('success','Berhasil mengubah data');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal mengubah data');
        }
    }

    public function update_user(Request $request, $id)
    {
        $valid = validator($request->only('name', 'phone', 'email', 'address'), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email|unique:users,email,'.$id,
            'address' => 'nullable',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'phone', 'email', 'address');
        // Phone lama sebelum di-update (dipakai untuk link awal via kecocokan phone)
        $oldPhone = User::where('id', $id)->value('phone');

        // Kolom email NOT NULL di DB: hanya diupdate jika diisi, jika kosong pertahankan email lama
        $updateData = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ];
        if (!empty($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        DB::beginTransaction();
        $update = User::where('id', $id)->update($updateData);

        // Sinkronisasi ke tabel customer (hanya untuk tipe user), scope: name, phone, address
        if ($update !== false && Gate::allows('isUser')) {
            $user = User::where('id', $id)->first();
            $customerId = $user->customer_id;

            if (!empty($customerId)) {
                // Link sudah ada: update customer terkait
                Customer::where('id', $customerId)->update([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                ]);
            } else {
                // Link awal: cari customer via kecocokan phone (lama atau baru)
                $phones = array_values(array_unique(array_filter([$oldPhone, $data['phone']])));
                $customer = Customer::whereIn('phone', $phones)
                    ->whereNotIn('id', User::whereNotNull('customer_id')->where('id', '!=', $id)->pluck('customer_id'))
                    ->orderBy('id')
                    ->first();
                if (!empty($customer)) {
                    // Isi link + update customer
                    User::where('id', $id)->update(['customer_id' => $customer->id]);
                    Customer::where('id', $customer->id)->update([
                        'name' => $data['name'],
                        'phone' => $data['phone'],
                        'address' => $data['address'],
                    ]);
                }
                // Tidak ada customer cocok -> dilewati (tidak membuat customer baru)
            }
        }

        if ($update !== false){
            DB::commit();
            return redirect('profile')->with('success','Data profil berhasil diperbarui');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal memperbarui data profil');
        }
    }

    public function edit_password()
    {
        $data = Auth::user();
        return view('web.profile.edit_password', $data);
    }

    public function update_password(Request $request, $id)
    {
        $valid = validator($request->all(), [
            'password' => 'required|string|confirmed|min:6',
            'password_confirmation' => 'required|string|min:6',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $data = $request->all();
        DB::beginTransaction();
        $update = User::where('id', $id)->update([
            'password' => bcrypt($data['password_confirmation'])
        ]);
        if ($update){
            DB::commit();
            return redirect('profile')->with('success','Password Berhasil Diperbarui');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Perbarui Password');
        }
    }

    public function update_photo_profile(Request $request){
        $valid = validator($request->only('photo'), [
            'photo' => 'required|image|mimes:png,jpg,jpeg|max:10000'
        ]);

        if ($valid->fails()) {
            return response(['status' => false, 'message' => $valid->errors()->first(), 'thumbnail_url' => null], 200);
        }
        $imageName = time().'.'.$request->photo->extension();
        $request->photo->storeAs('public/user/thumbnail', $imageName);
        $update = User::where('id', Auth::user()->id)->update([
            'avatar' => $imageName
        ]);

        if ($update){
            return response()->json([
                'status' => true,
                'message' => 'Foto profil berhasil diubah',
                'thumbnail_url' => url('storage/public/user/thumbnail/'.$imageName)
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Foto profil gagal diubah, coba ulangi kembali',
                'thumbnail_url' => ''
            ]);
        }
        
    }
}
