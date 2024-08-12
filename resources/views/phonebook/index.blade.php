<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Телефонная книга</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            margin-top: 20px;
        }
        .user {
            margin-bottom: 30px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .user h3 {
            margin: 0;
        }
        .list {
            list-style-type: none;
            padding: 0;
        }
        .list li {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<h1>Телефонная книга</h1>

@foreach ($users as $user)
    <div class="user">
        <h2>{{ $user->first_name }} {{ $user->last_name }}</h2>
        <h3> Заметки </h3>
        <p>{{$user->notes}}</p>
        <br>


        <h3>Телефоны</h3>
        @if ($user->phone->isEmpty())
            <p>Нет телефонов.</p>
        @else
            <ul class="list">
                @foreach ($user->phone as $phon)
                    <li>{{ $phon->number }} ({{ $phon->type }})</li>
                @endforeach
            </ul>
        @endif

        <h3>Email</h3>
        @if ($user->emails->isEmpty())
            <p>Нет email.</p>
        @else
            <ul class="list">
                @foreach ($user->emails as $email)
                    <li>{{ $email->email }} ({{ $email->type }})</li>
                @endforeach
            </ul>
        @endif

        <h3>Ссылки</h3>
        @if ($user->links->isEmpty())
            <p>Нет ссылок.</p>
        @else
            <ul class="list">
                @foreach ($user->links as $link)
                    <li><a href="{{ $link->link }}" target="_blank">{{ $link->link }}</a> ({{ $link->type }})</li>
                @endforeach
            </ul>
        @endif

        <h3>Даты</h3>
        @if ($user->dates->isEmpty())
            <p>Нет дат.</p>
        @else
            <ul class="list">
                @foreach ($user->dates as $date)
                    <li>{{ $date->date }} ({{ $date->type }})</li>
                @endforeach
            </ul>
        @endif

        <h3>Компании</h3>
        @if ($user->companies->isEmpty())
            <p>Нет мест работы.</p>
        @else
            <ul class="list">
                @foreach ($user->companies as $company)
                    <li>{{ $company->name }} ({{ $company->address }})</li>
                @endforeach
            </ul>
        @endif
    </div>
@endforeach

</body>
</html>
