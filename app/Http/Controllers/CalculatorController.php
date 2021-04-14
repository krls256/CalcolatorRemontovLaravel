<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CalculatorDB;

class CalculatorController extends Controller
{
  protected $estimateId;  # ID компании в текущей итерации
  protected $typeRoom;
  protected $all    = []; # Общие данные
  public    $result = []; # Возвращаем результат

  /**
   * Сортируем параметры
   * 
   * @param array $req - Данные request
   * @return array - Сортированый массив
   */
  public function sort($req)
  {
    $data = [];

    foreach ($req as $key => $value)
      $data[$key] = (gettype($value) == 'array') ? array_values($value) : $value;

    return $data;
  }

  /**
   * Считаем и сортируем по цене
   * 
   * @param array $data - Получиные данные из бызы
   */
  public function total($data)
  {

    $price = 0;

    foreach ($data as $key => $value) {
      if ( gettype( current($value) ) == 'array' ) {
        $price += $this->total($value);
      } else {
        $price += isset($value['price']) ? $value['price'] : 0;
      }
    }

    return $price;
  }

  /****************************************************************************************************/
  /**
   * Считаем цену
   * 
   * @param array $array - Массив с ценнами на услугу
   * 
   * @return int
   */
  public function sum( $array ) 
  { 
    $return     = [];
    $height     = $this->all['height'] ? $this->all['height'] : 2.7;
    $P          = ($this->long*2)+($this->width*2);

    $door = $this->typeRoom == 'hallway' ? 4 : 1;

    #Площадь окна
    $pw = $this->windows * 2.26;
    $pd = 1.8*$door;

    $wellArea   = (($P*$height)-($pw+$pd))/$this->divider;
    $area       = $this->long*$this->width;

    foreach ($array as $key => $value)
    {
      $price = $value->meta;
      unset($value->meta);

      switch ($value->dimension) {
        case 1:
          $metric = 'м²';
          break;
        case 2:
          $metric = 'шт.';
          break;
        case 3:
          $metric = 'п/м';
          break;
      }

      $value->dimension = 1;
  
      # Стоимость * площадь стен
      if ( $value->type == "wall") {
        $value->dimension = round($wellArea/0.5)*.5;
        $price            = $price*$wellArea;
      }

      # Стоимость * площадь пола или потолка
      if ( $value->type == "сeiling" || $value->type == "floor") { 
        $value->dimension = round($area/0.5)*.5;
        $price            = $price*$area;
      }

      # Если есть прокладка провода, то тоже считаем
      if ($value->name == 'electrical' ) {
        $value->dimension = "6 " . $metric;
        $price            = ($price*2)*3;
      }

      if ( $value->name == 'sockets' ) {
        $value->dimension = 3;
        $price            = $price*3;
      }

      # Разводка труб для горячей и холодной воды в ванной
      if ($value->name == 'piping' && $this->typeRoom == 'bathroom') {
        $value->dimension = 5;
        $price = $price*5;
      }

      # Разводка труб для горячей и холодной воды в ванной
      if ($value->name == 'piping' && $this->typeRoom == 'kitchen' ) {
        $value->dimension = 2;
        $price = $price*2;
      }

      # Считаем длинну плинтуса
      if ( $value->name == 'plinth' ) {
        $value->dimension = round($P * 10) / 10;
        $price = $P * $price;
      }

      if ( $value->name == "floor_primer" || $value->name == "wall_primer" ) {
        $price = $price*2;
      }

      $value->price   = (int) $price;  # Приобразуем строку в число
      $value->metric  = $metric;

      foreach ($value as $name => $row) 
      {
        if ( count($array) == 1 )
          $return[$name] = $row;
        else
          $return[$key][$name] = $row;
      }
    }
  
    return $return;
  }

  /**
   * Подсчитываем дополнительные услуги
   * 
   * @param mixed $data
   */
  public function get( $data )
  {
    $query = new CalculatorDB($this->estimateId);
  
    foreach ($data as $key => $value) 
    {
      # Добаляем в запрос сантехнику
      if ($key == 'plumbing') {
        $query->setParametrs([
          'sink'    => $value,
          'toilet'  => $value,
          'bath'    => $value
        ]);
      }

      # Добавляем в запрос
      if ( $value == 'change' ) {
        $query->setParametr($key, 'installing');
        $query->setParametr($key, 'dismantling');
      }

      $query->setParametr($key, $value);
    }
    
    $ret = $query->get();
    
    return $ret;
  }

  /**
   * получаем цены пы комнатам
   * 
   * @param int   $id     - ID компании
   * @param array $value  - Данные
   * @param float $height - Высота потолка
   * 
   * @return array
   */
  public function getPriceRoom($value)
  {
    $res = [];

    # Перебераем комнату одного типа
    foreach ($value as $key => $value) {
      $param          = [];
      $this->long     = $value['long'];
      $this->width    = $value['width'];
      $this->windows  = isset($value['windows']) ? $value['windows'] : 0;
      $this->divider  = isset($value['divider']) ? $value['divider'] : 1;

      unset($value['long']);
      unset($value['width']);
      unset($value['windows']);
      unset($value['divider']);

      # Добавляем отделку если это ноостройка
      if ( $this->all['type'] == '0' && !isset($this->all['calc']) ) {
        switch ($this->typeRoom) {
          case 'bathroom':
            $value['still']['piping']       = 'installing';
            $value['still']['bath']         = 'installing';
            $value['still']['toilet']       = 'installing';
            $value['still']['sink']         = 'installing';
            $value['still']['putty']        = 'wall';
            $value['still']['screed']       = 'floor';
            break;
          default:
            $value['still']['plaster']        = 'wall';
            $value['still']['screed']         = 'floor';
            $value['still']['floor_primer']   = 'floor';
            $value['still']['wall_primer']    = 'wall';
            $value['still']['putty']          = 'wall';
            break;
        }
      }

      foreach ($value as $name => $type) {
        $typeGet      = gettype($type) == 'array' ? $type : [$type => $name];
        $param[$name] = $this->get($typeGet);
      }

      $res[$key] = $this->getRoom($param);
    }

    return $res;
  }

  /**
   * Получаем общие 
   * 
   * @param array $data - данные из калькулятора
   * 
   * @return void
   */
  public function allData($data)
  {
    $this->all = $data['all'];
    unset($data['all']);

    return $data;
  }

  /**
   * Подсчитываем каждую комнату
   * 
   * @param array $data - Получиные данные из бызы
   */
  public function getRoom($data)
  {
    $ret = [];
    
    foreach ($data as $key => $val) {
      if ( gettype($val) == 'array' ) {
        $ret[$key] = $this->getRoom($val);
      } else {
        $ret[$key] = $this->sum($val);  
      }
    }

    return $ret;
  }

  /** 
   * Счетаем
   * 
   * @param int   $id   - ID компании
   * @param array $data - Дынные с калькулятора
   */
  public function calc($data)
  {                       
    $res = [];

    # Перебераем компанту по типам
    foreach ($data as $key => $value) {
      $this->typeRoom = $key;
      $res[$key] = $this->getPriceRoom($value);
    }

    return $res;
  }

  /**
   * Сортировка компаний по цене
   * 
   * @param array $data - Массив с компаниями
   * 
   * @return array
   */
  public function companySort($data) 
  {
    usort($data, function ($a, $b) {
      if ($a['price'] == $b['price']) return 0;
      return ($a['price'] < $b['price']) ? -1 : 1;
    });

    return $data;
  }

  /**
   * Получаем данные от калькулятора
   * 
   * @param Illuminate\Http\Request
   */
  public function score(Request $req)
  {
    $req      = $this->allData($req->all());    # Удаляем общие данные
    $req      = $this->sort($req);              # Сортируем данные
    $company  = DB::table('estimates')->get();  # Получаем список смет
    $res      = [];                             # Складируем результат

    # Перебераем сметы 
    foreach ($company as $key => $row) {
      $this->estimateId = $row->id;  # Пишем id компании в глобальную переменную
      
      $calc = $this->calc($req);
      $com  = DB::table('company')
                ->where('id', $row->company_id)->first();

      $ret = [
        'id'        => $row->id,
        'name'      => $row->name,
        'img'       => $com->logo,
        'url'       => $com->url,
        'price'     => $this->total($calc),
        'details'   => $calc
      ];

      /**
       * Результат вычисления по 1 компании.
       * Складируем в переменную для дальнейшей передачи в шаблон.
       */
      array_push($res, $ret);
    }

    $res = $this->companySort($res);

    return response()->json($res);
  }

  /**
   * 
   */
  public function getTypeRemont(Type $var = null)
  {
    $type = $this->all['type'];

    switch ($this->all['typeRem']) {
      case 0:
        $ret = [
          'kitchen' => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => [
              'screed'        => 'floor',
              'floor_primer'  => 'floor',
              'plinth'        => 'installing',
              'wall_primer'   => 'wall',
              'sink'          => 'installing',
              'piping'        => 'installing'
            ]  
          ],
          'bathroom' => [
            "сeiling" => "pvc",
            "wall"    => "tile",
            "floor"   => "tile",
            "still"   => [
              "sink"    => "change",
              "toilet"  => "change",
              "bath"    => "change",
              "sockets" => "change"
            ]
          ],
          'badroom' => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => $type==1 ? [
              'screed'        => 'floor',
              'wall_primer'   => 'wall',
              'floor_primer'  => 'floor',
              'plinth'        => 'change'
            ] : [
              "screed"        => "floor",
              'wall_primer'   => 'wall',
              'floor_primer'  => 'floor',
              'plinth'        => 'installing'
            ]
          ],
          'toilet'    => [
            [
              "сeiling" => "stretch",
              "wall"    => "wallpaper",
              "floor"   => "tile",
              "still"   => [
                "toilet"  => "change"
              ]
            ]
          ],
          'hallway' => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => [
              'screed'  => 'floor',
              'plinth'  => 'change'
            ]
          ]
        ];
        break;
      case 1:
        $ret = [
          'kitchen'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => $type == 1 ? [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "change",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sink"          => "change",
              "piping"        => "installing",
              "sockets"       => "change"
            ] : [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "sink"          => "installing",
              "plinth"        => "installing",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "piping"        => "installing",
              "sockets"       => "installing"
            ]
          ],
          'bathroom'  => [
            "сeiling" => "pvc",
            "wall"    => "tile",
            "floor"   => "tile",
            "still"   => $type == 1 ? [
              "toilet"    => "change",
              "bath"      => "change",
              "towelRail" => "change",
              "sink"      => "change",
              "piping"    => "installing",
              "sockets"   => "change"
            ] : [
              "toilet"    => "installing",
              "bath"      => "installing",
              "towelRail" => "installing",
              "sink"      => "installing",
              "piping"    => "installing",
              "sockets"   => "installing"
            ]
          ],
          'badroom'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => $type==1 ? [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "change",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sockets"       => "change"
            ] : [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "installing",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sockets"       => "installing"
            ]
          ],
          'toilet'    => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "tile",
            "still"   =>  $type==1 ? [
              "toilet"  => "change",
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall"
            ] : [
              "toilet"  => "installing",
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall"
            ]
          ],
          'hallway'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => $type==1 ? [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "change",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sockets"       => "change"
            ] : [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "installing",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sockets"       => "installing"
            ]
          ]
        ];
        break;
      case 2:
        $ret = [
          'kitchen'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => $type==1 ? [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "change",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sink"          => "installing",
              "piping"        => "installing",
              "sockets"       => "change"
            ] : [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "installing",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sink"          => "installing",
              "piping"        => "installing",
              "sockets"       => "installing"
            ]
          ],
          'bathroom'  => [
            "сeiling" => "pvc",
            "wall"    => "tile",
            "floor"   => "tile",
            "still"   => $type==1 ? [
              "toilet"    => "change",
              "bath"      => "change",
              "towelRail" => "change",
              "sink"      => "change",
              "piping"    => "installing",
              "sockets"   => "change"
            ] : [
              "toilet"    => "installing",
              "bath"      => "installing",
              "towelRail" => "installing",
              "sink"      => "installing",
              "piping"    => "installing",
              "sockets"   => "installing"
            ]
          ],
          'badroom'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   =>  $type==1 ? [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "change",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sockets"       => "change"
            ]: [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "installing",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sockets"       => "installing"
            ]
          ],
          'toilet'    => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "tile",
            "still"   => $type==1 ? [
              "toilet"  => "change",
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall"
            ] : [
              "toilet"  => "installing",
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall"
            ]
          ],
          'hallway'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => $type==1 ? [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "change",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sockets"       => "change"
            ] : [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "installing",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
              "sockets"       => "installing"
            ]
          ]
        ];
        break;  
      case 3:
        $ret = [
          'kitchen'   => [
            "still"   => [
              'screed'        => 'floor',
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
            ]
          ],
          'bathroom'  => [
            "сeiling" => "pvc",
            "wall"    => "tile",
            "floor"   => "tile",
            "still"   => [
              "bath"      => "installing",
              "piping"    => "installing"
            ]
          ],
          'badroom'   => [
            "still"   => [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
            ]
          ],
          'toilet'    => [
            "floor"   => "tile",
            "still"   => [
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall"
            ]
          ],
          'hallway'   => [
            "still"   => [
              'screed'        => "floor",
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plaster"       => "wall",
              "putty"         => "wall",
            ]
          ]
        ];
        break;
      case 4:
        $ret = [
          'kitchen'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "wall_primer"   => "wall",
              "plinth"        => "change",
              "sink"          => "change",
            ]
          ],
          'bathroom'  => [
            "сeiling" => "stretch",
            "wall"    => "tile",
            "floor"   => "tile",
            "still"    => [
              "toilet"  => "change",
              "sink"    => "change",
              "piping"  => "installing"
            ]
          ],
          'badroom'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"    => [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "change",
              "wall_primer"   => "wall"
            ]
          ],
          'toilet'    => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
          ],
          'hallway'   => [
            "сeiling" => "stretch",
            "wall"    => "wallpaper",
            "floor"   => "laminate",
            "still"   => [
              "screed"        => "floor",
              "floor_primer"  => "floor",
              "plinth"        => "change",
              "wall_primer"   => "wall",
            ]
          ]
        ];
        break;
    }

    return $ret;
  }
  
  /**
   * Считам проценит от общей площади
   */
  function getInfoRoom(array $array)
  {
    $typeRemont = $this->getTypeRemont();
    $aere       = $array['aere'];

    switch ($array['rooms']) {
      case 0:
        $data = [
          "kitchen"   => [
            array_merge($typeRemont['kitchen'], [
              "long"    => sqrt($aere*0.20),
              "width"   => sqrt($aere*0.20),
              "divider" => 2
            ])
          ],
          "badroom"   => [
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.64),
              "width"   => sqrt($aere*0.64),
              "windows" => 1
            ])
          ],
          "bathroom"  => [
            array_merge($typeRemont['bathroom'], [
              "long"    => sqrt($aere*0.16),
              "width"   => sqrt($aere*0.16)
            ])
          ]
        ];
        break;
      case 1:
        $data = [
          "kitchen"   => [
            array_merge($typeRemont['kitchen'], [
              "long"    => sqrt($aere*0.25),
              "width"   => sqrt($aere*0.25),
              "windows" => 1
            ])
          ],
          "badroom"   => [
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.445),
              "width"   => sqrt($aere*0.445),
              "windows" => 1
            ])
          ],
          "bathroom"  => [
            array_merge($typeRemont['bathroom'], [
              "long"    => sqrt($aere*0.11),
              "width"   => sqrt($aere*0.11)
            ])
          ],
          "hallway"   => [
            array_merge($typeRemont['hallway'], [
              "long"    => sqrt($aere*0.166),
              "width"   => sqrt($aere*0.166)
            ])
          ]
        ];
        break;
      case 2:
        $data = [
          "kitchen"   => [
            array_merge($typeRemont['kitchen'], [
              "long"    => sqrt($array['aere']*0.18),
              "width"   => sqrt($array['aere']*0.18),
              "windows" => 1
            ])
          ],
          "badroom"   => [
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($array['aere']*0.32),
              "width"   => sqrt($array['aere']*0.32),
              "windows" => 1
            ]), 
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($array['aere']*0.28),
              "width"   => sqrt($array['aere']*0.28),
              "windows" => 1
            ])
          ],
          "bathroom"  => [
            array_merge($typeRemont['bathroom'], [
              "long"    => sqrt($array['aere']*0.08),
              "width"   => sqrt($array['aere']*0.08)
            ])
          ],
          "hallway"   => [
            array_merge($typeRemont['hallway'], [
              "long"    => sqrt($array['aere']*0.16),
              "width"   => sqrt($array['aere']*0.16)
            ])
          ]
        ];
        break;
      case 3:        
        $data = [
          "kitchen"   => [
            array_merge($typeRemont['kitchen'], [
              "long"    => sqrt($aere*0.125),
              "width"   => sqrt($aere*0.125),
              "windows" => 1
            ])
          ],
          "badroom"   => [
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.222),
              "width"   => sqrt($aere*0.222),
              "windows" => 1
            ]),
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.222),
              "width"   => sqrt($aere*0.222),
              "windows" => 1
            ]),
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.194),
              "width"   => sqrt($aere*0.194),
              "windows" => 1
            ])
          ],
          "bathroom"  => [
            array_merge($typeRemont['bathroom'], [
              "long"    => sqrt($aere*0.055),
              "width"   => sqrt($aere*0.055)
            ])
          ],
          "toilet"    => [
            array_merge($typeRemont['toilet'], [
              "long"    => sqrt($aere*0.027),
              "width"   => sqrt($aere*0.027)
            ])
          ],
          "hallway"   => [
            array_merge($typeRemont['hallway'], [
              "long"    => sqrt($aere*0.125),
              "width"   => sqrt($aere*0.125)
            ])
          ]
        ];
        break;
      case 4:        
        $data = [
          "kitchen"   => [
            array_merge($typeRemont['kitchen'], [
              "long"    => sqrt($aere*0.137),
              "width"   => sqrt($aere*0.137),
              "windows" => 1
            ])
          ],
          "badroom"   => [
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.196),
              "width"   => sqrt($aere*0.196),
              "windows" => 1
            ]),
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.176),
              "width"   => sqrt($aere*0.176),
              "windows" => 1
            ]), 
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.156),
              "width"   => sqrt($array['aere']*0.156),
              "windows" => 1
            ]), 
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.137),
              "width"   => sqrt($aere*0.137),
              "windows" => 1
            ])
          ],
          "bathroom"  => [
            array_merge($typeRemont['bathroom'], [
              "long"    => sqrt($aere*0.058),
              "width"   => sqrt($aere*0.058)
            ]), 
            array_merge($typeRemont['bathroom'], [
              "long"    => sqrt($aere*0.039),
              "width"   => sqrt($aere*0.039)
            ])],
          "hallway"   => [
            array_merge($typeRemont['hallway'], [
              "long"    => sqrt($aere*0.098),
              "width"   => sqrt($aere*0.098)
            ])
          ]
        ];
        break;
      case 5:
        $data = [
          "kitchen"   => [
            array_merge($typeRemont['kitchen'], [
              "long"    => sqrt($aere*0.118),
              "width"   => sqrt($aere*0.118),
              "windows" => 1
            ])
          ],
          "badroom"   => [
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.157),
              "width"   => sqrt($aere*0.157),
              "windows" => 1
            ]), 
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.157),
              "width"   => sqrt($aere*0.157),
              "windows" => 1
            ]), 
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.141),
              "width"   => sqrt($aere*0.141),
              "windows" => 1
            ]), 
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.125),
              "width"   => sqrt($aere*0.125),
              "windows" => 1
            ]), 
            array_merge($typeRemont['badroom'], [
              "long"    => sqrt($aere*0.11),
              "width"   => sqrt($aere*0.11),
              "windows" => 1
            ])
          ],
          "bathroom"  => [
            array_merge($typeRemont['bathroom'], [
              "long"    => sqrt($aere*0.062),
              "width"   => sqrt($aere*0.062)
            ]), 
            array_merge($typeRemont['bathroom'], [
              "long"    => sqrt($aere*0.047),
              "width"   => sqrt($aere*0.047)
            ])
          ],
          "hallway"   => [
            array_merge($typeRemont['hallway'], [
              "long"    => sqrt($array['aere']*0.078),
              "width"   => sqrt($array['aere']*0.078)
            ])
          ]
        ];
        break;
    }

    return $data;
  }

  /**
   * Простой калькулятор ремонта
   */
  public function lite(Request $req)
  {
    Validator::make($req->all(), [
      'type'    => 'required|number',
      'typeRem' => 'required|number|max:5'
    ]);

    $company  = DB::table('estimates')->get();  # Получаем список смет
    $res      = [];                             # Складируем результат
    $this->all  = [
      'type'    => $req->type,
      'height'  => 2.7, 
      'typeRem' => $req->typeRem,
      'calc'    => 'lite'
    ]; 

    $data = $this->getInfoRoom($req->all());

    foreach ($company as $row) {
      $this->estimateId = $row->id;  # Пишем id компании в глобальную переменную
    
      $calc = $this->calc($data);
      $com  = DB::table('company')
        ->where('id', $row->company_id)
        ->first();
  
      $ret = [
        'id'        => $row->id,
        'name'      => $row->name,
        'img'       => $com->logo,
        'url'       => $com->url,
        'price'     => $this->total($calc),
        'details'   => $calc
      ];

      /**
       * Результат вычисления по 1 компании.
       * Складируем в переменную для дальнейшей передачи в шаблон.
       */
      array_push($res, $ret);
    }

    $res = $this->companySort($res);

    return response()->json($res);
  }

  
}
