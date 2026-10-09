<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display the public checkout page.
     */
    public function index(Request $request)
    {
        $data = [
            'stok_filter' => collect([]),
            'stok_spro' => collect([]),
            'stok_gb' => collect([]),
            'all_products' => collect([]),
            'processes' => collect([]),
            'origins' => collect([]),
            'initial_tab' => 'checkout',
            'authUser' => Auth::user(),
        ];

        return view('web.user.checkout.checkout', $data);
    }

    /**
     * Save shipping address for authenticated user.
     */
    public function saveShippingAddress(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi login telah berakhir. Silakan masuk akun terlebih dahulu.'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|min:8|max:25',
            'address' => 'required|string|min:5|max:1000',
        ], [
            'phone.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'phone.min' => 'Nomor WhatsApp minimal 8 digit.',
            'address.required' => 'Alamat lengkap pengiriman wajib diisi.',
            'address.min' => 'Alamat pengiriman minimal 5 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::find(Auth::id());
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pengguna tidak ditemukan.'
                ], 404);
            }

            if ($request->filled('name')) {
                $user->name = trim($request->name);
            }
            $user->phone = trim($request->phone);
            $user->address = trim($request->address);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Data alamat pengiriman berhasil disimpan.',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('saveShippingAddress error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan ke database: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process checkout: save into `sales` and `sales_items` tables.
     */
    public function processCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:150',
            'phone' => 'required|string|min:8|max:50',
            'address' => 'required|string|min:5|max:1000',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|numeric|min:1',
            'customer_notes' => 'nullable|string|max:500',
        ], [
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.min' => 'Nomor WhatsApp minimal 8 digit.',
            'address.required' => 'Alamat lengkap pengiriman wajib diisi.',
            'address.min' => 'Alamat pengiriman minimal 5 karakter.',
            'items.required' => 'Keranjang pesanan masih kosong.',
            'items.min' => 'Pilih minimal satu produk untuk checkout.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $phone = trim($request->phone);
        $name = trim($request->name ?? '');
        $address = trim($request->address);
        $customerNotes = trim($request->customer_notes ?? '');
        $items = $request->items;

        DB::beginTransaction();
        try {
            // 1. Get or Create Customer
            $customer = Customer::where('phone', $phone)->first();
            if (!$customer) {
                $customer = Customer::create([
                    'name' => $name ?: 'Pelanggan Online',
                    'phone' => $phone,
                ]);
            } else if ($name && (empty($customer->name) || $customer->name === 'Pelanggan Online')) {
                $customer->update(['name' => $name]);
            }

            // 2. Generate unique Invoice Code
            $inv_code = 'INV/TC' . date('y') . '/' . date('mdHis');
            $counter = 1;
            while (Sales::where('inv_code', $inv_code)->exists()) {
                $inv_code = 'INV/TC' . date('y') . '/' . date('mdHis') . $counter;
                $counter++;
            }

            // 3. Process items and calculate totals
            $rawSubtotal = 0;
            $totalHpp = 0;
            $itemsData = [];

            foreach ($items as $it) {
                $productId = $it['id'];
                $qty = (float)($it['quantity'] ?? 1);
                $product = Product::find($productId);

                // Calculate wholesale / bundling tiered pricing
                $p15 = ($product && !empty($product->price_grosir15)) ? (float)$product->price_grosir15 : 0;
                $p50 = ($product && !empty($product->price_grosir50)) ? (float)$product->price_grosir50 : 0;
                $basePrice = $product ? (float)$product->price : (float)($it['price'] ?? 0);
                $productType = $product ? (string)$product->type : '2';

                if ($productType === '1') {
                    // Green Beans: >=50kg, >=15kg
                    if ($qty >= 50 && $p50 > 0) {
                        $price = $p50;
                    } else if ($qty >= 15 && $p15 > 0) {
                        $price = $p15;
                    } else {
                        $price = $basePrice;
                    }
                } else {
                    // Roasted Filter (2) & Espresso (3) Beans: Bundling (>= 2 Pack)
                    if ($qty >= 2 && $p15 > 0) {
                        $price = $p15;
                    } else {
                        $price = $basePrice;
                    }
                }

                $itemTotal = $price * $qty;
                $variant = $it['variant'] ?? 'Whole Beans (Biji Utuh)';
                $note = $it['note'] ?? '';

                $productName = $product ? $product->name : ($it['name'] ?? 'Roasted Beans');
                $hpp = $product ? (float)$product->price_hpp : 0;

                $rawSubtotal += $itemTotal;
                $totalHpp += ($hpp * $qty);

                $itemsData[] = [
                    'product_id' => $productId,
                    'product_name' => $productName,
                    'variant' => $variant,
                    'note' => $note,
                    'price' => $price,
                    'qty' => $qty,
                    'total' => $itemTotal,
                ];
            }

            // 4. Construct inv_desc with all unmapped metadata
            $descLines = [];
            $descLines[] = "=== INFORMASI PENGIRIMAN ===";
            $descLines[] = "Nama Penerima: " . ($name ?: ($customer->name ?? '-'));
            $descLines[] = "No. WhatsApp: " . $phone;
            $descLines[] = "Alamat Pengiriman:\n" . $address;
            if (!empty($customerNotes)) {
                $descLines[] = "Catatan Pembeli: " . $customerNotes;
            }
            $descLines[] = "\n=== RINCIAN VARIAN & GILINGAN ===";
            foreach ($itemsData as $idx => $d) {
                $line = ($idx + 1) . ". " . $d['product_name'] . " (" . $d['qty'] . " pack)";
                if (!empty($d['variant'])) {
                    $line .= " | Varian: " . $d['variant'];
                }
                if (!empty($d['note'])) {
                    $line .= " | Catatan: " . $d['note'];
                }
                $descLines[] = $line;
            }
            $inv_desc = implode("\n", $descLines);

            // 5. Create Sales record
            $authorId = Auth::id() ?: null;
            $sale = Sales::create([
                'inv_category' => 'Online',
                'inv_code' => $inv_code,
                'inv_date' => date('Y-m-d'),
                'inv_cust' => $customer->id,
                'inv_hpp' => $totalHpp,
                'inv_sub_total' => $rawSubtotal,
                'inv_discount' => 0,
                'inv_expedition' => 0,
                'inv_total' => $rawSubtotal,
                'inv_status_payment' => 'unpaid',
                'inv_status' => 'Draft',
                'inv_desc' => $inv_desc,
                'author' => $authorId,
            ]);

            // 6. Create SalesItem records
            foreach ($itemsData as $d) {
                SalesItem::create([
                    'itm_inv_id' => $sale->id,
                    'itm_product' => $d['product_id'],
                    'itm_price' => $d['price'],
                    'itm_qty' => $d['qty'],
                    'itm_total' => $d['total'],
                    'author' => $authorId,
                ]);
            }

            // 7. Update User profile address & phone if user logged in
            if (Auth::check()) {
                $currentUser = User::find(Auth::id());
                if ($currentUser) {
                    if (!empty($name) && empty($currentUser->name)) {
                        $currentUser->name = $name;
                    }
                    $currentUser->phone = $phone;
                    $currentUser->address = $address;
                    $currentUser->save();
                }
            }

            DB::commit();

            // 8. Generate WhatsApp direct message
            $formatRupiah = function($num) {
                return 'Rp ' . number_format($num, 0, ',', '.');
            };

            $waMsg = "*INVOICE PESANAN TOKO KOPI TANJOE*\n";
            $waMsg .= "----------------------------------------\n";
            $waMsg .= "*No. Invoice:* {$inv_code}\n";
            $waMsg .= "*Penerima:* " . ($name ?: ($customer->name ?? '-')) . "\n";
            $waMsg .= "*No. WhatsApp:* {$phone}\n";
            $waMsg .= "*Alamat Kirim:* {$address}\n";
            $waMsg .= "----------------------------------------\n";
            $waMsg .= "*DAFTAR PESANAN:*\n";

            foreach ($itemsData as $idx => $d) {
                $waMsg .= ($idx + 1) . ". *" . $d['product_name'] . "*\n";
                $waMsg .= "   • Varian: " . $d['variant'] . " | Qty: " . $d['qty'] . " pack\n";
                $waMsg .= "   • Subtotal: " . $formatRupiah($d['total']) . "\n";
                if (!empty($d['note'])) {
                    $waMsg .= "   • Catatan: " . $d['note'] . "\n";
                }
            }

            $waMsg .= "----------------------------------------\n";
            $waMsg .= "*Subtotal:* " . $formatRupiah($rawSubtotal) . "\n";
            $waMsg .= "*Ongkir:* Dihitung oleh Admin\n";
            $waMsg .= "*TOTAL ESTIMASI:* *" . $formatRupiah($rawSubtotal) . "*\n";
            $waMsg .= "----------------------------------------\n";
            $waMsg .= "Halo Admin Toko Kopi Tanjoe, saya telah menyelesaikan checkout di web dengan No. Invoice *{$inv_code}*. Mohon info perhitungan ongkir dan instruksi pembayarannya. Terima kasih!";

            $waUrl = 'https://wa.me/6285974607547?text=' . urlencode($waMsg);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat dengan No. Invoice: ' . $inv_code,
                'inv_code' => $inv_code,
                'sale_id' => $sale->id,
                'wa_url' => $waUrl,
                'wa_message' => $waMsg,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('processCheckout error: ' . $e->getMessage() . ' ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}
