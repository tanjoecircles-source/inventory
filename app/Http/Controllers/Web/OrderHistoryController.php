<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\SalesItem;
use App\Models\Product;
use App\Models\ProductImage;
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
                    ->get();

                $this->attachProductImageUrls($items);

                $itemsGrouped = $items->groupBy('itm_inv_id');
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
            ->select('s.*', 'c.name as customer_name', 'c.phone as customer_phone', 'c.address as customer_address')
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

        $this->attachProductImageUrls($items);

        $sale->items = $items;

        $data = [
            'sale' => $sale,
            'authUser' => Auth::user(),
        ];

        return view('core.order_history_detail', $data);
    }

    /**
     * Attach shop-style product image URLs to sales items.
     * Source: primary image from product_images table (same as shop/cart),
     * with the shared no-image fallback.
     */
    private function attachProductImageUrls($items): void
    {
        if ($items->isEmpty()) {
            return;
        }

        $productIds = $items->pluck('itm_product')->filter()->unique()->values()->all();

        $imagesByProduct = ProductImage::whereIn('product_id', $productIds)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->groupBy('product_id');

        foreach ($items as $item) {
            $img = $imagesByProduct->get($item->itm_product, collect())->first();
            $item->product_image_url = $img
                ? url('storage/public/' . $img->image_path)
                : asset('assets/images/products/no-image.png');
        }
    }

    /**
     * Display payment instruction page for a specific invoice.
     */
    public function payment($id)
    {
        $sale = DB::table('sales as s')
            ->leftJoin('customer as c', 'c.id', '=', 's.inv_cust')
            ->select('s.id', 's.inv_code', 's.inv_total', 's.inv_status', 's.inv_status_payment',
                     's.inv_status_delivery', 's.inv_desc', 'c.name as customer_name', 'c.phone as customer_phone')
            ->where('s.id', $id)
            ->first();

        if (!$sale) {
            abort(404, 'Invoice tidak ditemukan.');
        }

        // Only allow Publish & unpaid
        if ($sale->inv_status !== 'Publish' || $sale->inv_status_payment === 'paid') {
            return redirect()->route('transaction.history.detail', $id);
        }

        $data = [
            'sale'     => $sale,
            'authUser' => Auth::user(),
        ];

        return view('core.order_history_payment', $data);
    }
}
