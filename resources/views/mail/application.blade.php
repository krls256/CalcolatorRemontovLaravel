<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка с сайта Calculator Remonta</title>
</head>
<body>
<table>
    <tr>
        <td>Пользователь оставил заявку на обратный звонок.</td>
    </tr>
    <tr>
        <td><strong>Данные пользователя: </strong></td>
        <br />
    </tr>
    <tr>
        <td><strong>Имя: </strong>{{ $data['name'] }}</td>
    </tr>
    <tr>
        <td><strong>Телефон: </strong>{{ $data['phone'] }}</td>
        <br />
    </tr>
    <tr>
        <td><strong>Хост: </strong>{{ $data['itshost'] }}</td>
        <br />
    </tr>
    @if($data['type'])
    <tr>
        <td><strong>Тип: </strong>{{ $data['type'] }}</td>
        <br />
    </tr>
    @endif
    @if($data['from'])
    <tr>
        <td><strong>От: </strong>{{ $data['from'] }}</td>
        <br />
    </tr>
    @endif
    @if($data['issearch'])
    <tr>
        <td><strong>Поисковый запрос: </strong>{{ $data['issearch'] }}</td>
        <br />
    </tr>
    @endif
    @if($data['utm_term'])
    <tr>
        <td><strong>UTM term: </strong>{{ $data['utm_term'] }}</td>
        <br />
    </tr>
    @endif
    <tr>
        <td><strong>IP: </strong>{{ $data['ip_lida'] }}</td>
        <br />
    </tr>
    <tr>
        <td><strong>URL: </strong>{{ $data['url'] }}</td>
        <br />
    </tr>
    @if($data['utm_keyword'])
    <tr>
        <td><strong>UTM keyword: </strong>{{ $data['utm_keyword'] }}</td>
        <br />
    </tr>
    @endif
    <tr>
        <td>Это письмо отправленно автоматически, на него отвечать не нужно! С уважением администрация сайта <a
                href="https://calculator-remonta.ru/">calculator-remonta.ru</td>
    </tr>
</table>
</body>
</html>
