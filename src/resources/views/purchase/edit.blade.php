@extends('layouts.app')

@section('content')
<main class="flex-grow px-4">
    <div class="w-full max-w-xl mx-auto my-20 space-y-6">
        <h1 class="text-2xl font-bold text-center">住所の変更</h1>

        <form action="{{ route('purchase.update', ['product' => $product->id]) }}"
            method="post"
            class="space-y-4">
            @csrf

            <!-- poastal code -->
            <section class="space-y-1">
                <label for="postal_code" class="block font-semibold">郵便番号</label>

                <input type="text" id="postal_code" name="postal_code" placeholder="例: 123-4567"
                    value="{{ old('postal_code', $address['postal_code'] ?? '') }}"
                    class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                <!-- validation -->
                @error('postal_code')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </section>

            <!-- address -->
            <section class="space-y-1">
                <label for="address" class="block font-semibold">住所</label>

                <input type="text" id="address" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3"
                    value="{{ old('address', $address['address'] ?? '') }}"
                    class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                <!-- validation -->
                @error('address')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </section>

            <!-- building -->
            <section class="space-y-1">
                <label for="building" class="block font-semibold">建物名</label>

                <input type="text" id="building" name="building"
                    placeholder="例: 千駄ヶ谷マンション101"
                    value="{{ old('building', $address['building'] ?? '') }}"
                    class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                <!-- validation -->
                @error('building')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </section>

            <!-- submit button-->
            <div class="pt-8">
                <button type="submit"
                    class="w-full bg-red-500 text-white h-10 rounded hover:bg-red-400 transition text-sm font-semibold">
                    更新する
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
