<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bidding</title>
    <style>
        body {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Hi {{ $data['vendor']->name }}</h1>
    <p>
        You have been bidding in {{ $data['request_no'] }}
    </p>
    <p>Attachment files here:</p>
    <ul>
        @foreach ($data['attachments'] as $attachment)
            <li><a href="{{ asset('uploads/xls/' . trim($attachment)) }}">{{ trim($attachment) }}</a></li>
        @endforeach
    </ul>
</body>
</html>