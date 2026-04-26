<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $data = [
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
            'total_qty' => $this->getTotalQuantity($cart)
        ];
        return view('web.user.cart.index', $data);
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);
        if (count($cart) == 0) {
            return redirect('home')->with('danger', 'Keranjang belanja kosong');
        }

        $data = [
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
            'total_qty' => $this->getTotalQuantity($cart),
            'user' => auth()->user()
        ];
        return view('web.user.cart.checkout', $data);
    }

    public function add(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan']);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity']++;
        } else {
            $cart[$product_id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "photo" => $product->photo_thumbnail
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true, 
            'message' => 'Produk ditambahkan ke keranjang',
            'cart_count' => $this->getTotalQuantity($cart)
        ]);
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = Session::get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            Session::put('cart', $cart);
            return response()->json(['success' => true]);
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = Session::get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Session::put('cart', $cart);
            }
            return response()->json(['success' => true]);
        }
    }

    private function getTotalQuantity($cart)
    {
        $total = 0;
        foreach($cart as $item) {
            $total += $item['quantity'];
        }
        return $total;
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
