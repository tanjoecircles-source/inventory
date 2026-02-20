<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index(){
        $data = [];
        return view('core.'.$this->device_detector().'.landing', $data);
    }
}