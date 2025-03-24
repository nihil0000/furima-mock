@extends('layouts.app')

@section('content')
<main class="purchase-container">
    <h1 class="page-title">商品購入画面</h1>

    <div class="purchase-content">
        <!-- purchase details -->
        <section class="purchase-details">
            <!-- product information -->
            <div class="product-info">
                <div class="product-image">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                </div>
                <div class="product-summary">
                    <h2 class="product-name">{{ $product->product_name }}</h2>
                    <p class="product-price">¥{{ $product->price }}</p>
                </div>
            </div>

            <!-- 支払い方法選択 -->
            <div class="payment-method">
                <h3>支払い方法</h3>
                <form method="get" action="{{ route('purchase.show', ['product' => $product->id]) }}">
                    <select name="payment" onchange="this.form.submit()">
                        <option value="" disabled {{ request('payment') ? '' : 'selected' }}>選択してください</option>
                        <option value="コンビニ払い" {{ request('payment') === 'コンビニ支払い' ? 'selected' : '' }}>コンビニ支払い</option>
                        <option value="クレジットカード" {{ request('payment') === 'カード支払い' ? 'selected' : '' }}>カード支払い</option>
                    </select>
                </form>
            </div>

            <!-- 配送先情報 -->
            <div class="shipping-info">
                <h3>配送先</h3>
                <p>{{ $address['postal_code'] ?? '登録されていません'}}</p>
                <p>{{ $address['address'] ?? '登録されていません'}}</p>
                <p>{{ $address['building'] ?? '登録されていません'}}</p>

                <!-- validation -->
                @error ('address')
                    <div class="form__error">
                        <p class="form__error-msg">{{ $message }}</p>
                    </div>
                @enderror

                <a href="{{ route('purchase.create', ['product' => $product->id]) }}" class="change-address">変更する</a>
            </div>
        </section>

        <!-- 右側（価格確認 + 購入ボタン） -->
        <aside class="purchase-summary">
            <!-- 購入処理のフォーム -->
            <form method="post" action="{{ route('purchase.store', ['product' => $product->id]) }}">
                @csrf
                <input type="hidden" name="payment" value="{{ request('payment') }}">
                <input type="hidden" name="postal_code" value="{{ isset($address) ? $address['postal_code'] : '' }}">
                <input type="hidden" name="address" value="{{ isset($address) ? $address['address'] : '' }}">
                <input type="hidden" name="building" value="{{ isset($address) ? $address['building'] : '' }}">

                <table class="summary-table">
                    <tr>
                        <th>商品代金</th>
                        <td>¥{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td>{{ request('payment') ?? '選択されていません' }}</td>
                    </tr>
                </table>

                <!-- validation -->
                @error ('payment')
                    <div class="form__error">
                        <p class="form__error-msg">{{ $message }}</p>
                    </div>
                @enderror

                <button type="submit" class="purchase-button">購入する</button>
            </form>
        </aside>
    </div>
</main>
@endsection
