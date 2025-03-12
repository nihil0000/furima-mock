@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<main class="login-container">
    <p class="login__title">ログイン</p>

    <div class="login-form">
        <form action="{{ route('login.store') }}" class="form__body" method="post" novalidate>
            @csrf
            <!-- email form -->
            <div class="form__group">
                <p class="form__group-label">メールアドレス</p>

                <div class="form__group-item">
                    <input type="email" class="form__input" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                </div>

                <!-- validation -->
                @error('email')
                <div class="form__error">
                    <p class="form__error-msg">{{ $error }}</p>
                </div>
                @enderror
            </div>

            <!-- password form -->
            <div class="form__group">
                <p class="form__group-label">パスワード</p>

                <div class="form__group-item">
                    <input type="password" class="form__input" name="password" placeholder="例: coachtech1106">
                </div>

                <!-- validation -->
                @error('password')
                <div class="form__error">
                    <p class="form__error-msg">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <button type="submit" class="login-button">ログインする</button>
            <a href="" class="auth-link">会員登録はこちら</a>
        </form>
    </div>
</main>
@endsection
