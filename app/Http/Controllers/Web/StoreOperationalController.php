<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\StoreOperational;
use App\Models\StoreOperationalItem;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class StoreOperationalController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('store_operational AS s')
                    ->leftJoin('vendor AS c', 'c.id', '=', 's.op_vendor')
                    ->select('s.*', 'c.name AS vendor_name')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('s.op_code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('s.op_date', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('store_operational AS s')
                    ->leftJoin('vendor AS c', 'c.id', '=', 's.op_vendor')
                    ->select('s.op_id')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('s.op_code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    })
                ->orderBy('s.op_date', 'DESC')
                ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->op_date = date('d M Y', strtotime($value->op_date));
                if($value->op_status_payment == 'Belum Lunas' && $value->op_payment > 0){
                    $value->payment_color = 'danger';
                    $value->status_payment = 'Bayar Sebagian';
                }elseif($value->op_status_payment == 'Lunas' && $value->op_payment > 0){
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
            $view = view('web.admin.store_operational.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.store_operational.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('store_operational')
                    ->select('id', 'op_code AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('op_code', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('op_code', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        $data = [
            'op_code' => 'OP/TC'.date('y').'/'.date('mdhis'),
            'date' => date('d-m-Y'),
            'vendor' => Vendor::all()
        ];
        return view('web.admin.store_operational.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('op_category', 'op_code', 'op_date', 'op_vendor'), [
            'op_category' => 'required',
            'op_code' => 'required',
            'op_date' => 'required',
            'op_vendor' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('op_category', 'op_code', 'op_date', 'op_vendor');
        DB::beginTransaction();
        $insert = StoreOperational::create([
            'op_category' => $data['op_category'],
            'op_code' => $data['op_code'],
            'op_date' => date('Y-m-d', strtotime($data['op_date'])),
            'op_vendor' => $data['op_vendor'],
            'op_total' => 0,
            'op_status_payment' => 'Belum Lunas',
            'op_status' => 'Draft'
        ]);
        if ($insert){
            DB::commit();
            return redirect('store-operational-detail/'.$insert->id)->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function itemAdd($id)
    {
        $data = ['op_id' => $id];
        return view('web.admin.store_operational.item_add', $data);
    }

    public function itemCreate(Request $request)
    {
        $valid = validator($request->only('op_id', 'itm_product', 'itm_price', 'itm_qty', 'itm_total'), [
            'op_id' => 'required',
            'itm_product' => 'required',
            'itm_price' => 'required',
            'itm_qty' => 'required',
            'itm_total' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('op_id', 'itm_product', 'itm_price', 'itm_qty', 'itm_total');
        DB::beginTransaction();
        $insert = StoreOperationalItem::create([
            'itm_op_id' => $data['op_id'],
            'itm_product' => $data['itm_product'],
            'itm_price' => str_replace('.', "", $data['itm_price']),
            'itm_qty' => $data['itm_qty'],
            'itm_total' => str_replace('.', "", $data['itm_total'])
        ]);
        if ($insert){
            DB::commit();
            return redirect('store-operational-detail/'.$data['op_id'])->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function itemDetail($id)
    {
        $op_id = $_GET['op'];
        $detail = DB::table('store_operational_items AS s')
            ->select('s.*')
            ->where(['s.id' => $id, 's.itm_op_id' => $op_id])
            ->first();
        $data = ['detail' => $detail];
        return view('web.admin.store_operational.item_detail', $data);
    }

    public function itemDelete($id)
    {
        $op_id = $_GET['op'];
        $data = StoreOperationalItem::find($id);
        if (is_null($data)){
            return redirect('store-operational-detail/'.$op_id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('store-operational-detail/'.$op_id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('store-operational-detail/'.$op_id)->with('success','Data has been deleted.');
        }
    }

    public function detail($id)
    {
        $contents = DB::table('store_operational_items')
                    ->select('*', 'itm_product as product_name', 'itm_price as product_price')
                    ->where(['itm_op_id' => $id])
                    ->orderBy('id', 'DESC')
                    ->get();
        if(!empty($contents)){
            $itm_total = 0;
            foreach ($contents as $key => $value) {
                $itm_total += $value->itm_total;
            }
        }

        $detail = DB::table('store_operational AS s')
            ->leftJoin('vendor AS c', 'c.id', '=', 's.op_vendor')
            ->select('s.*',
                    'c.name AS vendor_name')
            ->where(['s.id' => $id])
            ->first();
        $detail->must_pay = (INT)$detail->op_total - (INT)$detail->op_payment;
        
        $data = [
            'store_operational' => $detail,
            'op_sub_total' => $itm_total,
            'op_total' => (INT)$itm_total - (INT)$detail->op_discount,
            'contents' => $contents
        ];

        return view('web.admin.store_operational.detail', $data);
    }

    public function edit($id)
    {
        $detail = StoreOperational::where(['id' => $id])->first();
        $data = [
            'detail' => $detail,
            'vendor' => Vendor::all(),
            'op_date' => date('d-m-Y', strtotime($detail->op_date))
        ];
        return view('web.admin.store_operational.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('op_category','op_code', 'op_date', 'op_vendor'), [
            'op_category' => 'required',
            'op_code' => 'required',
            'op_date' => 'required',
            'op_vendor' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('op_category', 'op_code', 'op_date', 'op_vendor');
        DB::beginTransaction();
        $update = StoreOperational::where('id', $id)->update([
            'op_category' => $data['op_category'],
            'op_code' => $data['op_code'],
            'op_date' => date('Y-m-d', strtotime($data['op_date'])),
            'op_vendor' => $data['op_vendor'],
        ]);
        if ($update){
            DB::commit();
            return redirect('store-operational-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function updateFinal(Request $request, $id)
    {
        $valid = validator($request->only('op_sub_total', 'op_total'), [
            'op_sub_total' => 'required',
            'op_total' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('op_sub_total', 'op_discount', 'op_total');
        if($data['op_total'] == 0){
            return redirect()->back()->with('danger', 'Product is not empty');
        }
        DB::beginTransaction();
        $update = StoreOperational::where('id', $id)->update([
            'op_sub_total' => $data['op_sub_total'],
            'op_discount' => !empty($data['op_discount']) ? $data['op_discount'] : 0,
            'op_total' => $data['op_total'],
            'op_status' => 'Publish'
        ]);
        if ($update){
            DB::commit();
            return redirect('store-operational-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function publish($id)
    {
        DB::beginTransaction();
        $update = StoreOperational::where('id', $id)->update([
            'op_status' => 'Publish'
        ]);
        if ($update){
            DB::commit();
            return redirect('store-operational-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function drafting($id)
    {
        DB::beginTransaction();
        $update = StoreOperational::where('id', $id)->update([
            'op_status' => 'Draft'
        ]);
        if ($update){
            DB::commit();
            return redirect('store-operational-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function payment($id)
    {
        $detail = DB::table('store_operational AS s')
                ->leftJoin('vendor AS c', 'c.id', '=', 's.op_vendor')
                ->select('s.*', 'c.name AS vendor_name')
                ->where(['s.id' => $id])
                ->first();
        $detail->must_pay = $detail->op_total - $detail->op_payment;
        $data = [
            'detail' => $detail,
            'op_date' => date('d-m-Y', strtotime($detail->op_date))
        ];
        return view('web.admin.store_operational.payment', $data);
    }

    public function pay(Request $request, $id)
    {
        $valid = validator($request->only('payment-option', 'op_payment'), [
            'payment-option' => 'required',
            'op_payment' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        
        $detail = StoreOperational::where(['id' => $id])->first();
        $data = $request->only('payment-option', 'op_payment');
        $data['op_payment'] = preg_replace('/[^0-9]/', '', $data['op_payment']);
        if($data['payment-option'] == 'partial-pay'){
            $detail->must_pay = (INT)$detail->op_total - (INT)$detail->op_payment;
            if($data['op_payment'] >= $detail->must_pay){
                return redirect()->back()->with('danger', 'Jumlah Pembayaran Lebih Dari Atau Sama Dengan Tagihan');
            }
        }
        $data['op_pay'] = (INT)$data['op_payment'] + (INT)$detail->op_payment;
        DB::beginTransaction();
        $update = StoreOperational::where('id', $id)->update([
            'op_payment' => $data['op_pay'],
            'op_payment_date' => date('Y-m-d'),
            'op_status_payment' => ($data['op_pay'] == $detail->op_total) ? 'Lunas' : 'Belum Lunas'
        ]);
        if ($update){
            DB::commit();
            return redirect('store-operational-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function set($id)
    {
        $detail = DB::table('store_operational AS s')
                ->leftJoin('vendor AS c', 'c.id', '=', 's.op_vendor')
                ->select('s.*',
                        'c.name AS vendor_name')
                ->where(['s.id' => $id])
                ->first();
        $data = [
            'detail' => $detail,
            'op_date' => date('d-m-Y', strtotime($detail->op_date))
        ];
        return view('web.admin.store_operational.set', $data);
    }

    public function setup(Request $request, $id)
    {
        $data = $request->only('op_expedition', 'op_discount');
        DB::beginTransaction();
        $update = StoreOperational::where('id', $id)->update([
            'op_expedition' => preg_replace('/[^0-9]/', '', $data['op_expedition']),
            'op_discount' => preg_replace('/[^0-9]/', '', $data['op_discount'])
        ]);
        if ($update){
            DB::commit();
            return redirect('store-operational-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function delete($id)
    {
        $data = StoreOperational::find($id);
        if (is_null($data)){
            return redirect('store-operational-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('store-operational-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('store-operational-list')->with('success','Data has been deleted.');
        }
    }
}
