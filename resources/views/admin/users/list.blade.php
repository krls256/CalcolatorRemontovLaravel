@extends('admin.layouts.main')

@section('title', "Пользователи")

@section('content')
  <div class="title-block">
      <h1 class="title">Список пользователей</h1>
      <a href="/admin/users/add" class="btn">Добавить</a>
  </div>
  @if( count( $users ) == 0 )
    <div class="box info-box">Нет активных пользователей.</div>
  @endif

  @if( count( $users ) > 0 )
    @foreach($users as $user)
      <div class="box flex box-list">
        <div class="box-list__name">
          <a href="/admin/users/{{ $user->id }}">{{ $user->email }}</a>
          <span><a href="/admin/users/del/{{ $user->id }}/" class="del">Удалить</a></span>
        </div>
        <div class="box-list__send">
          <a href="/admin/users/{{ $user->id }}" class="btn opacity">Редактировать</a>
        </div>
      </div>
    @endforeach
  @endif
@endsection