@extends('layouts.app')

@section('content')
<main class="address-edit-container">
    <h1 class="page-title">住所の変更</h1>

    {{-- <form action="{{ route('address.update') }}" method="POST"> --}}
        @csrf

        <!-- 郵便番号 -->
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" required>
            @error('postal_code') <p class="error">{{ $message }}</p> @enderror
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $address->address ?? '') }}" required>
            @error('address') <p class="error">{{ $message }}</p> @enderror
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $address->building ?? '') }}">
            @error('building') <p class="error">{{ $message }}</p> @enderror
        </div>

        <!-- 更新ボタン -->
        <button type="submit" class="update-button">更新する</button>
    </form>
</main>
@endsection
