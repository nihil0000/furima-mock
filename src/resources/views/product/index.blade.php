@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/show.css') }}">
@endsection

@section('content')
<main class="product-list-container">
    <section class="profile-tabs">
        <ul class="tabs">
            <li>
                <a href="{{ route('product.index', ['tab' => 'recommend']) }}"
                    class="{{ request()->query('tab', 'recommend') === 'recommend' ? 'mylist' : '' }}">
                    おすすめ
                </a>
            </li>
            <li>
                <a href="{{ route('product.index', ['tab' => 'mylist']) }}"
                    class="{{ request()->query('tab') === 'mylist' ? 'recommend' : '' }}">
                    マイリスト
                </a>
            </li>
        </ul>
    </section>

    {{--
    @if (request()->query('tab', 'recommend') === 'recommend')
        <section class="product-list">
            @foreach ($sellProducts as $product)
                <div class="product">
                    <img src="{{ asset($product->image_path ?? 'images/sample-product.png') }}" alt="商品画像">
                    <p class="product-name">{{ $product->name }}</p>
                </div>
            @endforeach
        </section>
    @else
        <section class="product-list">
            @foreach ($boughtProducts as $product)
                <div class="product">
                    <img src="{{ asset($product->image_path ?? 'images/sample-product.png') }}" alt="商品画像">
                    <p class="product-name">{{ $product->name }}</p>
                </div>
            @endforeach
        </section>
    @endif
    --}}
</main>
@endsection
