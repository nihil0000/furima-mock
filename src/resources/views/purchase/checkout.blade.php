@extends('layouts.app')

@section('content')
<main class="purchase-container">
    <h1 class="page-title">商品購入画面</h1>

    <div class="purchase-content">
        <!-- 左側（商品情報 + 支払い方法 + 配送先） -->
        <section class="purchase-details">
            <!-- 商品情報 -->
            <div class="product-info">
                <div class="product-image">
                    <img src="{{ asset('images/sample-product.png') }}" alt="商品画像">
                </div>
                <div class="product-summary">
                    <h2 class="product-name">商品名</h2>
                    <p class="product-price">¥47,000</p>
                </div>
            </div>

            <!-- 支払い方法選択 -->
            <div class="payment-method">
                <h3>支払い方法</h3>
                <select name="payment" required>
                    <option value="" disabled selected>選択してください</option>
                    <option value="credit_card">クレジットカード</option>
                    <option value="convenience_store">コンビニ払い</option>
                    <option value="bank_transfer">銀行振込</option>
                </select>
            </div>

            <!-- 配送先情報 -->
            <div class="shipping-info">
                <h3>配送先</h3>
                <p>〒 XXX-YYYY</p>
                <p>ここには住所と連絡先が入ります</p>
                {{-- <a href="{{ route('purchase.create') }}" class="change-address">変更する</a> --}}
                <a href="#" class="change-address">変更する</a>
            </div>
        </section>

        <!-- 右側（価格確認 + 購入ボタン） -->
        <aside class="purchase-summary">
            <table class="summary-table">
                <tr>
                    <th>商品代金</th>
                    <td>¥47,000</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td>コンビニ払い</td>
                </tr>
            </table>
            <button type="submit" class="purchase-button">購入する</button>
        </aside>
    </div>
</main>
@endsection
