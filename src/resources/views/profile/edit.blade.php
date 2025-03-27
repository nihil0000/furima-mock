@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/edit.css') }}">
@endsection

@section('content')
<main class="profile-edit-container">
    <p class="title">プロフィール設定</p>

    <section class="profile-header">

    </section>

    <!-- profile edit form -->
    <section class="form">
        <form action="{{ route('profile.store') }}" class="form__body" method="post" enctype="multipart/form-data">
            @csrf

            <!-- image -->
            <div class="profile-image">
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="profile-img">

                <label for="image" class="image-upload-label">画像を選択する</label>
                <input type="file" id="image" name="image">

                <!-- validation message -->
                @error('image')
                    <p class="form__error-msg">{{ $message }}</p>
                @enderror
            </div>

            <!-- user name -->
            <div class="form__group">
                <p class="form__group-label">ユーザー名</p>

                <div class="form__group-item">
                    <input type="text" class="form__input" name="name" value="{{ $user->name }}">
                </div>

                <!-- validation -->
                @error('name')
                <div class="form__error">
                    <p class="form__error-msg">{{ $message }}</p>
                </div>
                @enderror
            </div>

            <!-- postal　code -->
            <div class="form__group">
                <div class="form__group-label">
                    <p class="label__text">郵便番号</p>
                </div>
                <div class="postal-code-input">
                    <input type="text" name="postal_code" placeholder="例: 123-4567"
                            value="{{ old('postal_code', optional($user->address)->postal_code) }}">
                </div>
                <div class="postal-code-form__error">
                    @error('postal_code')
                        <p class="form__error-msg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- address -->
            <div class="form__group">
                <div class="form__group-label">
                    <p class="label__text">住所</p>
                </div>
                <div class="address-input">
                    <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3"
                            value="{{ old('address', optional($user->address)->address) }}">
                </div>
                <div class="address-form__error">
                    @error('address')
                        <p class="form__error-msg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- building name -->
            <div class="form__group">
                <div class="form__group-label">
                    <p class="label__text">建物名</p>
                </div>
                <div class="form__group-item">
                    <input type="text" class="building-name-input" name="building"
                            placeholder="例: 千駄ヶ谷マンション101"
                            value="{{ old('building', optional($user->address)->building) }}">
                </div>
                <div class="address-form__error">
                    @error('building')
                        <p class="form__error-msg">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="update-button">更新する</button>
        </form>
    </section>
</main>
@endsection
