@extends('layouts.app')

@section('content')
<main class="flex-grow px-4 py-10">
    <div class="max-w-3xl mx-auto space-y-10">
        <h1 class="text-2xl font-bold text-center">商品の出品</h1>

        <form action="{{ route('product.store') }}" method='post' enctype="multipart/form-data"
            novalidate class="space-y-10">
            @csrf

            <!-- upload product image -->
            <section class="space-y-3 border-b pb-6">
                <h2 class="text-lg font-semibold">商品画像</h2>

                <label for="image"
                    class="block border border-dashed border-red-400 rounded-md py-4 px-6 text-center text-red-500 cursor-pointer hover:bg-red-100">
                    画像を選択する
                </label>
                <input type="file" id="image" name="image" class="hidden">
                <p id="file-name" class="text-sm text-center mt-1"></p>

                <!-- validation message -->
                @error('image')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </section>

            <!-- product details -->
            <section class="space-y-6 border-b pb-6">
                <h2 class="text-lg font-semibold">商品の詳細</h2>

                <!-- select category -->
                <div>
                    <h3 class="font-semibold mb-2">カテゴリー</h3>

                    <div class="flex flex-wrap gap-2">
                        @foreach ($categories as $category)
                            <div class="mb-2">
                                <input type="checkbox" id="category_{{ $category->id }}" name='category[]'
                                    value="{{ $category->id }}"
                                    class="hidden peer"
                                    {{ in_array($category->id, old('category', [])) ? 'checked' : '' }}>
                                <label for="category_{{ $category->id }}"
                                    class="peer-checked:bg-red-500 peer-checked:text-white text-red-500 px-3 py-1 rounded-3xl text-sm cursor-pointer border border-red-500 hover:bg-red-100 transition">
                                    {{ $category->category_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- validation message -->
                    @error('category')
                        <p class="text-sm text-red-500 mt-3">{{ $message }}</p>
                    @enderror
                </div>

                <!-- select product status -->
                <div>
                    <h3 class="font-semibold mb-2">商品の状態</h3>
                    <select name="status" class="w-full max-w-sm border border-gray-400 px-3 py-2 rounded">>
                        <option value="" disabled selected>選択してください</option>
                        <option value="良好" {{ old('status') === '良好' ? 'selected' : '' }}>良好</option>
                        <option value="目立った傷や汚れなし" {{ old('status') === '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                        <option value="やや傷や汚れあり" {{ old('status') === 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                        <option value="状態が悪い" {{ old('status') === '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
                    </select>

                    <!-- validation message -->
                    @error('status')
                        <p class="text-sm text-red-500 mt-3">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <!-- product information -->
            <section class="space-y-4">
                <h2 class="text-lg font-semibold border-b pb-2">商品名と説明</h2>

                <!-- product name -->
                <div>
                    <label for="name" class="block font-medium mb-1">商品名</label>
                    <input type="text" id="name" name="product_name" value="{{ old('product_name') }}"
                        class="w-full border border-gray-400 px-3 py-2 rounded">

                    <!-- validation message -->
                    @error('product_name')
                        <p class="text-sm text-red-500 mt-3">{{ $message }}</p>
                    @enderror
                </div>

                <!-- brand name -->
                <div>
                    <label for="brand" class="block font-medium mb-1">ブランド名</label>
                    <input type="text" id="brand" name="brand_name" value="{{ old('brand_name') }}"
                        class="w-full border border-gray-400 px-3 py-2 rounded">

                    <!-- validation message -->
                    @error('brand_name')
                        <p class="text-sm text-red-500 mt-3">{{ $message }}</p>
                    @enderror
                </div>

                <!-- description -->
                <div>
                    <label for="description" class="block font-medium mb-1">商品の説明</label>
                    <textarea id="description" name="description"
                        class="w-full border border-gray-400 px-3 py-2 rounded h-32 resize-none">{{ old('description') }}</textarea>

                    <!-- validation message -->
                    @error('description')
                        <p class="text-sm text-red-500 mt-3">{{ $message }}</p>
                    @enderror
                </div>

                <!-- price -->
                <div>
                    <label for="price" class="block font-medium mb-1">販売価格</label>

                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">¥</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                            class="pl-8 w-full border border-gray-400 px-3 py-2 rounded">
                    </div>

                    <!-- validation message -->
                    @error('price')
                        <p class="text-sm text-red-500 mt-3">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <!-- submit button -->
            <button type="submit"
                class="block mx-auto w-full max-w-sm bg-red-500 text-white text-center font-semibold py-2 rounded hover:bg-red-400 transition">
                出品する
            </button>
        </form>
    </div>
</main>
@endsection
