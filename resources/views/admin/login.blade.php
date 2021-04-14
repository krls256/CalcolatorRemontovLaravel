@extends('admin.layouts.login')

@section('title', "Авторизация")

@section('content')

<div class="header">
    <h1>Авторизация</h1>
</div>
<form action="" class="form" id="login-form">
    {{ csrf_field() }}
    <label for="login" class="input">
        <input type="text" id="login" name="login" placeholder="Логин">
    </label>
    <label for="password" class="input">
        <input type="password" id="password" name="password" placeholder="Пароль">
    </label>
    <div class="screen-info"></div>
    <button type="submit" class="btn">Войти</button>
</form>
@endsection