@extends('layouts.app')

@section('content')
<main class="flex-grow px-4">
    <!-- navigation tabs -->
    <section class="flex justify-center border-b border-gray-300">
        <a href="{{ route('product.index', ['page' => 'recommend', 'query' => request('query')]) }}"
            class="px-6 py-4 text-sm font-semibold border-b-2 transition
                {{ request()->query('page', 'recommend') === 'recommend'
                    ? 'text-red-500 border-red-500'
                    : 'text-gray-500 border-transparent hover:text-black hover:border-gray-400' }}">
            おすすめ
        </a>
        <a href="{{ route('product.index', ['page' => 'mylist', 'query' => request('query')]) }}"
            class="px-6 py-4 text-sm font-semibold border-b-2 transition
                {{ request()->query('page') === 'mylist'
                    ? 'text-red-500 border-red-500'
                    : 'text-gray-500 border-transparent hover:text-black hover:border-gray-400' }}">
            マイリスト
        </a>
    </section>

    <!-- search keyword -->
    @if (!empty($query))
        <div class="w-full mt-4 px-8">
            <p class="inline-block bg-gray-100 border border-gray-300 text-gray-700 px-4 py-2 rounded-full shadow-sm">
                「<span class="font-semibold text-black">{{ $query }}</span>」の検索結果
            </p>
        </div>
    @endif

    <!-- recommend products -->
    @if (request()->query('page', 'recommend') === 'recommend')
        <!-- show recommended products -->
        <section class="grid gap-6 grid-cols-2 md:grid-cols-3 xl:grid-cols-4 px-4 py-6">
            @foreach ($products as $product)
                <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                    <a href="{{ route('product.show', ['product' => $product->id]) }}">
                        <div class="aspect-square bg-gray-200 overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-full h-full object-cover">
                        </div>

                        <div class=h-[64px]>
                            <p class="p-2 text-center">{{ $product->product_name }}</p>

                            @if ($product->is_sold)
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-lg">Sold</span>
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </section>

    <!-- mylist products -->
    @elseif (isset($favorites))
        <!-- show favorite products -->
        <section class="grid gap-6 grid-cols-2 md:grid-cols-3 xl:grid-cols-4 px-4 py-6">
            @foreach ($favorites as $favorite)
                @php $product = $favorite->product; @endphp

                <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                    <a href="{{ route('product.show', ['product' => $product->id]) }}">
                        <div class="aspect-square bg-gray-200 overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-full h-full object-cover">>
                        </div>

                        <div class=h-[64px]>
                            <p class="p-2 text-center">{{ $product->product_name }}</p>

                            @if ($product->is_sold)
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-lg">Sold</span>
                            @endif
                        </div>
                    </a>
                </div>

            @endforeach
        </section>
    @endif
</main>
@endsection
