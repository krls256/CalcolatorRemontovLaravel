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
  <div class="layout login">
    <div class="content">
      @yield('content')
    </div>
    <div class="footer">
      <a href="/">На главную</a>
    </div>
  </div>
</body>
</html>