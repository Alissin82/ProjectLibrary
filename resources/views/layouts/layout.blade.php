<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>
        @yield('title')
    </title>

    @vite(['resources/css/app.css'])

</head>
<body class="p-3">
    @yield('content')
</body>

@yield('javascript')
@vite(['resources/js/app.js'])
@vite(['resources/sass/app.scss'])

</html>


