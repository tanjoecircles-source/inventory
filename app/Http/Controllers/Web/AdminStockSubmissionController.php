<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\StockSubmission;
use App\Models\StockSubmissionItem;
use App\Models\StorePurchasing;
use App\Models\StorePurchasingItem;
use App\Models\Vendor;
use Carbon\Carbon;

class AdminStockSubmissionController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $search = $request->input('search');
        $status = $request->input('status');

        $submissions = StockSubmission::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('author', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderByRaw("FIELD(status, 'Menunggu Persetujuan', 'Draft', 'Disetujui', 'Ditolak')")
            ->orderBy('created_at', 'desc')
            ->withCount('items')
            ->paginate(10);

        $data = [
            'submissions' => $submissions,
            'search' => $search,
            'filter_status' => $status
        ];

        return view('web.admin.stock_submission.list', $data);
    }

    public function detail($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $submission = StockSubmission::with('items', 'user')
            ->where('id', $id)
            ->firstOrFail();

        $data = ['submission' => $submission];

        return view('web.admin.stock_submission.detail', $data);
    }

    public function approveForm($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $submission = StockSubmission::with('items')
            ->where('id', $id)
            ->where('status', StockSubmission::STATUS_PENDING)
            ->firstOrFail();

        // Ambil store purchasing yang masih Draft dengan join vendor
        $storePurchasing = DB::table('store_purchasing AS s')
            ->leftJoin('vendor AS v', 'v.id', '=', 's.pur_vendor')
            ->select('s.*', 'v.name AS vendor_name')
            ->where('s.pur_status', 'Draft')
            ->orderBy('s.pur_date', 'desc')
            ->get();

        $data = [
            'submission' => $submission,
            'store_purchasing' => $storePurchasing
        ];

        return view('web.admin.stock_submission.approve_form', $data);
    }

    public function approveProcess(Request $request, $id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $request->validate([
            'store_purchasing_id' => 'required|exists:store_purchasing,id',
        ]);

        $submission = StockSubmission::with('items')
            ->where('id', $id)
            ->where('status', StockSubmission::STATUS_PENDING)
            ->firstOrFail();

        $storePurchasing = StorePurchasing::where('id', $request->store_purchasing_id)
            ->where('pur_status', 'Draft')
            ->firstOrFail();

        DB::beginTransaction();
        try {
            // Copy items dari stock submission ke store purchasing items
            foreach ($submission->items as $item) {
                StorePurchasingItem::create([
                    'itm_pur_id' => $storePurchasing->id,
                    'itm_product' => $item->product_name,
                    'itm_price' => 0,
                    'itm_qty' => $item->quantity,
                    'itm_total' => 0,
                ]);
            }

            // Update status submission menjadi Disetujui
            $submission->update([
                'status' => StockSubmission::STATUS_APPROVED,
                'submitted_at' => now()
            ]);

            DB::commit();

            return redirect('store-purchasing-detail/' . $storePurchasing->id)
                ->with('success', 'Pengajuan stok berhasil disetujui. Item telah ditambahkan ke belanja toko.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('danger', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');

        $submission = StockSubmission::where('id', $id)
            ->where('status', StockSubmission::STATUS_PENDING)
            ->firstOrFail();

        $submission->update([
            'status' => StockSubmission::STATUS_REJECTED,
        ]);

        return redirect()->route('admin-stock-submission-list')
            ->with('success', 'Pengajuan stok ditolak.');
    }
}