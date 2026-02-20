<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\ReportStore;
use App\Models\SpendingStore;
use App\Models\Employee;
use App\Models\ShiftStore;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportStoreController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('report_store AS rs')
                    ->leftJoin('employee AS e', 'e.id', '=', 'rs.employee_id')
                    ->leftJoin('shift_store AS sf', 'sf.id', '=', 'rs.shift_id')
                    ->select('rs.*', 'e.name AS emp_name', 'sf.name AS shift_name')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('e.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('rs.date', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('report_store AS rs')
                    ->leftJoin('employee AS e', 'e.id', '=', 'rs.employee_id')
                    ->select('rs.id')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('e.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('rs.date', 'DESC')
                    ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->date = date('d M Y', strtotime($value->date));
                if($value->status == 'verified'){
                    $value->status_color = 'danger';
                    $value->status_label = 'Verified';
                }elseif($value->status == 'reported'){
                    $value->status_color = 'success';
                    $value->status_label = 'Reported';
                }else{
                    $value->status_color = 'dark';
                    $value->status_label = 'Draft';
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
            $view = view('web.agent.report_store.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.agent.report_store.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('report_store')
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
            'employee' => Employee::all(),
            'shift' => ShiftStore::all()
        ];
        return view('web.agent.report_store.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('employee_id', 'shift_id', 'date', 'cash', 'qris'), [
            'date' => 'required',
            'employee_id' => 'required',
            'shift_id' => 'required',
            'cash' => 'required',
            'qris' => 'required'
        ]);
        
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('cash', 'qris', 'date', 'employee_id', 'shift_id');
        DB::beginTransaction();
        $cash = preg_replace('/[^0-9]/', '', $data['cash']);
        $qris = preg_replace('/[^0-9]/', '', $data['qris']);
        $total = (FLOAT)$cash + (FLOAT)$qris;
        $insert = ReportStore::create([
            'date' => date('Y-m-d', strtotime($data['date'])),
            'employee_id' => $data['employee_id'],
            'shift_id' => $data['shift_id'],
            'cash' => $cash,
            'qris' => $qris,
            'total' => $total,
            'status' => 'draft',
            'author' => Auth::user()->id
        ]);
        if ($insert){
            DB::commit();
            return redirect('report-store-detail/'.$insert->id)->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function spendingAdd($id)
    {
        $data = ['report_id' => $id];
        return view('web.agent.report_store.spending_add', $data);
    }

    public function SpendingCreate(Request $request)
    {
        $valid = validator($request->only('report_id', 'product', 'price', 'qty', 'total'), [
            'report_id' => 'required',
            'product' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'total' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('report_id', 'product', 'price', 'qty', 'total');
        DB::beginTransaction();
        $insert = SpendingStore::create([
            'report_id' => $data['report_id'],
            'product' => $data['product'],
            'price' => str_replace('.', "", $data['price']),
            'qty' => $data['qty'],
            'total' => str_replace('.', "", $data['total'])
        ]);
        if ($insert){
            DB::commit();
            return redirect('report-store-detail/'.$data['report_id'])->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $contents = DB::table('spending_store')
                    ->select('*')
                    ->where(['report_id' => $id])
                    ->orderBy('id', 'DESC')
                    ->get();
        if(!empty($contents)){
            $total_spent = 0;
            foreach ($contents as $key => $value) {
                $total_spent += $value->total;
            }
        }

        $detail = DB::table('report_store AS rs')
            ->leftJoin('employee AS e', 'e.id', '=', 'rs.employee_id')
            ->leftJoin('shift_store AS sf', 'sf.id', '=', 'rs.shift_id')
            ->select('rs.*', 'e.name AS emp_name', 'sf.name AS shift_name')
            ->where(['rs.id' => $id])
            ->first();
        $detail->total = (INT)$detail->cash + (INT)$detail->qris;
        $detail->pay = (INT)$detail->cash - (INT)$total_spent;
        $detail->total_final = (INT)$detail->total - (INT)$total_spent;
        $data = [
            'report_store' => $detail,
            'spending' => $total_spent,
            'contents' => $contents
        ];

        return view('web.agent.report_store.detail', $data);
    }

    public function edit($id)
    {
        $detail = ReportStore::where(['id' => $id])->first();
        $data = [
            'detail' => $detail,
            'employee' => Employee::all(),
            'date' => date('d-m-Y', strtotime($detail->date))
        ];
        return view('web.agent.report_store.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('cash','qris', 'date', 'employee_id'), [
            'cash' => 'required',
            'qris' => 'required',
            'date' => 'required',
            'employee_id' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('cash', 'qris', 'date', 'employee_id');
        DB::beginTransaction();
        $update = ReportStore::where('id', $id)->update([
            'cash' => preg_replace('/[^0-9]/', '', $data['cash']),
            'qris' => preg_replace('/[^0-9]/', '', $data['qris']),
            'date' => date('Y-m-d', strtotime($data['date'])),
            'employee_id' => $data['employee_id'],
            'author' => Auth::user()->id
        ]);
        if ($update){
            DB::commit();
            return redirect('report-store-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function spendingDetail($id)
    {
        if(isset($_GET['rpt'])){
            $rptid = $_GET['rpt'];
        }

        $detail = DB::table('spending_store AS rs')
            ->select('rs.*')
            ->where(['rs.id' => $id, 'rs.report_id' => $rptid])
            ->first();
        $data = ['detail' => $detail];
        return view('web.agent.report_store.spending_detail', $data);
    }

    public function updateFinal(Request $request, $id)
    {
        $valid = validator($request->only('total', 'pay', 'spending'), [
            'pay' => 'required',
            'total' => 'required',
            'spending' => 'required'
        ]);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('total', 'pay', 'spending');
        DB::beginTransaction();
        $update = ReportStore::where('id', $id)->update([
            'spending' => $data['spending'],
            'pay' => $data['pay'],
            'total' => $data['total'],
            'is_saved' => 'true'
        ]);
        if ($update){
            DB::commit();
            return redirect('report-store-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function publish($id)
    {
        DB::beginTransaction();
        $update = ReportStore::where('id', $id)->update([
            'status' => 'reported'
        ]);
        if ($update){
            DB::commit();
            return redirect('report-store')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function verification($id)
    {
        DB::beginTransaction();
        $update = ReportStore::where('id', $id)->update([
            'status' => 'verified'
        ]);
        if ($update){
            DB::commit();
            return redirect('report-store')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function payment($id)
    {
        $detail = DB::table('report_store AS s')
                ->leftJoin('vendor AS c', 'c.id', '=', 's.employee_id')
                ->select('s.*', 'c.name AS vendor_name')
                ->where(['s.id' => $id])
                ->first();
        $detail->must_pay = $detail->qris - $detail->pur_payment;
        $data = [
            'detail' => $detail,
            'date' => date('d-m-Y', strtotime($detail->date))
        ];
        return view('web.agent.report_store.payment', $data);
    }

    public function delete($id)
    {
        $data = ReportStore::find($id);
        if (is_null($data)){
            return redirect('report-store-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('report-store-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('report-store')->with('success','Data has been deleted.');
        }
    }

    public function spendingDelete($id)
    {
        if(isset($_GET['rpt'])){
            $rpt_id = $_GET['rpt'];
        }
        $data = SpendingStore::find($id);
        if (is_null($data)){
            return redirect('report-store-detail/'.$rpt_id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('report-store-detail/'.$rpt_id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('report-store-detail/'.$rpt_id)->with('success','Data has been deleted.');
        }
    }
}
