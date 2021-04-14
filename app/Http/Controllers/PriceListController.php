<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PriceListController extends Controller
{
    /**
     * Выводим компании с прайсами
     * 
     * @return view
     */
    public function get() 
    {
        $get =  DB::table('company')
            ->select('*', DB::raw('(`rating_profile` + `rating_reviews`)/2 as `ratingSort`'))
            ->orderBy('ratingSort', "DESC")
            ->get();
    
        foreach ($get as $value) {
            $meta =  DB::table('meta_price')
                ->where('company_id', $value->id)
                ->get();

            $value->priceList = $meta;
        }
        
        $super = $get->where('id', 8)->first();
        
        return view('price', [
            'companies' => $get, 
            'super'     => $super
        ]);
    }

    /**
     * Добавление пункта в прайс
     */
    public function add(Request $res)
    {
        $valid = Validator::make($res->all(), [
            'id'    => 'required|numeric',
            'type'  => '',
            'price' => 'required|numeric',
            'title' => 'required'
        ]);

        # Если данные не прошли валидацию
        if ( $valid->fails() ) { 
            return response()->json([
                'status'    => 'error',
                'type'      => 'validation',
                'message'   => $valid->errors()
            ]);
        }

        $sql    = DB::table('meta_price');
        $id     = $sql->insertGetId([
            'company_id'    => (int) $res->id,
            'group'         => $res->type ? (int) $res->type : null,
            'title'         => $res->title,
            'price'         => (int) $res->price,
            'measure'       => $res->measure
        ]);

        return response()->json([
            'code'  => 'ok',
            'data'  => [
                'id'            => $id,
                'type'          => $res->type,
                'title'         => $res->title,
                'price'         => $res->price,
                'measure'       => $res->measure
            ],
            'message' => ''
        ]);
    }
}
