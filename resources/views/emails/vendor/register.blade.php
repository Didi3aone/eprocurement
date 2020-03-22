<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Pendaftaran Anda</title>
</head>
<body>
    <h2>Hai, {{ $vendor->name }}</h2>
    <p>Jangan lupa untuk melakukan verifikasi pendaftaran <a href="{{ route('vendor.verify', $vendor->activate_token) }}">DISINI</a></p>
</body>
</html>