<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Invest;
use App\Models\InvestPayment;
use Illuminate\Support\Facades\Auth;

class InvestController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('invest')
                    ->select('*')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('invest')
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
            $view = view('web.admin.invest.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.invest.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('invest')
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
        $data = ['param_url' => (isset($_GET['purchasing'])) ? $_GET['purchasing']:''];
        return view('web.admin.invest.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'start_date' => 'required',
            'due_date' => 'required',
            'total_invest' => 'required',
            'margin' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        DB::beginTransaction();
        $insert = Invest::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'start_date' => date('Y-m-d', strtotime($data['start_date'])),
            'due_date' => date('Y-m-d', strtotime($data['due_date'])),
            'total_invest' => preg_replace('/[^0-9]/', '', $data['total_invest']),
            'total_payment' => 0,
            'margin' => $data['margin']
        ]);
        if ($insert){
            DB::commit();
            return redirect('invest-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $detail = Invest::where(['id' => $id])->first();
        $detail->underpayment = (INT)$detail->total_invest - (INT)$detail->total_payment;
        $contents = DB::table('invest_payment')
                    ->select('id as id_pay','total_payment as total_pay', 'payment_date as date_pay')
                    ->where(['invest_id' => $id])
                    ->orderBy('id', 'DESC')
                    ->get();
        if(!empty($contens)){
            foreach ($contents as $key => $value) {
                $value->date_pay = strtotime('d-m-Y', $value->date_pay);
            }
        }
        $data = [
            'detail' => $detail,
            'contents' => $contents
        ];

        return view('web.admin.invest.detail', $data);
    }

    public function edit($id)
    {
        $data = Invest::where(['id' => $id])->first();
        return view('web.admin.invest.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name', 'phone'), [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name', 'phone');
        DB::beginTransaction();
        $update = Invest::where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
        if ($update){
            DB::commit();
            return redirect('invest-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function payment($id)
    {
        $data = Invest::where(['id' => $id])->first();
        $data->payment_date = date('d-m-Y');
        $data->underpayment = (INT)$data->total_invest - (INT)$data->total_payment;
        return view('web.admin.invest.payment', $data);
    }

    public function pay(Request $request, $id)
    {
        $valid = validator($request->only('payment_date', 'total_payment', 'sum_payment'), [
            'payment_date' => 'required',
            'total_payment' => 'required',
            'sum_payment' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        $data['total_payment'] = preg_replace('/[^0-9]/', '', $data['total_payment']);
        DB::beginTransaction();
        $insert = InvestPayment::create([
            'invest_id' => $id,
            'payment_date' => $data['payment_date'],
            'total_payment' => $data['total_payment']
        ]);
        $update = $insert && Invest::where('id', $id)->update([
            'total_payment' => (INT)$data['total_payment'] + (INT)$data['sum_payment']
        ]);
        if ($update){
            DB::commit();
            return redirect('invest-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function payDelete()
    {
        $idpay = isset($_GET['id_pay']) ? $_GET['id_pay'] : "";
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $detail = invest::find($id);
        $data = InvestPayment::find($idpay);
        if(!empty($detail) && !empty($data)){
            $rbpayment = (INT)$detail->total_payment - (INT)$data->total_payment; 
        }else{
            $rbpayment = "";
        }
        if (is_null($data)){
            return redirect('invest-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('invest-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            Invest::where('id', $id)->update(['total_payment' => $rbpayment]);
            return redirect('invest-detail/'.$id)->with('success','Data has been deleted.');
        }
    }

    public function delete($id)
    {
        $data = Invest::find($id);
        if (is_null($data)){
            return redirect('invest-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('invest-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('invest-list')->with('success','Data has been deleted.');
        }
    }
}
