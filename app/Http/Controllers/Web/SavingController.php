<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SavingDeduction;

class SavingController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";

        $base = DB::table('share_profit AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->where(function($q) use ($search){
                        $q->where('p.name', 'like', '%'.$search.'%');
                    });

        $contents = (clone $base)
                    ->leftJoin('share_profit_employee AS spe', 'spe.sp_id', '=', 'sp.id')
                    ->select(
                        'sp.id',
                        'sp.status',
                        'sp.total_profit',
                        'sp.created_at',
                        'p.name AS periode',
                        DB::raw('COALESCE(SUM(spe.tabungan_credit), 0) AS total_tabungan'),
                        DB::raw('COALESCE((SELECT SUM(amount) FROM saving_deduction WHERE saving_deduction.sp_id = sp.id), 0) AS total_potongan')
                    )
                    ->groupBy('sp.id', 'sp.status', 'sp.total_profit', 'sp.created_at', 'p.name')
                    ->orderBy('sp.id', 'DESC')
                    ->paginate($limit);

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->created_at = date('d M Y', strtotime($value->created_at));
                $value->sisa_tabungan = (INT)$value->total_tabungan - (INT)$value->total_potongan;
            }
        }

        $counts = $contents->total();

        $grand_total = (clone $base)
                    ->leftJoin('share_profit_employee AS spe', 'spe.sp_id', '=', 'sp.id')
                    ->sum('spe.tabungan_credit');

        $grand_potongan = (clone $base)
                    ->leftJoin('saving_deduction AS sd', 'sd.sp_id', '=', 'sp.id')
                    ->sum('sd.amount');

        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts,
            'grand_total' => $grand_total,
            'grand_potongan' => $grand_potongan,
            'grand_sisa' => (INT)$grand_total - (INT)$grand_potongan,
        ];
        if($request->ajax()){
            $view = view('web.admin.saving.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.saving.list', $data);
    }

    public function detail($id)
    {
        $detail = DB::table('share_profit AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->select('sp.*', 'p.name AS periode')
                    ->where('sp.id', $id)
                    ->first();

        if (is_null($detail)){
            return redirect('saving-list')->with('danger','Data periode tidak ditemukan.');
        }

        $contents = DB::table('share_profit_employee AS spe')
                    ->leftJoin('employee AS e', 'e.id', '=', 'spe.employee_id')
                    ->select('spe.*', 'e.name AS employee', 'e.category AS category')
                    ->where('spe.sp_id', $id)
                    ->where('spe.tabungan_credit', '>', 0)
                    ->orderBy('spe.tabungan_credit', 'DESC')
                    ->get();

        $summary = DB::table('share_profit_employee')
                    ->selectRaw('COUNT(id) AS total_penabung, COALESCE(SUM(sub_total), 0) AS total_sub_total, COALESCE(SUM(tabungan_credit), 0) AS total_tabungan')
                    ->where('sp_id', $id)
                    ->first();

        $total_potongan = DB::table('saving_deduction')->where('sp_id', $id)->sum('amount');
        $summary->total_potongan = $total_potongan;
        $summary->sisa_tabungan = (INT)$summary->total_tabungan - (INT)$total_potongan;

        $deductions = DB::table('saving_deduction')
                    ->where('sp_id', $id)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();

        $data = [
            'detail' => $detail,
            'contents' => $contents,
            'deductions' => $deductions,
            'summary' => $summary,
        ];

        return view('web.admin.saving.detail', $data);
    }

    public function deduction($id)
    {
        $detail = DB::table('share_profit AS sp')
                    ->leftJoin('periode AS p', 'p.id', '=', 'sp.periode_id')
                    ->select('sp.*', 'p.name AS periode')
                    ->where('sp.id', $id)
                    ->first();

        if (is_null($detail)){
            return redirect('saving-list')->with('danger','Data periode tidak ditemukan.');
        }

        $total_tabungan = DB::table('share_profit_employee')->where('sp_id', $id)->sum('tabungan_credit');
        $total_potongan = DB::table('saving_deduction')->where('sp_id', $id)->sum('amount');

        $data = [
            'id' => $id,
            'detail' => $detail,
            'sisa_tabungan' => (INT)$total_tabungan - (INT)$total_potongan,
            'date' => date('d-m-Y'),
        ];
        return view('web.admin.saving.deduction', $data);
    }

    public function deductionCreate(Request $request, $id)
    {
        $valid = validator($request->only('name', 'date', 'amount'), [
            'name' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->all();
        $amount = (INT)str_replace('.', "", $data['amount']);
        if ($amount <= 0){
            return redirect()->back()->with('danger','Nominal potongan harus lebih dari 0.')->withInput();
        }

        $total_tabungan = DB::table('share_profit_employee')->where('sp_id', $id)->sum('tabungan_credit');
        $total_potongan = DB::table('saving_deduction')->where('sp_id', $id)->sum('amount');
        $sisa = (INT)$total_tabungan - (INT)$total_potongan;
        if ($amount > $sisa){
            return redirect()->back()->with('danger','Nominal melebihi sisa tabungan Rp '.number_format($sisa, 0, ',', '.'))->withInput();
        }

        DB::beginTransaction();
        $insert = SavingDeduction::create([
            'sp_id' => $id,
            'name' => $data['name'],
            'date' => date('Y-m-d', strtotime($data['date'])),
            'amount' => $amount,
            'author' => Auth::user()->id ?? null,
        ]);
        if ($insert){
            DB::commit();
            return redirect('saving-detail/'.$id)->with('success','Potongan tabungan berhasil ditambahkan');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }

    public function deductionDelete($id)
    {
        $data = SavingDeduction::find($id);
        if (is_null($data)){
            return redirect()->back()->with('danger','Something Wrong, data not found.');
        }

        $mid = $data->sp_id;
        DB::beginTransaction();
        if ($data->delete()){
            DB::commit();
            return redirect('saving-detail/'.$mid)->with('success','Potongan tabungan berhasil dihapus.');
        }else{
            DB::rollback();
            return redirect('saving-detail/'.$mid)->with('danger','Something Wrong, Data failed to delete.');
        }
    }
}
