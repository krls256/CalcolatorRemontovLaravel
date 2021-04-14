@extends('admin.layouts.main')

@section('title', "Добавить смету")

@section('content')
  <div class="title-block">
    <h1 class="title">Добавить смету</h1>
  </div>
  <form action="" metchod="POST" class="form" id="add-estimates-form">
    <div class="box">
      <div class="row padding">
        <div class="col-6">
          <div class="select__title">Компания</div>
          <label for="role" class="select">
            <select name="company" id="company" data-placeholder="Выбрать">
              <option></option>
              @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
              @endforeach
            </select>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Укладка кабеля + штробление</div>
          <label class="input">
            <input type="text" name="installing[electrical][price]" placeholder="Цена за м/п" />
            <input type="hidden" name="installing[electrical][type]" value="3" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Разводка труб(1 водоточка)</div>
          <label class="input">
            <input type="text" name="installing[piping][price]" placeholder="Цена за ед." />
            <input type="hidden" name="installing[piping][type]" value="2" />
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
            <input type="text" name="dismantling[towelRail][price]" placeholder="Цена за ед." />
            <input type="hidden" name="dismantling[towelRail][type]" value="2" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Демонтаж унитаза</div>
          <label class="input">
            <input type="text" name="dismantling[toilet][price]" placeholder="Цена за ед." />
            <input type="hidden" name="dismantling[toilet][type]" value="2" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Демонтаж раковины</div>
          <label class="input">
            <input type="text" name="dismantling[sink][price]" placeholder="Цена за ед." />
            <input type="hidden" name="dismantling[sink][type]" value="2" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Демонтаж ванны/душа</div>
          <label class="input">
            <input type="text" name="dismantling[bath][price]" placeholder="Цена за ед." />
            <input type="hidden" name="dismantling[bath][type]" value="2" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Демонтаж плинтусов</div>
          <label class="input">
            <input type="text" name="dismantling[plinth][price]" placeholder="Цена за м/п" />
            <input type="hidden" name="dismantling[plinth][type]" value="3"/>
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Демонтаж розеток/выключателей</div>
          <label class="input">
            <input type="text" name="dismantling[sockets][price]" placeholder="Цена за ед." />
            <input type="hidden" name="dismantling[sockets][type]" value="2"/>
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
            <input type="text" name="installing[towelRail][price]" placeholder="Цена за ед." />
            <input type="hidden" name="installing[towelRail][type]" value="2" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Установка унитаза</div>
          <label class="input">
            <input type="text" name="installing[toilet][price]" placeholder="Цена за ед." />
            <input type="hidden" name="installing[toilet][type]" value="2" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Установка раковины</div>
          <label class="input">
            <input type="text" name="installing[sink][price]" placeholder="Цена за ед." />
            <input type="hidden" name="installing[sink][type]" value="2" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Установка ванны/душа</div>
          <label class="input">
            <input type="text" name="installing[bath][price]" placeholder="Цена за ед." />
            <input type="hidden" name="installing[bath][type]" value="2" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Установка плинтуса</div>
          <label class="input">
            <input type="text" name="installing[plinth][price]" placeholder="Цена за м/п"/>
            <input type="hidden" name="installing[plinth][type]" value="3" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Установка розеток/выключателей</div>
          <label class="input">
            <input type="text" name="installing[sockets][price]" placeholder="Цена за ед." />
            <input type="hidden" name="installing[sockets][type]" value="2"/>
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
          <label  class="input">
            <input type="text" name="floor[tile][price]" placeholder="Цена за м²" />
            <input type="hidden" name="floor[tile][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Паркетная доска</div>
          <label class="input">
            <input type="text" name="floor[parquet][price]" placeholder="Цена за м²" />
            <input type="hidden" name="floor[parquet][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Ламинат</div>
          <label class="input">
            <input type="text" name="floor[laminate][price]" placeholder="Цена за м²" />
            <input type="hidden" name="floor[laminate][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Керамогранит</div>
          <label class="input">
            <input type="text" name="floor[stoneware][price]" placeholder="Цена за м²" />
            <input type="hidden" name="floor[stoneware][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Стяжка</div>
          <label class="input">
            <input type="text" name="floor[screed][price]" placeholder="Цена за м²" />
            <input type="hidden" name="floor[screed][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Грунтовка пола</div>
          <label class="input">
            <input type="text" name="floor[floor_primer][price]" placeholder="Цена за м²"/>
            <input type="hidden" name="floor[floor_primer][type]" value="1" />
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
          <label  class="input">
            <input type="text" name="сeiling[stretch][price]" placeholder="Цена за м²" />
            <input type="hidden" name="сeiling[stretch][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Окраска</div>
          <label class="input">
            <input type="text" name="сeiling[сoloration][price]" placeholder="Цена за м²" />
            <input type="hidden" name="сeiling[сoloration][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Подвесной</div>
          <label class="input">
            <input type="text" name="сeiling[pvc][price]" placeholder="Цена за м²" />
            <input type="hidden" name="сeiling[pvc][type]" value="1" />
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
            <input type="text" name="wall[wallpaper][price]" placeholder="Цена за м²" />
            <input type="hidden" name="wall[wallpaper][type]" value="1">
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Окраска</div>
          <label class="input">
            <input type="text" name="wall[сoloration][price]" placeholder="Цена за м²" />
            <input type="hidden" name="wall[сoloration][type]" value="1">
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Плитка</div>
          <label class="input">
            <input type="text" name="wall[tile][price]" placeholder="Цена за м²" />
            <input type="hidden" name="wall[tile][type]" value="1">
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Шпатлевка стен</div>
          <label class="input">
            <input type="text" name="wall[putty][price]" placeholder="Цена за м²" />
            <input type="hidden" name="wall[putty][type]" value="1">
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Штукатурка стен</div>
          <label class="input">
            <input type="text" name="wall[plaster][price]" placeholder="Цена за м²" />
            <input type="hidden" name="wall[plaster][type]" value="1">
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Грунтовка стен</div>
          <label class="input">
            <input type="text" name="wall[wall_primer][price]" placeholder="Цена за м²"/>
            <input type="hidden" name="wall[wall_primer][type]" value="1">
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
            <input type="text" name="tail[grout][price]" placeholder="Цена за м²" />
            <input type="hidden" name="tail[grout][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Подрезка</div>
          <label class="input">
            <input type="text" name="tail[pruning][price]" placeholder="Цена за м²" />
            <input type="hidden" name="tail[pruning][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Демонтаж</div>
          <label class="input">
            <input type="text" name="dismantling[tail][price]" placeholder="Цена за м²" />
            <input type="hidden" name="dismantling[tail][type]" value="1" />
            <span>руб.</span>
          </label>
        </div>
      </div>
    </div>
    <div class="footer">
      <button type="submit" class="btn center opacity">Добавить</button>
    </div>
  </form>
@endsection