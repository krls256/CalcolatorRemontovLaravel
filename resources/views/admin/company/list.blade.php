@extends('admin.layouts.main')

@section('title', "Компании")

@section('content')
  <div class="title-block">
    <h1 class="title">Список компаний</h1>
    <a href="/admin/companies/add" class="btn">Добавить</a>
  </div>
  @if ( Request::get('status') )
    @if ( Request::get('status') == 'ok')
      <div class="box notice success">Компания успешно удалена.</div>
    @else
      <div class="box notice error">Не удалось удалить компанию.</div>
    @endif
  @endif

  @if ( count( $companies ) ) 
    @foreach($companies as $company)
      <div class="box flex box-list">
        <div class="box-list__img">
          <img src="/{{ $company->logo }}" alt="{{ $company->name }}"/>
        </div>
        <div class="box-list__name">
          <a href="/admin/companies/{{ $company->url }}">{{ $company->name }}</a>
          <span>
            <a href="/company/{{ $company->url }}/">Просмотр</a>
            <a href="/admin/companies/del/{{ $company->id }}/" class="del">Удалить</a>
          </span>
        </div>
        <div class="box-list__send">
          <a href="/admin/companies/{{ $company->url }}" class="btn opacity">Редактировать</a>
        </div>
      </div>
    @endforeach

  @else
    <div class="box notice">Нет компаний.</div>
  @endif
@endsection