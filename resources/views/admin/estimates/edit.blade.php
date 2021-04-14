@extends('admin.layouts.main')

@section('title', 'Редактирование сметы '.$name)

@section('content')
  <div class="title-block">
    <h1 class="title">Ред. сметы "{{ $name }}"</h1>
  </div>
  <form action="" metchod="POST" class="form" id="edit-estimates-form">
    <input type="hidden" name="estimate" value="{{ $id }}">
    <div class="box">
      <div class="box__title">Общие данные</div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Укладка кабеля + штробление</div>
          <label class="input">
            <input type="text" name="installing[electrical]" placeholder="Цена за п/м" value="{{ $data['installing']['electrical'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Разводка труб(1 водоточка)</div>
          <label class="input">
            <input type="text" name="installing[piping]" placeholder="Цена за ед." value="{{ $data['installing']['piping'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="box__title">Демонтажные работы</div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Демонтаж полотенцесушителя</div>
          <label class="input">
            <input type="text" name="dismantling[towelRail]" placeholder="Цена за ед." value="{{ $data['dismantling']['towelRail'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Демонтаж унитаза</div>
          <label for="dismantlingToilet" class="input">
            <input type="text" name="dismantling[toilet]" placeholder="Цена за ед." value="{{ $data['dismantling']['toilet'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Демонтаж раковины</div>
          <label class="input">
            <input type="text" name="dismantling[sink]" placeholder="Цена за ед." value="{{ $data['dismantling']['sink'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Демонтаж ванны/душа</div>
          <label class="input">
            <input type="text" name="dismantling[bath]" placeholder="Цена за ед." value="{{ $data['dismantling']['bath'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Демонтаж плинтусов</div>
          <label class="input">
            <input type="text" name="dismantling[plinth]" placeholder="Цена за м/п" value="{{ $data['dismantling']['plinth'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Демонтаж розеток/выключателей</div>
          <label class="input">
            <input type="text" name="dismantling[sockets]" placeholder="Цена за ед." value="{{ $data['dismantling']['sockets'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="box__title">Установка</div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Установка полотенцесушителя</div>
          <label class="input">
            <input type="text" name="installing[towelRail]" placeholder="Цена за ед." value="{{ $data['installing']['towelRail'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Установка унитаза</div>
          <label class="input">
            <input type="text" name="installing[toilet]" placeholder="Цена за ед." value="{{ $data['installing']['toilet'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Установка раковины</div>
          <label class="input">
            <input type="text" name="installing[sink]" placeholder="Цена за ед." value="{{ $data['installing']['sink'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Установка ванны/душа</div>
          <label class="input">
            <input type="text" name="installing[bath]" placeholder="Цена за ед." value="{{ $data['installing']['bath'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Установка плинтуса</div>
          <label class="input">
            <input type="text" name="installing[plinth]" placeholder="Цена за м/п" value="{{ $data['installing']['plinth'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Установка розеток/выключателей</div>
          <label class="input">
            <input type="text" name="installing[sockets]" placeholder="Цена за ед." value="{{ $data['installing']['sockets'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="box__title">Отделка пола</div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Плитка</div>
          <label class="input">
            <input type="text" name="floor[tile]" placeholder="Цена за м²" value="{{ $data['floor']['tile'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Паркетная доска</div>
          <label class="input">
            <input type="text" name="floor[parquet]" placeholder="Цена за м²" value="{{ $data['floor']['parquet'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Ламинат</div>
          <label class="input">
            <input type="text" name="floor[laminate]" placeholder="Цена за м²" value="{{ $data['floor']['laminate'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Керамогранит</div>
          <label class="input">
            <input type="text" name="floor[stoneware]" placeholder="Цена за м²" value="{{ $data['floor']['stoneware'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Стяжка пола</div>
          <label class="input">
            <input type="text" name="floor[screed]" placeholder="Цена за м²" value="{{ $data['floor']['screed'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Грунтовка пола</div>
          <label class="input">
            <input type="text" name="floor[floor_primer]" placeholder="Цена за м²" value="{{ $data['floor']['floor_primer'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="box__title">Отделка потолка</div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Натяжной потолок</div>
          <label class="input">
            <input type="text" name="сeiling[stretch]" placeholder="Цена за м²" value="{{ $data['сeiling']['stretch'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Окраска</div>
          <label class="input">
            <input type="text" name="сeiling[сoloration]" placeholder="Цена за м²" value="{{ $data['сeiling']['сoloration'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Подвесной</div>
          <label class="input">
            <input type="text" name="сeiling[pvc]" placeholder="Цена за м²" value="{{ $data['сeiling']['pvc'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="box__title">Отделка стен</div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Оклейка обоями</div>
          <label class="input">
            <input type="text" name="wall[wallpaper]" placeholder="Цена за м²" value="{{ $data['wall']['wallpaper'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Окраска</div>
          <label class="input">
            <input type="text" name="wall[сoloration]" placeholder="Цена за м²" value="{{ $data['wall']['сoloration'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Плитка</div>
          <label class="input">
            <input type="text" name="wall[tile]" placeholder="Цена за м²" value="{{ $data['wall']['tile'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Шпатлевка стен</div>
          <label class="input">
            <input type="text" name="wall[putty]" placeholder="Цена за м²" value="{{ $data['wall']['putty'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Штукатурка стен</div>
          <label class="input">
            <input type="text" name="wall[plaster]" placeholder="Цена за м²" value="{{ $data['wall']['plaster'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Грунтовка стен</div>
          <label class="input">
            <input type="text" name="wall[wall_primer]" placeholder="Цена за м²" value="{{ $data['wall']['wall_primer'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
    </div>
    <div class="box">
      <div class="box__title">Плиточные работы</div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Затирка</div>
          <label class="input">
            <input type="text" name="tail[grout]" placeholder="Цена за м²" value="{{ $data['tail']['grout'] }}"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Подрезка</div>
          <label class="input">
            <input type="text" name="tail[pruning]" placeholder="Цена за м²" value="{{ $data['tail']['pruning'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Демонтаж</div>
          <label class="input">
            <input type="text" name="dismantling[tail]" placeholder="Цена за м²"  value="{{ $data['dismantling']['tail'] }}"/>
            <span>руб.</span>
          </label>
        </div>
      </div>
    </div>
    <div class="footer">
      <button type="submit" class="btn center opacity">Сохранить</button>
    </div>
  </form>
@endsection