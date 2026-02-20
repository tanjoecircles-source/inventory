<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Roasting;
use App\Models\RoastingItem;
use App\Models\RoastingProfile;
use App\Models\Vendor;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class RoastingController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('roasting AS s')
                    ->leftJoin('vendor AS c', 'c.id', '=', 's.vendor')
                    ->select('s.*', 'c.name AS vendor_name')
                    ->where(function($contents) use ($search){
                        $contents->where('s.code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('s.date', 'DESC')->orderBy('s.id', 'DESC')->paginate($limit);

        $counts = DB::table('roasting AS s')
                    ->leftJoin('vendor AS c', 'c.id', '=', 's.vendor')
                    ->select('s.inv_id')
                    ->where(function($contents) use ($search){
                        $contents->where('s.code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    })
                    ->where(['s.author' => Auth::user()->id])
                    ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->date = date('d M Y', strtotime($value->date));
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.roasting.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.roasting.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('roasting')
                    ->select('id', 'code AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('code', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('code', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        $data = [
            'code' => 'ROAST/'.date('dmy').'/'.date('his'),
            'date' => date('d-m-Y'),
            'vendor' => Vendor::all()
        ];
        return view('web.admin.roasting.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('code', 'date', 'vendor'), [
            'code' => 'required',
            'date' => 'required',
            'vendor' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('code', 'date', 'vendor');
        DB::beginTransaction();
        $insert = Roasting::create([
            'code' => $data['code'],
            'date' => date('Y-m-d', strtotime($data['date'])),
            'vendor' => $data['vendor'],
            'status' => 'Draft',
            'author' => Auth::user()->id
        ]);
        if ($insert){
            DB::commit();
            return redirect('roasting-detail/'.$insert->id)->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail(Request $request, $id)
    {
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('roasting_item AS s')
                    ->leftJoin('product AS p', 'p.id', '=', 's.product')
                    ->select('s.*', 'p.name AS product_name', 'p.price AS product_price', 'p.price_hpp AS price_hpp')
                    ->where(['s.roasting_id' => $id])
                    ->where(function($contents) use ($search){
                        $contents->where('p.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->get();

        if(!empty($contents)){
            $qty_total = 0;
            foreach ($contents as $key => $value) {
                $qty_total += $value->qty;
            }
        }
        
        $detail = DB::table('roasting AS s')
            ->leftJoin('vendor AS c', 'c.id', '=', 's.vendor')
            ->select('s.*',
                    'c.name AS vendor_name')
            ->where(['s.id' => $id])
            ->first();
        
        $data = [
            'roasting' => $detail,
            'qty_total' => $qty_total,
            'keyword' => $search,
            'contents' => $contents
        ];
        return view('web.admin.roasting.detail', $data);
    }

    public function edit($id)
    {
        $detail = Roasting::where(['id' => $id])->first();
        $data = [
            'detail' => $detail,
            'vendor' => Vendor::all(),
            'date' => date('d-m-Y', strtotime($detail->date))
        ];
        return view('web.admin.roasting.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('inv_category','code', 'date', 'vendor'), [
            'inv_category' => 'required',
            'code' => 'required',
            'date' => 'required',
            'vendor' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('code', 'date', 'vendor');
        DB::beginTransaction();
        $update = Roasting::where('id', $id)->update([
            'inv_category' => $data['inv_category'],
            'code' => $data['code'],
            'date' => date('Y-m-d', strtotime($data['date'])),
            'vendor' => $data['vendor'],
            'author' => Auth::user()->id
        ]);
        if ($update){
            DB::commit();
            return redirect('roasting-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function addItem($id)
    {
        $data = [
            'roasting_id' => $id,
            'product' => Product::where('type', 'Green')->get(),
            'roast_profile' => RoastingProfile::all()
        ];
        return view('web.admin.roasting.item_add', $data);
    }

    public function createItem(Request $request, $id)
    {
        $valid = validator($request->only('product', 'profile', 'qty'), [
            'product' => 'required',
            'profile' => 'required',
            'qty' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('product', 'profile', 'qty');
        DB::beginTransaction();
        $insert = RoastingItem::create([
            'roasting_id' => $id,
            'product' => $data['product'],
            'profile' => $data['profile'],
            'qty' => $data['qty'],
            'artisan_log' => NULL,
            'author' => Auth::user()->id
        ]);
        
        $product_stock = Product::where('id', $data['product'])->value('stock');
        $update_stock = (FLOAT)$product_stock - (FLOAT)$data['qty'];
        $result = $insert && Product::where('id', $data['product'])->update(['stock' => $update_stock]);

        if ($result){
            DB::commit();
            return redirect('roasting-detail/'.$id)->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detailItem($id)
    {
        $dataid = $_GET['id'];
        $detail = DB::table('roasting_item AS s')
            ->leftJoin('product AS p', 'p.id', '=', 's.product')
            ->leftJoin('roasting_profile AS rp', 'rp.id', '=', 's.profile')
            ->select('s.*','p.name AS product_name', 'rp.name AS roasting_profile')
            ->where(['s.id' => $dataid, 's.roasting_id' => $id])
            ->first();
        $data = ['detail' => $detail];
        return view('web.admin.roasting.item_detail', $data);
    }

    public function deleteItem($id)
    {
        $dataid = $_GET['id'];
        $data = RoastingItem::find($dataid);
        if (is_null($data)){
            return redirect('roasting-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('roasting-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('roasting-detail/'.$id)->with('success','Data has been deleted.');
        }
    }

    public function updateFinal(Request $request, $id)
    {
        $valid = validator($request->only('inv_hpp','inv_sub_total', 'inv_total'), [
            'inv_hpp' => 'required',
            'inv_sub_total' => 'required',
            'inv_total' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('inv_hpp', 'inv_sub_total', 'inv_discount', 'inv_expedition', 'inv_total');
        DB::beginTransaction();
        $update = Roasting::where('id', $id)->update([
            'inv_hpp' => $data['inv_hpp'],
            'inv_sub_total' => $data['inv_sub_total'],
            'inv_discount' => !empty($data['inv_discount']) ? $data['inv_discount'] : 0,
            'inv_expedition' => !empty($data['inv_expedition']) ? $data['inv_expedition'] : 0,
            'inv_total' => $data['inv_total']
        ]);
        if ($update){
            DB::commit();
            return redirect('roasting-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function publish($id)
    {
        DB::beginTransaction();
        $update = Roasting::where('id', $id)->update([
            'status' => 'Publish'
        ]);
        if ($update){
            DB::commit();
            return redirect('roasting-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function drafting($id)
    {
        DB::beginTransaction();
        $update = Roasting::where('id', $id)->update([
            'status' => 'Draft'
        ]);
        if ($update){
            DB::commit();
            return redirect('roasting-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function print($id)
    {
        $detail = DB::table('roasting AS s')
            ->leftJoin('vendor AS c', 'c.id', '=', 's.vendor')
            ->select('s.*',
                    'c.name AS vendor_name')
            ->where(['s.id' => $id])
            ->first();
        $detail->inv_expedition = (!empty($detail->inv_expedition)) ? $detail->inv_expedition : 0;
        $detail->must_pay = (INT)$detail->inv_total - (INT)$detail->inv_payment;
        $product = DB::table('roasting_item AS s')
            ->leftJoin('product AS p', 'p.id', '=', 's.product')
            ->select('s.*', 'p.name AS product_name', 'p.price AS product_price', 'p.summary AS product_desc')
            ->where(['s.roasting_id' => $id])
            ->orderBy('id', 'DESC')
            ->get();
            
        $data = [
            'detail' => $detail,
            'item' => $product
        ];
        
        $pdf = Pdf::loadView('web.admin.roasting.print', $data);
        $pdf->set_paper('LEGAL', 'potrait');
        return $pdf->stream(strtoupper($detail->vendor_name).'_'.$detail->code.'.pdf', array("Attachment" => false));
        
        //return view('web.admin.roasting.print', $data);
    }

    public function payment($id)
    {
        $detail = DB::table('roasting AS s')
                ->leftJoin('vendor AS c', 'c.id', '=', 's.vendor')
                ->select('s.*',
                        'c.name AS vendor_name')
                ->where(['s.id' => $id])
                ->first();
        $detail->must_pay = $detail->inv_total - $detail->inv_payment;
        $data = [
            'detail' => $detail,
            'date' => date('d-m-Y', strtotime($detail->date))
        ];
        return view('web.admin.roasting.payment', $data);
    }

    public function pay(Request $request, $id)
    {
        $valid = validator($request->only('payment-option', 'inv_payment', 'inv_payment_type'), [
            'payment-option' => 'required',
            'inv_payment' => 'required',
            'inv_payment_type' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        
        $detail = Roasting::where(['id' => $id])->first();
        $data = $request->only('payment-option', 'inv_payment', 'inv_payment_type');
        $data['inv_payment'] = preg_replace('/[^0-9]/', '', $data['inv_payment']);
        if($data['payment-option'] == 'partial-pay'){
            $detail->must_pay = (INT)$detail->inv_total - (INT)$detail->inv_payment;
            if($data['inv_payment'] >= $detail->must_pay){
                return redirect()->back()->with('danger', 'Jumlah Pembayaran Lebih Dari Atau Sama Dengan Tagihan');
            }
        }
        $data['inv_pay'] = (INT)$data['inv_payment'] + (INT)$detail->inv_payment;
        DB::beginTransaction();
        $update = Roasting::where('id', $id)->update([
            'inv_payment' => $data['inv_pay'],
            'inv_payment_date' => date('Y-m-d'),
            'inv_payment_type' => $data['inv_payment_type'],
            'status_payment' => ($data['inv_pay'] == $detail->inv_total) ? 'paid' : 'unpaid'
        ]);
        if ($update){
            DB::commit();
            return redirect('roasting-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function set($id)
    {
        $detail = DB::table('roasting AS s')
                ->leftJoin('vendor AS c', 'c.id', '=', 's.vendor')
                ->select('s.*',
                        'c.name AS vendor_name')
                ->where(['s.id' => $id])
                ->first();
        $data = [
            'detail' => $detail,
            'date' => date('d-m-Y', strtotime($detail->date))
        ];
        return view('web.admin.roasting.set', $data);
    }

    public function setup(Request $request, $id)
    {
        $data = $request->only('inv_expedition', 'inv_discount');
        DB::beginTransaction();
        $update = Roasting::where('id', $id)->update([
            'inv_expedition' => preg_replace('/[^0-9]/', '', $data['inv_expedition']),
            'inv_discount' => preg_replace('/[^0-9]/', '', $data['inv_discount'])
        ]);
        if ($update){
            DB::commit();
            return redirect('roasting-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function delete($id)
    {
        $data = Roasting::find($id);
        if (is_null($data)){
            return redirect('roasting-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('roasting-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('roasting-list')->with('success','Data has been deleted.');
        }
    }
}
