@extends('layouts.app')

@section('content')
<main class="product-create-container">
    <h1 class="page-title">商品出品</h1>

    <!-- 商品画像アップロード -->
    <section class="product-image-upload">
        <label for="image-upload" class="image-upload-label">
            <div class="image-upload-box">
                <span>画像を選択する</span>
            </div>
        </label>
        <input type="file" id="image-upload" name="image" accept="image/*" hidden>
    </section>

    <!-- 商品の詳細 -->
    <section class="product-details">
        <h2>商品の詳細</h2>

        <!-- カテゴリー選択 -->
        <div class="category-selection">
            <h3>カテゴリー</h3>
            <div class="category-tags">
                <label><input type="checkbox" name="category[]" value="fashion"> ファッション</label>
                <label><input type="checkbox" name="category[]" value="electronics"> 家電</label>
                <label><input type="checkbox" name="category[]" value="interior"> インテリア</label>
                <label><input type="checkbox" name="category[]" value="ladies"> レディース</label>
                <label><input type="checkbox" name="category[]" value="mens"> メンズ</label>
                <label><input type="checkbox" name="category[]" value="cosmetics"> コスメ</label>
                <label><input type="checkbox" name="category[]" value="shoes"> 靴</label>
                <label><input type="checkbox" name="category[]" value="sports"> スポーツ</label>
                <label><input type="checkbox" name="category[]" value="books"> 本</label>
                <label><input type="checkbox" name="category[]" value="handmade"> ハンドメイド</label>
                <label><input type="checkbox" name="category[]" value="accessories"> アクセサリー</label>
                <label><input type="checkbox" name="category[]" value="baby"> ベビー・キッズ</label>
            </div>
        </div>

        <!-- 商品の状態 -->
        <div class="product-condition">
            <h3>商品の状態</h3>
            <select name="condition" required>
                <option value="" disabled selected>選択してください</option>
                <option value="new">新品</option>
                <option value="like_new">ほぼ新品</option>
                <option value="good">良好</option>
                <option value="acceptable">使用感あり</option>
            </select>
        </div>
    </section>

    <!-- 商品情報 -->
    <section class="product-info-form">
        <h2>商品名と説明</h2>

        <label for="name">商品名</label>
        <input type="text" id="name" name="name" required>

        <label for="brand">ブランド名</label>
        <input type="text" id="brand" name="brand">

        <label for="description">商品の説明</label>
        <textarea id="description" name="description" rows="4"></textarea>

        <label for="price">販売価格</label>
        <div class="price-input">
            <span>¥</span>
            <input type="number" id="price" name="price" min="0" required>
        </div>
    </section>

    <!-- 出品ボタン -->
    <button type="submit" class="submit-button">出品する</button>
</main>
@endsection
