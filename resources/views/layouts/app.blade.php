<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        }
    </script>
</head>
<body>
<div id="app">
    @include('includes.header')

    <main class="py-4">
        <div class="ui fluid container">
            <div>
                <router-view></router-view>
            </div>
        </div>
    </main>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</body>
</html>
