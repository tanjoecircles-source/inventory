<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\ShareProfit;
use App\Models\ShareProfitSpending;
use App\Models\ShareProfitEmployee;
use App\Models\Periode;
use App\Models\Employee;
use App\Models\Sales;
use App\Models\StoreRecap;
use App\Models\BeanRecap;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ShareProfitController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('share_profit AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->select('sp.*', 'p.name AS periode')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('p.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('sp.id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('share_profit AS sp')
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
            $view = view('web.admin.share_profit.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.share_profit.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('share_profit')
                    ->select('id', 'name AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function calculate(Request $request){
        //calculate toko kopi
        $store_recap = StoreRecap::where(['periode_id' => $request->id, 'status' => 'Verified'])->first();
        $profit_toko = (!empty($store_recap)) ? $store_recap->profit : 0;
        //calculate cofee bean
        $bean_recap = BeanRecap::where(['periode_id' => $request->id, 'status' => 'Verified'])->first();
        $profit_bean = (!empty($bean_recap)) ? (INT)$bean_recap->profit - (INT)$bean_recap->total_potongan : 0;
        $potongan_non_investor = (!empty($bean_recap)) ? (INT)$bean_recap->potongan_non_investor : 0;
        $data = [
            'profit_toko' => $profit_toko,
            'profit_bean' => $profit_bean,
            'potongan_non_investor' => $potongan_non_investor
        ];
        
        return response()->json($data);
    }

    public function emppart(Request $request){
        $emp = Employee::where(['id' => $request->id_employee])->first();
        $owner = Employee::where(['category' => 'Owner'])->count();
        $profit = ShareProfit::where(['id' => $request->id_profit])->first();
        $sub_share = ((FLOAT)$emp->percent_share / 100 * (INT)$profit->total_profit);
        if($emp->category == 'Owner'){
            $tabungan_credit = (INT)$profit->potongan_non_investor / (INT)$owner;
        }else{
            $tabungan_credit = 0;
        }
        $data = [
            'sub_share' => round($sub_share),
            'tabungan_credit' => $tabungan_credit,
            'total_share' => (INT)$sub_share - (INT)$tabungan_credit
        ];
        
        return response()->json($data);
    }

    public function add()
    {
        $period = Periode::whereNotIn('id', function($query) {
                    $query->select('periode_id')->from('share_profit');
                })->orderBy('id', 'desc')->get();
        $data = [
            'period' => $period,
            'param_url' => (isset($_GET['purchasing'])) ? $_GET['purchasing']:''
        ];
        return view('web.admin.share_profit.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->all(), [
            'periode_id' => 'required',
            'profit_toko' => 'required',
            'potongan_non_investor' => 'required',
            'profit_bean' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        $profit_toko = str_replace('.', '', $data['profit_toko']);
        $potongan_non_investor = $data['potongan_non_investor'];
        $profit_bean = str_replace('.', '', $data['profit_bean']);
        $total_profit = (INT)$profit_toko + (INT)$profit_bean;
        DB::beginTransaction();
        $insert = ShareProfit::create([
            'periode_id' => $data['periode_id'],
            'profit_toko' => $profit_toko,
            'potongan_non_investor' => $potongan_non_investor,
            'profit_bean' => $profit_bean,
            'total_profit' => $total_profit,
            'total_share' => 0,
            'desc' => $data['desc'],
            'status' => 'Draft',
            'athor' => Auth::user()->id
        ]);
        if ($insert){
            DB::commit();
            return redirect('share-profit-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $detail = DB::table('share_profit AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->select('sp.*', 'p.name AS periode')
                    ->where(['sp.id' => $id])
                    ->first();

        $sql = DB::table('share_profit_employee AS spe')
                    ->leftJoin('employee AS e', 'e.id', '=', 'spe.employee_id')
                    ->select('spe.*', 'e.name as employee')
                    ->where(['spe.sp_id' => $id]);
        $contents = $sql->orderBy('id', 'DESC')->get();
        $detail->potongan = $sql->sum('potongan');
        $detail->balanced = (INT)$detail->total_profit - ((INT)$detail->total_share + (INT)$detail->potongan);
        $detail->balanced = max(0, $detail->balanced);
        $data = [
            'detail' => $detail,
            'contents' => $contents
        ];

        return view('web.admin.share_profit.detail', $data);
    }

    public function edit($id)
    {
        $data = ShareProfit::where(['id' => $id])->first();
        return view('web.admin.share_profit.edit', $data);
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
        $update = ShareProfit::where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'],
        ]);
        if ($update){
            DB::commit();
            return redirect('share-profit-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function share($id)
    {
        $profit = ShareProfit::where(['id' => $id])->first();
        $data = [
            'profit' => $profit,
            'employee' => Employee::all()
        ];
        return view('web.admin.share_profit.share', $data);
    }

    public function shareCreate(Request $request, $id)
    {
        $valid = validator($request->only('employee_id', 'sub_total', 'total'), [
            'employee_id' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        
        $check = ShareProfitEmployee::where([
                    'employee_id' => $data['employee_id'],
                    'sp_id' => $id
                ])->count();
        if($check > 0){
            return redirect('share-profit-share/'.$id)->with('danger','Error! Sorry your data already exists');
        }
        
        $emp = Employee::where(['id' => $data['employee_id']])->first();
        DB::beginTransaction();
        $insert = ShareProfitEmployee::create([
            'sp_id' => $id,
            'employee_id' => $data['employee_id'],
            'sub_total' => str_replace('.', "", $data['sub_total']),
            'tabungan_credit' => str_replace('.', "", $data['tabungan_credit']),
            'potongan' => str_replace('.', "", $data['potongan']),
            'total' => str_replace('.', "", $data['total']),
            'desc' => $data['desc'],
            'payment_status' => 'unpaid',
            'author' => Auth::user()->id
        ]);
        $profit = ShareProfit::where('id', $id)->first();
        $result = ShareProfit::where('id', $id)->update([
            'total_share' => (INT)$profit->total_share + (INT)str_replace('.', "", $data['total'])+ (INT)str_replace('.', "", $data['tabungan_credit'])
        ]);

        if ($insert && $result){
            DB::commit();
            return redirect('share-profit-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function shareDelete($id)
    {   
        $mid = isset($_GET['mid']) ? $_GET['mid'] : '';
        $data = ShareProfitEmployee::find($id);
        if (is_null($data)){
            return redirect('share-profit-detail/'.$mid)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('share-profit-detail/'.$mid)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('share-profit-detail/'.$mid)->with('success','Data has been deleted.');
        }
    }

    public function spending($id)
    {   
        $data['id'] = $id;
        return view('web.admin.share_profit.spending', $data);
    }

    public function publish($id)
    {
        DB::beginTransaction();
        $update = ShareProfit::where('id', $id)->update([
            'status' => 'Published'
        ]);
        if ($update){
            DB::commit();
            return redirect('share-profit-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }


    public function delete($id)
    {
        $data = ShareProfit::find($id);
        if (is_null($data)){
            return redirect('share-profit-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('share-profit-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('share-profit-list')->with('success','Data has been deleted.');
        }
    }
}
