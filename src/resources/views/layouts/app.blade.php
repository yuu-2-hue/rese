<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header__container">
        <div class="header__item">
            <div class="ttl__wrapper">
                <form action="/menu" method="get">
                    <button class="menu-btn">
                        <span class="top-line"></span>
                        <span class="center-line"></span>
                        <span class="under-line"></span>
                    </button>
                </form>
                <a class="logo" href="/">Rese</a>
            </div>
            @yield('header')
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>