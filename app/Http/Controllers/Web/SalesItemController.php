<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\SalesItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SalesItemController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('sales_items s')
                    ->leftJoin('product AS p', 'p.id', '=', 's.itm_product')
                    ->select('s.*', 'p.name', 'p.price')
                    ->where(['s.author' => Auth::user()->id])
                    ->where(function($contents) use ($search){
                        $contents->where('p.name', 'like', '%'.$search.'%');
                    })
                    ->orderBy('id', 'DESC')
                    ->paginate($limit);

        $counts = DB::table('sales_items')
                ->where(['s.author' => Auth::user()->id])
                ->where(function($contents) use ($search){
                    $contents->where('p.name', 'like', '%'.$search.'%');
                })
                ->orderBy('id', 'DESC')
                ->count();

        if(!empty($contents)){
            foreach ($contents as $key => $value) {
                $value->inv_date = date('d M Y', strtotime($value->inv_date));
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if($request->ajax()){
            $view = view('web.admin.sales_item.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.sales_item.list', $data);
    }

    public function combo(Request $request){
        $data = $request->all();
        $keyword = empty($data['search']) ? "" : $data['search'];
        $contents = DB::table('logistic_items')
                    ->select('id', 'itm_name AS text')
                    ->whereRaw('1 = 1')
                    ->where(function($contents) use ($keyword){
                        $contents->where('itm_name', 'like', '%'.$keyword.'%');
                    })
                    ->orderBy('itm_name', 'ASC')
                    ->get();
        return response()->json(['results' => $contents ? $contents : array()]);
    }

    public function add($id)
    {
        $data = [
            'inv_id' => $id,
            'product' => Product::all()
        ];
        return view('web.admin.sales_items.add', $data);
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('inv_id', 'itm_product', 'itm_price', 'itm_qty', 'itm_total'), [
            'inv_id' => 'required',
            'itm_product' => 'required',
            'itm_price' => 'required',
            'itm_qty' => 'required',
            'itm_total' => 'required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('inv_id', 'itm_product', 'itm_price', 'itm_qty', 'itm_total');
        DB::beginTransaction();
        $insert = SalesItem::create([
            'itm_inv_id' => $data['inv_id'],
            'itm_product' => $data['itm_product'],
            'itm_price' => str_replace('.', "", $data['itm_price']),
            'itm_qty' => $data['itm_qty'],
            'itm_total' => str_replace('.', "", $data['itm_total']),
            'author' => Auth::user()->id
        ]);
        $product_stock = Product::where('id', $data['itm_product'])->value('stock');
        if($product_stock < (FLOAT)$data['itm_qty']){
            DB::rollback();
            return redirect('sales-item-add/'.$data['inv_id'])->with('danger', 'Proses Gagal, Jumlah quantity produk tidak dapat melebihi stok!');
        }
        $update_stock = (FLOAT)$product_stock - (FLOAT)$data['itm_qty'];
        $result = $insert && Product::where('id', $data['itm_product'])->update(['stock' => $update_stock]);
        if ($result){
            DB::commit();
            return redirect('sales-detail/'.$data['inv_id'])->with('success','Data has been created');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $inv_id = $_GET['inv'];
        $detail = DB::table('sales_items AS s')
            ->leftJoin('product AS p', 'p.id', '=', 's.itm_product')
            ->select('s.*','p.name AS product_name', 'p.price AS product_price', 'p.type')
            ->where(['s.id' => $id, 's.itm_inv_id' => $inv_id])
            ->first();
        $data = ['detail' => $detail];
        return view('web.admin.sales_items.detail', $data);
    }

    public function edit($id)
    {
        $data = SalesItem::where(['id' => $id])->first();
        $data->inv_date = date('d-m-Y', strtotime($data->inv_date));
        return view('web.admin.logistic_items.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('itm_name', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment'), [
            'itm_name' => 'required',
            'inv_date' => 'required',
            'inv_source' => 'required',
            'inv_total' => 'required',
            'inv_status_payment' => 'required'
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('itm_name', 'inv_date', 'inv_source', 'inv_total', 'inv_status_payment');
        DB::beginTransaction();
        $update = SalesItem::where('id', $id)->update([
            'itm_name' => $data['itm_name'],
            'inv_date' => date('Y-m-d', strtotime($data['inv_date'])),
            'inv_source' => $data['inv_source'],
            'inv_total' => $data['inv_total'],
            'inv_status_payment' => $data['inv_status_payment'],
            'author' => Auth::user()->id
        ]);
        if ($update){
            DB::commit();
            return redirect('logistic-list')->with('success','Data has been updated');
        }else{
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }
    }
    
    public function delete($id)
    {
        $inv_id = $_GET['inv'];
        $data = SalesItem::find($id);
        if (is_null($data)){
            return redirect('sales-detail/'.$inv_id)->with('danger','Something Wrong, data not found.');
        }elseif (!$data->delete()){
            return redirect('sales-detail/'.$inv_id)->with('danger','Something Wrong, Data failed to delete.');
        }else{
            $product_stock = Product::where('id', $data['itm_product'])->value('stock');
            $update_stock = (FLOAT)$product_stock + (FLOAT)$data['itm_qty'];
            Product::where('id', $data['itm_product'])->update(['stock' => $update_stock]);
            return redirect('sales-detail/'.$inv_id)->with('success','Data has been deleted.');
        }
    }
}
