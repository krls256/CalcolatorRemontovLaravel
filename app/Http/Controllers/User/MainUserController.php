<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainUserController extends Controller
{
    public function amateur() {
        return view('calculator.amateur');
    }
}
