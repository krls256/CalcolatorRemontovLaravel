<?php

namespace App\Http\Controllers\Download;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainDownloadController extends Controller
{
    public function index(Request $request) {
        $file_path = storage_path() . '/app/';

        return response()->download($file_path . $request->url);
    }
}
