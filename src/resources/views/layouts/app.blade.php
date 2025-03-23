<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')

    <title>furima</title>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a href="{{ route('product.index') }}" class="header__logo">
                <img src="{{ asset('images/logo.svg') }}" alt="ロゴ">
            </a>

            <!-- Display search bar in header (except on login and registration pages) -->
            @unless (Request::is('login') || Request::is('register'))
                <form action="{{ route('product.index') }}" method="get" class="header__search">
                    <input type="text" name="query" placeholder="なにをお探しですか？" value="{{ request('query') }}">
                    <button type="submit">検索</button>
                </form>
            @endunless

            <nav class="header__nav">
                @auth
                    <!-- Show only for authenticated users -->
                    <a href="{{ route('logout.destroy') }}" class="header__button"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        ログアウト
                    </a>
                    <a href="{{ route('profile.show') }}" class="header__button">マイページ</a>
                    <a href="{{ route('product.create') }}" class="header__button">出品</a>
                    <form action="{{ route('logout.destroy') }}" id="logout-form" method="post">
                        @csrf
                    </form>
                @endauth

                @guest
                    @if (Request::routeIs('product.index') || Request::routeIs('product.show'))
                        <!-- Show only for guests on product list or detail pages -->
                        <a href="{{ route('login.create') }}" class="header__button">ログイン</a>
                        <a href="{{ route('profile.show') }}" class="header__button">マイページ</a>
                        <a href="{{ route('product.create') }}" class="header__button">出品</a>
                    @endif
                @endguest
            </nav>
        </div>
    </header>

    @yield('content')

</body>

</html>
