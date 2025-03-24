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
            <li>
                <a href="{{ route('profile.show', ['tab' => 'exhibit']) }}"
                    class="{{ request()->query('tab', 'exhibit') === 'exhibit' ? 'active' : '' }}">
                    出品した商品
                </a>
            </li>
            <li>
                <a href="{{ route('profile.show', ['tab' => 'order']) }}"
                    class="{{ request()->query('tab') === 'order' ? 'active' : '' }}">
                    購入した商品
                </a>
            </li>
        </ul>
    </section>

    @if (request()->query('tab', 'exhibit') === 'exhibit')
        <section class="product-list">
            @foreach ($user->products as $product)
                <div class="product">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                    <p class="product-name">{{ $product->product_name }}</p>
                </div>
            @endforeach
        </section>
    @else
        <section class="product-list">
            @foreach ($user->orders as $order)
                @php
                    $product = $order->product;
                @endphp

                <div class="product">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                    <p class="product-name">{{ $product->product_name }}</p>
                </div>
            @endforeach
        </section>
    @endif
</main>
@endsection
