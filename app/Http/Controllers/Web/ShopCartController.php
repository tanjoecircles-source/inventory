<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopCartController extends Controller
{
    /**
     * Display the public shop cart page.
     */
    public function index(Request $request)
    {
        $data = [
            'authUser' => Auth::user(),
        ];

        return view('web.user.cart.cart', $data);
    }
}
