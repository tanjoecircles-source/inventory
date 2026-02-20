<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\File;
//use Jenssegers\Agent\Agent;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $product_image_width = "600";
    public $product_image_height = "450";

    public static function currency($data) {
        $return = "Rp ".number_format($data, 0, ',', '.');
        return $return;
    }

    // public static function device() {
    //     $agent = new Agent();
    //     $return = $agent->isDesktop();
    //     return $return;
    // }
    public function usertanjoe()
    {
        $data = DB::table('users AS u')
            ->select(
                'u.*'
            )
            ->where('u.id', Auth::user()->id)
            ->first();
        return $data;
    }

    public function seller_info()
    {
        $data = DB::table('users AS u')
            ->leftJoin('seller AS s', 's.user', '=', 'u.id')
            ->leftJoin('region AS r', 'r.id', '=', 's.region')
            ->leftJoin('district AS d', 'd.id', '=', 's.district')
            ->select(
                's.*',
                's.id AS seller_id',
                'u.name AS seller_name',
                'u.phone AS seller_phone',
                'u.ifseller',
                'r.name AS region_name',
                'd.name AS district_name',
            )
            ->where('u.id', Auth::user()->id)
            ->first();
        return $data;
    }

    public function agent_info()
    {
        $data = DB::table('users AS u')
            ->leftJoin('agent AS a', 'a.user', '=', 'u.id')
            ->leftJoin('region AS r', 'r.id', '=', 'a.region')
            ->leftJoin('district AS d', 'd.id', '=', 'a.district')
            ->select(
                'a.*',
                'a.id AS agent_id',
                'u.name AS agent_name',
                'u.phone AS agent_phone',
                'u.ifseller',
                'r.name AS region_name',
                'd.name AS district_name',
            )
            ->where('u.id', Auth::user()->id)
            ->first();
        return $data;
    }

    public function year_range($range=30){
        $first = Carbon::now()->subYears($range)->year;
        $now = Carbon::now()->year;
        $no = 0;
        for($i=$now;$i>$first;$i--){
            $data[$no]['id']     = $i;
            $data[$no]['name']   = $i;
            $no++;
        }
        return (object)$data;
    }

    public function format_angka($angka) {
        $frmt = "Rp ".number_format($angka, 0, ',', '.');
        return $frmt;
    }

    public function device_detector(){
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        $mobile_version = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));    
        $result = $mobile_version ? 'mobile/' : '';
        return $result;
    }

    protected function reArrangeProduct($id){
        $return  = new \stdClass();
        $product = Product::where('id', $id)->firstOrFail();
        $return->information = [
            'harga' => $this->format_angka($product->price),
            'komisi' => $this->format_angka($product->sales_commission),
            'kondisi' => $product->condition,
            'brand' => $product->detailBrand->name,
            'tipe' => $product->detailType->name,
            'varian' => $product->detailVariant->name,
            'tranmisi' => $product->transmission,
            'warna' => $product->detailColor->name,
            'kode_warna' => $product->detailColor->code,
            'jarak_tempuh' => $product->detailKm->name,
            'tahun' => $product->production_year,
            'kapasitas_mesin' => $product->detailMachineCapacity->name, 
            'bahan_bakar' => $product->fuel,
            'tipe_bodi' => $product->detailBodyType->name,
            'kapasitas_penumpang' => $product->passanger_capacity,
            'tangan_ke' => $product->detailOwner->name,
            'pajak' => $product->end_of_tax == '1970-01-01' ? '-' : $product->end_of_tax,
            'kode_plat' => $product->detailVehicleCode->name,
            'judul' => $product->name,
            'deskripsi' => $product->summary,
        ];
        $return->sales = [
            'harga' => $this->format_angka($product->price),
            'komisi' => $this->format_angka($product->sales_commission),
            'sistem_pembayaran' => $product->payment_type
        ];
        if(!empty($product->photo_exterior_front) && File::exists(storage_path('app/public/'.$product->photo_exterior_front))) 
            $product->photo_exterior_front = url('storage/'.$product->photo_exterior_front);
        else
            $product->photo_exterior_front = url('storage/noimages.jpg');

        if(!empty($product->photo_exterior_back) && File::exists(storage_path('app/public/'.$product->photo_exterior_back))) 
            $product->photo_exterior_back = url('storage/'.$product->photo_exterior_back);
        else
            $product->photo_exterior_back = url('storage/noimages.jpg');

        if(!empty($product->photo_exterior_left) && File::exists(storage_path('app/public/'.$product->photo_exterior_left))) 
            $product->photo_exterior_left = url('storage/'.$product->photo_exterior_left);
        else
            $product->photo_exterior_left = url('storage/noimages.jpg');

        if(!empty($product->photo_exterior_right) && File::exists(storage_path('app/public/'.$product->photo_exterior_right))) 
            $product->photo_exterior_right = url('storage/'.$product->photo_exterior_right);
        else
            $product->photo_exterior_right = url('storage/noimages.jpg');

        if(!empty($product->photo_interior_front) && File::exists(storage_path('app/public/'.$product->photo_interior_front))) 
            $product->photo_interior_front = url('storage/'.$product->photo_interior_front);
        else
            $product->photo_interior_front = url('storage/noimages.jpg');
        
        if(!empty($product->photo_interior_center) && File::exists(storage_path('app/public/'.$product->photo_interior_center))) 
            $product->photo_interior_center = url('storage/'.$product->photo_interior_center);
        else
            $product->photo_interior_center = url('storage/noimages.jpg');

        if(!empty($product->photo_interior_behind) && File::exists(storage_path('app/public/'.$product->photo_interior_behind))) 
            $product->photo_interior_behind = url('storage/'.$product->photo_interior_behind);
        else
            $product->photo_interior_behind = url('storage/noimages.jpg');
            
        if(!empty($product->photo_machine) && File::exists(storage_path('app/public/'.$product->photo_machine))) 
            $product->photo_machine = url('storage/'.$product->photo_machine);
        else
            $product->photo_machine = url('storage/noimages.jpg');
            
        $return->photos = [
            $product->photo_exterior_front,
            $product->photo_exterior_back,
            $product->photo_exterior_left,
            $product->photo_exterior_right,
            $product->photo_interior_front,
            $product->photo_interior_center,
            $product->photo_interior_behind,
            $product->photo_machine
        ];

        return $return;
    }
}
