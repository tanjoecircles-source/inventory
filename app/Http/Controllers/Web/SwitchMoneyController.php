<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\SwitchMoney;
use App\Models\UserSwitchMoney;
use App\Models\VendorBank;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SwitchMoneyController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = $request->get('keyword', '');
        $status = $request->get('status', '');
        $startdate = $request->get('startdate', '');
        $enddate = $request->get('enddate', '');

        $query = DB::table('switch_money AS sm')
                    ->leftJoin('vendor_bank AS fb', 'fb.id', '=', 'sm.from_bank_id')
                    ->leftJoin('vendor_bank AS tb', 'tb.id', '=', 'sm.to_bank_id')
                    ->select('sm.*', 'fb.name AS from_bank_name', 'tb.name AS to_bank_name')
                    ->where(function($q) use ($search){
                        $q->where('fb.name', 'like', '%'.$search.'%')
                          ->orWhere('tb.name', 'like', '%'.$search.'%')
                          ->orWhere('sm.note', 'like', '%'.$search.'%');
                    });

        if(!empty($status)) $query->where('sm.status', $status);
        if(!empty($startdate)) $query->where('sm.date', '>=', date('Y-m-d', strtotime($startdate)));
        if(!empty($enddate)) $query->where('sm.date', '<=', date('Y-m-d', strtotime($enddate)));

        $contents = $query->orderBy('sm.date', 'DESC')->orderBy('sm.id', 'DESC')->paginate($limit);
        $counts = $query->count();
        $total_amount = $query->sum('sm.amount');

        $data = [
            'keyword' => $search,
            'status' => $status,
            'startdate' => $startdate,
            'enddate' => $enddate,
            'contents' => $contents,
            'contents_count' => $counts,
            'total_amount' => $total_amount,
            'limit' => $limit
        ];

        if($request->ajax()){
            $view = view('web.admin.switch_money.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }

        return view('web.admin.switch_money.list', $data);
    }

    public function add()
    {
        $banks = VendorBank::where('status', 'Active')->get();
        return view('web.admin.switch_money.add', ['banks' => $banks]);
    }

    public function create(Request $request)
    {
        $valid = validator($request->all(), [
            'date' => 'required',
            'from_bank_id' => 'required',
            'to_bank_id' => 'required|different:from_bank_id',
        ]);

        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        
        DB::beginTransaction();
        $insert = SwitchMoney::create([
            'date' => date('Y-m-d', strtotime($request->date)),
            'from_bank_id' => $request->from_bank_id,
            'to_bank_id' => $request->to_bank_id,
            'amount' => 0,
            'fee' => 0,
            'total' => 0,
            'status' => 'Draft',
            'note' => $request->note,
            'author' => Auth::user()->id
        ]);

        if ($insert) {
            DB::commit();
            return redirect('switch-money-list')->with('success', 'Data Berhasil Disimpan');
        } else {
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal menyimpan data');
        }
    }

    public function detail($id)
    {
        $detail = SwitchMoney::with(['from_bank', 'to_bank', 'items', 'user_author', 'user_editor'])->find($id);
        if (!$detail) return redirect('switch-money-list')->with('danger', 'Data tidak ditemukan');

        return view('web.admin.switch_money.detail', ['detail' => $detail]);
    }

    public function edit($id)
    {
        $detail = SwitchMoney::find($id);
        if (!$detail || $detail->status == 'Published') return redirect('switch-money-list')->with('danger', 'Data tidak bisa diubah');
        
        $banks = VendorBank::where('status', 'Active')->get();
        return view('web.admin.switch_money.edit', ['detail' => $detail, 'banks' => $banks]);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->all(), [
            'date' => 'required',
            'from_bank_id' => 'required',
            'to_bank_id' => 'required|different:from_bank_id',
        ]);

        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();

        DB::beginTransaction();
        $update = SwitchMoney::where('id', $id)->update([
            'date' => date('Y-m-d', strtotime($request->date)),
            'from_bank_id' => $request->from_bank_id,
            'to_bank_id' => $request->to_bank_id,
            'note' => $request->note,
            'editor' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        if ($update) {
            DB::commit();
            return redirect('switch-money-detail/'.$id)->with('success', 'Data Berhasil Diperbarui');
        } else {
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal memperbarui data');
        }
    }

    public function publish($id)
    {
        $update = SwitchMoney::where('id', $id)->update(['status' => 'Published']);
        if ($update) return redirect('switch-money-list')->with('success', 'Data Berhasil Dipublikasikan');
        return redirect()->back()->with('danger', 'Gagal mempublikasikan data');
    }

    public function delete($id)
    {
        $detail = SwitchMoney::find($id);
        if (!$detail || $detail->status == 'Published') return redirect('switch-money-list')->with('danger', 'Data tidak bisa dihapus');
        
        DB::beginTransaction();
        UserSwitchMoney::where('switch_money_id', $id)->delete();
        if ($detail->delete()) {
            DB::commit();
            return redirect('switch-money-list')->with('success', 'Data Berhasil Dihapus');
        }
        DB::rollback();
        return redirect()->back()->with('danger', 'Gagal menghapus data');
    }

    // ITEM METHODS
    public function itemAdd($id)
    {
        $master = SwitchMoney::find($id);
        if (!$master || $master->status == 'Published') return redirect('switch-money-list')->with('danger', 'Data tidak bisa diubah');
        
        $users = User::orderBy('name', 'ASC')->get();
        return view('web.admin.switch_money.item_add', ['master' => $master, 'users' => $users]);
    }

    public function itemCreate(Request $request, $id)
    {
        $valid = validator($request->all(), [
            'user_name' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();

        $amount = str_replace('.', '', $request->amount);
        $type = $request->get('type', 'addition');
        
        DB::beginTransaction();
        $insert = UserSwitchMoney::create([
            'switch_money_id' => $id,
            'user_name' => $request->user_name,
            'date' => date('Y-m-d', strtotime($request->date)),
            'amount' => $amount,
            'type' => $type
        ]);

        if ($insert) {
            $this->recalculate($id);
            DB::commit();
            return redirect('switch-money-detail/'.$id)->with('success', 'Item Berhasil Ditambahkan');
        } else {
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal menambahkan item');
        }
    }

    public function itemDelete($id)
    {
        $item = UserSwitchMoney::find($id);
        if (!$item) return redirect()->back();
        
        $master_id = $item->switch_money_id;
        $master = SwitchMoney::find($master_id);
        if ($master->status == 'Published') return redirect()->back()->with('danger', 'Data sudah dipublikasikan');

        if ($item->delete()) {
            $this->recalculate($master_id);
            return redirect()->back()->with('success', 'Item Berhasil Dihapus');
        }
        return redirect()->back()->with('danger', 'Gagal menghapus item');
    }

    public function itemDeductionAdd($id)
    {
        $master = SwitchMoney::find($id);
        if (!$master || $master->status == 'Published') return redirect('switch-money-list')->with('danger', 'Data tidak bisa diubah');
        
        return view('web.admin.switch_money.item_deduction_add', ['master' => $master]);
    }

    private function recalculate($master_id)
    {
        $items = UserSwitchMoney::where('switch_money_id', $master_id)->get();
        $additions = $items->where('type', 'addition')->sum('amount');
        $deductions = $items->where('type', 'deduction')->sum('amount');
        
        $total_amount = $additions - $deductions;
        
        $master = SwitchMoney::find($master_id);
        $total = $total_amount + $master->fee;
        
        SwitchMoney::where('id', $master_id)->update([
            'amount' => $total_amount,
            'total' => $total
        ]);
    }
}
