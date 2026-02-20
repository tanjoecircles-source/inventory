<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\RefBodyType;
use Illuminate\Support\Facades\Auth;

class RefBodyTypeController extends Controller
{
    public function list(Request $request)
    {
        $limit = 10;
        $search = (isset($_GET['keyword'])) ? $_GET['keyword'] : "";
        $contents = DB::table('ref_body_type')
            ->select('*')
            ->whereRaw('1 = 1')
            ->where(function ($contents) use ($search) {
                $contents->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'DESC')
            ->paginate($limit);

        $counts = DB::table('ref_body_type')
            ->where(function ($contents) use ($search) {
                $contents->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'DESC')
            ->count();

        if (!empty($contents)) {
            foreach ($contents as $key => $value) {
                $value->created_at = date('d M Y', strtotime($value->created_at));
            }
        }
        $data = [
            'keyword' => $search,
            'limit' => $limit,
            'contents' => $contents,
            'contents_count' => $counts
        ];
        if ($request->ajax()) {
            $view = view('web.admin.ref_body_type.paginate', $data)->render();
            return response()->json(['html' => $view]);
        }
        return view('web.admin.ref_body_type.list', $data);
    }
    public function add()
    {
        return view('web.admin.ref_body_type.add');
    }

    public function create(Request $request)
    {
        $valid = validator($request->only('name'), [
            'name' => 'required',

        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name');

        DB::beginTransaction();
        $insert = RefBodyType::create([
            'name' => $data['name'],

        ]);
        if ($insert) {
            DB::commit();
            return redirect('body-type-list')->with('success', 'Data has been created');
        } else {
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to create, try again later');
        }
    }

    public function detail($id)
    {
        $data = RefBodyType::where(['id' => $id])->first();
        return view('web.admin.ref_body_type.detail', $data);
    }

    public function edit($id)
    {
        $data = RefBodyType::where(['id' => $id])->first();
        return view('web.admin.ref_body_type.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $valid = validator($request->only('name'), [
            'name' => 'required',

        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        $data = $request->only('name');
        DB::beginTransaction();
        $update = RefBodyType::where('id', $id)->update([
            'name' => $data['name'],

        ]);
        if ($update) {
            DB::commit();
            return redirect('body-type-list')->with('success', 'Data has been updated');
        } else {
            DB::rollback();
            return redirect()->back()->with('danger', 'Data failed to update, try again later');
        }


    }
    public function delete($id)
    {
        $data = RefBodyType::find($id);
        if (is_null($data)) {
            return redirect('body-type-detail/' . $id)->with('danger', 'Something Wrong, data not found.');
        } elseif (!$data->delete()) {
            return redirect('body-type-detail/' . $id)->with('danger', 'Something Wrong, Data failed to delete.');
        } else {
            return redirect('body-type-list')->with('success', 'Data has been deleted.');
        }
    }
}
