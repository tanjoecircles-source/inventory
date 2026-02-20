<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Visitation;
use App\Models\Etalase;
use App\Models\Product;
use App\Mail\ApprovedVisitation;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VisitationConfirmController extends Controller
{
    private $limit = 10;
    
    public function list(Request $request)
    {
        $seller = $this->seller_info();
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $product = new Product();
        $qMenungguKonfirmasi = $product->queryVisitionWaitingConfirmation();
        $qDisetujui = $product->queryVisitationApproved(); //todo
        $qDitolak = $product->queryVisitationRejected();
        $countMenunggu = $countDisetujui = $countDitolak = 0;
        $contentMenunggu = $contentDisetujui = $contentDitolak = [];
        $category = $request['category'] ?? '';
        $viewPaging = '';
        switch($category){
            case 'waiting' :
                $contentMenunggu = $qMenungguKonfirmasi
                    ->where('p.seller_id', $seller->id)
                    ->orderBy('p.name', 'ASC')
                    ->paginate($this->limit);
                $viewPaging = 'web.seller.visitation_confirm.paginate_waiting';
                break;
            case 'visitation' :
                $contentVisitasi = $qDisetujui
                    ->where('p.seller_id', $seller->id)
                    ->orderBy('p.name', 'ASC')
                    ->paginate($this->limit);
                $viewPaging = 'web.seller.visitation_confirm.paginate_visitation';
                break;
            case 'reject':
                $contentDitolak = $qDitolak
                    ->where('p.seller_id', $seller->id)
                    ->orderBy('p.name', 'ASC')
                    ->paginate($this->limit);
                $viewPaging = 'web.seller.visitation_confirm.paginate_reject';
                break;
            default:
                $countMenunggu = $qMenungguKonfirmasi
                    ->where('p.seller_id', $seller->id)
                    ->count();
                $countDisetujui = $qDisetujui
                    ->where('p.seller_id', $seller->id)
                    ->count();
                $countDitolak = $qDitolak
                    ->where('p.seller_id', $seller->id)
                    ->count();

                $contentMenunggu = $qMenungguKonfirmasi
                    ->where('p.seller_id', $seller->id)
                    ->orderBy('p.name', 'ASC')
                    ->paginate($this->limit);
                $contentDisetujui = $qDisetujui
                    ->where('p.seller_id', $seller->id)
                    ->orderBy('p.name', 'ASC')
                    ->paginate($this->limit);
                $contentDitolak = $qDitolak
                    ->where('p.seller_id', $seller->id)
                    ->orderBy('p.name', 'ASC')
                    ->paginate($this->limit);
                $viewPaging = 'web.seller.visitation_confirm.paginate_waiting';
                break;
        }

        if(!empty($contentMenunggu)){
            foreach ($contentMenunggu as $key => $value) {
                $value->created_date = date('d M Y', strtotime($value->created_date));
                $value->price = $this->format_angka($value->price);
                $value->sales_commission = $this->format_angka($value->sales_commission);
                $value->published = $value->status == 'Active' ? 'Aktif' : 'Draft';
                $value->published_style = $value->status == 'Active' ? 'badge-success' : 'badge-warning';
                $value->agent_count = Visitation::where('product', $value->product_id)->count(); 
            }
        }
        
        if(!empty($contentDisetujui)){
            foreach ($contentDisetujui as $key => $value) {
                $value->created_date = date('d M Y', strtotime($value->created_date));
                $value->price = $this->format_angka($value->price);
                $value->sales_commission = $this->format_angka($value->sales_commission);
                $value->published = $value->status == 'Active' ? 'Aktif' : 'Draft';
                $value->published_style = $value->status == 'Active' ? 'badge-success' : 'badge-warning';
                $value->agent_count = Visitation::where('product', $value->product_id)->count(); 
            }
        }
        
        if(!empty($contentDitolak)){
            foreach ($contentDitolak as $key => $value) {
                $value->created_date = date('d M Y', strtotime($value->created_date));
                $value->price = $this->format_angka($value->price);
                $value->sales_commission = $this->format_angka($value->sales_commission);
                $value->published = $value->status == 'Active' ? 'Aktif' : 'Draft';
                $value->published_style = $value->status == 'Active' ? 'badge-success' : 'badge-warning';
                $value->agent_count = Visitation::where('product', $value->product_id)->count(); 
            }
        }

        $data = [
            'keyword' => '',
            'limit' => $this->limit,
            'contentMenunggu' => $contentMenunggu,
            'contentDisetujui' => $contentDisetujui,
            'contentDitolak' => $contentDitolak,
            'countMenunggu' => $countMenunggu,
            'countDisetujui' => $countDisetujui,
            'countDitolak' => $countDitolak
        ];
        if($request->ajax()){
            $view = view($viewPaging, $data)->render();
            return response()->json(['html' => $view]);
        }

        return view('web.seller.visitation_confirm.list', $data);
    }

    public function detailWaiting(Request $request, $id){
        $product = Product::where('id', $id)->firstOrFail();
        $listWaiting = $product->listWaiting()->paginate(10);
        if ($request->ajax() && isset($request['page'])){
            $view = view('.web.seller.visitation_confirm.paginate_detail_waiting', ['listWaiting' => $listWaiting])->render();
            return response()->json(['html' => $view]);
        }
        $detailProduct = $this->reArrangeProduct($id);

        $result['id_produk'] = $product->id;
        $result['info'] = $detailProduct->information;
        $result['sales'] = $detailProduct->sales;
        $result['foto'] = $detailProduct->photos;
        $result['listWaiting'] = $listWaiting;
        return view('web.seller.visitation_confirm.detail_waiting', $result);
    }
    
    public function detailApproved(Request $request, $id){
        $product = Product::where('id', $id)->firstOrFail();
        $seller = $this->seller_info();
        $listApproved = $product->listApproved()->paginate(10);
        if ($request->ajax() && isset($request['page'])){
            $view = view('.web.seller.visitation_confirm.paginate_detail_approved', ['listApproved' => $listApproved])->render();
            return response()->json(['html' => $view]);
        }
        $detailProduct = $this->reArrangeProduct($id);

        $result['id_produk'] = $product->id;
        $result['info'] = $detailProduct->information;
        $result['sales'] = $detailProduct->sales;
        $result['foto'] = $detailProduct->photos;
        $result['listApproved'] = $listApproved;
        return view('web.seller.visitation_confirm.detail_approved', $result);
    }

    public function qrCodeVisitation(Request $request){
        $visitation = Visitation::where('id', $request->id)->first();
        $data = json_encode([
            'url' => url('qrcode-agent/finalize-visitation/'.$visitation->id.'/12345UNIQ')
        ]);
        echo QrCode::size(300)->generate($data);
    }
    
    public function detailRejected(Request $request, $id){
        $product = Product::where('id', $id)->firstOrFail();
        $seller = $this->seller_info();
        $listRejected = $product->listRejected()->paginate(10);
        if ($request->ajax() && isset($request['page'])){
            $view = view('.web.seller.visitation_confirm.paginate_detail_rejected', ['listRejected' => $listRejected])->render();
            return response()->json(['html' => $view]);
        }
        $detailProduct = $this->reArrangeProduct($id);

        $result['id_produk'] = $product->id;
        $result['info'] = $detailProduct->information;
        $result['sales'] = $detailProduct->sales;
        $result['foto'] = $detailProduct->photos;
        $result['listRejected'] = $listRejected;
        return view('web.seller.visitation_confirm.detail_rejected', $result);
    }

    public function approve(Request $request, $id){
        $update = Visitation::where('id', $id)->update([
            'status' => 'Disetujui'
        ]);
        if ($update){
            //queued mail to agent when approved
            $visitation = Visitation::where('id', $id)->first();
            Mail::to($visitation->detailAgent->detailUser->email)->queue(new ApprovedVisitation([
                'title' => 'Pengajuan Visitasi disetujui',
                'visitation' => $visitation,
                'product' => $visitation->detailProduct
            ]));

            return redirect()->back()->with('success','Pengajuan visitasi berhasil disetujui');
        }else{
            return redirect()->back()->with('danger','Pengajuan visitasi gagal disetujui, coba ulangi kembali');
        }
    }
    
    public function reject(Request $request, $id){
        $update = Visitation::where('id', $id)->update([
            'status' => 'Ditolak'
        ]);
        if ($update){
            return redirect()->back()->with('success','Pengajuan visitasi berhasil ditolak');
        }else{
            return redirect()->back()->with('danger','Pengajuan visitasi gagal ditolak, coba ulangi kembali');
        }
    }

    public function generate_code($length = 6){
		do {
			$random_str = Str::random($length);
			$count = Visitation::where('code', $random_str)->count();
		} while($count !== FALSE && $count > 0);
		return $random_str;
    }
}
