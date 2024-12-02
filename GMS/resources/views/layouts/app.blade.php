<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Free Guarage Management System with free technical support</title>
    <meta name="keywords" content="guarage management system,free guarage management system application,car garage management software,
    garage management software open source,
    garage management system project,
    best garage management software,
    free car garage management software,
    best garage software,
    automotive workshop management software,
    auto repair software free" />
    <meta name="description"
        content="Get full featured Free Guarage Management system, Best auto repair and garage management software for independent workshops and repair shop. Get top garage software features, reviews, pricing and free demo. Get free Support. " />
    <meta name="subject" content="Free Guarage Management System with free technical support">
    <meta name="author" content="ashutosh kumar choubey">
    <meta name="url" content="worldgyan.com">
    <meta name="identifier-URL" content="worldgyan.com">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global">
    <meta name="og:title" content="Free Guarage Management System with free technical support" />
    <meta name="og:url" content="worldgyan.com" />
    <meta name="og:image" content="public/assets/worldggyan for easy and simple.jpg" />
    <!-- logo -->
    <meta name="og:site_name" content="Free Guarage Management System with free technical support" />
    <meta name="og:description"
        content="Get full featured Free Guarage Management system, Best auto repair and garage management software for independent workshops and repair shop. Get top garage software features, reviews, pricing and free demo. Get free Support." />
    <meta property="og:type" content="Software Application" />
    <meta name="date" content="2020-01-13" scheme="YYYY-MM-DD">

    <!-- Scripts -->
    <script src="{{ asset('js/defaultApp.js') }}" defer></script>
    <!-- <script src="{{ asset('bootstrap-4.1.3/dist/js/bootstrap.js') }}"></script>   -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
            @yield('scripts')
            @stack('scripts')
        </main>
    </div>
</body>

</html>