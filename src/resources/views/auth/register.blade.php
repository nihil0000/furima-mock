@extends('layouts/app')

@section('content')
<main class="min-h-[calc(100vh-144px)] bg-white px-4">
    <div class="w-full max-w-xl mx-auto my-20 space-y-6">
        <h1 class="text-2xl font-bold text-center">会員登録</h1>

        <!-- register form -->
        <section>
            <form action="{{ route('register.create') }}" method="post" novalidate class="space-y-4">
                @csrf

                <!-- user name -->
                <div>
                    <label for="user_name" class="block font-semibold mb-1">ユーザー名</label>

                    <input type="text" name="name" id="user_name" placeholder="例: 山田 太郎" value="{{ old('name') }}"
                        class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                    <!-- validation -->
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- email -->
                <div>
                    <label for="email" class="block font-semibold mb-1">メールアドレス</label>

                    <input type="email" name="email" id="email" placeholder="例: test@example.com"
                        value="{{ old('email') }}" class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                    <!-- validation -->
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- password -->
                <div>
                    <label for="password" class="block font-semibold mb-1">パスワード</label>

                    <input type="password" name="password" id="password" placeholder="例: coachtech1106"
                        class="w-full h-10 border border-gray-400 px-3 text-sm">

                    <!-- validation -->
                    @error('password')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- confirm password -->
                <div>
                    <label for="confirmed_password" class="block font-semibold mb-1">確認用パスワード</label>

                    <input type="password" id="confirmed_password" name="password_confirmation"
                        class="w-full h-10 border border-gray-400 px-3">

                    <!-- validation -->
                    @error('password_confirmation')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- submit -->
                <div>
                    <button type="submit"
                        class="w-full h-10 bg-red-500 text-white rounded hover:bg-red-400 transition text-sm font-semibold mt-8">
                        登録する
                    </button>
                </div>

                <!-- link to login -->
                <a href="{{ route('login.create') }}"
                    class="block text-center text-sm text-blue-600 hover:underline mt-4">
                    ログインはこちら
                </a>
            </form>
        </section>
    </div>
</main>
@endsection
