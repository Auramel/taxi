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

        <script src="https://telegram.org/js/telegram-web-app.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>

        <script>
            const telegram = window.Telegram;
            const user = telegram.WebApp.initDataUnsafe.user;

            if (user) {
                telegram.WebApp.ready();
                window.tgUser = user;
            } else {
                // if (location.href !== 'https://cr76759.tw1.ru/public/webapp/error') {
                {{--    location.href = '{{ route('webapp.error') }}';--}}
                // }
            }

            @stack('scripts')
        </script>
    </body>
</html>
