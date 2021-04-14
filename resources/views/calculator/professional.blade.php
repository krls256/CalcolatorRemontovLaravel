@extends('layouts.main')

@section('title', 'Калькулятор ремонта')
@section('description', 'Калькулятор ремонта квартир - это уникальный сервик который поможет вам посчитать стоимость ремонта вашей квартиры.')

@section('content')

    <div class="content">
        <h1>Профессиональный калькулятор ремонта</h1>
        <div class="wrap">
            <div class="wd-3 mwd-12">
                @component('block.menuCalculator', ['info' => false])
                @endcomponent
                <div class="boxes super">
                    <div class="super__header">
                        Лучшая компания
                    </div>
                    <div class="rating__block">
                        <div class="rating__img">
                            <img src="/static/images/image.svg" data-src="{{ $super->logo }}" alt="{{ $super->name }}" class="lazy">
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
                <form method="POST" action="" class="calc-prof">
                    <div class="boxes">
                        <div class="boxes__header"><i class="boxes__img-pink icon-dashboard"></i>Общие данные</div>
                        <div class="calc__content">
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Тип помещения</div>
                                    <div class="calc-trigger">
                                        <input type="hidden" name="all[type]" value="1">
                                        <span data-val="0">Новостройка</span>
                                        <span data-val="1" class="active">Вторичка</span>
                                    </div>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Высота потолка</div>
                                    <label for="areaHeight" class="input">
                                        <input type="text" name="all[height]" id="areaHeight" placeholder="Высота" value="2.7" autocomplete="off" data-test="true">
                                        <span>м</span>
                                    </label>
                                </div>
                            </div>
                            <div class="calc-block">
                                <div class="wd-12 mwd-12">
                                    <label class="checkbox">
                                        <input name="all[electrical]" type="checkbox" class="checkbox__input">
                                        <div class="checkbox__block"><svg width="20px" height="20px" viewBox="0 0 20 20"><path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path><polyline points="4 11 8 15 16 6"></polyline></svg></div>
                                        <span>Проводка электрики</span>
                                    </label>
                                    <div class="info tooltip" data-text="Проводка электрики подразумевает укладка кабеля для 3-х электроточек(2-х розеток и люстры) с штроблением и заделкой штроб."></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="calc-prof__header">
                        <div class="add">
                            <a class="add__button" href="#calcWindow">
                                <svg viewBox="0 0 469.33333 469.33333" xmlns="http://www.w3.org/2000/svg" width="22" height="22">
                                    <path class="add__img" d="m437.332031 192h-160v-160c0-17.664062-14.335937-32-32-32h-21.332031c-17.664062 0-32 14.335938-32 32v160h-160c-17.664062 0-32 14.335938-32 32v21.332031c0 17.664063 14.335938 32 32 32h160v160c0 17.664063 14.335938 32 32 32h21.332031c17.664063 0 32-14.335937 32-32v-160h160c17.664063 0 32-14.335937 32-32v-21.332031c0-17.664062-14.335937-32-32-32zm0 0"/>
                                </svg>
                                <span>Добавить<span>
                            </a>
                        </div>
                        <div class="edit">
                            <i class="edit__controll-back" data-controll="back">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 451.846 451.847"><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744 L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284 c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z" fill="#fff"/></svg>
                            </i>
                            <div>
        
                            </div>
                            <i class="edit__controll-next" data-controll="next">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 451.846 451.847"><path d="M345.441,248.292L151.154,442.573c-12.359,12.365-32.397,12.365-44.75,0c-12.354-12.354-12.354-32.391,0-44.744 L278.318,225.92L106.409,54.017c-12.354-12.359-12.354-32.394,0-44.748c12.354-12.359,32.391-12.359,44.75,0l194.287,194.284 c6.177,6.18,9.262,14.271,9.262,22.366C354.708,234.018,351.617,242.115,345.441,248.292z" fill="#fff"/></svg>
                            </i>
                        </div>
                    </div>
                    <div class="calc-prof__content">
                        <div class="empty">Добавте комнату.</div>
                    </div>
                    <div class="calc-prof__footer">
                        <div class="block__buttom">
                            <button class="button__blue">Добавить комнату</button>
                            <button type="submit" class="button__green inactive">Рассчитать</button>
                        </div>
                    </div>
                </form>
                <div class="prof rating" id="rating"></div>
            </div>
        </div>
        <div class="wrap">
            <div class="mwd-12 boxes">
                <div class="boxes__header">
                    <i class="boxes__img-turquoise icon-info"></i>
                    О профессиональном калькуляторе
                </div>
                <div class="boxes__content p">
                    <div>
                        <p><strong>Калькулятор ремонта</strong> – это удобный инструмент, который посчитает стоимость ремонта Вашей квартиры за считанные секунды.</p>
                        <p>Система подбора выгодных предложений разработана на основе информаций, предоставленной 10-ю лучшими ремонтными компаниями Москвы. Мы обработали их сметы, на основе этих данных разработали виртуального помощника по подбору выгодных смет. Кроме того, в топ подрядчиков попали только проверенные компании.</p>
                        <p>Хотите узнать примерную стоимость ремонта, не вызывая десяток сметчиков из разных компаний, или же считаете, что рассматриваемый Вами подрядчик завышает стоимость работ, и к тому же боитесь столкнуться с мошенниками – воспользуйтесь нашим калькулятором прямо сейчас!</p>
                        <p>Пользоваться калькулятором ремонта очень просто:</p>
                        <ul>
                            <li>выберете тип здания;</li>
                            <li>укажите высоту потолка;</li>
                            <li>выберете комнаты, в которых нужно сделать ремонт;</li>
                            <li>после чего выберете материалы и дополнительные работы.</li>
                        </ul>
                        <p>Готово! Калькулятор сравнивает цены и выбирает для Вас лучшее предложение. Изучите информацию, прочитайте отзывы, оставь заявку, после этого с Вами свяжется сотрудник выбранной компании и назначит дату замера для составления подробной сметы.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="calcWindow">
        <div class="modal-content">
            <div class="modal-header">
                <div class="title">Выберите тип комнаты</div>
                <div class="close-calcWindow">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 340.8 340.8"><path d="M170.4,0C76.4,0,0,76.4,0,170.4s76.4,170.4,170.4,170.4s170.4-76.4,170.4-170.4S264.4,0,170.4,0z M170.4,323.6 c-84.4,0-153.2-68.8-153.2-153.2S86,17.2,170.4,17.2S323.6,86,323.6,170.4S254.8,323.6,170.4,323.6z"/><path d="M182.4,169.6l50-50c3.2-3.2,3.2-8.8,0-12c-3.2-3.2-8.8-3.2-12,0l-50,50l-50-50c-3.2-3.2-8.8-3.2-12,0 c-3.2,3.2-3.2,8.8,0,12l50,50l-50,49.6c-3.2,3.2-3.2,8.8,0,12c1.6,1.6,4,2.4,6,2.4s4.4-0.8,6-2.4l50-50l50,50c1.6,1.6,4,2.4,6,2.4 s4.4-0.8,6-2.4c3.2-3.2,3.2-8.8,0-12L182.4,169.6z"/></svg>
                </div>
            </div>
            <div class="add-tabs">
                <span data-add="3" class="close-calcWindow"><i style="background: url(static/images/badroom.svg)"></i>Жилая</span>
                <span data-add="1" class="close-calcWindow"><i style="background: url(static/images/kitchen.svg)"></i>Кухня</span>
                <span data-add="2" class="close-calcWindow"><i style="background: url(static/images/bothrom.svg)"></i>Ванная</span>
                <span data-add="4" class="close-calcWindow"><i style="background: url(static/images/cupbord.svg)"></i>Прихожая</span>
                <span data-add="5" class="close-calcWindow"><i style="background: url(static/images/tissue-roll.svg)"></i>Туалет</span>
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
            <form action="" id="send-application">
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
@endsection