<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // 1. Fetch Filter Roasted Beans (type 2)
        $stok_filter = DB::table('product as p')
            ->select(
                'p.id as id',
                'p.name_pl as name',
                'p.origin',
                'p.elevation',
                'p.varietal',
                'p.process',
                'p.processor',
                'p.harvest',
                'p.order_pricelist',
                'p.desc',
                'p.price as price',
                'p.price_grosir15 as price_grosir15',
                'p.price_grosir50 as price_grosir50',
                'p.is_new as is_new',
                'p.stock as stock',
                'p.photo_thumbnail as photo',
                'p.type as type'
            )
            ->where([
                'p.type' => '2',
                'p.status' => 'Active',
                'p.is_pricelist' => 'true'
            ])
            ->orderBy('order_pricelist', 'ASC')
            ->get();

        // 2. Fetch Espresso Roasted Beans (type 3)
        $stok_spro = DB::table('product as p')
            ->select(
                'p.id as id',
                'p.name_pl as name',
                'p.category as category',
                'p.origin',
                'p.elevation',
                'p.varietal',
                'p.process',
                'p.processor',
                'p.harvest',
                'p.order_pricelist',
                'p.desc',
                'p.price as price',
                'p.price_grosir15 as price_grosir15',
                'p.price_grosir50 as price_grosir50',
                'p.is_new as is_new',
                'p.stock as stock',
                'p.photo_thumbnail as photo',
                'p.type as type'
            )
            ->where([
                'p.type' => '3',
                'p.status' => 'Active',
                'p.is_pricelist' => 'true'
            ])
            ->orderBy('order_pricelist', 'ASC')
            ->get();

        // 3. Fetch Green Beans / Specialty Lots (type 1)
        $stok_gb = DB::table('product as p')
            ->select(
                'p.id as id',
                'p.name_pl as name',
                'p.origin',
                'p.elevation',
                'p.varietal',
                'p.process',
                'p.processor',
                'p.harvest',
                'p.order_pricelist',
                'p.desc',
                'p.price as price',
                'p.price_grosir15 as price_grosir15',
                'p.price_grosir50 as price_grosir50',
                'p.is_new as is_new',
                'p.stock as stock',
                'p.photo_thumbnail as photo',
                'p.type as type'
            )
            ->where([
                'p.type' => '1',
                'p.status' => 'Active',
                'p.is_pricelist' => 'true'
            ])
            ->orderBy('order_pricelist', 'ASC')
            ->get();

        // Load images for all products
        $allProducts = $stok_filter->merge($stok_spro)->merge($stok_gb);
        $productIds = $allProducts->pluck('id')->unique()->toArray();
        $allImages = ProductImage::whereIn('product_id', $productIds)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->groupBy('product_id');

        $formatProducts = function ($products, $defaultCategory, $stockLabelReady, $stockLabelEmpty, $stockColor) use ($allImages) {
            foreach ($products as $value) {
                $value->is_new = ($value->is_new == 'true') ? 'New' : '';
                $value->order_pricelist = empty($value->order_pricelist) ? 0 : $value->order_pricelist;
                $value->stock_label = ($value->stock > 0) ? $stockLabelReady : $stockLabelEmpty;
                $value->stock_icon = ($value->stock > 0) ? 'fe-check-circle' : 'fe-x-circle';
                $value->stock_color = ($value->stock > 0) ? $stockColor : 'danger';
                $value->category_name = $value->category ?? $defaultCategory;

                $productImages = $allImages->get($value->id, collect());
                $value->images = $productImages->map(function ($img) {
                    $img->image_url = url('storage/public/' . $img->image_path);
                    return $img;
                });

                if ($productImages->isEmpty() && !empty($value->photo)) {
                    $defaultImg = new \stdClass();
                    $defaultImg->image_url = asset('assets/images/products/no-image.png');
                    $defaultImg->is_primary = 'true';
                    $value->images = collect([$defaultImg]);
                }
            }
        };

        $formatProducts($stok_filter, 'Filter Roast', 'Ready', 'Sold Out', 'success');
        $formatProducts($stok_spro, 'Espresso Roast', 'Ready', 'Pre Order', 'success');
        $formatProducts($stok_gb, 'Green Beans', 'Ready', 'Sold Out', 'success');

        // Extract processes and origins for filter chips
        $processes = $allProducts->pluck('process')->filter()->unique()->values();
        $origins = $allProducts->pluck('origin')->filter()->unique()->values();

        $data = [
            'stok_filter' => $stok_filter,
            'stok_spro' => $stok_spro,
            'stok_gb' => $stok_gb,
            'all_products' => $allProducts,
            'processes' => $processes,
            'origins' => $origins,
            'authUser' => Auth::user(),
        ];

        return view('core.shop', $data);
    }
}

