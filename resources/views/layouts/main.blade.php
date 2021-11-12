<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />

    <link rel="preload" href="/static/css/main.css?v=1.0.4" as="style">
    <link rel="preload" href="/static/js/main.js?v=1.0.4" as="script">

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Калькулятор ремонта квартир." />
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="@yield('description')">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:locale" content="ru_RU" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">

    <meta name="yandex-verification" content="7ceb4083a568134c" />

    <link rel="stylesheet" href="/static/css/main.css?v=1.0.4">
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
    <script src="/static/js/main.js?v=1.0.4"></script>

    <script src="https://www.google.com/recaptcha/api.js?render={{env("RECAPTCHA_V3_PUBLIC")}}"></script>

    @if( Auth::check() )
        <script src="/static/js/admin.js"></script>
    @endif
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(85542874, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/85542874" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
