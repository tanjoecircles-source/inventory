<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderHistoryController extends Controller
{
    /**
     * Display list of order / transaction history.
     */
    public function index(Request $request)
    {
        $isLoggedIn = Auth::check();
        $user = Auth::user();
        $orders = collect([]);

        if ($isLoggedIn) {
            $userId = $user->id;
            $userPhone = $user->phone;

            $customerIds = [];
            if (!empty($userPhone)) {
                $customerIds = Customer::where('phone', $userPhone)->pluck('id')->toArray();
            }

            $salesQuery = DB::table('sales as s')
                ->leftJoin('customer as c', 'c.id', '=', 's.inv_cust')
                ->select(
                    's.*',
                    'c.name as customer_name',
                    'c.phone as customer_phone'
                )
                ->where(function ($q) use ($userId, $customerIds) {
                    $q->where('s.author', $userId);
                    if (!empty($customerIds)) {
                        $q->orWhereIn('s.inv_cust', $customerIds);
                    }
                });

            // Filter status if tab is present
            $statusFilter = $request->get('status', 'all');
            if ($statusFilter === 'unpaid') {
                $salesQuery->where('s.inv_status_payment', 'unpaid');
            } elseif ($statusFilter === 'paid') {
                $salesQuery->where('s.inv_status_payment', 'paid');
            }

            $salesList = $salesQuery->orderBy('s.id', 'DESC')->paginate(15);

            // Fetch items for each sale
            $saleIds = $salesList->pluck('id')->toArray();
            $itemsGrouped = collect([]);

            if (!empty($saleIds)) {
                $items = DB::table('sales_items as si')
                    ->leftJoin('product as p', 'p.id', '=', 'si.itm_product')
                    ->select(
                        'si.*',
                        'p.name as product_name',
                        'p.name_pl as product_name_pl',
                        'p.photo_thumbnail as product_photo',
                        'p.origin as product_origin',
                        'p.process as product_process'
                    )
                    ->whereIn('si.itm_inv_id', $saleIds)
                    ->get()
                    ->groupBy('itm_inv_id');

                $itemsGrouped = $items;
            }

            foreach ($salesList as $sale) {
                $sale->items = $itemsGrouped->get($sale->id, collect([]));
                $sale->items_count = $sale->items->sum('itm_qty');
            }

            $orders = $salesList;
        }

        $data = [
            'isLoggedIn' => $isLoggedIn,
            'authUser' => $user,
            'orders' => $orders,
            'currentFilter' => $request->get('status', 'all'),
        ];

        return view('core.order_history', $data);
    }

    /**
     * Display detail of a specific invoice.
     */
    public function detail($id)
    {
        $sale = DB::table('sales as s')
            ->leftJoin('customer as c', 'c.id', '=', 's.inv_cust')
            ->select('s.*', 'c.name as customer_name', 'c.phone as customer_phone')
            ->where('s.id', $id)
            ->first();

        if (!$sale) {
            abort(404, 'Invoice tidak ditemukan.');
        }

        $items = DB::table('sales_items as si')
            ->leftJoin('product as p', 'p.id', '=', 'si.itm_product')
            ->select(
                'si.*',
                'p.name as product_name',
                'p.name_pl as product_name_pl',
                'p.photo_thumbnail as product_photo',
                'p.origin as product_origin',
                'p.process as product_process'
            )
            ->where('si.itm_inv_id', $sale->id)
            ->get();

        $sale->items = $items;

        $data = [
            'sale' => $sale,
            'authUser' => Auth::user(),
        ];

        return view('core.order_history_detail', $data);
    }
}
