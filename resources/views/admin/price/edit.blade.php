@extends('admin.layouts.main')

@section('title', 'Редактирование сметы ' . $name)

@section('content')
    <div class="title-block">
        <h1 class="title">Ред. приайс-листа "{{ $name }}"</h1>
    </div>
    <form action="" metchod="POST" class="form" id="edit-price-form">
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="box">
            <div class="box__title">Общие данные</div>
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">Наименование</div>
                    <label class="input">
                        <input type="text" name="title" placeholder="Пол">
                    </label>
                </div>
                <div class="col-6">
                    <div class="input__title">Тип услуги?</div>
                    <label for="type" class="select">
                        <select name="type" id="type" data-placeholder="Монтажные работы">
                            <option></option>
                            <option >Без сортировки</option>
                            <option value="1">Демонтажные работы</option>
                            <option value="5">Потолок</option>
                            <option value="2">Стены</option>
                            <option value="3">Пол</option>
                            <option value="4">Монтажные работы</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-6">
                    <div class="input__title">Стоимость за ед.</div>
                    <label class="input">
                        <input type="text" name="price" placeholder="300">
                        <span>руб.</span>
                    </label>
                </div>
                <div class="col-6">
                    <div class="input__title">В чем измеряется?</div>
                    <label for="measure" class="select">
                        <select name="measure" id="measure" data-placeholder="м²">
                            <option></option>
                            <option value="1">м²</option>
                            <option value="2">шт.</option>
                            <option value="3">м/п</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="row padding">
                <div class="col-12">
                    <input class="btn center opacity" type="submit" value="Добавить" />
                </div>
            </div>
        </div>
    </form>
    <div class="box flex box-list th">
        <div class="col-8">
            <div class="input__title">Наименование</div>
        </div>
        <div class="col-2">
            <div class="input__title">Стоимость</div>
        </div>
        <div class="col-1">
            <div class="input__title">Ед. изм.</div>
        </div>
        <div class="col-1">
            <div class="input__title"></div>
        </div>
    </div>
    <div id="list">
        @if( count($data) )
            @foreach($data as $item)
                <div class="box flex box-list th price-list">
                    <div class="col-8">{{ $item->title }}</div>
                    <div class="col-2">{{ $item->price }} руб.</div>
                    <div class="col-1">
                        @if($item->measure == 1)
                            м²
                        @elseif ($item->measure == 2)
                            шт.
                        @else
                            м/п
                        @endif
                    </div>
                    <div class="col-1">
                        <a href="/admin/price/del/{{ $item->id }}" >
                            <svg viewBox="0 0 329.26933 329" xmlns="http://www.w3.org/2000/svg"><path d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0" fill="#9e9e9e" /></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        @else 
            <div class="box notice">Нет не одного пункта!</div>
        @endif
    </div>
@endsection