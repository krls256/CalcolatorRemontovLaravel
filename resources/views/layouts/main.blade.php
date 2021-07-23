<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />

    <link rel="preload" href="/static/css/main.css?v=1.0.1" as="style">
    <link rel="preload" href="/static/js/main.js?v=1.0.1" as="script">

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Калькулятор ремонта квартир." />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:locale" content="ru_RU" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">

    <meta name="yandex-verification" content="cce5fb41b8406d9b" />

    <link rel="stylesheet" href="/static/css/main.css?v=1.0.1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
    <header class="header">
        <div class="header__content">
            <a href="/" class="logo">
                <span class="logo__img"></span>
                <span class="logo__text">Калькулятор ремонта</span>
            </a>
            <div class="header__button"><i></i></div>
            <menu class="menu">
                <li><a href="/" Request::is('/') ? 'active' : '' }}">Калькулятор</a></li>
                <li><a href="/rating" class="{{ Request::is('rating') ? 'active' : '' }}">Рейтинг</a></li>
                <li><a href="/price" class="{{ Request::is('price') ? 'active' : '' }}">Цены</a></li>
                <li><a href="/video" class="{{ Request::is('video') ? 'active' : '' }}">Видео</a></li>
                @if( Auth::check() )
                    <li><a href="/admin">Админ панель</a></li>
                @endif
            </menu>
        </div>
    </header>
    <div class="leyout">
        @yield('content')
    </div>
    <footer>
        <div class="footer-conteiner">
            <ul class="footer-conteiner__menu">
                <li><a href="/">Калькулятор</a></li>
                <li><a href="/rating">Рейтинг</a></li>
                <li><a href="/price">Цены</a></li>
                <li><a href="/video">Видео</a></li>
            </ul>
            <div class="copy">© 2020 Все права защищены!</div>
        </div>
    </footer>
    <div class="info-conteiner"></div>
    <script>
        function onloadCallback() {
            var el = document.querySelector('.g-recaptcha');

            if(el) {
                grecaptcha.render(el, {
                    'sitekey' : '6LeuMrsZAAAAAAGLBV40YEPQNRGLqcHj5IK_2iET'
                });
            }
        }
    </script>
    <script src="/static/js/main.js?v=1.0.1"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

    @if( Auth::check() )
        <script src="/static/js/admin.js"></script>
    @endif
</body>
</html>
