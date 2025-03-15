<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <link rel="shortcut icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Logo_BAZNAS_RI-Hijau-01.png/1167px-Logo_BAZNAS_RI-Hijau-01.png" />
        <title>{{ $title }}</title>
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <!-- JS -->
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <!-- content -->
        @yield('content')
    </body>
</html>
