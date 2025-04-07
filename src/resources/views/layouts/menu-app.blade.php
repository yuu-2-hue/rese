<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layouts/menu-common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header__container">
        <div class="header__item">
            <div class="ttl__wrapper">
                <form action="/menu/back" method="get">
                    <button class="menu-btn">
                        <span class="right-line"></span>
                        <span class="left-line"></span>
                    </button>
                </form>
            </div>
            @yield('header')
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>