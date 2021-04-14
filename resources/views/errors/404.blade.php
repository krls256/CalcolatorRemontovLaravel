@extends('layouts.main')

@section('title', "Стриница не найдена!")
@section('description', "Ну удалось найти указаную стриницу или она временно не доступна. Попробуйте зайти позже.")

@section('content')
    <section class="section">
        <div class="content">
            <h1>Страница не найдена!</h1>
            <div class="wrap">
                <div class="boxes wd-12 padding">
                    <div class="error404">Ошибка 404</div>
                    <div class="error404-title">Страница не найдена или временно недоступна. Проверте коректность введенной ссылки или зайдите позже.</div>
                    <a href="/" class="button__green error-btn">На главную</a>
                </div> 
            </div> 
        </div>
    </section>
@endsection