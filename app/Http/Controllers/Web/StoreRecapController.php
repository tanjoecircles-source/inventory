<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\ReportStore;
use App\Models\StorePurchasing;
use App\Models\StoreOperational;
use App\Models\Periode;
use App\Models\BaristaFee;
use App\Models\StoreRecap;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class StoreRecapController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('store_recap AS sr')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sr.periode_id')
                    ->select('sr.*', 'p.name AS periode')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('p.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('sr.id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('store_recap AS sr')
                ->leftJoin('periode AS p', 'p.id', '=', 'sr.periode_id')
                ->where(function($contents) use ($search){
                    $contents->where('p.name', 'like', '%'.$search.'%');
                })
                ->orderBy('sr.id', 'DESC')
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
            $view = view('web.admin.store_recap.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.store_recap.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('store_recap')
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
        $period = Periode::whereNotIn('id', function($query) {
                    $query->select('periode_id')->from('store_recap');
                })->orderBy('id', 'desc')->get();
        $data = ['period' => $period];
        return view('web.admin.store_recap.add', $data);
    }

    public function calculate(Request $request){
        $periode = Periode::where(['id' => $request->id])->first();
        $start_period = $periode->start_date;
        $end_period = $periode->end_date;
        //calculate income
        $income = ReportStore::where([['date', '>=', $start_period], ['date', '<=', $end_period], 'status' => 'verified']);
        $income_cash = $income->sum('cash');
        $income_qris = $income->sum('qris');

        $income_total = (INT)$income_cash + (INT)$income_qris;
        
        //calculate outcome
        $outcome_cash = ReportStore::where([['date', '>=', $start_period], ['date', '<=', $end_period], 'status' => 'verified']);
        $outcome_cash = $outcome_cash->sum('spending');

        $outcome_purchasing = StorePurchasing::where([['pur_date', '>=', $start_period], ['pur_date', '<=', $end_period], 'pur_status_payment' => 'Lunas']);
        $outcome_purchasing = $outcome_purchasing->sum('pur_total');

        $outcome_operational = StoreOperational::where([['op_date', '>=', $start_period], ['op_date', '<=', $end_period], 'op_status_payment' => 'Lunas']);
        $outcome_operational = $outcome_operational->sum('op_total');

        $outcome_barista = BaristaFee::where(['periode_id' => $request->id])->first();
        $outcome_barista = (!empty($outcome_barista)) ? $outcome_barista->total_fee : 0;

        $outcome_total = (INT)$outcome_cash + (INT)$outcome_purchasing + (INT)$outcome_operational + (INT)$outcome_barista;

        $data = [
            'income_cash' => $income_cash,
            'income_qris' => $income_qris,
            'income_total' => $income_total,
            'outcome_cash' => $outcome_cash,
            'outcome_purchasing' => $outcome_purchasing,
            'outcome_operational' => $outcome_operational,
            'outcome_barista' => $outcome_barista,
            'outcome_total' => $outcome_total,
            'profit' => (INT)$income_total - (INT)$outcome_total
        ];
        
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        $insert = StoreRecap::create([
            'periode_id' => $data['periode_id'],
            'income_qris' => preg_replace('/[^0-9]/', '', $data['income_qris']),
            'income_cash' => preg_replace('/[^0-9]/', '', $data['income_cash']),
            'income_total' => preg_replace('/[^0-9]/', '', $data['income_total']),
            'outcome_cash' => preg_replace('/[^0-9]/', '', $data['outcome_cash']),
            'outcome_purchasing' => preg_replace('/[^0-9]/', '', $data['outcome_purchasing']),
            'outcome_operational' => preg_replace('/[^0-9]/', '', $data['outcome_operational']),
            'outcome_barista' => preg_replace('/[^0-9]/', '', $data['outcome_barista']),
            'outcome_total' => preg_replace('/[^0-9]/', '', $data['outcome_total']),
            'profit' => str_replace('.', '', $data['profit']),
            'status' => 'Draft',
            'athor' => Auth::user()->id
        ]);
        if ($insert){
            DB::commit();
            return redirect('store-recap-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $detail = DB::table('store_recap AS sr')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sr.periode_id')
                    ->select('sr.*', 'p.name AS periode')
                    ->where(['sr.id' => $id])
                    ->first();

        $data = ['detail' => $detail];
        return view('web.admin.store_recap.detail', $data);
    }

    public function edit($id)
    {
        $detail = StoreRecap::where(['id' => $id])->first();
        $period = Periode::where(['id' => $detail->periode_id])->orderBy('id', 'desc')->get();
        $data = [
            'period' => $period,
            'detail' => $detail
        ];
        return view('web.admin.store_recap.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        DB::beginTransaction();
        $update = StoreRecap::where('id', $id)->update([
            'income_qris' => preg_replace('/[^0-9]/', '', $data['income_qris']),
            'income_cash' => preg_replace('/[^0-9]/', '', $data['income_cash']),
            'income_total' => preg_replace('/[^0-9]/', '', $data['income_total']),
            'outcome_cash' => preg_replace('/[^0-9]/', '', $data['outcome_cash']),
            'outcome_purchasing' => preg_replace('/[^0-9]/', '', $data['outcome_purchasing']),
            'outcome_operational' => preg_replace('/[^0-9]/', '', $data['outcome_operational']),
            'outcome_barista' => preg_replace('/[^0-9]/', '', $data['outcome_barista']),
            'outcome_total' => preg_replace('/[^0-9]/', '', $data['outcome_total']),
            'profit' => str_replace('.', '', $data['profit'])
        ]);
        if ($update){
            DB::commit();
            return redirect('store-recap-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function publish($id)
    {
        DB::beginTransaction();
        $update = StoreRecap::where('id', $id)->update([
            'status' => 'Verified'
        ]);
        if ($update){
            DB::commit();
            return redirect('store-recap-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function delete($id)
    {
        $data = StoreRecap::find($id);
        if (is_null($data)){
            return redirect('store-recap-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('store-recap-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('store-recap-list')->with('success','Data has been deleted.');
        }
    }
}
