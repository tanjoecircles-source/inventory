<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;
use App\Models\Periode;
use App\Models\BeanRecap;
use App\Models\BeanRecapSpending;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class BeanRecapController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('bean_recap AS br')
                    ->leftJoin('periode AS p', 'p.id', '=', 'br.periode_id')
                    ->select('br.*', 'p.name AS periode')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($search){
                        $contents->where('p.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('br.id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('bean_recap AS br')
                ->leftJoin('periode AS p', 'p.id', '=', 'br.periode_id')
                ->where(function($contents) use ($search){
                    $contents->where('p.name', 'like', '%'.$search.'%');
                })
                ->orderBy('br.id', 'DESC')
                ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->created_at = date('d M Y', strtotime($value->created_at));
                $value->sisa_profit = (INT)$value->profit - (INT)$value->total_potongan;
            }
        }
        
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.bean_recap.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.bean_recap.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('bean_recap')
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
                    $query->select('periode_id')->from('bean_recap');
                })->orderBy('id', 'desc')->get();
        $data = ['period' => $period];
        return view('web.admin.bean_recap.add', $data);
    }

    public function calculate(Request $request){
        $periode = Periode::where(['id' => $request->id])->first();
        $start_period = $periode->start_date;
        $end_period = $periode->end_date;
        //calculate income
        $sales = Sales::where([['inv_date', '>=', $start_period], ['inv_date', '<=', $end_period], 'inv_status' => 'publish']);
        $subtotal = $sales->sum('inv_sub_total');
        $discount = $sales->sum('inv_discount');
        $income = (INT)$subtotal - (INT)$discount;
        $hpp = $sales->sum('inv_hpp');

        $profit = (INT)$income - (INT)$hpp;

        $data = [
            'income' => $income,
            'hpp' => $hpp,
            'profit' => $profit
        ];
        
        return response()->json($data);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        $insert = BeanRecap::create([
            'periode_id' => $data['periode_id'],
            'income' => preg_replace('/[^0-9]/', '', $data['income']),
            'hpp' => preg_replace('/[^0-9]/', '', $data['hpp']),
            'profit' => preg_replace('/[^0-9]/', '', $data['profit']),
            'status' => 'Draft',
            'athor' => Auth::user()->id
        ]);
        if ($insert){
            DB::commit();
            return redirect('bean-recap-list')->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $detail = DB::table('bean_recap AS br')
                    ->leftJoin('periode AS p', 'p.id', '=', 'br.periode_id')
                    ->select('br.*', 'p.name AS periode')
                    ->where(['br.id' => $id])
                    ->first();

        $spending = DB::table('bean_recap_spending')
                    ->select('*')
                    ->where(['bean_recap_id' => $id])
                    ->orderBy('id', 'DESC')
                    ->get();
        $detail->total_potongan = (INT)$detail->total_potongan + (INT)$detail->potongan_non_investor;
        $detail->sisa_profit = (INT)$detail->profit - (INT)$detail->total_potongan;
        $data = [
            'detail' => $detail,
            'spending' => $spending
        ];
        return view('web.admin.bean_recap.detail', $data);
    }

    public function edit($id)
    {
        $detail = BeanRecap::where(['id' => $id])->first();
        $period = Periode::where(['id' => $detail->periode_id])->orderBy('id', 'desc')->get();
        $data = [
            'period' => $period,
            'detail' => $detail
        ];
        return view('web.admin.bean_recap.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        DB::beginTransaction();
        $update = BeanRecap::where('id', $id)->update([
            'income' => preg_replace('/[^0-9]/', '', $data['income']),
            'hpp' => preg_replace('/[^0-9]/', '', $data['hpp']),
            'profit' => preg_replace('/[^0-9]/', '', $data['profit']),
        ]);
        if ($update){
            DB::commit();
            return redirect('bean-recap-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function spending($id)
    {   
        $data['id'] = $id;
        $data['date'] = date('d-m-Y');
        return view('web.admin.bean_recap.spending', $data);
    }

    public function spendingCreate(Request $request, $id)
    {
        $valid = validator($request->only('name','amount', 'date'), [
            'name' => 'required',
            'date' => 'required',
            'amount' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        $is_non_investor = empty($data['is_non_investor']) ? 'false' : 'true';
        DB::beginTransaction();
        $insert = BeanRecapSpending::create([
            'bean_recap_id' => $id,
            'name' => $data['name'],
            'date' => date('Y-m-d', strtotime($data['date'])),
            'amount' => str_replace('.', "", $data['amount']),
            'is_non_investor' => $is_non_investor
        ]);
        $profit = BeanRecap::where('id', $id)->first();
        if($is_non_investor == 'true'){
            $result = $insert && BeanRecap::where('id', $id)->update([
                'potongan_non_investor' => (INT)$profit->potongan_non_investor + (INT)str_replace('.', "", $data['amount'])
            ]);
        }else{
            $result = $insert && BeanRecap::where('id', $id)->update([
                'total_potongan' => (INT)$profit->total_potongan + (INT)str_replace('.', "", $data['amount'])
            ]);
        }
        if ($result){
            DB::commit();
            return redirect('bean-recap-detail/'.$id)->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function SpendingDelete($id)
    {
        $mid = (isset($_GET['mid'])) ? $_GET['mid'] : '';
        $data = BeanRecapSpending::find($id);
        if (is_null($data)){
            return redirect('bean-recap-detail/'.$mid)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('bean-recap-detail/'.$mid)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('bean-recap-detail/'.$mid)->with('success','Data has been deleted.');
        }
    }

    public function publish($id)
    {
        DB::beginTransaction();
        $update = BeanRecap::where('id', $id)->update([
            'status' => 'Verified'
        ]);
        if ($update){
            DB::commit();
            return redirect('bean-recap-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function delete($id)
    {
        $data = BeanRecap::find($id);
        if (is_null($data)){
            return redirect('bean-recap-detail/'.$id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('bean-recap-detail/'.$id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            return redirect('bean-recap-list')->with('success','Data has been deleted.');
        }
    }
}
