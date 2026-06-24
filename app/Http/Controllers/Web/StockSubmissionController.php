<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\StockSubmission;
use App\Models\StockSubmissionItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StockSubmissionController extends Controller
{
    public function list(Request $request)
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        $user = Auth::user();
        $search = $request->input('search');

        $submissions = StockSubmission::where('user_id', $user->id)
            ->when($search, function ($query, $search) {
                return $query->where('author', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->withCount('items')
            ->paginate(10);

        $data = [
            'submissions' => $submissions,
            'search' => $search
        ];

        return view('web.agent.stock_submission.list', $data);
    }

    public function add()
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        return view('web.agent.stock_submission.add');
    }

    public function create(Request $request)
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:Roasted Filter,Roasted Espresso,Bahan Lainnya',
        ]);

        $user = Auth::user();

        $submission = StockSubmission::create([
            'user_id' => $user->id,
            'author' => $user->name,
            'type' => $request->type,
            'date' => $request->date,
            'status' => StockSubmission::STATUS_DRAFT,
            'submitted_at' => null
        ]);

        return redirect()->route('stock-submission-detail', ['app_id' => $submission->id])
            ->with('success', 'Draft pengajuan stok berhasil dibuat.');
    }

    public function detail($id)
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        $user = Auth::user();
        $submission = StockSubmission::with('items', 'user')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $data = ['submission' => $submission];

        return view('web.agent.stock_submission.detail', $data);
    }

    public function itemAdd($id)
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        $user = Auth::user();
        $submission = StockSubmission::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', StockSubmission::STATUS_DRAFT)
            ->firstOrFail();

        $data = ['submission' => $submission];

        return view('web.agent.stock_submission.item_add', $data);
    }

    public function itemCreate(Request $request, $id)
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        $user = Auth::user();
        $submission = StockSubmission::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', StockSubmission::STATUS_DRAFT)
            ->firstOrFail();

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'required|string|max:50',
        ]);

        foreach ($request->items as $item) {
            StockSubmissionItem::create([
                'submission_id' => $submission->id,
                'product_id' => null,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
            ]);
        }

        return redirect()->route('stock-submission-detail', ['app_id' => $submission->id])
            ->with('success', 'Item berhasil ditambahkan.');
    }

    public function itemDelete($submissionId, $itemId)
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        $user = Auth::user();
        $submission = StockSubmission::where('id', $submissionId)
            ->where('user_id', $user->id)
            ->where('status', StockSubmission::STATUS_DRAFT)
            ->firstOrFail();

        $item = StockSubmissionItem::where('id', $itemId)
            ->where('submission_id', $submission->id)
            ->firstOrFail();

        $item->delete();

        return redirect()->route('stock-submission-detail', ['app_id' => $submission->id])
            ->with('success', 'Item berhasil dihapus.');
    }

    public function submit($id)
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        $user = Auth::user();
        $submission = StockSubmission::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', StockSubmission::STATUS_DRAFT)
            ->firstOrFail();

        // Minimal harus ada 1 item
        $itemCount = $submission->items()->count();
        if ($itemCount == 0) {
            return redirect()->route('stock-submission-detail', ['app_id' => $submission->id])
                ->with('danger', 'Minimal harus ada 1 item sebelum mengajukan.');
        }

        $submission->update([
            'status' => StockSubmission::STATUS_PENDING,
            'submitted_at' => now()
        ]);

        return redirect()->route('stock-submission-list')
            ->with('success', 'Pengajuan stok berhasil dikirim.');
    }

    public function delete($id)
    {
        if (Gate::denies('isAgent')) return view('error_authorize');

        $user = Auth::user();
        $submission = StockSubmission::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($submission->status !== StockSubmission::STATUS_DRAFT) {
            return redirect()->route('stock-submission-list')
                ->with('danger', 'Hanya pengajuan dengan status Draft yang dapat dihapus.');
        }

        $submission->items()->delete();
        $submission->delete();

        return redirect()->route('stock-submission-list')
            ->with('success', 'Pengajuan stok berhasil dihapus.');
    }
}