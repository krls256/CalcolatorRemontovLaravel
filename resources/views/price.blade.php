@extends('layouts.main')

@section('title', "Цены на ремонт квартир в Москве.")
@section('description', "В этом раздели вы можете подробно изучить смету каждой компании, и выбрать для себя самую подходящую.")

@section('content')

    <section class="section">
        <div class="content">
            <h1>Настоящие цены на ремонт квартиры в Москве.</h1>
            <div class="wrap">
                <div class="wd-12 boxes">
                    <h2 class="boxes__header sub_title">
                        Цены на ремонт квартир в Москве, цены взяты с риальных смет компаний.
                    </h2>
                    <div class="boxes__content p">
                        <p>Если вы хоть раз пытались найти цены на ремонт квартиры в Москве, то скорее всего вам не удалось найти что-то адекватное, именно поэтому мы решили собрать цены 10 крупных компаний.</p>
                        <p><strong>Раздел цены</strong> — это уникальная страница на которой опубликованы сметы 10 крупнейших ремонтных компаний Москвы. По какой-то причине не помог наш калькулятор? Не проблема! Теперь вы сами можете собственными руками посчитать стоимость ремонта основываясь на реальных сметах подрядчиков.</p>
                    </div>
                </div>
            </div>
            <div class="wrap">
                <div class="wd-3 mwd-12">
                    <div class="boxes">
                        <div class="boxes__header"><i class="boxes__img-orang icon-info"></i>Для чего этот раздел?</div>
                        <div class="boxes__content">
                        <div class="p">
                            <p>В этом раздели вы можете подробно изучить смету каждой компании и выбрать для себя самую подходящую.</p>
                        </div>
                        </div>
                    </div>
                    <div class="boxes super">
                        <div class="super__header">
                            Лучшая компания
                        </div>
                        <div class="rating__block">
                            <div class="rating__img">
                                <img src="/static/images/image.svg" data-src="{{ $super->logo }}" alt="{{ $super->name }}" class="lazy">
                                <noscript><img src="{{ $super->logo }}" alt="{{ $super->name }}"></noscript>
                            </div>
                            <div class="rating__name">
                                <a href="/rating/{{ $super->url }}">{{ $super->name }}</a>
                                <div>
                                    <span>Оценка:</span>
                                    @component('block.rating', ['rating' => ( $super->rating_profile + $super->rating_reviews)/2 ])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="super__footer">
                            <a class="link-button send-zamer" href="#animatedModal" data-id="{{ $super->id }}">Оставить заявку</a>
                        </div>
                    </div>
                </div>
                <div class="wd-9 mwd-12">
                    <div class="rating">
                        @foreach($companies as $company)
                            <div class="module rating-price">
                                <div class="rating__block">
                                    <div class="rating__img">
                                        <img src="/static/images/image.svg" data-src="{{ $company->logo }}" alt="{{ $company->name }}" class="lazy">
                                        <noscript><img src="{{ $company->logo }}" alt="{{ $company->name }}"></noscript>
                                    </div>
                                    <div class="rating__name">
                                        <a href="/rating/{{ $company->url }}/">{{ $company->name }}</a>
                                        <div>
                                            <span>Оценка:</span>
                                            @component('block.rating', ['rating' => ( $company->rating_profile + $company->rating_reviews)/2 ])
                                            @endcomponent                 
                                        </div>
                                    </div>
                                    <div class="rating__price">
                                        <span>Косметический</span>
                                        <span><i>От </i><strong>{{ $company->redecorating ?? '—' }}</strong> руб.</span>
                                    </div>
                                    <div class="rating__price">
                                        <span>Капитальный</span>
                                        <span><i>От </i><strong>{{ $company->overhaul ?? '—' }}</strong> руб.</span>
                                    </div>
                                    <div class="rating__price">
                                        <span>Евро</span>
                                        <span><i>От </i><strong>{{ $company->turnkey_repair ?? '—' }}</strong> руб.</span>
                                    </div>
                                </div>

                                <div class="rating__special">
                                    <div class="estimate">
                                        <div class=" estimate__price estimate-header">
                                            <span class="estimate-header__name">Полный прайс-лист</span>
                                            <span class="estimate-header__title">Ед. измерения</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 451.846 451.847"><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744 L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284 c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z" fill="#dcdcdc"></path></svg>
                                        </div>
                                        <div class="estimate__list">
                                            @foreach($company->priceList as $item)
                                                @if($item->group == null)
                                                    <div class="estimate__item">
                                                        <div>
                                                            <span>{{ $item->title }}</span>
                                                            <span>
                                                                @switch($item->measure)
                                                                    @case(2) шт. @break
                                                                    @case(3) м/п @break
                                                                    @default м² @break
                                                                @endswitch
                                                            </span>
                                                            <span><strong>{{ $item->price }}</strong> руб.</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="estimate__item">
                                                <div class="sub">
                                                    <span>Демонтажные работы</span>
                                                    <div class="estimate__list">
                                                        @foreach($company->priceList as $item)
                                                            @if ($item->group == 1)
                                                                <div class="estimate__item">
                                                                    <div>
                                                                        <span>{{ $item->title }}</span>
                                                                        <span>
                                                                            @switch($item->measure)
                                                                                @case(2) шт. @break
                                                                                @case(3) м/п @break
                                                                                @default м² @break
                                                                            @endswitch
                                                                        </span>
                                                                        <span><strong>{{ $item->price }}</strong> руб.</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="estimate__item">
                                                <div class="sub">
                                                    <span>Потолки</span>
                                                    <div class="estimate__list">
                                                        @foreach($company->priceList as $item)
                                                            @if ($item->group == 5)
                                                                <div class="estimate__item">
                                                                    <div>
                                                                        <span>{{ $item->title }}</span>
                                                                        <span>
                                                                            @switch($item->measure)
                                                                                @case(2) шт. @break
                                                                                @case(3) м/п @break
                                                                                @default м² @break
                                                                            @endswitch
                                                                        </span>
                                                                        <span><strong>{{ $item->price }}</strong> руб.</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="estimate__item">
                                                <div class="sub">
                                                    <span>Стены</span>
                                                    <div class="estimate__list">
                                                        @foreach($company->priceList as $item)
                                                            @if ($item->group == 2)
                                                                <div class="estimate__item">
                                                                    <div>
                                                                        <span>{{ $item->title }}</span>
                                                                        <span>
                                                                            @switch($item->measure)
                                                                                @case(2) шт. @break
                                                                                @case(3) м/п @break
                                                                                @default м² @break
                                                                            @endswitch
                                                                        </span>
                                                                        <span><strong>{{ $item->price }}</strong> руб.</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="estimate__item">
                                                <div class="sub">
                                                    <span>Пол</span>
                                                    <div class="estimate__list">
                                                        @foreach($company->priceList as $item)
                                                            @if ($item->group == 3)
                                                                <div class="estimate__item">
                                                                    <div>
                                                                        <span>{{ $item->title }}</span>
                                                                        <span>
                                                                            @switch($item->measure)
                                                                                @case(2) шт. @break
                                                                                @case(3) м/п @break
                                                                                @default м² @break
                                                                            @endswitch
                                                                        </span>
                                                                        <span><strong>{{ $item->price }}</strong> руб.</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="estimate__item">
                                                <div class="sub">
                                                    <span>Монтаж</span>
                                                    <div class="estimate__list">
                                                        @foreach($company->priceList as $item)
                                                            @if ($item->group == 4)
                                                                <div class="estimate__item">
                                                                    <div>
                                                                        <span>{{ $item->title }}</span>
                                                                        <span>
                                                                            @switch($item->measure)
                                                                                @case(2) шт. @break
                                                                                @case(3) м/п @break
                                                                                @default м² @break
                                                                            @endswitch
                                                                        </span>
                                                                        <span><strong>{{ $item->price }}</strong> руб.</span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='estimate__footer'>
                                            <span>Все цены были взяты из официальной сметы компании.</span>
                                            <a href="/download?url={{ $company->estimate }}" class="button__green" target="_blank">Скачать смету</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="wrap">
                <div class="mwd-12 boxes">
                    <h2 class="boxes__header">
                        <i class="boxes__img-turquoise icon-info"></i>
                        О рейтинге цен ремонта
                    </h2>
                    <div class="boxes__content p">
                    </div>
                </div>
            </div>
        </div>
        <div id="animatedModal">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="title">Оставить заявку</div>
                    <div class="close-animatedModal">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 340.8 340.8"><path d="M170.4,0C76.4,0,0,76.4,0,170.4s76.4,170.4,170.4,170.4s170.4-76.4,170.4-170.4S264.4,0,170.4,0z M170.4,323.6 c-84.4,0-153.2-68.8-153.2-153.2S86,17.2,170.4,17.2S323.6,86,323.6,170.4S254.8,323.6,170.4,323.6z"/><path d="M182.4,169.6l50-50c3.2-3.2,3.2-8.8,0-12c-3.2-3.2-8.8-3.2-12,0l-50,50l-50-50c-3.2-3.2-8.8-3.2-12,0 c-3.2,3.2-3.2,8.8,0,12l50,50l-50,49.6c-3.2,3.2-3.2,8.8,0,12c1.6,1.6,4,2.4,6,2.4s4.4-0.8,6-2.4l50-50l50,50c1.6,1.6,4,2.4,6,2.4 s4.4-0.8,6-2.4c3.2-3.2,3.2-8.8,0-12L182.4,169.6z"/></svg>
                    </div>
                </div>
                <div class="modal-layout">
                    <form id="send-application">
                        <input type="hidden" name="id">
                        <span>Ваше имя</span>
                        <label for="name" class="input">
                            <input type="text" name="name" id="name" placeholder="Иван" />
                        </label>
                        <span>Номер телефона</span>
                        <label for="phone" class="input">
                            <input type="text" name="phone" id="phone" />
                        </label>
                        <div class="window-notif"></div>
                        <div class="g-recaptcha"></div>
                        <button type="submit" class="link-button">Оставить заявку</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection