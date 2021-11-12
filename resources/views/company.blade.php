@extends('layouts.main')

@section('title', $name)
@section('description', "Отзывы и цены о компании \"$name\" можно узнать в этом разделе. А так-же посчитать стоимость ремонта.")

@section('content')
  <section class="section">
    <div class="content">
      <h1>Отзывы о компании {{ $name }}</h1>
      <div class="wrap reverse">
        <div class="wd-8 mwd-12">
            <div class="wd-12 mwd-12 boxes company-info">
              <div class="company-info__body">
                  <h2>Информация о компании {{ $name }}:</h2>
                  {!! $description !!}
              </div>
            </div>
            <div class="boxes">
              <div class="boxes__header">
                <i class="boxes__img-orang icon-info"></i>
                Отзывы компании
              </div>
            </div>
            @foreach ($reviews as $val)
              <div class="boxes wd-12 mwd-12 review">
                <div class="boxes__header review__header {{ $val->provider }}">
                  <i></i>
                  <strong>{{ $val->user }}</strong>
                  <div class="star-rating">
                  @component('block.rating', ['rating' => $val->rating])
                  @endcomponent
                  </div>
                </div>
                <div class="boxes__content" data-text="{{ $val->originalText }}">
                  <div class="text-review">
                    {{ $val->text }}
                  </div>
                  @if($val->more)
                    <div class="open-full">Показать полностью</div>
                  @endif
                </div>
                <div class="boxes__footer review__footer">
                  <span>
                    @php
                      echo date('d.m.Y H:i', $val->date);
                    @endphp
                  </span>
                  @if($val->provider === 'yell')
                    <a href="https://yell.ru/{{ $yell_id }}/?reviewId={{ $val->review_id }}" class="link-button" target="_blank">К источнику</a>
                  @elseif ($val->provider === 'flamp')
                    <a href="https://flamp.ru/firm/reviews-{{ $flamp_id }}/otzyv-{{ $val->review_id }}" class="link-button" target="_blank">К источнику</a>
                  @elseif ($val->provider === 'yandex')
                    <a href="https://yandex.ru/maps/org/{{ $yandex_id }}" class="link-button" target="_blank">К источнику</a>
                  @endif

                  @if( Auth::check() )
                    <a href="#" data-id="{{ $val->id }}" class="link-button red reviews-delete" target="_blank">Удалить</a>
                  @endif
                </div>
              </div>
            @endforeach

        </div>

        <div class="wd-4 mwd-12">
          <div class="boxes company-info">
            <div class="boxes company-info__header">
              <img src="/static/images/image.svg" data-src="/{{ $logo }}" alt="{{ $name }}" class="lazy">
              <noscript><img src="/{{ $logo }}" alt="{{ $name }}"></noscript>
              <div class="item">
                <span>{{ $name }}</span>
                @component('block.rating', ['rating' => ($profile + $rating_reviews)/2 ])
                @endcomponent
              </div>
            </div>
            <div class="company-infobox">
              <p><strong>Телефон: </strong> +{{ $phone }}</p>
              <p><strong>Сайт: </strong> <a href="{{ $site }}">{{ $site }}</a></p>
              <p><strong>Адрес: </strong>{{ $address }}</p>
              <div>
                <strong>Отзывы: </strong>
                @component('block.rating', ['rating' => $rating_reviews ])
                @endcomponent
              </div>
              <div>
                <strong>Rusprofile: </strong>
                @component('block.rating', ['rating' => $profile ])
                @endcomponent
              </div>
            </div>
            <div class="company-info__footer">
              <a href="/professional" class="button__green" target="_blank">Рассчитать ремонт</a>
              <a href="#animatedModal" class="button__blue send-zamer" data-id="{{ $id }}">Оставить заявку</a>
            </div>
          </div>
        </div>
      </div>
      @if ($reviewsNav['total'] > $reviewsNav['show'])
        <div class="wrap">
          <div class="wd-12 mwd-12">
            <div class="page-nav">
              @if ( $reviewsNav['сurrent'] > 1 )
                <a href="/rating/{{ $url }}" class="page-nav__start"></a>
                <a href="/rating/{{ $url }}/{!! $reviewsNav['сurrent']-1 !!}" class="page-nav__back"></a>
              @endif

              <div class="page-nav__number">
                @for ($i = 1; $i < $reviewsNav['pages']+1; $i++)
                  @if ( $i >= $reviewsNav['start'] && $i <= $reviewsNav['end'] )
                    @if ($i == $reviewsNav['сurrent'])
                      <a href="/rating/{{ $url }}/{{ $i }}" class="active">{{ $i }}</a>
                    @else
                      <a href="/rating/{{ $url }}/{{ $i }}">{{ $i }}</a>
                    @endif
                  @endif
                @endfor
              </div>

              @if ($i > $reviewsNav['сurrent'] && $reviewsNav['сurrent']+1 < $i )
                <a href="/rating/{{ $url }}/{!! $reviewsNav['сurrent']+1 !!}" class="page-nav__next"></a>
                <a href="/rating/{{ $url }}/{{ $i-1 }}" class="page-nav__end"></a>
              @endif
            </div>
          </div>
        </div>
      @endif
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
