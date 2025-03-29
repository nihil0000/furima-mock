<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    @yield('css')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>furima</title>
</head>

<body class="font-slab">
    <header class="bg-black text-white py-4">
        <div class="max-w-[1200px] mx-auto flex flex-col xl:flex-row items-center justify-between">

            <!-- logo -->
            <a href="{{ route('product.index') }}" class="self-center xl:self-auto">
                <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" class="h-8">
            </a>

            <!-- show search bar in header (except on login and registration pages) -->
            @unless (Request::is('login') || Request::is('register'))
                <form action="{{ route('product.index') }}" method="get" class="flex items-center space-x-2">
                    <input type="text" name="query" placeholder="なにをお探しですか？" value="{{ request('query') }}"
                        class="my-4 h-8 w-full md:w-60 xl:w-80 rounded text-black px-4 text-sm" />
                    <button type="submit"
                        class="bg-white text-black h-8 px-4 py-1 rounded hover:bg-gray-100">検索</button>
                </form>
            @endunless

            <nav class="flex items-center space-x-5">
                @auth
                    <!-- show only for authenticated users -->
                    <a href="{{ route('logout.destroy') }}" class="hover:underline"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <a href="{{ route('profile.show') }}" class="hover:underline">マイページ</a>
                    <a href="{{ route('product.create') }}"
                        class="bg-white text-black px-3 py-1 rounded hover:bg-gray-200">出品</a>
                    <form action="{{ route('logout.destroy') }}" id="logout-form" method="post" class="hidden">
                        @csrf
                    </form>
                @endauth

                @guest
                    @if (Request::routeIs('product.index') || Request::routeIs('product.show'))
                        <!-- show only for guests on product list or detail pages -->
                        <a href="{{ route('login.create') }}" class="hover:underline">ログイン</a>
                        <a href="{{ route('profile.show') }}" class="hover:underline">マイページ</a>
                        <a href="{{ route('product.create') }}"
                            class="bg-white text-black px-3 py-1 rounded hover:bg-gray-200 h-8">出品</a>
                    @endif
                @endguest
            </nav>
        </div>
    </header>

    @yield('content')

</body>

</html>
