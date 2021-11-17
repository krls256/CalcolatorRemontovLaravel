@extends('layouts.main')

@section('title', "Рейтинг компаний")
@section('description', "Мы собрали для вас рейтинг из самых популярных компаний Москвы и Московской области.")

@section('content')
  <section class="section">
    <div class="content">
      <h1>Рейтинг ремонтных компаний</h1>
      <div class="wrap">
        <div class="wd-3 mwd-12">
          <div class="boxes">
            <div class="boxes__header"><i class="boxes__img-orang icon-info"></i>Рейтинг</div>
            <div class="boxes__content">
              <div class="p">
                <p>Мы собрали для вас рейтинг из самых популярных компаний Москвы и Московской области. Оценка компании проводится по многим параметрам, основными являются:</p>
                <ul>
                    <li>Цена</li>
                    <li>Отзывы клиентов</li>
                    <li>Опыт работы</li>
                </ul>
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
              <div class="module rating__block">
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
                <div class="rating__count">
                  <a href="/rating/{{ $company->url }}/">
                    <i class="reviews-icon"></i>
                    {{ $company->count }} <span>отзыва</span>
                  </a>
                </div>
                <div class="rating__sand">
                  <a class="link-button send-zamer" href="#animatedModal" data-id="{{ $company->id }}">Оставить заявку</a>
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
            О рейтенге ремонта
          </h2>
          <div class="boxes__content p">
            <div class="wrap">
              <div class="wd-2 mwd-12">
                <i class="rating-img"></i>
              </div>
              <div class="wd-10 mwd-12">
                <p><strong>Рейтинг ремонта квартир</strong> – это отличный способ узнать больше о репутации компании на современном рынке. Благодаря реальным мнениям пользователей можно точно определить, какая фирма предоставляет по-настоящему качественные услуги по ремонту. Стоимость ремонта в Москве требует значительных вложений, поэтому рисковать, отдавая деньги непроверенным подрядчикам, не хочет ни один заказчик.</p>
                <p>При помощи рейтинга ремонта вы сможете навсегда забыть о ненужных волнениях и платить исключительно заслуживающим доверия фирмам.</p>
              </div>
            </div>
            <div>
              <p>Выбрать достойную ремонтную компанию в Москве непросто. Для этого нужно учесть множество факторов, среди которых:</p>
              <p class="p">
                <ul>
                  <li>финансовое положение организации;</li>
                  <li>статус и репутация компании;</li>
                  <li>отзывы реальных клиентов;</li>
                  <li>опыт фирмы;</li>
                  <li>цены на предоставляемые услуги.</li>
                </ul>
              </p>
              <p>Всё это собрано воедино в сервисе, представляющем рейтинг ремонта в Москве. Вся работа уже сделана за вас, поэтому тратить лишнее время и нервы больше не придётся. Просто доверьтесь рейтингу. Вся предоставляемая информация полностью правдива и проверена. Проделать ту же самую работу обычному человеку «не в теме» намного сложнее.</p>
              <p>В рейтинге представлен список из 10 компаний, предоставляющих качественные услуги по ремонту в столице. Данный рейтинг основывается на фактических данных. Основными критериями оценки являются реальные отзывы с таких ресурсов как flamp.ru и yell.ru. Собранная и проанализированная информация показывает мнения людей и их отношение к той или иной компании. Данный фактор является ключевым фактором при выборе достойного поставщика услуг.</p>
              <p>Финансовое положение фирмы также играет важную роль, поскольку это многое говорит о том, насколько успешно организация ведёт бизнес. Чем лучше финансовое положение компании, тем лучше обстоят дела и тем больше довольных клиентов оставляет она за собой. Здесь учитываются данные о доходах, судебных делах, налогообложение и т.д. За счёт этого можно сделать вывод о надёжности организации. Для составления достоверного рейтинга также взята информация с авторитетного ресурса rusprofile.ru, на основе которого компания имеет определённое количество звёзд. Каждая представленная компания может иметь от 0 до 5 звёзд. Здесь же имеется раздел отзывов, где можно почитать мнения заказчиков о фирме. Реальные отзывы собраны с различных независимых ресурсов со ссылкой на источник, чтобы каждый потенциальный заказчик мог убедиться в их подлинности.</p>
              <p><strong>Что интересного можно найти?</strong></p>
              <p>В разделе представлен не только рейтинг ремонта квартир в Москве. Здесь же пользователи могут выбрать понравившуюся фирму, ознакомившись с информацией, а после сразу же оставить заявку, заполнив поля «Имя» и «Номер телефона». Нажав на ту или иную компанию, пользователи увидят основную информацию о ней и контактные данные (ссылка на сайт, номер контактного телефона, адрес). Это полезно и очень удобно, особенно для жителей столицы, которые высоко ценят своё время.</p>
              <p>При необходимости можно рассчитать ремонт с учётом особенностей объекта. Также на странице рейтинга можно найти много другой полезной информации и сервисов для тех, кто хочет вкладывать деньги только в качественный ремонт квартир и других объектов в Москве.</p>
            </div>
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

        <form id="send-application" data-recaptcha-public="{{env("RECAPTCHA_V3_PUBLIC")}}">
            @clientdata
            <div class="window-notif my-2"></div>
            <input type="hidden" name="id" />
            <span>Ваше имя</span>
            <label for="name" class="input">
                <input type="text" name="name" id="name" placeholder="Иван" />
            </label>
            <span>Номер телефона</span>
            <label for="phone" class="input">
                <input type="text" name="phone" id="phone" />
            </label>
            <button type="submit" class="link-button">Оставить заявку</button>

        </form>
    </div>
    </div>
    </div>
@endsection
