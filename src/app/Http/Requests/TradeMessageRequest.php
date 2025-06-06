<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TradeMessageRequest extends FormRequest
{
    /**
     * 認可処理：購入者または出品者のみ許可
     */
    public function authorize()
    {
        // メッセージの編集・削除時は、メッセージから取引情報を取得
        if ($this->route('message')) {
            $trade = $this->route('message')->trade;
        } else {
            $trade = $this->route('trade');
        }

        return $this->user() && $trade && (
            $this->user()->id === $trade->buyer_id ||
            $this->user()->id === $trade->seller_id
        );
    }

    /**
     * バリデーションルール
     */
    public function rules()
    {
        return [
            'message' => 'required|string|max:400',
            'image'   => 'nullable|mimes:jpeg,png',
        ];
    }

    /**
     * バリデーションメッセージ
     */
    public function messages()
    {
        return [
            'message.required' => '本文を入力してください',
            'message.max'      => '本文は400文字以内で入力してください',
            'image.mimes'      => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
