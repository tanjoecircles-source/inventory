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
use App\Models\Product;
use App\Models\Visitation;

class TransactionVisitationController extends Controller
{
    private $limit = 10;

    public function list(Request $request)
    {
        $agent = $this->agent_info();
        $qMenungguKonfirmasi = Visitation::where(['agent' => $agent->id, 'status' => 'Menunggu Konfirmasi']);
        $qDisetujui = Visitation::where(['agent' => $agent->id, 'status' => 'Undefined']); //todo
        $qDitolak = Visitation::where(['agent' => $agent->id, 'status' => 'Ditolak']);
        $qVisitasi = Visitation::where(['agent' => $agent->id, 'status' => 'Disetujui']);
        $qSold = Visitation::where(['agent' => $agent->id, 'status' => 'Selesai']);
        $countMenunggu = $countDisetujui = $countDitolak = $countVisitasi = $countSelesai = 0;
        $contentMenunggu = $contentDisetujui = $contentDitolak = $contentVisitasi = $contentSelesai = [];
        $category = $request['category'] ?? '';
        $viewPaging = '';
        switch($category){
            case 'waiting' :
                $contentMenunggu = $qMenungguKonfirmasi->paginate($this->limit);
                $viewPaging = 'web.agent.transaction.paginate';
                break;
            case 'visitation' :
                $contentVisitasi = $qVisitasi->paginate($this->limit);
                $viewPaging = 'web.agent.transaction.paginateVisiting';
                break;
            case 'seller-confirm' :
                $contentDisetujui = $qDisetujui->paginate($this->limit);
                $viewPaging = 'web.agent.transaction.paginateConfirm';
                break;
            case 'sold':
                $contentSelesai = $qSold->paginate($this->limit);
                $viewPaging = 'web.agent.transaction.paginateSold';
                break;
            case 'cancel':
                $contentDitolak = $qDitolak->paginate($this->limit);
                $viewPaging = 'web.agent.transaction.paginateCancel';
                break;
            default:
                $countMenunggu = $qMenungguKonfirmasi->count();
                $countDisetujui = $qDisetujui->count();
                $countDitolak = $qDitolak->count();
                $countVisitasi = $qVisitasi->count();
                $countSelesai = $qSold->count();

                $contentMenunggu = $qMenungguKonfirmasi->paginate($this->limit);
                $contentDisetujui = $qDisetujui->paginate($this->limit);
                $contentDitolak = $qDitolak->paginate($this->limit);
                $contentVisitasi = $qVisitasi->paginate($this->limit);
                $contentSelesai = $qSold->paginate($this->limit);
                $viewPaging = 'web.agent.transaction.paginate';
                break;
        }

        if(!empty($contentMenunggu)){
            foreach ($contentMenunggu as $key => $value) {
                if (!empty($value->detailProduct)){
                    $value->detailProduct->price = $this->format_angka($value->detailProduct->price);
                    $value->detailProduct->sales_commission = $this->format_angka($value->detailProduct->sales_commission);
                }
            }
        }
        if(!empty($contentDisetujui)){
            foreach ($contentDisetujui as $key => $value) {
                if (!empty($value->detailProduct)){
                    $value->detailProduct->price = $this->format_angka($value->detailProduct->price);
                    $value->detailProduct->sales_commission = $this->format_angka($value->detailProduct->sales_commission);
                }
            }
        }
        if(!empty($contentDitolak)){
            foreach ($contentDitolak as $key => $value) {
                if (!empty($value->detailProduct)){
                    $value->detailProduct->price = $this->format_angka($value->detailProduct->price);
                    $value->detailProduct->sales_commission = $this->format_angka($value->detailProduct->sales_commission);
                }
            }
        }
        if(!empty($contentVisitasi)){
            foreach ($contentVisitasi as $key => $value) {
                if (!empty($value->detailProduct)){
                    $value->detailProduct->price = $this->format_angka($value->detailProduct->price);
                    $value->detailProduct->sales_commission = $this->format_angka($value->detailProduct->sales_commission);
                }
            }
        }
        if(!empty($contentSelesai)){
            foreach ($contentSelesai as $key => $value) {
                if (!empty($value->detailProduct)){
                    $value->detailProduct->price = $this->format_angka($value->detailProduct->price);
                    $value->detailProduct->sales_commission = $this->format_angka($value->detailProduct->sales_commission);
                }
            }
        }

        $data = [
            'keyword' => '',
            'limit' => $this->limit,
            'contents' => $contentMenunggu,
            'contentDisetujui' => $contentDisetujui,
            'contentDitolak' => $contentDitolak,
            'contentVisitasi' => $contentVisitasi,
            'contentSelesai' => $contentSelesai,
            'waitingCount' => $countMenunggu,
            'visitingCount' => $countVisitasi,
            'confirmCount' => $countDisetujui,
            'soldCount' => $countSelesai,
            'cancelCount' => $countDitolak
        ];
        if($request->ajax()){
            $view = view($viewPaging, $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.agent.transaction.list', $data);
    }

    private function reArrangeProduct2($id){
        $detail = Visitation::where('id', $id)->first();
        
        $information = [
            'harga' => $this->format_angka($detail->detailProduct->price),
            'komisi' => $this->format_angka($detail->detailProduct->sales_commission),
            'kondisi' => $detail->detailProduct->condition,
            'brand' => $detail->detailProduct->detailBrand->name,
            'tipe' => $detail->detailProduct->detailType->name,
            'varian' => $detail->detailProduct->detailVariant->name,
            'tranmisi' => $detail->detailProduct->transmission,
            'warna' => $detail->detailProduct->detailColor->name ?? '',
            'kode_warna' => $detail->detailProduct->detailColor->code ?? '',
            'jarak_tempuh' => $detail->detailProduct->detailKm->name,
            'tahun' => $detail->detailProduct->production_year,
            'kapasitas_mesin' => $detail->detailProduct->detailMachineCapacity->name, 
            'bahan_bakar' => $detail->detailProduct->fuel,
            'tipe_bodi' => $detail->detailProduct->detailBodyType->name,
            'kapasitas_penumpang' => $detail->detailProduct->passanger_capacity,
            'tangan_ke' => $detail->detailProduct->detailOwner->name,
            'pajak' => $detail->detailProduct->end_of_tax == '1970-01-01' ? '-' : $detail->detailProduct->end_of_tax,
            'kode_plat' => $detail->detailProduct->detailVehicleCode->name,
            'judul' => $detail->detailProduct->name,
            'deskripsi' => $detail->detailProduct->summary,
            'visit_date' => date('D d M Y, H:i', strtotime($detail->date.' '.$detail->time)).' WIB',
            'location' => $detail->location,
            'customer_address' => $detail->customer_address,
            'customer_name' => $detail->customer_name
        ];
        $sales = [
            'harga' => $this->format_angka($detail->detailProduct->price),
            'komisi' => $this->format_angka($detail->detailProduct->sales_commission),
            'sistem_pembayaran' => $detail->detailProduct->payment_type
        ];
        if(!empty($detail->detailProduct->photo_exterior_front) && File::exists(storage_path('app/public/'.$detail->detailProduct->photo_exterior_front))) 
            $detail->detailProduct->photo_exterior_front = url('storage/'.$detail->detailProduct->photo_exterior_front);
        else
            $detail->detailProduct->photo_exterior_front = url('storage/noimages.jpg');

        if(!empty($detail->detailProduct->photo_exterior_back) && File::exists(storage_path('app/public/'.$detail->detailProduct->photo_exterior_back))) 
            $detail->detailProduct->photo_exterior_back = url('storage/'.$detail->detailProduct->photo_exterior_back);
        else
            $detail->detailProduct->photo_exterior_back = url('storage/noimages.jpg');

        if(!empty($detail->detailProduct->photo_exterior_left) && File::exists(storage_path('app/public/'.$detail->detailProduct->photo_exterior_left))) 
            $detail->detailProduct->photo_exterior_left = url('storage/'.$detail->detailProduct->photo_exterior_left);
        else
            $detail->detailProduct->photo_exterior_left = url('storage/noimages.jpg');

        if(!empty($detail->detailProduct->photo_exterior_right) && File::exists(storage_path('app/public/'.$detail->detailProduct->photo_exterior_right))) 
            $detail->detailProduct->photo_exterior_right = url('storage/'.$detail->detailProduct->photo_exterior_right);
        else
            $detail->detailProduct->photo_exterior_right = url('storage/noimages.jpg');

        if(!empty($detail->detailProduct->photo_interior_front) && File::exists(storage_path('app/public/'.$detail->detailProduct->photo_interior_front))) 
            $detail->detailProduct->photo_interior_front = url('storage/'.$detail->detailProduct->photo_interior_front);
        else
            $detail->detailProduct->photo_interior_front = url('storage/noimages.jpg');
        
        if(!empty($detail->detailProduct->photo_interior_center) && File::exists(storage_path('app/public/'.$detail->detailProduct->photo_interior_center))) 
            $detail->detailProduct->photo_interior_center = url('storage/'.$detail->detailProduct->photo_interior_center);
        else
            $detail->detailProduct->photo_interior_center = url('storage/noimages.jpg');

        if(!empty($detail->detailProduct->photo_interior_behind) && File::exists(storage_path('app/public/'.$detail->detailProduct->photo_interior_behind))) 
            $detail->detailProduct->photo_interior_behind = url('storage/'.$detail->detailProduct->photo_interior_behind);
        else
            $detail->detailProduct->photo_interior_behind = url('storage/noimages.jpg');
            
        if(!empty($detail->detailProduct->photo_machine) && File::exists(storage_path('app/public/'.$detail->detailProduct->photo_machine))) 
            $detail->detailProduct->photo_machine = url('storage/'.$detail->detailProduct->photo_machine);
        else
            $detail->detailProduct->photo_machine = url('storage/noimages.jpg');
            
        $photos = [
            $detail->detailProduct->photo_exterior_front,
            $detail->detailProduct->photo_exterior_back,
            $detail->detailProduct->photo_exterior_left,
            $detail->detailProduct->photo_exterior_right,
            $detail->detailProduct->photo_interior_front,
            $detail->detailProduct->photo_interior_center,
            $detail->detailProduct->photo_interior_behind,
            $detail->detailProduct->photo_machine
        ];

        $return = new \stdClass();
        $return->detail = $detail;
        $return->photos = $photos;
        $return->sales = $sales;
        $return->information = $information;
        return $return;
    }

    public function detailWaiting($id)
    {
        $agent = $this->agent_info();
        $product = $this->reArrangeProduct2($id);

        $result['id_produk'] = $product->detail->detailProduct->id;
        $result['info'] = $product->information;
        $result['sales'] = $product->sales;
        $result['foto'] = $product->photos;
        
        $result['etalase'] = 0;
        return view('web.agent.transaction.detail_waiting', $result);
    }
    
    public function detailVisitation($id)
    {
        $agent = $this->agent_info();
        $product = $this->reArrangeProduct2($id);

        $result['id_produk'] = $product->detail->detailProduct->id;
        $result['info'] = $product->information;
        $result['sales'] = $product->sales;
        $result['foto'] = $product->photos;
        $result['detail'] = $product->detail;
        
        $result['etalase'] = 0;
        return view('web.agent.transaction.detail_visitation', $result);
    }
    
    public function detailDone($id)
    {
        $agent = $this->agent_info();
        $product = $this->reArrangeProduct2($id);

        $result['id_produk'] = $product->detail->detailProduct->id;
        $result['info'] = $product->information;
        $result['sales'] = $product->sales;
        $result['foto'] = $product->photos;
        $result['detail'] = $product->detail;
        
        $result['etalase'] = 0;
        return view('web.agent.transaction.detail_done', $result);
    }

    public function checkout(Request $request){
        $visitationId = decrypt($request->id);
        $update = Visitation::where('id', $visitationId)->update([
            'status' => 'Selesai'
        ]);

        if ($update){
            return redirect('transaction')->with('success','Checkout produk berhasil');
        }else{
            return redirect('transaction')->with('danger','Checkout produk gagal, coba ulangi kembali');
        }
    }

}
