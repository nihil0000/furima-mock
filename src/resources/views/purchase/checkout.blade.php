@extends('layouts.app')

@section('content')
<main class="flex-grow px-4">
    <div class="max-w-5xl mx-auto flex flex-col lg:flex-row gap-10 py-20">

        <!-- purchase details -->
        <section class="flex-1 space-y-8">
            <!-- product information -->
            <div class="flex gap-8 border-b pb-6">
                <div class="w-64 h-64 bg-gray-200 flex items-center justify-center shadow-xl">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="object-cover w-full h-full" />
                </div>

                <div class="space-y-4">
                    <h2 class="text-2xl font-bold">{{ $product->product_name }}</h2>
                    <p class="text-xl font-semibold">¥{{ number_format($product->price) }}</p>
                </div>
            </div>

            <!-- select payment -->
            <div class="border-b pb-6">
                <h3 class="text-lg font-semibold mb-2">支払い方法</h3>

                <form method="get" action="{{ route('purchase.show', ['product' => $product->id]) }}">
                    <select name="payment" onchange="this.form.submit()"
                        class="border px-3 py-2 rounded w-full max-w-sm">
                        <option value="" disabled {{ request('payment') ? '' : 'selected' }}>選択してください</option>
                        <option value="コンビニ支払い" {{ request('payment') === 'コンビニ支払い' ? 'selected' : '' }}>コンビニ支払い</option>
                        <option value="カード支払い" {{ request('payment') === 'カード支払い' ? 'selected' : '' }}>カード支払い</option>
                    </select>
                </form>

                <!-- validation -->
                @error ('payment')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- shipping address -->
            <div class="pb-6">
                <h3 class="text-lg font-semibold mb-2">配送先</h3>

                @if (empty($address['postal_code']) || empty($address['address']) || empty($address['building']))
                    <p class="text-gray-500">登録されていません</p>
                @else
                    <p>〒 {{ $address['postal_code'] }}</p>
                    <p>{{ $address['address'] . $address['building'] }}</p>
                @endif

                <!-- validation -->
                @error ('postal_code')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                @error ('address')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
                @error ('building')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <a href="{{ route('purchase.create', ['product' => $product->id]) }}"
                    class="text-blue-500 text-sm mt-2 inline-block">変更する</a>
            </div>
        </section>

        <!-- purchase confirmation -->
        <aside class="w-full lg:w-[400px] space-y-6">
            <!-- 購入処理のフォーム -->
            <form method="post" action="{{ route('purchase.store', ['product' => $product->id]) }}"
                class="space-y-6">
                @csrf
                <input type="hidden" name="payment" value="{{ request('payment') }}">
                <input type="hidden" name="postal_code" value="{{ isset($address) ? $address['postal_code'] : '' }}">
                <input type="hidden" name="address" value="{{ isset($address) ? $address['address'] : '' }}">
                <input type="hidden" name="building" value="{{ isset($address) ? $address['building'] : '' }}">

                <table class="w-full text-sm border border-gray-300">
                    <tr class="border-b border-gray-300">
                        <th class="text-lg text-left px-4 py-2">商品代金</th>
                        <td class="text-lg text-right px-4 py-2">¥{{ number_format($product->price) }}</td>
                    </tr>
                    <tr>
                        <th class="text-lg text-left px-4 py-2">支払い方法</th>
                        <td class="text-lg text-right px-4 py-2">{{ request('payment') ?? '選択されていません' }}</td>
                    </tr>
                </table>

                <button type="submit"
                    class="w-full bg-red-500 text-white font-bold py-2 rounded hover:bg-red-400 transition">
                    購入する
                </button>
            </form>
        </aside>
    </div>
</main>
@endsection
