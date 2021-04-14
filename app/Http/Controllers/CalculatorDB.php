<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CalculatorDB extends Controller
{
    private $query = [];  # Массив запроса
  private $area;
  private $id;          # ID компании 

  /**
   * Получаем id компании
   * 
   * @param int $id - ID компании
   * 
   * @return void
   */
  function __construct( $id )
  {
    $this->id =  $id;
  }

  /**
   * Добавляем параметры в массив запроса
   * 
   * @param string $name - название поля
   * @param string $type - тип поля
   * 
   * @return void
   */
  public function setParametr($name, $type = 'all')
  {
    array_push($this->query, [
      'type'        => $type,      # Тип параметра
      'name'        => $name       # Название параметра
    ]);
  }

  /**
   * Для удобства делаем добавление параметров через массив
   * 
   * @param array $array - Массив параметров
   * 
   * @return void
   */
  public function setParametrs( $array )
  {
    foreach ($array as $key => $value) 
      $this->setParametr($key, $value);
  }

  /**
   * Подготовка запроса 
   * 
   * @param object $query
   * 
   * @return Illuminate\Support\Facades\DB
   */
  protected function training( $query ) 
  {
    # Перебераем все параметры
    foreach($this->query as $value) {
      $query->orWhere(Function ($query) use ($value) {
        $query->where($value);
      });
    } 
  }

  /**
   * Получаем результат запроса 
   * 
   * @return 
   */
  public function get()
  {
    $init =  DB::table('estimatesMeta')
      ->select('name', 'type', 'meta', 'dimension')
      ->where('estimate_id', $this->id)   # ID Компании
      ->where(function ($query) {
        $this->training( $query ); 
      });

    return $init->get();
  }
}
