<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trade;
use App\Models\Rating;
use Illuminate\Support\Facades\DB; // トランザクション用
use Illuminate\Validation\ValidationException; // バリデーションエラーハンドリング用

class RatingController extends Controller
{
    public function store(Request $request, Trade $trade)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'rated_user_id' => 'required|exists:users,id', // 評価されるユーザーID
        ]);

        $raterId = auth()->id(); // 評価したユーザー（自分）
        $ratedUserId = (int) $request->rated_user_id; // 評価されたユーザー（相手）
        $score = $request->score;

        // 評価対象がこの取引に関わるユーザーか、かつ自分自身ではないかを確認
        $allowedRatedUsers = [$trade->buyer_id, $trade->seller_id];
        if (!in_array($ratedUserId, $allowedRatedUsers) || $raterId === $ratedUserId) {
             throw ValidationException::withMessages([
                 'rating' => '評価対象のユーザーが正しくありません。' // または '自分自身を評価することはできません。'
             ])->redirectTo(route('trade.show', $trade->id)); // エラー時に同じチャット画面に戻す
        }

        // 既に評価済みかチェック
        $existingRating = Rating::where('trade_id', $trade->id)
                                ->where('rater_id', $raterId)
                                ->where('rated_user_id', $ratedUserId)
                                ->first();

        if ($existingRating) {
             throw ValidationException::withMessages([
                 'rating' => 'この取引では既に相手を評価済みです。'
             ])->redirectTo(route('trade.show', $trade->id));
        }

        DB::transaction(function () use ($trade, $raterId, $ratedUserId, $score) {
            // 評価を保存
            Rating::create([
                'trade_id' => $trade->id,
                'rater_id' => $raterId,
                'rated_user_id' => $ratedUserId,
                'score' => $score,
            ]);

            // tradesテーブルの評価日時を更新
            if ($raterId === $trade->buyer_id) {
                $trade->update(['buyer_rated_at' => now()]);
            } elseif ($raterId === $trade->seller_id) {
                $trade->update(['seller_rated_at' => now()]);
            }

             // TODO: 必要に応じて、両者からの評価が完了したら取引ステータスを最終的な「完了」にするなどのロジックを追加
             // if ($trade->refresh()->buyer_rated_at && $trade->seller_rated_at) {
             //     $trade->update(['status' => 'closed']); // 例: 'closed' ステータスを追加
             // }
        });

        // 評価成功後のリダイレクト
        // 購入者の評価完了後、商品一覧へリダイレクト
        if ($raterId === $trade->buyer_id) {
             return redirect()->route('product.index')->with('success', '取引相手を評価しました！');
        }

        // 出品者の評価完了後、同じチャット画面にリダイレクト
        return back()->with('success', '取引相手を評価しました！');
    }
}
