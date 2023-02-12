<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Calendar Amoba</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>

    <body>
        <div id="app">

            @yield('content')

        </div>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"></script>
    </body>

