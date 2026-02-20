<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitation;
use App\Models\Product;

class QrCodeController extends Controller
{

    public function qrCodeAgent(Request $request)
    {
        $data = [];
        return view('web.agent.qrcode.index', $data);
    }

    public function confirmQrCodeVisitation(Request $request, $visitationId, $uniqId){
        $agent = $this->agent_info();
        $visitation = Visitation::where('id', $visitationId)
            ->where('agent', $agent->agent_id)
            ->first();
        if (empty($visitation)){
            return redirect('home')->with('danger', 'Otorisasi qrcode gagal');
        }else if ($visitation->status != 'Disetujui'){
            return redirect('home')->with('danger', 'Visitasi '.$visitation->status);
        }
        $productId = $visitation->product;
        $product = Product::where('id', $productId)->firstOrFail();
        $seller = $product->detailSeller;
        $detailProduct = $this->reArrangeProduct($productId);
        $result['id_produk'] = $product->id;
        $result['info'] = $detailProduct->information;
        $result['sales'] = $detailProduct->sales;
        $result['foto'] = $detailProduct->photos;
        $result['seller'] = $seller;
        $result['visitation'] = $visitation;
        $result['payment_method'] = $product->payment_type;
        $result['link_checkout'] = url('transaction/checkout?id='.encrypt($visitationId));
        return view('web.agent.qrcode.qrcode_confirm_visitation', $result);
    }
}
