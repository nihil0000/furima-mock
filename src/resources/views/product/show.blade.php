@extends('layouts.app')

@section('content')
<main class="product-detail-container">
    <!-- 商品情報エリア -->
    <div class="product-detail">
        <!-- 左側（商品画像） -->
        <div class="product-image">
            <img src="{{ asset('images/sample-product.png') }}" alt="商品画像">
        </div>

        <!-- 右側（商品詳細情報） -->
        <div class="product-info">
            <h1 class="product-title">商品名がここに入る</h1>
            <p class="product-brand">ブランド名</p>
            <p class="product-price">¥47,000 <span class="tax-included">（税込）</span></p>

            <!-- いいね & コメント -->
            <div class="product-actions">
                <span class="likes">⭐ 3</span>
                <span class="comments">💬 1</span>
            </div>

            <!-- 購入ボタン -->
            <button class="purchase-button">購入手続きへ</button>

            <!-- 商品説明 -->
            <div class="product-description">
                <h2>商品説明</h2>
                <p>カラー：グレー</p>
                <p>新品</p>
                <p>商品の状態は良好です。傷もありません。</p>
                <p>購入後、即発送いたします。</p>
            </div>

            <!-- 商品の情報 -->
            <div class="product-details">
                <h2>商品の情報</h2>
                <p>カテゴリー：
                    <span class="category-tag">洋服</span>
                    <span class="category-tag">メンズ</span>
                </p>
                <p>商品の状態： <span class="condition">良好</span></p>
            </div>
        </div>
    </div>

    <!-- コメントエリア -->
    <div class="product-comments">
        <h2>コメント (1)</h2>
        <div class="comment">
            <div class="comment-user">
                <img src="{{ asset('images/default-user.png') }}" alt="ユーザーアイコン" class="user-icon">
                <span class="username">admin</span>
            </div>
            <p class="comment-text">こちらにコメントが入ります。</p>
        </div>

        <!-- コメント入力フォーム -->
        <div class="comment-form">
            <label for="comment">商品のコメント</label>
            <textarea id="comment" name="comment" rows="4"></textarea>
            <button class="submit-comment-button">コメントを送信する</button>
        </div>
    </div>
</main>
@endsection
