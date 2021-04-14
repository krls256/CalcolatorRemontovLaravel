<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="/static/css/admin/app.css">
  <script src="/static/js/admin/main.js"></script>
</head>
<body>
  <nav>
    <div class="content">
      <a href="/admin"><div class="logo"></div></a>
      <a href="/admin/logout" class="exit">
        <svg xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 511.996 511.996" class="">
          <path d="M349.85,62.196c-10.797-4.717-23.373,0.212-28.09,11.009c-4.717,10.797,0.212,23.373,11.009,28.09 c69.412,30.324,115.228,98.977,115.228,176.035c0,106.034-85.972,192-192,192c-106.042,0-192-85.958-192-192 c0-77.041,45.8-145.694,115.192-176.038c10.795-4.72,15.72-17.298,10.999-28.093c-4.72-10.795-17.298-15.72-28.093-10.999 C77.306,99.275,21.331,183.181,21.331,277.329c0,129.606,105.061,234.667,234.667,234.667 c129.592,0,234.667-105.068,234.667-234.667C490.665,183.159,434.667,99.249,349.85,62.196z" />
          <path d="M255.989,234.667c11.782,0,21.333-9.551,21.333-21.333v-192C277.323,9.551,267.771,0,255.989,0 c-11.782,0-21.333,9.551-21.333,21.333v192C234.656,225.115,244.207,234.667,255.989,234.667z"/>
        </svg>
        Выйти
      </a>
    </div>
  </nav>
  <div class="layout main">
    <div class="left">
      <div class="box">
        <ul class="left__menu">
          <li>
            <a href="/admin/companies" class="{{ Request::is('admin/companies') ? 'active' : '' }}">Компании</a>
          </li>
          <li>
            <a href="/admin/estimates" class="{{ Request::is('admin/estimates') ? 'active' : '' }}">Сметы</a>
          </li>
          <li>
            <a href="/admin/users" class="{{ Request::is('admin/users') ? 'active' : '' }}">Пользователи</a>
          </li>
          <li>
            <a href="/admin/price" class="{{ Request::is('admin/price') ? 'active' : '' }}">Цены</a>
          </li>
          <li>
            <a href="/">Перйти на сайт</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="content">
      @yield('content')
    </div>
  </div>
</body>
</html>