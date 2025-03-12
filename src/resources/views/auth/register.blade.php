@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<main class="register-container">
    <p class="register__title">Register</p>

    <!-- register form -->
    <div class="register-form">
        <form action="{{ route('register.create') }}" class="form__body" method="post" novalidate>
            @csrf

            <!-- user name -->
            <div class="form__group">
                <p class="form__group-label">ユーザー名</p>

                <div class="form__group-item">
                    <input type="text" class="form__input" name="name" placeholder="例: 山田 太郎" value="{{ old('name') }}">
                </div>

                <!-- validation -->
                @error('name')
                <div class="form__error">
                    <p class="form__error-msg">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <!-- email -->
            <div class="form__group">
                <p class="form__group-label">メールアドレス</p>

                <div class="form__group-item">
                    <input type="email" class="form__input" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                </div>

                <!-- validation -->
                @error('email')
                <div class="form__error">
                    <p class="form__error-msg">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <!-- password -->
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

            <!-- confirm password -->
            <div class="form__group">
                <p class="form__group-label">確認用パスワード</p>

                <div class="form__group-item">
                    <input type="password" class="form__input" name="password" placeholder="例: coachtech1106">
                </div>

                <!-- validation -->
                @error('confirm_password')
                <div class="form__error">
                    <p class="form__error-msg">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <button type="submit" class="register-button">登録</button>
            <a href="" class="auth-link">ログインはこちら</a>
        </form>
    </div>
</main>
@endsection
