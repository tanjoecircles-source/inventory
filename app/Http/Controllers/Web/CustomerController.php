<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('customer')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('customer')
                ->where(function($contents) use ($search){
                    $contents->where('name', 'like', '%'.$search.'%');
                })
                ->orderBy('id', 'DESC')
                ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->created_at = date('d M Y', strtotime($value->created_at));
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.customer.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.customer.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('customer')
                    ->select('id', 'name AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        $data = ['param_url' => (isset($_GET['sales'])) ? $_GET['sales']:''];
        return view('web.admin.customer.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('name', 'phone', 'address'), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'phone', 'address', 'param_url');
        DB::beginTransaction();
        $insert = Customer::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address']
        ]);
        if ($insert){
            DB::commit();
            if($data['param_url'] == 'true'){
                return redirect('sales-add')->with('success','Data has been created');
            }else{
                return redirect('customer-list')->with('success','Data has been created');
            }
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $data = Customer::where(['id' => $id])->first();
        return view('web.admin.customer.detail', $data);
    }

    public function edit($id)
    {
        $data = Customer::where(['id' => $id])->first();
        return view('web.admin.customer.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'phone', 'address'), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'nullable',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'phone', 'address');
        // Phone lama sebelum di-update (dipakai untuk link awal via kecocokan phone)
        $oldPhone = Customer::where('id', $id)->value('phone');

        DB::beginTransaction();
        $update = Customer::where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);

        // Sinkronisasi ke akun user (type='user'), scope: name, phone, address
        if ($update !== false) {
            // Cari user type='user' yang sudah terlink ke customer ini via customer_id
            $user = User::where('type', 'user')->where('customer_id', $id)->first();

            if (empty($user)) {
                // Link awal: cari user type='user' via kecocokan phone (lama atau baru) yang belum dilink customer lain
                $phones = array_values(array_unique(array_filter([$oldPhone, $data['phone']])));
                $user = User::where('type', 'user')
                    ->whereIn('phone', $phones)
                    ->where(function ($q) use ($id) {
                        $q->whereNull('customer_id')->orWhere('customer_id', $id);
                    })
                    ->orderBy('id')
                    ->first();
                if (!empty($user)) {
                    // Isi link
                    User::where('id', $user->id)->update(['customer_id' => $id]);
                }
            }

            if (!empty($user)) {
                // Update data akun user dari data customer
                User::where('id', $user->id)->update([
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                ]);
            }
            // Tidak ada user type='user' cocok -> dilewati
        }

        if ($update !== false){
            DB::commit();
            return redirect('customer-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        $data = Customer::find($id);
        if (is_null($data)){
            return redirect('customer-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('customer-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('customer-list')->with('success','Data has been deleted.');
        }
    }
}
