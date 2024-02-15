<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Messenger</title>

        <title> @yield('title', config('app.name'))</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body data-theme="emerald" >
        @yield('content')
        <div id="messenger">
            <messenger-component></messenger-component>
        </div>
    </body>
</html>
