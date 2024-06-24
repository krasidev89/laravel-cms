<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('css/backend.css')) }}">

    <!-- Custom Styles -->
    @yield('styles')

    <!-- Scripts -->
    <script src="{{ asset(mix('js/backend.js')) }}"></script>
</head>
<body>
    <div id="backend" class="d-flex flex-column position-absolute inset-0">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark border-bottom shadow-sm">
            <div class="container-fluid px-0">
                <a href="{{ url('/') }}" class="navbar-brand">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <div class="d-flex order-0 order-sm-1">
                    <button type="button" class="navbar-toggler button_hamburger_htx rounded-0" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span></span>
                    </button>

                    <button type="button" class="navbar-toggler button_hamburger_htra rounded-0 d-block d-md-none ml-2" data-toggle="collapse" data-target="#sideNavbarContent" aria-controls="sideNavbarContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span></span>
                    </button>
                </div>

                <div id="navbarContent" class="collapse navbar-collapse" data-parent="#backend">
                    <hr class="border-secondary mt-2 mb-0 d-sm-none">

                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle pr-0" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="{{ route('backend.profile.show') }}" @class(["dropdown-item", "active"=> request()->routeIs('backend.profile.show')])>
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
                    </ul>
                </div>
            </div>
        </nav>

        <div class="flex-grow-1 position-relative">
            <div class="d-flex flex-row-reverse flex-md-row position-absolute inset-0">
                <div class="d-flex flex-shrink-0 navbar-expand-md">
                    <div id="sideNavbarContent" class="collapse navbar-collapse width flex-fill bg-white shadow-sm" data-parent="#backend">
                        <nav id="backend-side-navbar">
                            <div class="input-group border-bottom has-clear p-3">
                                <input type="text" class="form-control searchbar" data-target="#backend-side-nav-group" placeholder="{{ __('Search in menu...') }}">

                                <div class="input-group-append">
                                    <button type="button" class="btn btn-clear">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="backend-side-nav-group" class="flex-grow-1 overflow-auto">
                                <ul class="nav flex-column">
                                    <!-- Google Analytics -->
                                    <li class="nav-item">
                                        @php
                                            $isOpenCollapseGoogleAnalytics = request()->routeIs('backend.google-analytics.*');
                                        @endphp
                                        <a href="#collapseGoogleAnalytics" class="nav-link d-flex align-items-center {{ $isOpenCollapseGoogleAnalytics ? 'default-expanded' : 'collapsed' }}" data-toggle="collapse" aria-expanded="{{ $isOpenCollapseGoogleAnalytics ? 'true' : 'false' }}" aria-controls="collapseGoogleAnalytics">
                                            <i class="fas fa-chart-simple mr-2"></i>
                                            {{ __('Google Analytics') }}
                                            <i class="plus-minus-rotate flex-shrink-0 ml-auto collapsed"></i>
                                        </a>

                                        <div id="collapseGoogleAnalytics" @class(["collapse", "show"=> $isOpenCollapseGoogleAnalytics])>
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="{{ route('backend.google-analytics.overview') }}" @class(["nav-link", "active"=> request()->routeIs('backend.google-analytics.overview')])>
                                                        {{ __('Overview') }}
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ route('backend.google-analytics.urls') }}" @class(["nav-link", "active"=> request()->routeIs('backend.google-analytics.urls')])>
                                                        {{ __('URLs') }}
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ route('backend.google-analytics.locations') }}" @class(["nav-link", "active"=> request()->routeIs('backend.google-analytics.locations')])>
                                                        {{ __('Locations') }}
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ route('backend.google-analytics.languages') }}" @class(["nav-link", "active"=> request()->routeIs('backend.google-analytics.languages')])>
                                                        {{ __('Languages') }}
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ route('backend.google-analytics.browsers') }}" @class(["nav-link", "active"=> request()->routeIs('backend.google-analytics.browsers')])>
                                                        {{ __('Browsers') }}
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ route('backend.google-analytics.operating-systems') }}" @class(["nav-link", "active"=> request()->routeIs('backend.google-analytics.operating-systems')])>
                                                        {{ __('Operating Systems') }}
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a href="{{ route('backend.google-analytics.device-categories') }}" @class(["nav-link", "active"=> request()->routeIs('backend.google-analytics.device-categories')])>
                                                        {{ __('Device Categories') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>

                                    <!-- Projects -->
                                    <li class="nav-item">
                                        @php
                                            $isOpenCollapseProjects = request()->routeIs('backend.projects.*');
                                        @endphp
                                        <a href="#collapseProjects" class="nav-link d-flex align-items-center {{ $isOpenCollapseProjects ? 'default-expanded' : 'collapsed' }}" data-toggle="collapse" aria-expanded="{{ $isOpenCollapseProjects ? 'true' : 'false' }}" aria-controls="collapseProjects">
                                            <i class="fas fa-diagram-project mr-2"></i>
                                            {{ __('Projects') }}
                                            <i class="plus-minus-rotate flex-shrink-0 ml-auto collapsed"></i>
                                        </a>

                                        <div id="collapseProjects" @class(["collapse", "show"=> $isOpenCollapseProjects])>
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="{{ route('backend.projects.index') }}" @class(["nav-link", "active"=> request()->routeIs('backend.projects.index')])>
                                                        {{ __('List Projects') }}
                                                    </a>
                                                </li>

                                                @can('manage_system')
                                                <li class="nav-item">
                                                    <a href="{{ route('backend.projects.create') }}" @class(["nav-link", "active"=> request()->routeIs('backend.projects.create')])>
                                                        {{ __('Create Project') }}
                                                    </a>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </li>

                                    <!-- Users -->
                                    <li class="nav-item">
                                        @php
                                            $isOpenCollapseUsers = request()->routeIs('backend.users.*');
                                        @endphp
                                        <a href="#collapseUsers" class="nav-link d-flex align-items-center {{ $isOpenCollapseUsers ? 'default-expanded' : 'collapsed' }}" data-toggle="collapse" aria-expanded="{{ $isOpenCollapseUsers ? 'true' : 'false' }}" aria-controls="collapseUsers">
                                            <i class="fas fa-users mr-2"></i>
                                            {{ __('Users') }}
                                            <i class="plus-minus-rotate flex-shrink-0 ml-auto collapsed"></i>
                                        </a>

                                        <div id="collapseUsers" @class(["collapse", "show"=> $isOpenCollapseUsers])>
                                            <ul class="nav flex-column">
                                                <li class="nav-item">
                                                    <a href="{{ route('backend.users.index') }}" @class(["nav-link", "active"=> request()->routeIs('backend.users.index')])>
                                                        {{ __('List Users') }}
                                                    </a>
                                                </li>

                                                @can('manage_system')
                                                <li class="nav-item">
                                                    <a href="{{ route('backend.users.create') }}" @class(["nav-link", "active"=> request()->routeIs('backend.users.create')])>
                                                        {{ __('Create User') }}
                                                    </a>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>

                <main class="flex-md-shrink-1 flex-shrink-0 w-100 overflow-auto pt-3">
                    <div class="container-fluid mb-3">
                        @yield('content')
                    </div>

                    @yield('scripts')
                </main>
            </div>
        </div>
    </div>

    @if (session('status'))
    <script>
        Swal.fire({
            icon: 'success',
            text: '{{ session('status') }}',
            confirmButtonText: '{{ __('Close') }}',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'swal2-styled btn btn-primary m-1'
            }
        });
    </script>
    @endif

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            text: '{{ session('success') }}',
            confirmButtonText: '{{ __('Close') }}',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'swal2-styled btn btn-primary m-1'
            }
        });
    </script>
    @endif
</body>
</html>
