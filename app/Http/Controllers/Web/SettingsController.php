<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller
{
    public function index()
    {
        if (Gate::denies('isAdmin')) return view('error_authorize');
        return view('web.admin.settings.index');
    }
}