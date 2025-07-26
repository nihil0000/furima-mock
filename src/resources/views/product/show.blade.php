@extends('layouts.app')

@section('content')
<main class="flex-grow px-4 py-10">
    <!-- product details container -->
    <div class="max-w-5xl mx-auto flex flex-col xl:flex-row gap-10">

        <!-- product image -->
        <section class="aspect-square w-full xl:w-1/2 h-full shadow-xl">
            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-full h-full object-cover">
        </section>

        <!-- product details -->
        <div class="flex-1 space-y-2">

            <!-- product name -->
            <h1 class="text-2xl font-bold">{{ $product->product_name }}</h1>

            <!-- brand name -->
            <p class="text-sm text-gray-600">{{ $product->brand_name }}</p>

            <!-- price -->
            <p class="text-2xl font-smibold">¥{{ number_format($product->price) }}
                <span class="tax-included">（税込）</span>
            </p>

            <!-- favorite, comment -->
            <section class="flex ml-4 gap-8">
                <!-- favorite register, delete-->
                <div>
                    @if ($isFavorited)
                        <!-- favorite delete button -->
                        <form action="{{ route('favorite.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('delete')

                            <button type="submit" class="flex flex-col items-center gap-1">
                                @include('components.icons.favorite')

                                <span>{{ $product->favorites_count }}</span>
                            </button>
                        </form>
                    @else
                        <!-- favorite register button -->
                        <form action="{{ route('favorite.store', $product->id) }}" method="post">
                            @csrf

                            <button type="submit" class="flex flex-col items-center gap-1">
                                @include('components.icons.favorite')

                                <span>{{ $product->favorites_count }}</span>
                            </button>
                        </form>
                    @endif
                </div>

                <!-- comment count -->
                <div class="flex flex-col items-center gap-1">
                    @include('components.icons.comment')

                    <span>{{ $product->comments_count }}</span>
                </div>
            </section>

            <!-- button for the purchase page -->
            @if ($product->is_sold)
                <button disabled class="bg-gray-400 text-white py-2 px-6 rounded w-full">sold out</button>
            @else
                <a href="{{ route('purchase.show', ['product' => $product->id]) }}"
                    class="block bg-red-500 text-white text-center py-2 px-6 rounded hover:bg-red-400 transition w-full mb-2">
                    購入手続きへ
                </a>
            @endif

            <!-- button for the trade chat page -->
            <!-- @auth
                @if (auth()->id() !== $sellerId) {{-- ログインユーザーが出品者でない場合のみ表示 --}}
                    <form action="{{ route('trade.start', ['product' => $product->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="block bg-gray-500 text-white text-center py-2 px-6 rounded hover:bg-gray-400 transition w-full">
                            出品者と取引チャットを始める
                        </button>
                    </form>
                @endif
            @endauth -->

            <!-- product description -->
            <section class="space-y-2 pt-8">
                <h2 class="text-lg font-bold">商品説明</h2>
                <p class="text-sm whitespace-pre-wrap">{{ $product->description }}</p>
            </section>

            <!-- product category and status -->
            <section class="space-y-1 pt-2 border-t">
                <h2 class="text-lg font-bold">商品の情報</h2>

                <!-- category -->
                <p class="text-sm">カテゴリー：
                    @foreach ($product->categories as $category)
                        <span class="inline-block bg-gray-200 text-xs px-2 py-1 rounded mr-1 mb-2">
                            {{ $category->category_name }}
                        </span>
                    @endforeach
                </p>

                <!-- status -->
                <p class="text-sm">商品の状態：
                    <span class="inline-block text-sm">{{ $product->status }}</span>
                </p>
            </section>

            <!-- comment -->
            <section class="space-y-6 pt-2 border-t">
                <h2 class="text-lg font-bold">コメント ({{ $product->comments_count }})</h2>

                @foreach ($latestComments as $comment)
                    <div class="flex items-start gap-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-200 shrink-0">
                            @if ($comment->user->profile_image)
                                <img src="{{ asset('storage/' . ($comment->user->profile_image)) }}" alt="ユーザーアイコン"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full object-cover flex justify-center items-center text-[8px]">No Image</div>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm">{{ $comment->user->name }}</p>
                            <p class="text-sm bg-gray-100 px-3 py-2 rounded mt-1">{{ $comment->comment }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- input comment -->
                <form action="{{ route('comment.store', ['product' => $product->id]) }}" method="post" class="space-y-3">
                    @csrf

                    <label for="comment" class="block font-semibold">商品のコメント</label>
                    <textarea id="comment" name="comment"
                        class="w-full border border-gray-300 rounded px-3 py-2 h-32 text-sm resize-none"></textarea>

                    <!-- validation -->
                    @error('comment')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <button type="submit"
                        class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-400 transition w-full">
                        コメントを送信する
                    </button>
                </form>
            </section>
        </div>
    </div>

</main>
@endsection
