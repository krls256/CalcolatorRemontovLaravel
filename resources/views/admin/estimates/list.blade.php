@extends('admin.layouts.main')

@section('title', "Сметы")

@section('content')
  <div class="title-block">
    <h1 class="title">Список смет</h1>
    <a href="/admin/estimates/add" class="btn">Добавить</a>
  </div>

  @if ( Request::get('status') )
    @if ( Request::get('status') == 'ok')
      <div class="box notice success">Смета успешно удалена.</div>
    @else
      <div class="box notice error">Не удалось удалить смету.</div>
    @endif
  @endif

  @if ( count( $estimates ) ) 
    @foreach($estimates as $estimate)
      <div class="box flex box-list">
        <div class="box-list__name">
          <a href="/admin/estimates/edit/{{ $estimate->id }}">{{ $estimate->name }}</a>
          <span><a href="/admin/estimates/del/{{ $estimate->id }}/" class="del">Удалить</a></span>
        </div>
        <div class="box-list__send">
          <a href="/admin/estimates/edit/{{ $estimate->id }}" class="btn opacity">Редактировать</a>
        </div>
      </div>
    @endforeach
  @else
    <div class="box notice">Не найдено не одной сметы!</div>
  @endif
@endsection