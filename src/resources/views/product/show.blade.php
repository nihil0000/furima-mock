@extends('layouts.app')

@section('content')
<main class="product-detail-container">
    <!-- product -->
    <div class="product-detail">
        <!-- product image -->
        <div class="product-image">
            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
        </div>

        <!-- product details -->
        <div class="product-info">
            <h1 class="product-title">{{ $product->product_name }}</h1>
            <p class="product-brand">{{ $product->brand_name }}</p>
            <p class="product-price">¥{{ $product->price }} <span class="tax-included">（税込）</span></p>

            <!-- favorite -->
            <div class="favorite-container">
                @if ($product->favorites->contains('user_id', Auth::id()))
                    <!-- favorite delete button -->
                    <form action="{{ route('favorite.destroy', $product->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="favorite-icon active">
                            @include('components.icons.favorite')
                            <span>{{ $product->favorites_count }}</span>
                        </button>
                    </form>
                @else
                    <!-- favorite register button -->
                    <form action="{{ route('favorite.store', $product->id) }}" method="post">
                        @csrf
                        <button type="submit" class="favorite-icon">
                            @include('components.icons.favorite')
                            <span>{{ $product->favorites_count }}</span>
                        </button>
                    </form>
                @endif
            </div>

            <!-- comment -->
            <div class="comment-icon {{ $product->comments->contains('user_id', Auth::id()) ? 'active' : '' }}">
                @include('components.icons.comment')

                <span>{{ $product->comments_count }}</span>
            </div>

            <!-- button for the purchase page -->
            <a href="{{ route('purchase.show', ['product' => $product->id]) }}" class="purchase-button">
                購入手続きへ
            </a>

            <!-- product description -->
            <div class="product-description">
                <h2>商品説明</h2>
                <p>{{ $product->description }}</p>
            </div>

            <!-- product categori and status -->
            <div class="product-details">
                <h2>商品の情報</h2>
                <p>カテゴリー
                    @foreach ($product->categories as $category)
                        <p class="category-tag">{{ $category->category_name }}</p>
                    @endforeach
                </p>
                <p>商品の状態
                    <p class="condition">{{ $product->status }}</p>
                </p>
            </div>
        </div>
    </div>

    <!-- product comment -->
    <div class="product-comments">
        <h2>コメント ({{ $product->comments_count }})</h2>

        @foreach ($randomComments as $comment)
            <div class="comment">
                <div class="comment-user">
                    <img src="{{ asset('storage/' . ($comment->user->profile_image)) }}"
                        alt="ユーザーアイコン" class="user-icon">
                    <span class="username">{{ $comment->user->name }}</span>
                </div>
                <p class="comment-text">{{ $comment->comment }}</p>
            </div>
        @endforeach

        <!-- input comment -->
        <form action="{{ route('comment.store', ['product' => $product->id]) }}" method="POST" class="comment-form">
            @csrf
            <label for="comment">商品のコメント</label>
            <textarea id="comment" name="comment"></textarea>

            <!-- validation -->
            @error('comment')
                <div class="form__error">
                    <p class="form__error-msg">{{ $message }}</p>
                </div>
            @enderror

            <button type="submit" class="submit-comment-button">コメントを送信する</button>
        </form>
    </div>
</main>
@endsection
