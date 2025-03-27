@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/show.css') }}">
@endsection

@section('content')
<main class="product-list__container">

    <!-- navigation tabs -->
    <div class="product-tabs">
        <a href="{{ route('product.index', ['page' => 'recommend', 'query' => request('query')]) }}"
            class="{{ request()->query('page', 'recommend') === 'recommend' ? 'active-page' : '' }}">
            おすすめ
        </a>
        <a href="{{ route('product.index', ['page' => 'mylist', 'query' => request('query')]) }}"
            class="{{ request()->query('page') === 'mylist' ? 'active-page' : '' }}">
            マイリスト
        </a>
    </div>

    <!-- display the search keyword -->
    @if (!empty($query))
        <p class="search-keyword">「{{ $query }}」の検索結果</p>
    @endif

    @if (request()->query('page', 'recommend') === 'recommend')
        <!-- show recommended products -->
        <section class="product-list__grid">
            @foreach ($products as $product)
                <div class="product-card">
                    <a href="{{ route('product.show', ['product' => $product->id]) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                        <p class="product-name">{{ $product->product_name }}</p>

                        @if ($product->is_sold)
                            <span class="sold-label">Sold</span>
                        @endif
                    </a>
                </div>
            @endforeach
        </section>

    @elseif (isset($favorites))
        <!-- show favorite products -->
        <section class="product-list__grid">
            @foreach ($favorites as $favorite)
                @php $product = $favorite->product; @endphp

                <div class="product-card">
                    <a href="{{ route('product.show', ['product' => $product->id]) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                        <p class="product-name">{{ $product->product_name }}</p>

                        @if ($product->is_sold)
                            <span class="sold-label">Sold</span>
                        @endif
                    </a>
                </div>

            @endforeach
        </section>
    @endif
</main>
@endsection
