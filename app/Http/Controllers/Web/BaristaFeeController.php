<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\BaristaFee;
use App\Models\BaristaFeeEmployee;
use App\Models\Periode;
use App\Models\Employee;
use App\Models\Sales;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class BaristaFeeController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('barista_fee AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->select('sp.*', 'p.name AS periode')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('p.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('sp.id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('barista_fee AS sp')
                ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                ->where(function($contents) use ($search){
                    $contents->where('p.name', 'like', '%'.$search.'%');
                })
                ->orderBy('sp.id', 'DESC')
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
            $view = view('web.admin.barista_fee.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.barista_fee.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('barista_fee')
                    ->select('id', 'name AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function totalProfit(Request $request){
        $periode = Periode::where(['id' => $request->id])->first();
        $sales_total = Sales::where([
                            ['inv_date', '>=', $periode->start_date], 
                            ['inv_date', '<=', $periode->end_date], 
                            'inv_status' => 'publish',
                            'inv_status_payment' => 'paid'
                        ]);
        $sales_total = $sales_total->sum('inv_total');
        $sales_hpp = Sales::where([
                            ['inv_date', '>=', $periode->start_date], 
                            ['inv_date', '<=', $periode->end_date], 
                            'inv_status' => 'publish',
                            'inv_status_payment' => 'paid'
                        ]);
      
        $sales_hpp = $sales_hpp->sum('inv_hpp');
        $sales_expedition = Sales::where([
                            ['inv_date', '>=', $periode->start_date],
                            ['inv_date', '<=', $periode->end_date],
                            'inv_status' => 'publish',
                            'inv_status_payment' => 'paid'
                        ]);
        $sales_expedition = $sales_expedition->sum('inv_expedition');
        
        $data = ['sales_profit' => ((INT)$sales_total - (INT)$sales_expedition) - (INT)$sales_hpp];
        
        return response()->json($data);
    }

    public function calculate(Request $request){
        $emp = Employee::where(['id' => $request->id_employee])->first();
        $set = Setting::first();
        $periode = DB::table('barista_fee AS bf')
                    ->leftJoin('periode AS p', 'p.id', '=', 'bf.periode_id')
                    ->select('p.name as periode_name', 'p.start_date as periode_start', 'p.end_date as periode_end')
                    ->where(['bf.id' => $request->id_profit])
                    ->first();
        $jml_short =  DB::table('report_store AS rs')
                    ->select('rs.id')
                    ->where(['rs.employee_id' => $request->id_employee, ['rs.date', '>=', $periode->periode_start], ['rs.date', '<=', $periode->periode_end]])
                    ->whereIn('rs.shift_id', ['1', '4'])
                    ->count();
        $jml_long =  DB::table('report_store AS rs')
                    ->select('rs.id')
                    ->where(['rs.employee_id' => $request->id_employee, ['rs.date', '>=', $periode->periode_start], ['rs.date', '<=', $periode->periode_end]])
                    ->whereIn('rs.shift_id', ['2', '3'])
                    ->count();
        $fee_short = (INT)$set->barista_fee_short * (INT)$jml_short;
        $fee_long = (INT)$set->barista_fee_long * (INT)$jml_long;
        $fee_total = (INT)$fee_short + (INT)$fee_long;
        $data = [
            'shift_short' => $jml_short,
            'shift_long' => $jml_long,
            'percent_share' => $fee_total
        ];
        
        return response()->json($data);
    }

    public function comboPeriod(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('periode')
                    ->select('id', 'name AS text')
                    ->whereNotIn('id', function($query) {
                        $query->select('periode_id')->from('barista_fee');
                    })
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add()
    {
        
        $data = [
            'param_url' => (isset($_GET['purchasing'])) ? $_GET['purchasing']:'',
            'periode' => Periode::all()
        ];
        return view('web.admin.barista_fee.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->all(), [
            'periode_id' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        DB::beginTransaction();
        $insert = BaristaFee::create([
            'periode_id' => $data['periode_id'],
            'total_fee' => 0,
            'total_potongan' => 0,
            'total_share' => 0,
            'desc' => $data['desc'],
            'status' => 'Draft',
            'athor' => Auth::user()->id
        ]);
        if ($insert){
            DB::commit();
            return redirect('barista-fee-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $detail = DB::table('barista_fee AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->select('sp.*', 'p.name AS periode')
                    ->where(['sp.id' => $id])
                    ->first();
        $detail->sisa_profit = (INT)$detail->total_fee - ((INT)$detail->total_potongan + (INT)$detail->total_share);
        $contents = DB::table('barista_fee_employee AS spe')
                    ->leftJoin('employee AS e', 'e.id', '=', 'spe.employee_id')
                    ->select('spe.*', 'e.name as employee')
                    ->where(['spe.bf_id' => $id])
                    ->orderBy('id', 'DESC')
                    ->get();
        // if(!empty($contens)){
        //     foreach ($contents as $key => $value) {
        //         $value->date_pay = strtotime('d-m-Y', $value->date_pay);
        //     }
        // }
        $data = [
            'detail' => $detail,
            'contents' => $contents
        ];

        return view('web.admin.barista_fee.detail', $data);
    }

    public function person($id)
    {
        
        $set = Setting::first();
        $bfid = (isset($_GET['mid'])) ? $_GET['mid'] : "";
        $detail = DB::table('barista_fee AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->select('sp.*', 'p.name AS periode')
                    ->where(['sp.id' => $bfid])
                    ->first();

        $person = DB::table('barista_fee_employee AS spe')
                    ->leftJoin('employee AS e', 'e.id', '=', 'spe.employee_id')
                    ->select('spe.*', 'e.name as employee', 'e.position as position')
                    ->where(['spe.id' => $id])
                    ->first();
        $person->fee_short = (INT)$set->barista_fee_short * (INT)$person->shift_short;
        $person->fee_long = (INT)$set->barista_fee_long * (INT)$person->shift_long;
        $data = [
            'detail' => $detail,
            'person' => $person,
            'set' => $set
        ];
        return view('web.admin.barista_fee.person', $data);
    }

    public function printslip($id)
    {
        $set = Setting::first();
        $bfid = (isset($_GET['mid'])) ? $_GET['mid'] : "";
        $detail = DB::table('barista_fee AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->select('sp.*', 'p.name AS periode')
                    ->where(['sp.id' => $bfid])
                    ->first();

        $person = DB::table('barista_fee_employee AS spe')
                    ->leftJoin('employee AS e', 'e.id', '=', 'spe.employee_id')
                    ->select('spe.*', 'e.name as employee', 'e.position as position')
                    ->where(['spe.id' => $id])
                    ->first();
        $person->fee_short = (INT)$set->barista_fee_short * (INT)$person->shift_short;
        $person->fee_long = (INT)$set->barista_fee_long * (INT)$person->shift_long;
        $data = [
            'detail' => $detail,
            'person' => $person,
            'set' => $set
        ];
        //return $data;die;
        
        $pdf = Pdf::loadView('web.admin.barista_fee.printslip', $data);
        $pdf->set_paper('LEGAL', 'potrait');
        return $pdf->stream(strtoupper(str_replace(" ", "-", $person->employee)).'-'.str_replace("/", "-", $detail->periode).'.pdf', array("Attachment" => false));
        
        //return view('web.admin.sales.print', $data);
    }

    public function edit($id)
    {
        $data = BaristaFee::where(['id' => $id])->first();
        return view('web.admin.barista_fee.edit', $data);
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
        $update = BaristaFee::where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
        if ($update){
            DB::commit();
            return redirect('barista-fee-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function share($id)
    {
        $profit = BaristaFee::where(['id' => $id])->first();
        $data = [
            'profit' => $profit,
            'employee' => Employee::all()
        ];
        return view('web.admin.barista_fee.share', $data);
    }

    public function shareCreate(Request $request, $id)
    {
        $valid = validator($request->only('employee_id', 'shift_short', 'shift_long', 'sub_total', 'total'), [
            'employee_id' => 'required',
            'shift_short' => 'required',
            'shift_long' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        
        $check = BaristaFeeEmployee::where([
                    'employee_id' => $data['employee_id'],
                    'bf_id' => $id
                ])->count();
        if($check > 0){
            return redirect('barista-fee-share/'.$id)->with('danger','Error! Sorry your data already exists');
        }
        DB::beginTransaction();
        $insert = BaristaFeeEmployee::create([
            'bf_id' => $id,
            'employee_id' => $data['employee_id'],
            'shift_short' => str_replace('.', "", $data['shift_short']),
            'shift_long' => str_replace('.', "", $data['shift_long']),
            'sub_total' => str_replace('.', "", $data['sub_total']),
            'potongan' => str_replace('.', "", $data['potongan']),
            'total' => str_replace('.', "", $data['total']),
            'desc' => $data['desc'],
            'payment_status' => 'paid',
            'payment_date' => date('Y-m-d'),
            'author' => Auth::user()->id
        ]);
        $bf = BaristaFee::where('id', $id)->first();
        $result = $insert && BaristaFee::where('id', $id)->update([
            'total_potongan' => (INT)$bf->total_potongan + (INT)str_replace('.', "", $data['potongan']),
            'total_share' => (INT)$bf->total_share + (INT)str_replace('.', "", $data['total']),
            'total_fee' => (INT)$bf->total_fee + ((INT)str_replace('.', "", $data['total']) + (INT)str_replace('.', "", $data['potongan'])),
        ]);
        if ($result){
            DB::commit();
            return redirect('barista-fee-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function publish($id)
    {
        DB::beginTransaction();
        $update = BaristaFee::where('id', $id)->update([
            'status' => 'Published'
        ]);
        if ($update){
            DB::commit();
            return redirect('barista-fee-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }


    public function delete($id)
    {
        $data = BaristaFee::find($id);
        if (is_null($data)){
            return redirect('barista-fee-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('barista-fee-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('barista-fee-list')->with('success','Data has been deleted.');
        }
    }
}
