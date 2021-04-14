@extends('layouts.main')

@section('title', "Онлайн калькулятор ремонта квартиры")
@section('description', "Онлайн калькулятор ремонта с подробными сметами компаний.")

@section('content')
   <section id="one" class="section">
      <div class="content">
        <h1>Онлайн калькулятор ремонта квартиры</h1>
        <div class="wrap">
            <div class="boxes wd-12">
                <h2 class="boxes__header sub_title">
                    Онлайн калькулятор ремонта с подробными сметами и ценами компаний.
                </h2>
                <div class="boxes__content p">
                    <p>Наша команда вызвали замерщиков, и собрали сметы 10 крупнейших компаний Москвы и Московской области. Получив сметы мы объединили их в удобный калькулятор ремонта, который подойдет как новичкам так и профессионалам.</p>
                    <p>На этом сайте вы можете сравнить сметы, рассчитать стоимость ремонта, прочитать отзывы и выбрать для себя лучшую компанию.</p>
                </div>
            </div>
        </div>
        <div class="wrap reverse">
            <div class="wd-3 mwd-12">
                @component('block.menuCalculator', ['title' => 'Простой калькулятор'])
                    <p>Простой калькулятор ремонта квартиры — это инструмент созданый профессионалами для людей которые хотя сделать ремонт, не вдаваться в тонкости и детали процесса.</p>
                @endcomponent
            </div>
            <div class="wd-9 mwd-12">
                <div class="calc">
                    <form method="POST" class="calc__content" id="calc-lite">
                        <div class="calc__box">
                            <div class="calc__box-title">Простой калькулятор ремонта</div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Тип помещения</div>
                                    <div class="calc-trigger">
                                        <input type="hidden" name="type">
                                        <span data-val="0">Новостройка</span>
                                        <span data-val="1">Вторичка</span>
                                    </div>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Количество комнат</div>
                                    <div class="calc-rooms">
                                        <input type="hidden" name="rooms">
                                        <span data-val="0">Студия</span>
                                        <span data-val="1">1</span>
                                        <span data-val="2">2</span>
                                        <span data-val="3">3</span>
                                        <span data-val="4">4</span>
                                        <span data-val="5">5</span>
                                    </div>
                                </div>
                            </div>
                            <div class="calc-block">
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Тип ремонта</div>
                                    <div class="calc-rem">
                                        <select name="typeRem" id="typeRem" data-placeholder="Тип ремонта" data-necessarily>
                                            <option label="Тип ремонта"></option>
                                            <option value="0">После застройщика</option>
                                            <option value="1">Капитальный</option>
                                            <option value="2">Eвро</option>
                                            <option value="3">Черновой (White box)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="wd-6 mwd-12">
                                    <div class="calc__title">Укажите площадь</div>
                                    <label for="aere" class="input">
                                        <input type="number" name="aere" id="aere" autocomplete="off" placeholder="Введите значение" data-necessarily>
                                        <span>м<sup>2</sup></span>
                                    </label>
                                </div>
                            </div>
                            <div class="calc__footer ">
                                <button type="submit" class="button__green">Рассчитать</button>
                                <div class="filed">Не все поля заполнены!</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="prof rating" id="rating"></div>
            </div>
        </div>
      </div>
      <span class="nextCard">
         <a href="#two" class="nextCard__button"></a>
      </span>
   </section>
    <section id="two" class="section index">
        <div class="content">
            <h2>Что такое онлайн калькулятор ремонта квартиры?</h2>
            <div class="wrap">
                <div class="wd-4 mwd-12">
                    <i class="two-peaple"></i>
                </div>
                <div class="wd-8 two-text mwd-12">
                    <div class="p padding-40">
                        <p><strong>Ремонт</strong> — это очень сложный процесс. Онлайн калькулятор ремонта квартир создан для того, чтобы помочь обычному человеку с выбором надежного подрядчика, который предложит выгодные для Вас условия. Чтобы рассчитать приблизительную стоимость ремонта квартиры под ключ, воспользуйтесь нашим калькулятором!</p>
                        <p>Все что нужно – это указать площадь и количество комнат. С помощью такого калькулятора можно очень точно рассчитать стоимость каждой услуги, и сравнить сметы. А с помощью раздела «Цены» вы можете изучить подробный прайс-лист компании и рассчитать стоимость самому.</p>
                    </div>
                    <div class="buttom-center">
                        <a class="button__green" href="/professional">Посчитать</a>
                    </div>
                </div>
            </div>
            <h2>Умный рейтинг ремонта квартир.</h2>
            <div class="wrap">
                <div class="wd-8 mwd-12">
                    <div class="p padding-40">
                        <p>Наш сайт предоставляет рейтинг самых популярных компаний Москвы и Московской области. Наша задача всегда предоставлять Вам, самую актуальную информацию о ценах и контактных данных компаний.</p>
                        <p>Рейтинг ремонта квартир — это не просто список компаний, это отзывы, цены на ремонт квартир, оценки людей и многое другое.</p>
                    </div>
                    <div class="buttom-center">
                        <a class="button__green" href="/rating">К рейтингу</a>
                    </div>
                </div>
                <div class="wd-5 mwd-12">
                    <i class="two-cloud"></i>
                </div>
            </div>
        </div>
        <span class="nextCard">
                <a href="#tree" class="nextCard__button"></a>
        </span>
    </section>
    <section id="tree" class="section index">
        <div class="content">
            <h2>Рейтинг ремонтных компаний Москвы</h2>
            <div class="wrap">
                <div class="wd-4 mwd-12">
                    <div class="boxes">
                        <div class="boxes__header"><i class="boxes__img-orang icon-info"></i>Рейтинг</div>
                        <div class="boxes__content">
                            <div class="p padding-40">
                                <p>Мы собрали для вас рейтинг из самых популярных компаний Москвы и Московской области. Оценка компании проводится по многим параметрам, основными являются:</p>
                                <ul>
                                    <li>Цена</li>
                                    <li>Отзывы клиентов</li>
                                    <li>Опыт работы</li>
                                </ul>
                                <p>Учитывая эти и другие критерии мы собрали рейтинг из 30 компаний, с которыми вы можете ознакомится в разделе рейтинг.</p>
                            </div>
                            <div class="buttom-center">
                                <a class="button__green buttom-center" href="/rating">Рейтинг</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wd-8 mwd-12">
                    <div class="rating">
                        @foreach ($companies as $val)
                            <div class="module rating__block">
                                <div class="rating__img">
                                    <img src="/static/images/image.svg" data-src="{{ $val->logo }}" alt="{{ $val->name }}" class="lazy">
                                    <noscript><img src="{{ $val->logo }}" alt="{{ $val->name }}"></noscript>
                                </div>
                                <div class="rating__name">
                                    <a href="/rating/{{ $val->url }}/">{{ $val->name }}</a>
                                    <div>
                                        <span>Оценка:</span>
                                        @component('block.rating', ['rating' => ( $val->rating_profile + $val->rating_reviews)/2 ])
                                        @endcomponent
                                    </div>
                                </div>
                                <div class="rating__sand">
                                    <a class="link-button send-zamer" href="#animatedModal" data-id="{{ $val->id }}">Оставить заявку</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <span class="nextCard">
            <a href="#footer-go" class="nextCard__button"></a>
        </span>
    </section>
    <section id="footer-go">
        <div class="content">
            <h2>Лучшие компании</h2>
            <div class="wrap">
                <div class="wd-12 company-slider">
                    <div>
                        <a href="/rating/studiya-remontov/">
                            <img src="/static/images/image.svg" data-lazy="static/images/silver/studia-remontov.png" alt="Студия ремонтов" class="lazy">
                            <noscript><img src="static/images/silver/studia-remontov.png" alt="Студия ремонтов"></noscript>
                        </a>
                    </div>
                    <div>
                        <a href="/rating/sk-blagodat/">
                            <img src="/static/images/image.svg" data-lazy="static/images/silver/blagodat.png" alt="СК Благодать" class="lazy">
                            <noscript><img src="static/images/silver/blagodat.png" alt="СК Благодать"></noscript>
                        </a>
                    </div>
                    <div>
                        <a href="/rating/mastera-remonta/">
                            <img src="/static/images/image.svg" data-lazy="static/images/silver/master-remonta.png" alt="Мастера ремонта" class="lazy">
                            <noscript><img src="static/images/silver/master-remonta.png" alt="Мастера ремонта"></noscript>
                        </a>
                    </div>
                    <div>
                        <a href="/rating/proff-servis/">
                            <img src="/static/images/image.svg" data-lazy="static/images/silver/proff-service.png" alt="Профф сервис" class="lazy">
                            <noscript><img src="static/images/silver/proff-service.png" alt="Профф сервис"></noscript>
                        </a>
                    </div>
                    <div>
                        <a href="/rating/skazano-sdelano/">
                            <img src="/static/images/image.svg" data-lazy="static/images/silver/skazano-sdelano.png" alt="Сказано сделано" class="lazy">
                            <noscript><img src="static/images/silver/skazano-sdelano.png" alt="Сказано сделано"></noscript>
                        </a>
                    </div>
                    <div>
                        <a href="/rating/stroy-mg/">
                            <img src="/static/images/image.svg" data-lazy="static/images/silver/MG.png" alt="Строй МГ" class="lazy">
                            <noscript><img src="static/images/silver/MG.png" alt="Строй МГ"></noscript>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                <input type="hidden" name="id" />
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