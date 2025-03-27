@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/show.css') }}">
@endsection

@section('content')
<main class="profile-container">
    <section class="profile-header">
        <div class="profile-image">
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
        </div>
        <h2 class="profile-name">{{ $user->name }}</h2>
        <a href="{{ route('profile.edit') }}" class="profile-edit-btn">プロフィールを編集</a>
    </section>

    <section class="profile-tabs">
        <ul class="tabs">
            <a href="{{ route('profile.show', ['page' => 'exhibit']) }}"
                class="{{ request()->query('page', 'exhibit') === 'exhibit' ? 'active' : '' }}">
                出品した商品
            </a>
            <a href="{{ route('profile.show', ['page' => 'order']) }}"
                class="{{ request()->query('page') === 'order' ? 'active' : '' }}">
                購入した商品
            </a>
        </ul>
    </section>

    @if (request()->query('page', 'exhibit') === 'exhibit')
        <section class="product-list__grid">
            @foreach ($user->products as $product)
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
    @else
        <section class="product-list__grid">
            @foreach ($user->orders as $order)
                @php
                    $product = $order->product;
                @endphp

                <div class="product-card">
                    <a href="{{ route('product.show', ['product' => $product->id]) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                        <p class="product-name">{{ $product->product_name }}</p>
                    </a>
                </div>
            @endforeach
        </section>
    @endif
</main>
@endsection
