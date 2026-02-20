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
use App\Models\AgentInfo;
use App\Models\Visitation;
use App\Models\Etalase;
use App\Models\Product;
use App\Mail\RequestVisitation;
use App\Mail\ConfirmVisitation;
use Illuminate\Support\Facades\Mail;

class VisitationController extends Controller
{
    public function index($id)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $default_date = $date->format('d-m-Y');
        $default_time = $date->modify('+12 hours')->format('H:i');       
        $etalase = Etalase::where('id', $id)->first();
        $result = [
            'id' => $id,
            'default_date' => $default_date,
            'default_time' => $default_time,
            'product' => $etalase->product,
            'agent' => $etalase->agent
        ];
        return view('web.agent.visitasi.visitasi', $result);
    }

    public function submit(Request $request)
    {
        $data = $request->all();
        $valid = validator($data, [
            'date' => 'required',
            'time' => 'required',
            'location' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'request' => 'max:300'
        ]);
        if ($valid->fails()) return redirect()->back()->withErrors($valid)->withInput();
        DB::beginTransaction();
        $insert = Visitation::create([
            'code' => strtolower($this->generate_code(8)),
            'product' => $data['product'],
            'agent' => $data['agent'],
            'date' => date('Y-m-d', strtotime($data['date'])),
            'time' => $data['time'],
            'location' => $data['location'],
            'customer_name' => $data['customer_name'],
            'customer_address' => $data['customer_address'],
            'request' => $data['request'],
            'status' => 'Menunggu Konfirmasi',
            'author' => Auth::user()->id,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
        $update = Etalase::where(['product' => $data['product'], 'agent' => $data['agent']])->update(['status' => 'false']);
        if ($insert && $update){
            DB::commit();

            //queued email to requester (agent)
            Mail::to(Auth::user()->email)->queue(new RequestVisitation([
                'title' => 'Pengajuan Visitasi'
            ]));
            //queued email to owner (seller)
            $product = Product::where('id', $data['product'])->first();
            $agent = AgentInfo::where('user', Auth::user()->id)->first();
            Mail::to($product->detailSeller->detailUser->email)->queue(new ConfirmVisitation([
                'title' => 'Konfirmasi Pengajuan Visitasi',
                'agent' => $agent,
                'product' => $product,
                'date' => date('Y-m-d', strtotime($data['date'])),
                'time' => $data['time'],
            ]));

            return redirect('etalase')->with('success','Visitasi Berhasil Diajukan');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Gagal Mengajukan');
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
