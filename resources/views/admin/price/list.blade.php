@extends('admin.layouts.main')

@section('title', "Цены")

@section('content')
    <div class="title-block">
        <h1 class="title">Прайс лесты</h1>
    </div>
  
    @if( @count($companies) )
        @foreach($companies as $com)
            <div class="box flex box-list">
                <div class="box-list__img">
                    <img src="/{{ $com->logo }}" alt="{{ $com->name }}">
                </div>
                <div class="box-list__name">
                    <a href="/admin/price/edit/{{ $com->id }}">{{ $com->name }}</a>
                </div>
                <div class="box-list__send">
                    <a href="/admin/price/edit/{{ $com->id }}" class="btn opacity">Редактировать</a>
                </div>
            </div>
        @endforeach
    @else
        <div class="box notice">Не найдено не одной компании!</div>
    @endif
@endsection