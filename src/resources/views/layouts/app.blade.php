<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    @yield('css')

    @vite(['resources/js/app.js'])

    <title>furima</title>
</head>

<body class="min-h-screen flex flex-col font-slab">
    <header class="bg-black text-white py-4">
        <div class="max-w-[1200px] mx-auto flex flex-col xl:flex-row items-center justify-between">

            <!-- logo -->
            @if (Request::routeIs('verification.notice'))
                <a href="" class="self-center xl:self-auto">
                    <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" class="h-8">
                </a>
            @else
                <a href="{{ route('product.index') }}" class="self-center xl:self-auto cursor-pointer">
                    <img src="{{ asset('images/logo.svg') }}" alt="ロゴ" class="h-8">
                </a>
            @endif

            <!-- show search bar in header (except on login and registration pages) -->
            @unless (Request::routeIs('login.create') || Request::routeIs('register.create') || Request::routeIs('verification.notice'))
                <form action="{{ route('product.index') }}" method="get" class="flex items-center space-x-2">
                    <input type="text" name="query" placeholder="なにをお探しですか？" value="{{ request('query') }}"
                        class="my-4 h-8 w-full md:w-60 xl:w-80 rounded text-black px-4 text-sm" />
                    <button type="submit"
                        class="bg-white text-black h-8 px-4 py-1 rounded hover:bg-gray-100 text-sm md:text-base whitespace-nowrap">
                        検索
                    </button>
                </form>
            @endunless

            <nav class="flex items-center space-x-5">
                @auth
                    @unless (Request::routeIs('login.create') || Request::routeIs('register.create') || Request::routeIs('verification.notice'))
                        <!-- show only for authenticated users -->
                        <a href="{{ route('logout.destroy') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="hover:underline text-sm md:text-base whitespace-nowrap">
                            ログアウト
                        </a>

                        <a href="{{ route('profile.show') }}" class="hover:underline text-sm md:text-base whitespace-nowrap">
                            マイページ
                        </a>

                        <a href="{{ route('product.create') }}"
                            class="bg-white text-black px-3 py-1 rounded hover:bg-gray-200 text-sm md:text-base whitespace-nowrap">
                            出品
                        </a>

                        <form action="{{ route('logout.destroy') }}" id="logout-form" method="post" class="hidden">
                            @csrf
                        </form>
                    @endunless
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
