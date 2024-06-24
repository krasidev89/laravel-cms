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
    <link rel="stylesheet" href="{{ asset(mix('css/frontend.css')) }}">

    <!-- Custom Styles -->
    <style>
        #auth .card {
            width: 400px;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset(mix('js/frontend.js')) }}"></script>
</head>
<body>
    <div id="auth">
        <main>
            <div class="container-fluid">
                <div class="vh-100 d-flex flex-wrap justify-content-center align-items-center">
                    <div class="card shadow-sm">
                        <div class="card-header bg-transparent">@yield('title')</div>

                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

            @yield('scripts')
        </main>
    </div>
</body>
</html>
