<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class CharityController extends Controller
{

    public function index()
    {
        $data = [];
        return view('web.charity', $data);
    }
}
