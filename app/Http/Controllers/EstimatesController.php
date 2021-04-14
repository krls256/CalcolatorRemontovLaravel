<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class EstimatesController extends Controller
{
  /**
   * Выводим список смет
   */
  public function getEstimates(Request $req)
  {
    $get = DB::table('estimates')->get();
    return view('admin.estimates.list', ['estimates' => $get]);
  }

  /**
   * Создаем смету
   * 
   * @param Illuminate\Http\Request
   * @return Illuminate\Http\Response\Json
   */
  public function addEstimates(Request $req)
  {
    $valid = Validator::make($req->all(), [
      'company'               => 'required|numeric',
      'floor.*.price'         => 'required|numeric',
      'wall.*.price'          => 'required|numeric',
      'сeiling.*.price'       => 'required|numeric',
      'installing.*.price'    => 'required|numeric',
      'dismantling.*.price'   => 'required|numeric'
    ]);

    # Если данные не прошли валидацию
    if ( $valid->fails() ) { 
      return response()->json([
        'status'    => 'error',
        'type'      => 'validation',
        'message'   => $valid->errors()
      ]);
    }

    $companyName  = DB::table('company')->where('id', $req->company)->first();
    $create       = DB::table('estimates')->insertGetId([
      'company_id'    => $req->company,
      'name'          => $companyName->name 
    ]);

    $data = [];
    
    # Перебераем массив входящих данных
    foreach($req->all() as $key => $value) {
      if ($key === 'company') continue; # Удаляем пункт id сомпании

      foreach ($value as $name => $row) {
        array_push($data, [
          'type'        => $key, 
          'name'        => $name, 
          'dimension'   => $row['type'],
          'meta'        => $row['price'],
          'estimate_id' => $create]); 
      }
    }

    $insert = DB::table('estimatesMeta')->insert($data);

    return response()->json([
      'code' => $insert ? 'success' : 'error',
    ]);
  }

  /**
   * Редактирование сметы
   * 
   * @param Illuminate\Http\Request
   * @return Illuminate\Support\Facades\View
   */
  public function editEstimates($id)
  {
    $name       = DB::table('estimates')->where('id', $id)->first();
    $db         = DB::table('estimatesMeta')->where('estimate_id', $id)->get();
    
    $data;

    foreach ($db as $key => $value) {
      $data[$value->type][$value->name] = $value->meta;
    }
 
    return view('admin.estimates.edit', [
      'id'        => $id,
      'name'      => $name->name,
      'data'      => $data
    ]);
  }

  /**
   * Удаляем смету
   * 
   * @param integer $id ID сметы
   */
  public function delete($id)
  {
    try {
      DB::table('estimates')->where('id', $id)->delete();
      DB::table('estimatesMeta')->where('estimate_id', $id)->delete();

      return redirect('/admin/estimates?status=ok');
    } catch (QueryException $e) {
      return redirect('/admin/estimates?status=error');
    }
  }
  
  /**
   * Редактирование сметы
   * 
   * @param Illuminate\Http\Request
   */
  public function edit(Request $req)
  {
    $valid = Validator::make($req->all(), [
      'estimate'      => 'required|numeric',
      'floor.*'       => 'required|numeric',
      'wall.*'        => 'required|numeric',
      'сeiling.*'     => 'required|numeric',
      'installing.*'  => 'required|numeric',
      'dismantling.*' => 'required|numeric',
      'tail.*'        => 'required|numeric'
    ]);

    # Если данные не прошли валидацию
    if ( $valid->fails() ) { 
      return response()->json([
        'code'    => 'error',
        'type'      => 'validation',
        'message'   => $valid->errors()
      ]);
    }
  
    foreach ($req->all() as $key => $value) 
    {
      if( $key == 'estimate') continue;
      
      foreach ($value as $name => $meta )
        DB::table('estimatesMeta')
          ->where([
            'type'        => $key, 
            'name'        => $name, 
            'estimate_id' => $req->estimate])
          ->update([
            'meta'  =>$meta
          ]);
    }

    return response()->json([
      'code'  => 'ok',
      'message' => ''
    ]);
  }
}
