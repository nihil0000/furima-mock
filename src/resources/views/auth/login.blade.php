@extends('layouts/app')

@section('content')
<main class="min-h-[calc(100vh-64px)] bg-white flex justify-center px-4">
    <div class="w-full max-w-xl my-28 space-y-6">
        <h1 class="text-2xl font-bold text-center">ログイン</h1>

        <!-- login form -->
        <section class="login-form">
            <form action="{{ route('login.store') }}" method="post" novalidate class="space-y-4">
                @csrf

                <!-- email -->
                <div>
                    <label for="email" class="block font-semibold mb-1">メールアドレス</label>

                    <input type="email" name="email" id="email" placeholder="例: test@example.com" value="{{ old('email') }}"
                        class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                    <!-- validation -->
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- password -->
                <div>
                    <label for="password" class="block font-semibold mb-1">パスワード</label>

                    <input type="password" name="password" id="password" placeholder="例: coachtech1106"
                        class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                    <!-- validation -->
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- submit -->
                <div>
                    <button type="submit"
                        class="w-full bg-red-500 text-white h-10 rounded hover:bg-red-400 transition text-sm font-semibold mt-8">
                        ログインする
                    </button>
                </div>

                <!-- link to registration -->
                <a href="{{ route('register.create') }}" class="block text-center text-sm text-blue-600 hover:underline mt-4">
                    会員登録はこちら
                </a>
            </form>
        </section>
    </div>
</main>
@endsection
