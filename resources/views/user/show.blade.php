<!DOCTYPE html>
<html>
<head>
    <title>Данные пользователя</title>
</head>
<body>
    <h1>Данные пользователя: {{ $user->first_name }} {{ $user->last_name }}</h1>

    <h2>Номера телефонов:</h2>
    <ul>
        @foreach ($user->phone as $phon)
            <li>{{ $phon->number }} ({{ $phon->type }})</li>
        @endforeach
    </ul>

    <h2>Email адреса:</h2>
    <ul>
        @foreach ($user->emails as $email)
            <li>{{ $email->email }} ({{ $email->type }})</li>
        @endforeach
    </ul>
    <h2>Ссылки:</h2>
    <ul>
        @foreach ($user->links as $link)
            <li><a href="{{ $link->link }}">{{ $link->link }}</a> ({{ $link->type }})</li>
        @endforeach
    </ul>

    <h2>Даты:</h2>
    <ul>
        @foreach ($user->dates as $date)
            <li>{{ $date->date }} ({{ $date->type }})</li>
        @endforeach
    </ul>
</body>
</html>
