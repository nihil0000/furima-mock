@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- サイドバー -->
    <aside class="w-64 bg-gray-200 p-4 flex-shrink-0">
        <div class="font-bold mb-4">その他の取引</div>
        @foreach($sidebarTrades as $sidebarTrade)
            <a href="{{ route('trade.show', ['trade' => $sidebarTrade->id]) }}"
                class="flex items-center mb-2 p-2 rounded {{ $sidebarTrade->id == $trade->id ? 'bg-white font-bold' : '' }}">
                <img src="{{ asset('storage/' . $sidebarTrade->product->image) }}" class="w-10 h-10 object-cover rounded mr-2">
                <span>{{ $sidebarTrade->product->product_name }}</span>
            </a>
        @endforeach
    </aside>

    <!-- メインチャット画面 -->
    <main class="flex-1 bg-white p-8">
        @php
            $partner = $trade->buyer_id === $currentUserId ? $trade->seller : $trade->buyer;
            $isBuyer = $trade->buyer_id === $currentUserId;
            $editMessageId = request('edit_message_id');
        @endphp

        <!-- タイトルとボタンを横並び -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">
                「{{ $partner->name }}」さんとの取引画面
            </h2>
            @if($isBuyer)
                <a href="#" id="completeTradeButton" class="bg-red-500 text-white px-6 py-2 rounded-full text-base font-bold hover:bg-red-400">
                    取引を完了する
                </a>
            @endif
        </div>

        <!-- 商品情報 -->
        <div class="mb-4 p-4 bg-gray-100 rounded flex items-center gap-6">
            <img src="{{ asset('storage/' . $trade->product->image) }}" alt="商品画像" class="w-32 h-32 object-cover rounded bg-gray-200">
            <div>
                <div class="text-2xl font-bold mb-2">{{ $trade->product->product_name }}</div>
                <div class="text-lg">¥{{ number_format($trade->product->price) }}</div>
            </div>
        </div>
        <div class="h-96 overflow-y-auto border p-4 mb-4 bg-white rounded flex flex-col gap-2">
            @foreach($messages as $msg)
                @if($msg->user_id === $currentUserId)
                    <!-- 自分のメッセージ（右寄せ） -->
                    <div class="flex items-start gap-2 justify-end">
                        <div>
                            <div class="text-xs text-gray-500 text-right">{{ $msg->user->name }}（{{ $msg->created_at->format('Y/m/d H:i') }}）</div>
                            @if($editMessageId == $msg->id)
                                <!-- 編集フォーム -->
                                <form action="{{ route('trade-message.update', $msg->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="message" value="{{ old('message', $msg->message) }}" class="border rounded px-2 py-1 flex-1">
                                    <button type="submit" class="text-blue-500">保存</button>
                                    <a href="{{ url()->current() }}" class="text-gray-500 ml-2">キャンセル</a>
                                </form>
                            @else
                                @if($msg->message)
                                    <div class="bg-blue-200 rounded px-3 py-2 inline-block">{{ $msg->message }}</div>
                                @endif
                            @endif
                            @if($msg->image_path)
                                <div class="mt-1 text-right">
                                    <img src="{{ asset('storage/' . $msg->image_path) }}" alt="画像" class="w-32 h-32 object-cover rounded ml-auto">
                                </div>
                            @endif
                            <div class="text-right text-xs mt-1">
                                <!-- 編集ボタン -->
                                <form action="{{ url()->current() }}" method="GET" class="inline">
                                    <input type="hidden" name="edit_message_id" value="{{ $msg->id }}">
                                    <button type="submit" class="text-blue-500 ml-2">編集</button>
                                </form>
                                <!-- 削除ボタン -->
                                <form action="{{ route('trade-message.destroy', $msg->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 ml-2">削除</button>
                                </form>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-gray-300 overflow-hidden">
                            @if($msg->user->profile_image)
                                <img src="{{ asset('storage/' . $msg->user->profile_image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                    </div>
                @else
                    <!-- 相手のメッセージ（左寄せ） -->
                    <div class="flex items-start gap-2">
                        <div class="w-8 h-8 rounded-full bg-gray-300 overflow-hidden">
                            @if($msg->user->profile_image)
                                <img src="{{ asset('storage/' . $msg->user->profile_image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <div class="text-xs text-gray-500">{{ $msg->user->name }}（{{ $msg->created_at->format('Y/m/d H:i') }}）</div>
                            @if($msg->message)
                                <div class="bg-gray-200 rounded px-3 py-2 inline-block">{{ $msg->message }}</div>
                            @endif
                            @if($msg->image_path)
                                <div class="mt-1">
                                    <img src="{{ asset('storage/' . $msg->image_path) }}" alt="画像" class="w-32 h-32 object-cover rounded">
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <form action="{{ route('trade.messages.store', $trade->id) }}" method="POST"
            enctype="multipart/form-data" class="flex gap-2" id="tradeMessageForm">
            @csrf
            <div class="flex flex-col flex-1">
                <input type="text" name="message" class="border rounded px-2 py-1" placeholder="取引メッセージを記入してください">
                @if ($errors->has('message'))
                    <p class="text-red-500 text-sm mb-1">{{ $errors->first('message') }}</p>
                @endif
            </div>

            <div class="flex flex-col">
                <input type="file" name="image" class="border rounded px-2 py-1">
                @if ($errors->has('image'))
                    <p class="text-red-500 text-sm mb-1">{{ $errors->first('image') }}</p>
                @endif
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">送信</button>
        </form>
    </main>
</div>

<div id="ratingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex justify-center items-center hidden">
    <div class="bg-yellow-50 p-6 rounded-lg shadow-xl max-w-sm w-full">
        <div class="text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                取引が完了しました。
            </h3>
            <p class="text-gray-700 mb-4">今回の取引相手はどうでしたか？</p>

            <form id="ratingForm" method="POST">
                @csrf
                <input type="hidden" name="rated_user_id" id="rated_user_id">


                <div class="flex flex-row-reverse justify-center space-x-1 space-x-reverse text-gray-300 text-4xl cursor-pointer">
                    <input type="radio" name="score" id="star1" value="5" class="hidden" required>
                    <label for="star1" class="star">&#9733;</label>

                    <input type="radio" name="score" id="star2" value="4" class="hidden">
                    <label for="star2" class="star">&#9733;</label>

                    <input type="radio" name="score" id="star3" value="3" class="hidden">
                    <label for="star3" class="star">&#9733;</label>

                    <input type="radio" name="score" id="star4" value="2" class="hidden">
                    <label for="star4" class="star">&#9733;</label>

                    <input type="radio" name="score" id="star5" value="1" class="hidden">
                    <label for="star5" class="star">&#9733;</label>
                </div>
                @error('score')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('rating')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-6">
                    <button id="submitRatingBtn" type="submit"
                            class="px-8 py-2 bg-red-400 text-white text-base font-bold rounded-md shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-300">
                        送信する
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.star {
  color: #d1d5db; /* デフォルトでグレー */
  transition: color 0.2s ease;
}

/* ①：すべての星（label.star）は最初グレー */
.star {
  color: #d1d5db;
  transition: color 0.2s ease;
}

/* ②：クリックでチェックされた radio の「後ろにあるラベル（label.star）」を金色に */
#ratingForm input[type="radio"]:checked ~ label.star {
  color: gold;
}

/* ③：ラベルにマウスをかざしたとき、そのラベルと後ろ（後続）のラベルを金色に */
#ratingForm label.star:hover,
#ratingForm label.star:hover ~ label.star {
  color: gold;
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const trade = @json($trade);
    const currentUserId = @json($currentUserId);
    const modal = document.getElementById('ratingModal');
    const form = document.getElementById('ratingForm');
    const ratedUserIdInput = document.getElementById('rated_user_id');

    const ratedUserId = trade.buyer_id === currentUserId ? trade.seller_id : trade.buyer_id;
    ratedUserIdInput.value = ratedUserId;

    form.action = '{{ route('trades.ratings.store', $trade->id) }}';

    const isBuyer = trade.buyer_id === currentUserId;
    const isSeller = trade.seller_id === currentUserId;
    const buyerHasRated = trade.buyer_rated_at !== null;
    const sellerHasRated = trade.seller_rated_at !== null;
    const tradeCompleted = trade.completed_at !== null;

    let showModal = false;

    if (tradeCompleted) {
        if (isBuyer && !buyerHasRated) {
            showModal = true;
        }
        if (isSeller && !sellerHasRated) {
            showModal = true;
        }
    }

    if (showModal) {
        modal.classList.remove('hidden');
    }

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            // modal.classList.add('hidden'); // 今回は評価必須と想定し閉じない、またはバツボタンを設ける
        }
    });

    @if ($errors->any())
         @php
             $hasRatingErrors = false;
             foreach($errors->getMessages() as $key => $messages) {
                 if ($key === 'score' || $key === 'rated_user_id' || $key === 'rating') {
                     $hasRatingErrors = true;
                     break;
                 }
             }
         @endphp
         @if ($hasRatingErrors)
             modal.classList.remove('hidden');
         @endif
     @endif

    const completeTradeButton = document.getElementById('completeTradeButton');
    if (completeTradeButton) {
        completeTradeButton.addEventListener('click', function(e) {
            e.preventDefault();

            fetch('{{ route('trades.complete', $trade->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                console.log('取引完了:', data);

                modal.classList.remove('hidden');

                completeTradeButton.style.display = 'none';

            })
            .catch(error => {
                console.error('取引完了エラー:', error);
                alert('取引完了処理中にエラーが発生しました。' + (error.message || ''));
            });
        });
    }

    // 星のクリックイベント
    document.querySelectorAll('#ratingForm .star').forEach(label => {
        label.addEventListener('click', function() {
            const starInput = document.getElementById(this.getAttribute('for'));
            starInput.checked = true; // ラジオボタンをチェック
        });
    });

    // 保存キー（tradeごとに分ける）
    const localStorageKey = `trade_message_draft_${trade.id}`;

    // 入力欄の取得
    const messageInput = document.querySelector('input[name="message"]');

    // 初期化：ローカルストレージに保存されていたら復元
    if (messageInput && localStorage.getItem(localStorageKey)) {
        messageInput.value = localStorage.getItem(localStorageKey);
    }

    // 入力内容をリアルタイムで保存
    if (messageInput) {
        messageInput.addEventListener('input', function () {
            localStorage.setItem(localStorageKey, this.value);
        });
    };

    const messageForm = document.getElementById('tradeMessageForm');
    if (messageForm) {
        messageForm.addEventListener('submit', function () {
            localStorage.removeItem(localStorageKey); // 送信後に本文を削除
        });
    }
});

</script>
@endsection
