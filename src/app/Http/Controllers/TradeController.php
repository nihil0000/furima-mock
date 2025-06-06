<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Trade;
use App\Models\Order;
use Illuminate\Support\Facades\DB; // トランザクション用
use Illuminate\Support\Facades\Mail; // メール送信のためuse
use App\Mail\TradeCompletedMail; // 作成したMailableをuse

class TradeController extends Controller
{
    // 取引チャット開始
    public function start(Product $product)
    {
        $buyer = auth()->user();
        $seller = $product->user;

        // 既存の取引があれば再利用
        $trade = Trade::where('product_id', $product->id)
            ->where('buyer_id', $buyer->id)
            ->first();

        if (!$trade) {
            $trade = Trade::create([
                'product_id' => $product->id,
                'buyer_id' => $buyer->id,
                'seller_id' => $seller->id,
                'status' => 'trading',
            ]);
        }

        return redirect()->route('trade.show', $trade->id);
    }

    // チャット画面表示
    public function show(Trade $trade)
    {
        $this->authorize('view', $trade);

        $currentUserId = auth()->id();

        // サイドバー用：自分が関わる全取引
        $sidebarTrades = Trade::where('buyer_id', $currentUserId)
            ->orWhere('seller_id', $currentUserId)
            ->with('product')
            ->orderBy('updated_at', 'desc')
            ->get();

        // 未読メッセージを既読化
        $trade->tradeMessages()
            ->where('is_read', false)
            ->where('user_id', '!=', $currentUserId)
            ->update(['is_read' => true]);

        $messages = $trade->tradeMessages()->with('user')->orderBy('created_at')->get();

        return view('trade.show', compact('trade', 'messages', 'currentUserId', 'sidebarTrades'));
    }

    // マイページ用：自分が関わる取引一覧
    public function index()
    {
        $user = auth()->user();
        $trades = Trade::where('buyer_id', $user->id)
            ->orWhere('seller_id', $user->id)
            ->with('product')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('trade.index', compact('trades'));
    }

    // 取引を完了済みに更新するメソッド
    public function complete(Trade $trade)
    {
        // ポリシーで「購入者」のみ更新を許可していることを確認 (TradePolicy@update)
        $this->authorize('update', $trade);

        // 取引がまだ完了済みでない場合のみ更新
        if ($trade->completed_at === null) {
            $trade->update(['completed_at' => now(), 'status' => 'completed']);

            // 出品者にメール通知を送信
            try {
                Mail::to($trade->seller)->send(new TradeCompletedMail($trade));
            } catch (\Exception $e) {
                // エラーログ出力など、必要に応じてエラーハンドリング
                logger()->error('取引完了メール送信エラー:', ['trade_id' => $trade->id, 'error' => $e->getMessage()]);
                // ユーザーへのエラー通知は行わず、メール送信失敗をバックエンドで処理
            }
        }

        // 取引完了後、同じチャット画面にリダイレクト（モーダルはJSで表示制御）
        return response()->json(['message' => '取引を完了しました', 'trade_id' => $trade->id, 'trade_completed' => true]);
    }
}
