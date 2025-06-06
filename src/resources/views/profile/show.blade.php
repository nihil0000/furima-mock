@extends('layouts.app')

@section('content')
<main class="flex-grow px-4">
    <div class="space-y-4">
        <section class="w-full max-w-xl mx-auto pt-20 flex items-center gap-8">
            <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden shrink-0">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-sm">
                        No Image
                    </div>
                @endif
            </div>

            <div class="flex items-center place-content-between w-full">
                <h2 class="text-2xl">{{ $user->name }}</h2>

                @if (!is_null($user->average_rating))
                    <div class="flex items-center gap-1 text-yellow-500 text-sm ml-2">
                        @for ($i = 0; $i < $user->average_rating; $i++)
                            <span>&#9733;</span>
                        @endfor
                        <span class="text-gray-600">（{{ $user->receivedRatings->count() }}件）</span>
                    </div>
                @endif

                <div>
                    <a href="{{ route('profile.edit') }}"
                        class="text-red-500 border border-red-300 text-sm px-4 py-1 rounded hover:bg-red-100">
                        プロフィールを編集
                    </a>
                </div>
            </div>
        </section>

        <section>
            <!-- navigation tabs -->
            <div class="flex justify-center border-b border-gray-300">
                <a href="{{ route('profile.show', ['page' => 'exhibit']) }}"
                    class="px-6 py-4 text-sm font-semibold border-b-2 transition
                        {{ request()->query('page', 'exhibit') === 'exhibit'
                            ? 'text-red-500 border-red-500'
                            : 'text-gray-500 border-transparent hover:text-black hover:border-gray-400' }}">
                    出品した商品
                </a>
                <a href="{{ route('profile.show', ['page' => 'order']) }}"
                    class="px-6 py-4 text-sm font-semibold border-b-2 transition
                        {{ request()->query('page') === 'order'
                            ? 'text-red-500 border-red-500'
                            : 'text-gray-500 border-transparent hover:text-black hover:border-gray-400' }}">
                    購入した商品
                </a>
                <a href="{{ route('profile.show', ['page' => 'trading']) }}"
                    class="px-6 py-4 text-sm font-semibold border-b-2 transition
                        {{ request()->query('page') === 'trading'
                            ? 'text-red-500 border-red-500'
                            : 'text-gray-500 border-transparent hover:text-black hover:border-gray-400' }}">
                    取引中の商品
                    @if($tradingCount > 0)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5 ml-1">{{ $tradingCount }}</span>
                    @endif
                </a>
            </div>

            <!-- exhibit products -->
            @if (request()->query('page', 'exhibit') === 'exhibit')
                <!-- show exihibit produtcs -->
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 px-4 py-6">
                    @foreach ($user->products as $product)
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <a href="{{ route('product.show', ['product' => $product->id]) }}">
                                <div class="aspect-square bg-gray-200 overflow-hidden">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-full h-full object-cover">
                                </div>

                                <div class="h-[64px]">
                                    <p class="p-2 text-center">{{ $product->product_name }}</p>
                                </div>

                                @if ($product->is_sold)
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-lg">Sold</span>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            @elseif (request()->query('page') === 'order')
                <!-- show purchase products -->
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 px-4 py-6">
                    @foreach ($user->orders as $order)
                        @php
                            $product = $order->product;
                        @endphp

                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition">
                            <a href="{{ route('product.show', ['product' => $product->id]) }}">
                                <div class="aspect-square bg-gray-200 overflow-hidden">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-full h-full object-cover">
                                </div>

                                <div class="h-[64px]">
                                    <p class="p-2 text-center">{{ $product->product_name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @elseif (request()->query('page') === 'trading')
                <!-- show trade products -->
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8 px-4 py-6">
                    @foreach ($tradingProducts as $trade)
                        @php
                            $product = $trade->product;
                            $trade_id = $trade->id;
                        @endphp
                        <div class="bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-md transition relative">
                            <a href="{{ route('trade.show', ['trade' => $trade_id]) }}">
                                <div class="aspect-square bg-gray-200 overflow-hidden relative">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-full h-full object-cover">
                                    @if($trade->unread_count > 0)
                                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs rounded-full px-2 py-0.5 z-10">
                                            {{ $trade->unread_count }}
                                        </span>
                                    @endif
                                </div>
                                <div class="h-[64px]">
                                    <p class="p-2 text-center">{{ $product->product_name }}</p>
                                </div>
                                @if ($product->is_sold)
                                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-lg">Sold</span>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</main>
@endsection
