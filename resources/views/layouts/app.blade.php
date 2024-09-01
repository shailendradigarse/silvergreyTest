<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
    @yield('content')
</body>
</html>
