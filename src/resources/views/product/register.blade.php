@extends('layouts.app')

@section('content')
<main class="product-create-container">
    <h1 class="page-title">商品の出品</h1>

    <form action="{{ route('product.store') }}" class="form_-body" method='post' enctype="multipart/form-data" novalidate>
        @csrf

        <!-- upload image -->
        <section class="product-image-upload">
            <h2>商品画像</h2>

            <label for="image" class="image-upload-label">画像を選択する</label>
            <input type="file" id="image" name="image">

            <!-- validation message -->
            @error('image')
                <p class="form__error-msg">{{ $message }}</p>
            @enderror
        </section>

        <!-- product details -->
        <section class="product-details">
            <h2>商品の詳細</h2>

            <!-- select category -->
            <div class="category-selection">
                <h3>カテゴリー</h3>

                <div class="category-tags">
                    @foreach ($categories as $category)
                        <input type="checkbox" id='category . {{ $category->id }}' name='category[]'
                                value="{{ $category->id }}"
                                {{ in_array($category->id, old('category', [])) ? 'checked' : '' }}>
                        <label for="category . {{ $category->id }}" class='category-tag-label'>
                            {{ $category->category_name }}
                        </label>
                    @endforeach
                </div>

                <!-- validation message -->
                @error('category')
                    <p class="form__error-msg">{{ $message }}</p>
                @enderror
            </div>

            <!-- select product status -->
            <div class="product-status">
                <h3>商品の状態</h3>
                <select name="status">
                    <option value="" disabled selected>選択してください</option>
                    <option value="excellent">良好</option>
                    <option value="goods" {{ old('status') === 'goods' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                    <option value="fair" {{ old('status') === 'fair' ? 'selected' : '' }}>やや傷や汚れあり</option>
                    <option value="bad" {{ old('status') === 'bad' ? 'selected' : '' }}>状態が悪い</option>
                </select>

                <!-- validation message -->
                @error('status')
                    <p class="form__error-msg">{{ $message }}</p>
                @enderror
            </div>
        </section>

        <!-- product information -->
        <section class="product-info-form">
            <h2>商品名と説明</h2>

            <label for="name">商品名</label>
            <input type="text" id="name" name="product_name" value="{{ old('product_name') }}">

            <!-- validation message -->
            @error('product_name')
                <p class="form__error-msg">{{ $message }}</p>
            @enderror

            <label for="brand">ブランド名</label>
            <input type="text" id="brand" name="brand_name" value="{{ old('brand_name') }}">

            <!-- validation message -->
            @error('brand_name')
                <p class="form__error-msg">{{ $message }}</p>
            @enderror

            <label for="description">商品の説明</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>

            <!-- validation message -->
            @error('description')
                <p class="form__error-msg">{{ $message }}</p>
            @enderror

            <label for="price">販売価格</label>
            <div class="price-input">
                <span>¥</span>
                <input type="number" id="price" name="price" value="{{ old('price') }}">
            </div>

            <!-- validation message -->
            @error('price')
                <p class="form__error-msg">{{ $message }}</p>
            @enderror
        </section>

        <!-- submit button -->
        <button type="submit" class="submit-button">出品する</button>
    </form>
</main>
@endsection
