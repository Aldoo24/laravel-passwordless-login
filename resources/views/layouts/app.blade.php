<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <title>@yield('title' ?? '')</title>
</head>
<body>
    <main class="bg-gray-50 dark:bg-gray-900">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
