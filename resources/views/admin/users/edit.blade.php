@extends('admin.layouts.main')

@section('title', "Редактирование пользователя".$user->email)

@section('content')
  <div class="title-block">   
    <h1 class="title">Редакирование пользовател {{ $user->email }}</h1>
  </div>
  <form action="" class="form" id="add-user-form">
    {{ csrf_field() }}
    <div class="box">
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Логин</div>
          <label for="email" class="input">
            <input type="text" id="email" name="email" placeholder="Логин пользователя" value="{{ $user->email ?? '' }}"/>
          </label>
        </div>
        <div class="col-6">
          <div class="select__title">Роль пользователя</div>
          <label for="role" class="select">
            <select name="role" id="role" data-placeholder="Роль">
              <option></option>
              <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Администратор</option>
              <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Модератор</option>
            </select>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-6">
          <div class="input__title">Пароль</div>
          <label for="password" class="input">
            <input type="password" id="password" name="password" placeholder="••••••••"/>
          </label>
        </div>
        <div class="col-6">
          <div class="input__title">Повторите пароль</div>
          <label for="password-repeat" class="input">
            <input type="password" id="password-repeat" name="passwordRepiat" placeholder="••••••••"/>
          </label>
        </div>
      </div>
      <div class="row padding">
        <div class="col-12">
          <button type="submit" class="btn center opacity">Добавить</button>
        </div>
      </div>
    </div>
  </form>
@endsection