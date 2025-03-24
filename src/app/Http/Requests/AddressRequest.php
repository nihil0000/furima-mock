<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'name' => 'required',
            'image' => 'mimes:png,jpeg',
            'postal_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
            'building' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user.required' => 'ユーザ名を入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号をハイフンありの8文字で入力してください',
            'address.required' => '配送先住所を選択してください',
            'building.required' => '建物名を入力してください',
        ];
    }
}
