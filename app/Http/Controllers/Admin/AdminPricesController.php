<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminPricesController extends Controller
{
    /**
     * @return View
     */
    public function index() {
        $companies = DB::table('company')->get();
        return view('admin.price.list', ['companies' => $companies]);
    }

    public function del($id, Request $req) {
        $sql = DB::table('meta_price')->where('id', $id);
        $companyId = $sql->first();
        $sql->delete();

        if ($req->isMethod('get'))
            return redirect('admin/price/edit/' . $companyId->company_id);
        else
            return response()->json([
                'code'      => 'ok',
                'message'   => ''
            ]);
    }

    public function edit(int $id) {
        $company = DB::table('company')
            ->where('id', $id)
            ->first();

        $data = DB::table('meta_price')
            ->where('company_id', $company->id)
            ->get();

        return view('admin.price.edit', [
            'id'   => $company->id,
            'name' => $company->name,
            'data' => $data
        ]);
    }
}
