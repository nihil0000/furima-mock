<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => 'required',
            'description' => 'required|max:255',
            'image' => 'required|mimes:png,jpeg',
            'category' => 'required|array',
            'status' => 'required',
            'price' => 'required|numeric|min:0',
            'brand_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明を255文字以内で入力してください',
            'image.required' => '商品画像をアップロードしてください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'category.required' => '商品カテゴリーを選択してください',
            'status.required' => '商品状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.numeric' => '商品価格を数値で入力してください',
            'price.min' => '商品価格を0円以上で入力してください',
            'brand_name.required' => 'ブランド名を入力してください',
        ];
    }
}
