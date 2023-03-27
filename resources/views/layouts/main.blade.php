<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>
    <div id="app">
        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
            <div class="container">
                <a class="navbar-brand">
                    {{ env('BRAND') }}
                </a>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div id="navbarNav" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        @foreach (\App\Helpers\NavigationItems::getItems() as $text => $link)
                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="{{ $link }}"
                            >
                                {{ $text }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            @if (!empty($errors->all()))
                <div class="alert alert-danger text-start">
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
