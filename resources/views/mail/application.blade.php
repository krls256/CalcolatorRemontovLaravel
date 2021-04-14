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
            <br/>
        </tr>
        <tr>
            <td><strong>Имя: </strong>{{ $data['name'] }}</td>
        </tr>
        <tr>
            <td><strong>Телефон: </strong>{{ $data['phone'] }}</td>
            <br/>
        </tr>
        <tr>
            <td>Это письмо отправленно автоматически, на него отвечать не нужно! С уважением администрация сайта <a href="https://calculator-remonta.ru/">calculator-remonta.ru</td>
        </tr>
    </table>
</body>
</html>