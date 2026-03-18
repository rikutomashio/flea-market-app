<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
{
    return true;
}

public function rules()
{
    return [
        'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
        'prefecture' => ['required', 'string'],
        'city' => ['required', 'string'],
        'street' => ['required', 'string'],
        'building' => ['nullable', 'string'],
        'product_id' => ['required', 'exists:products,id'], // ←追加
    ];
}

public function messages(): array
{
    return [
        'postal_code.required' => '郵便番号を入力してください',
        'postal_code.regex' => '郵便番号は「123-4567」の形式で入力してください',

        'prefecture.required' => '都道府県を入力してください',
        'city.required' => '市区町村を入力してください',
        'street.required' => '番地を入力してください',
    ];
}
}
