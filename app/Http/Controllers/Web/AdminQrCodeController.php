<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Gate;

class AdminQrCodeController extends Controller
{
    public function index()
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $data = [
            'qr_content' => null,
        ];
        return view('web.admin.qrcode.index', $data);
    }

    public function generate(Request $request)
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        
        $request->validate([
            'content' => 'required|string',
        ]);

        $data = [
            'qr_content' => $request->content,
        ];

        return view('web.admin.qrcode.index', $data);
    }
}
