<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Purchasing;
use App\Models\PurchasingItem;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PurchasingController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('purchasing AS s')
                    ->leftJoin('vendor AS c', 'c.id', '=', 's.pur_vendor')
                    ->select('s.*', 'c.name AS vendor_name')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('s.pur_code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('s.pur_date', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('purchasing AS s')
                    ->leftJoin('vendor AS c', 'c.id', '=', 's.pur_vendor')
                    ->select('s.pur_id')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('s.pur_code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    })
                ->orderBy('s.pur_date', 'DESC')
                ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->pur_date = date('d M Y', strtotime($value->pur_date));
                if($value->pur_status_payment == 'Belum Lunas' && $value->pur_payment > 0){
                    $value->payment_color = 'danger';
                    $value->status_payment = 'Bayar Sebagian';
                }elseif($value->pur_status_payment == 'Lunas' && $value->pur_payment > 0){
                    $value->payment_color = 'success';
                    $value->status_payment = 'Lunas';
                }else{
                    $value->payment_color = 'dark';
                    $value->status_payment = 'Belum Bayar';
                }
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.purchasing.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.purchasing.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('purchasing')
                    ->select('id', 'pur_code AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('pur_code', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('pur_code', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        $data = [
            'pur_code' => 'PUR/TC'.date('y').'/'.date('mdhis'),
            'date' => date('d-m-Y'),
            'vendor' => Vendor::all()
        ];
        return view('web.admin.purchasing.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('pur_category', 'pur_code', 'pur_date', 'pur_vendor'), [
            'pur_category' => 'required',
            'pur_code' => 'required',
            'pur_date' => 'required',
            'pur_vendor' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('pur_category', 'pur_code', 'pur_date', 'pur_vendor');
        DB::beginTransaction();
        $insert = Purchasing::create([
            'pur_category' => $data['pur_category'],
            'pur_code' => $data['pur_code'],
            'pur_date' => date('Y-m-d', strtotime($data['pur_date'])),
            'pur_vendor' => $data['pur_vendor'],
            'pur_total' => 0,
            'pur_status_payment' => 'Belum Lunas',
            'pur_status' => 'Draft'
        ]);
        if ($insert){
            DB::commit();
            return redirect('purchasing-detail/'.$insert->id)->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function itemAdd($id)
    {
        $data = ['pur_id' => $id];
        return view('web.admin.purchasing.item_add', $data);
    }

    public function itemCreate(Request $request)
    {
        $valid = validator($request->only('pur_id', 'itm_product', 'itm_price', 'itm_qty', 'itm_total'), [
            'pur_id' => 'required',
            'itm_product' => 'required',
            'itm_price' => 'required',
            'itm_qty' => 'required',
            'itm_total' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('pur_id', 'itm_product', 'itm_price', 'itm_qty', 'itm_total');
        DB::beginTransaction();
        $insert = PurchasingItem::create([
            'itm_pur_id' => $data['pur_id'],
            'itm_product' => $data['itm_product'],
            'itm_price' => str_replace('.', "", $data['itm_price']),
            'itm_qty' => $data['itm_qty'],
            'itm_total' => str_replace('.', "", $data['itm_total'])
        ]);
        if ($insert){
            DB::commit();
            return redirect('purchasing-detail/'.$data['pur_id'])->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $contents = DB::table('purchasing_items')
                    ->select('*', 'itm_product as product_name', 'itm_price as product_price')
                    ->where(['itm_pur_id' => $id])
                    ->orderBy('id', 'DESC')
                    ->get();
        if(!empty($contents)){
            $itm_total = 0;
            foreach ($contents as $key => $value) {
                $itm_total += $value->itm_total;
            }
        }

        $detail = DB::table('purchasing AS s')
            ->leftJoin('vendor AS c', 'c.id', '=', 's.pur_vendor')
            ->select('s.*',
                    'c.name AS vendor_name')
            ->where(['s.id' => $id])
            ->first();
        $detail->must_pay = (INT)$detail->pur_total - (INT)$detail->pur_payment;
        
        $data = [
            'purchasing' => $detail,
            'pur_sub_total' => $itm_total,
            'pur_total' => (INT)$itm_total - (INT)$detail->pur_discount,
            'contents' => $contents
        ];

        return view('web.admin.purchasing.detail', $data);
    }

    public function edit($id)
    {
        $detail = Purchasing::where(['id' => $id])->first();
        $data = [
            'detail' => $detail,
            'vendor' => Vendor::all(),
            'pur_date' => date('d-m-Y', strtotime($detail->pur_date))
        ];
        return view('web.admin.purchasing.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('pur_category','pur_code', 'pur_date', 'pur_vendor'), [
            'pur_category' => 'required',
            'pur_code' => 'required',
            'pur_date' => 'required',
            'pur_vendor' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('pur_category', 'pur_code', 'pur_date', 'pur_vendor');
        DB::beginTransaction();
        $update = Purchasing::where('id', $id)->update([
            'pur_category' => $data['pur_category'],
            'pur_code' => $data['pur_code'],
            'pur_date' => date('Y-m-d', strtotime($data['pur_date'])),
            'pur_vendor' => $data['pur_vendor'],
        ]);
        if ($update){
            DB::commit();
            return redirect('purchasing-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function updateFinal(Request $request, $id)
    {
        $valid = validator($request->only('pur_sub_total', 'pur_total'), [
            'pur_sub_total' => 'required',
            'pur_total' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('pur_sub_total', 'pur_discount', 'pur_total');
        if($data['pur_total'] == 0){
            return redirect()->back()->with('danger', 'Product is not empty');
        }
        DB::beginTransaction();
        $update = Purchasing::where('id', $id)->update([
            'pur_sub_total' => $data['pur_sub_total'],
            'pur_discount' => !empty($data['pur_discount']) ? $data['pur_discount'] : 0,
            'pur_total' => $data['pur_total'],
            'pur_status' => 'Publish'
        ]);
        if ($update){
            DB::commit();
            return redirect('purchasing-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function publish($id)
    {
        DB::beginTransaction();
        $update = Purchasing::where('id', $id)->update([
            'pur_status' => 'Publish'
        ]);
        if ($update){
            DB::commit();
            return redirect('purchasing-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function payment($id)
    {
        $detail = DB::table('purchasing AS s')
                ->leftJoin('vendor AS c', 'c.id', '=', 's.pur_vendor')
                ->select('s.*', 'c.name AS vendor_name')
                ->where(['s.id' => $id])
                ->first();
        $detail->must_pay = $detail->pur_total - $detail->pur_payment;
        $data = [
            'detail' => $detail,
            'pur_date' => date('d-m-Y', strtotime($detail->pur_date))
        ];
        return view('web.admin.purchasing.payment', $data);
    }

    public function pay(Request $request, $id)
    {
        $valid = validator($request->only('payment-option', 'pur_payment'), [
            'payment-option' => 'required',
            'pur_payment' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        
        $detail = Purchasing::where(['id' => $id])->first();
        $data = $request->only('payment-option', 'pur_payment');
        $data['pur_payment'] = preg_replace('/[^0-9]/', '', $data['pur_payment']);
        if($data['payment-option'] == 'partial-pay'){
            $detail->must_pay = (INT)$detail->pur_total - (INT)$detail->pur_payment;
            if($data['pur_payment'] >= $detail->must_pay){
                return redirect()->back()->with('danger', 'Jumlah Pembayaran Lebih Dari Atau Sama Dengan Tagihan');
            }
        }
        $data['pur_pay'] = (INT)$data['pur_payment'] + (INT)$detail->pur_payment;
        DB::beginTransaction();
        $update = Purchasing::where('id', $id)->update([
            'pur_payment' => $data['pur_pay'],
            'pur_payment_date' => date('Y-m-d'),
            'pur_status_payment' => ($data['pur_pay'] == $detail->pur_total) ? 'Lunas' : 'Belum Lunas'
        ]);
        if ($update){
            DB::commit();
            return redirect('purchasing-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function set($id)
    {
        $detail = DB::table('purchasing AS s')
                ->leftJoin('vendor AS c', 'c.id', '=', 's.pur_vendor')
                ->select('s.*',
                        'c.name AS vendor_name')
                ->where(['s.id' => $id])
                ->first();
        $data = [
            'detail' => $detail,
            'pur_date' => date('d-m-Y', strtotime($detail->pur_date))
        ];
        return view('web.admin.purchasing.set', $data);
    }

    public function setup(Request $request, $id)
    {
        $data = $request->only('pur_expedition', 'pur_discount');
        DB::beginTransaction();
        $update = Purchasing::where('id', $id)->update([
            'pur_expedition' => preg_replace('/[^0-9]/', '', $data['pur_expedition']),
            'pur_discount' => preg_replace('/[^0-9]/', '', $data['pur_discount'])
        ]);
        if ($update){
            DB::commit();
            return redirect('purchasing-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function delete($id)
    {
        $data = Purchasing::find($id);
        if (is_null($data)){
            return redirect('purchasing-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('purchasing-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('purchasing-list')->with('success','Data has been deleted.');
        }
    }
}
