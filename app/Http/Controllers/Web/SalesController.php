<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;
use App\Models\Customer;
use App\Models\SalesItem;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $startdate = (isset($_GET['startdate'])) ? $_GET['startdate'] : "";
        $enddate = (isset($_GET['enddate'])) ? $_GET['enddate'] : "";
        $author = (isset($_GET['author'])) ? $_GET['author'] : "";
        $contents = DB::table('sales AS s')
                    ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                    ->leftJoin('users AS u', 'u.id', '=', 's.author')
                    ->select('s.*', 'c.name AS cust_name', 'u.name AS inv_author')
                    ->where(['s.inv_status_payment' => 'unpaid'])
                    ->where(function($contents) use ($search){
                        $contents->where('s.inv_code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    });
        if(!empty($startdate)){
            $contents = $contents->where('s.inv_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if(!empty($enddate)){
            $contents = $contents->where('s.inv_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if(!empty($author)){
            $contents = $contents->where(['s.author' => $author]);
        }
        if (Gate::denies('isAdmin')){
            $contents = $contents->where(['s.author' => Auth::user()->id]);
        }
        $contents = $contents->orderBy('s.inv_date', 'DESC')->orderBy('s.id', 'DESC')->paginate($limit);

        $counts = DB::table('sales AS s')
                    ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                    ->leftJoin('users AS u', 'u.id', '=', 's.author')
                    ->select('s.inv_id')
                    ->where(['s.inv_status_payment' => 'unpaid'])
                    ->where(function($contents) use ($search){
                        $contents->where('s.inv_code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    });
        if(!empty($startdate)){
            $counts = $counts->where('s.inv_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if(!empty($enddate)){
            $counts = $counts->where('s.inv_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if(!empty($author)){
            $counts = $counts->where(['s.author' => $author]);
        }
        if (Gate::denies('isAdmin')){
            $counts = $counts->where(['s.author' => Auth::user()->id]);
        }
        $counts = $counts->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->inv_date = date('d M Y', strtotime($value->inv_date));
                if($value->inv_status_payment == 'unpaid' && $value->inv_payment > 0){
                    $value->status_payment = 'Bayar Sebagian';
                }else{
                    $value->status_payment = '';
                }
            }
        }
        $data = [
            'keyword' => $search,
            'author_filtered' => $author,
            'startdate_filtered' => $startdate,
            'enddate_filtered' => $enddate,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts,
            'author' => User::all()
        ];
        if($request->ajax()){
            $view = view('web.admin.sales.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.sales.list', $data);
    }

    public function listPaid(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $startdate = (isset($_GET['startdate'])) ? $_GET['startdate'] : "";
        $enddate = (isset($_GET['enddate'])) ? $_GET['enddate'] : "";
        $author = (isset($_GET['author'])) ? $_GET['author'] : "";
        $contents = DB::table('sales AS s')
                    ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                    ->leftJoin('users AS u', 'u.id', '=', 's.author')
                    ->select('s.*', 'c.name AS cust_name', 'u.name AS inv_author')
                    ->where(['s.inv_status_payment' => 'paid'])
                    ->where(function($contents) use ($search){
                        $contents->where('s.inv_code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    });
        if(!empty($startdate)){
            $contents = $contents->where('s.inv_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if(!empty($enddate)){
            $contents = $contents->where('s.inv_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if(!empty($author)){
            $contents = $contents->where(['s.author' => $author]);
        }
        if (Gate::denies('isAdmin')){
            $contents = $contents->where(['s.author' => Auth::user()->id]);
        }
        $contents = $contents->orderBy('s.inv_date', 'DESC')->paginate($limit);

        $counts = DB::table('sales AS s')
                    ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                    ->leftJoin('users AS u', 'u.id', '=', 's.author')
                    ->select('s.inv_id')
                    ->where(['s.inv_status_payment' => 'paid'])
                    ->where(function($contents) use ($search){
                        $contents->where('s.inv_code', 'like', '%'.$search.'%')
                                ->orWhere('c.name', 'like', '%'.$search.'%');
                    });
        if(!empty($startdate)){
            $counts = $counts->where('s.inv_date', '>=', date('Y-m-d', strtotime($startdate)));
        }
        if(!empty($enddate)){
            $counts = $counts->where('s.inv_date', '<=', date('Y-m-d', strtotime($enddate)));
        }
        if(!empty($author)){
            $counts = $counts->where(['s.author' => $author]);
        }
        if (Gate::denies('isAdmin')){
            $counts = $counts->where(['s.author' => Auth::user()->id]);
        }
        $counts = $counts->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->inv_date = date('d M Y', strtotime($value->inv_date));
                if($value->inv_status_payment = 'paid'){
                    $value->inv_status_color = 'success';
                    $value->inv_status_label = 'Paid'; 
                }else{
                    $value->inv_status_color = 'danger';
                    $value->inv_status_label = 'Unpaid'; 
                }
            }
        }
        $data = [
            'keyword' => $search,
            'author_filtered' => $author,
            'startdate_filtered' => $startdate,
            'enddate_filtered' => $enddate,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts,
            'author' => User::all()
        ];
        if($request->ajax()){
            $view = view('web.admin.sales.paginate_paid', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.sales.list_paid', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('sales')
                    ->select('id', 'inv_code AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('inv_code', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('inv_code', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        $data = [
            'inv_code' => 'INV/TC'.date('y').'/'.date('mdhis'),
            'date' => date('d-m-Y'),
            'customer' => Customer::all()
        ];
        return view('web.admin.sales.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('inv_category', 'inv_code', 'inv_date', 'inv_cust'), [
            'inv_category' => 'required',
            'inv_code' => 'required',
            'inv_date' => 'required',
            'inv_cust' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('inv_category', 'inv_code', 'inv_date', 'inv_cust');
        DB::beginTransaction();
        $insert = Sales::create([
            'inv_category' => $data['inv_category'],
            'inv_code' => $data['inv_code'],
            'inv_date' => date('Y-m-d', strtotime($data['inv_date'])),
            'inv_cust' => $data['inv_cust'],
            'inv_expedition' => 0,
            'inv_total' => 0,
            'inv_status_payment' => 'unpaid',
            'inv_status' => 'Draft',
            'author' => Auth::user()->id
        ]);
        if ($insert){
            $cst = Customer::where(['id' => $data['inv_cust']])->first();
            $msg = $this->usertanjoe()->name." Membuat Invoice Baru\n".
                    "invoice Code : ".$data['inv_code']."\n".
                    "Nama Customer : ".$cst->name."\n".
                    date('d M Y', strtotime($data['inv_date']))."\n".
                    "https://www.app.tanjoecoffee.com/sales-detail/".$insert->id;
            $this->sendtele($msg);
            DB::commit();
            return redirect('sales-detail/'.$insert->id)->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail(Request $request, $id)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('sales_items AS s')
                    ->leftJoin('product AS p', 'p.id', '=', 's.itm_product')
                    ->select('s.*', 'p.name AS product_name', 'p.price AS product_price', 'p.price_hpp AS price_hpp')
                    ->where(['s.itm_inv_id' => $id])
                    ->where(function($contents) use ($search){
                        $contents->where('p.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('sales_items AS s')
                ->leftJoin('product AS p', 'p.id', '=', 's.itm_product')
                ->select('s.id')
                ->where(['s.itm_inv_id' => $id])
                ->where(function($contents) use ($search){
                    $contents->where('p.name', 'like', '%'.$search.'%');
                })
                ->orderBy('id', 'DESC')
                ->count();

        if(!empty($contents)){
            $itm_total = 0;
            $itm_hpp = 0;
            foreach ($contents as $key => $value) {
                $itm_total += $value->itm_total;
                $itm_hpp += (INT)$value->price_hpp * (FLOAT)$value->itm_qty;
            }
        }
        $detail = DB::table('sales AS s')
            ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
            ->select('s.*',
                    'c.name AS cust_name')
            ->where(['s.id' => $id])
            ->first();
        $detail->must_pay = (INT)$detail->inv_total - (INT)$detail->inv_payment;
        
        $data = [
            'invoice' => $detail,
            'inv_hpp' => $itm_hpp,
            'inv_sub_total' => $itm_total,
            'inv_total' => (INT)$itm_total - (INT)$detail->inv_discount + (INT)$detail->inv_expedition,
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.sales_items.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }

        return view('web.admin.sales.detail', $data);
    }

    public function edit($id)
    {
        $detail = Sales::where(['id' => $id])->first();
        $data = [
            'detail' => $detail,
            'customer' => Customer::all(),
            'inv_date' => date('d-m-Y', strtotime($detail->inv_date))
        ];
        return view('web.admin.sales.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('inv_category','inv_code', 'inv_date', 'inv_cust'), [
            'inv_category' => 'required',
            'inv_code' => 'required',
            'inv_date' => 'required',
            'inv_cust' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('inv_category', 'inv_code', 'inv_date', 'inv_cust');
        DB::beginTransaction();
        $update = Sales::where('id', $id)->update([
            'inv_category' => $data['inv_category'],
            'inv_code' => $data['inv_code'],
            'inv_date' => date('Y-m-d', strtotime($data['inv_date'])),
            'inv_cust' => $data['inv_cust'],
            'author' => Auth::user()->id
        ]);
        if ($update){
            DB::commit();
            return redirect('sales-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
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
        $update = Sales::where('id', $id)->update([
            'inv_hpp' => $data['inv_hpp'],
            'inv_sub_total' => $data['inv_sub_total'],
            'inv_discount' => !empty($data['inv_discount']) ? $data['inv_discount'] : 0,
            'inv_expedition' => !empty($data['inv_expedition']) ? $data['inv_expedition'] : 0,
            'inv_total' => $data['inv_total']
        ]);
        if ($update){
            DB::commit();
            return redirect('sales-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function publish($id)
    {
        DB::beginTransaction();
        $update = Sales::where('id', $id)->update([
            'inv_status' => 'Publish'
        ]);
        if ($update){
            DB::commit();
            return redirect('sales-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function drafting($id)
    {
        DB::beginTransaction();
        $update = Sales::where('id', $id)->update([
            'inv_status' => 'Draft'
        ]);
        if ($update){
            DB::commit();
            return redirect('sales-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function print($id)
    {
        $detail = DB::table('sales AS s')
            ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
            ->select('s.*',
                    'c.name AS cust_name')
            ->where(['s.id' => $id])
            ->first();
        $detail->inv_expedition = (!empty($detail->inv_expedition)) ? $detail->inv_expedition : 0;
        $detail->must_pay = (INT)$detail->inv_total - (INT)$detail->inv_payment;
        $product = DB::table('sales_items AS s')
            ->leftJoin('product AS p', 'p.id', '=', 's.itm_product')
            ->select('s.*', 'p.name AS product_name', 'p.price AS product_price', 'p.summary AS product_desc')
            ->where(['s.itm_inv_id' => $id])
            ->orderBy('id', 'DESC')
            ->get();

        foreach($product as $key => $v) {
            $v->disc = ((INT)$v->product_price - (INT)$v->itm_price) * (INT)$v->itm_qty;
            $v->product_disc = ($v->disc < 0) ? 0 : $v->disc;
        }
            
        $data = [
            'detail' => $detail,
            'item' => $product
        ];
        
        $pdf = Pdf::loadView('web.admin.sales.print', $data);
        $pdf->set_paper('LEGAL', 'potrait');
        return $pdf->stream(strtoupper(str_replace(" ", "-", $detail->cust_name)).'-'.str_replace("/", "-", $detail->inv_code).'.pdf', array("Attachment" => false));
        
        //return view('web.admin.sales.print', $data);
    }

    public function payment($id)
    {
        $detail = DB::table('sales AS s')
                ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                ->select('s.*',
                        'c.name AS cust_name')
                ->where(['s.id' => $id])
                ->first();
        $detail->must_pay = $detail->inv_total - $detail->inv_payment;
        $data = [
            'detail' => $detail,
            'inv_date' => date('d-m-Y', strtotime($detail->inv_date))
        ];
        return view('web.admin.sales.payment', $data);
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
        
        $detail =  DB::table('sales AS s')
            ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
            ->select('s.*',
                    'c.name AS cust_name')
            ->where(['s.id' => $id])
            ->first();
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
        $update = Sales::where('id', $id)->update([
            'inv_payment' => $data['inv_pay'],
            'inv_payment_date' => date('Y-m-d'),
            'inv_payment_type' => $data['inv_payment_type'],
            'inv_status_payment' => ($data['inv_pay'] == $detail->inv_total) ? 'paid' : 'unpaid'
        ]);
        if ($update){
            $msg = $this->usertanjoe()->name." Mengubah Status Pembayaran\n".
                    "invoice Code : ".$detail->inv_code."\n".
                    "Nama Customer : ".$detail->cust_name."\n".
                    "Tanggal Bayar : ".date('d M Y', strtotime(date('Y-m-d')))."\n".
                    "Tipe Pembayaran : ".$data['payment-option'].' ('.$data['inv_payment_type'].")\n".
                    "Rp ".str_replace(",", ".", number_format($data['inv_pay']))."\n".
                    "https://www.app.tanjoecoffee.com/sales-detail/".$id;
            $this->sendtele($msg);
            DB::commit();
            return redirect('sales-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function set($id)
    {
        $detail = DB::table('sales AS s')
                ->leftJoin('customer AS c', 'c.id', '=', 's.inv_cust')
                ->select('s.*',
                        'c.name AS cust_name')
                ->where(['s.id' => $id])
                ->first();
        $data = [
            'detail' => $detail,
            'inv_date' => date('d-m-Y', strtotime($detail->inv_date))
        ];
        return view('web.admin.sales.set', $data);
    }

    public function setup(Request $request, $id)
    {
        $data = $request->only('inv_expedition', 'inv_discount', 'inv_desc');
        DB::beginTransaction();
        $update = Sales::where('id', $id)->update([
            'inv_expedition' => preg_replace('/[^0-9]/', '', $data['inv_expedition']),
            'inv_discount' => preg_replace('/[^0-9]/', '', $data['inv_discount']),
            'inv_desc' => $data['inv_desc']
        ]);
        if ($update){
            DB::commit();
            return redirect('sales-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function delete($id)
    {
        $data = Sales::find($id);
        $cek_item = SalesItem::where('itm_inv_id', $id)->count();
        if($cek_item > 0){
            return redirect('sales-detail/'.$id)->with('danger','Tidak dapat menghapus invoice, Mohon hapus Item Produk terlebih dahulu');
        }
        if (is_null($data)){
            return redirect('sales-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('sales-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('sales-list')->with('success','Data has been deleted.');
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
}
