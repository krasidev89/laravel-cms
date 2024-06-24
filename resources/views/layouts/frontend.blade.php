<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if ($googleAnalyticsTrackingID = config('app.google_analytics_tracking_id'))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsTrackingID }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $googleAnalyticsTrackingID }}');
    </script>
    @endif
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('url', url()->full())">
    <meta property="og:title" content="@yield('title', config('app.name', 'Laravel'))">
    <meta property="og:description" content="@yield('description', config('app.description', 'Description'))">
    @hasSection('image')<meta property="og:image" content="@yield('image')">@endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="@yield('url', url('index.php'))">
    <meta property="twitter:title" content="@yield('title', config('app.name', 'Laravel'))">
    <meta property="twitter:description" content="@yield('description', config('app.description', 'Description'))">
    @hasSection('image')<meta property="twitter:image" content="@yield('image')">@endif

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="description" content="@yield('description', config('app.description', 'Description'))">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('css/frontend.css')) }}">

    <!-- Custom Styles -->
    @yield('styles')

    <!-- Scripts -->
    <script src="{{ asset(mix('js/frontend.js')) }}"></script>
</head>
<body>
    <div id="frontend">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark border-bottom shadow-sm">
            <div class="container">
                <a href="{{ url('/') }}" class="navbar-brand">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button type="button" class="navbar-toggler button_hamburger_htx rounded-0" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span></span>
                </button>

                <div id="navbarContent" class="collapse navbar-collapse">
                    <hr class="border-secondary mt-2 mb-0 d-sm-none">

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">{{ __('Login') }}</a>
                            </li>
                            @endif

                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">{{ __('Register') }}</a>
                            </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle pr-0" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('backend.google-analytics.overview') }}" class="dropdown-item">
                                        <i class="fas fa-chart-simple mr-2"></i>{{ __('Google Analytics') }}
                                    </a>

                                    <a href="{{ route('backend.profile.show') }}" class="dropdown-item">
                                        <i class="fas fa-user mr-2"></i>{{ __('Profile') }}
                                    </a>

                                    <hr class="dropdown-divider">

                                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        <i class="fas fa-power-off mr-2"></i>{{ __('Logout') }}
                                    </a>

                                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pt-3 pt-sm-5 bg-light">
            <div class="container mb-3 mb-sm-5">
                @yield('content')
            </div>

            @yield('scripts')
        </main>
    </div>
</body>
</html>
