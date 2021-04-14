<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainAdminController extends Controller
{
    /**
     * @return View
     */
    public function home() {
        return view('admin.home');
    }
}
