@extends('admin.layouts.main')

@section('title', "Добавить компанию")

@section('content')
  <div class="title-block">
    <h1 class="title">Добавить компанию</h1>
  </div>
    <form action="" class="form" id="add-company-form">
      {{ csrf_field() }}
      <div class="box">
        <div class="row padding">
          <div class="col-6">
            <div class="input__title">Названия компании<i style="color:#f00">*</i></div>
            <label for="name" class="input">
              <input type="text" id="name" name="name" placeholder="Ремонт">
            </label>
          </div>
          <div class="col-6">
            <div class="file__title">Логотип компании<i style="color:#f00">*</i></div>
            <label for="logo" class="file">
              <input type="file" name="logo" id="logo"/>
            </label>
          </div>
        </div>
        <div class="row padding">
          <div class="col-6">
            <div class="input__title">Web сайт<i style="color:#f00">*</i></div>
            <label for="site" class="input">
              <input type="text" id="site" name="site" placeholder="https://">
            </label>
          </div>
          <div class="col-6">
            <div class="input__title">Номер телефона<i style="color:#f00">*</i></div>
            <label for="phone" class="input">
              <input type="text" id="phone" name="phone" placeholder="+7 (___) ___-__-__">
            </label>
          </div>
        </div>
        <div class="row padding">
          <div class="col-6">
            <div class="input__title">Дата создания<i style="color:#f00">*</i></div>
            <label for="data" class="input">
              <input type="text" id="data" name="data" placeholder="01.01.1970" class="create_company" autocomplete="off" />
            </label>
          </div>
          <div class="col-6">
            <div class="input__title">Адрес компании<i style="color:#f00">*</i></div>
            <label for="address" class="input">
              <input type="text" id="address" name="address" placeholder="ул. Ленина, д. 1" />
            </label>
          </div>
          <div class="col-6">
            <div class="input__title">Email компании</div>
            <label for="email" class="input">
                <input type="text" id="email" name="email" placeholder="info@example.com"
                       value="{{ $email ?? '' }}" />
            </label>
        </div>
        </div>
      </div>
      <div class="box">
        <div class="row padding">
          <div class="col-6">
            <div class="input__title">Youtube</div>
            <label for="youtube" class="input">
              <input type="text" id="youtube" name="youtube" placeholder="https://"/>
            </label>
          </div>
          <div class="col-6">
            <div class="input__title">YELL ID</div>
            <label for="yell" class="input">
              <input type="text" id="yell" name="yell" placeholder="ID на площадке YELL"/>
            </label>
          </div>
        </div>
        <div class="row padding">
          <div class="col-6">
            <div class="input__title">FLAMP ID</div>
            <label for="flamp" class="input">
              <input type="text" id="flamp" name="flamp" placeholder="ID на площадке FLAMP"/>
            </label>
          </div>
          <div class="col-6">
            <div class="input__title">Yandex ShopID</div>
            <label for="yandex" class="input">
              <input type="text" id="yandex" name="yandex" placeholder="ID компании в yandex картах"/>
            </label>
          </div>
        </div>
        <div class="row padding">
          <div class="col-6">
            <div class="select__title">Рейтинг по RusProFile</div>
            <label for="profile" class="select">
              <select name="profile" id="profile" data-placeholder="Сколько звезд?">
                <option></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </label>
          </div>
        </div>
      </div>
      <div class="box">
        <div class="col-12">
          <textarea name="discription" id="discription" cols="30" rows="10"></textarea>
        </div>
      </div>
      <div class="footer">
        <button type="submit" class="btn center opacity">Добавить</button>
      </div>
    </form>
@endsection
