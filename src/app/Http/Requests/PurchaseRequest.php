<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
        'payment_method' => ['required', 'in:card,convenience'],
        'address_id' => ['required', 'exists:addresses,id'],
    ];
}

public function messages(): array
{
    return [
        'payment_method.required' => '支払い方法を選択してください',
        'payment_method.in' => '正しい支払い方法を選択してください',

        'address_id.required' => '配送先を選択してください',
        'address_id.exists' => '正しい配送先を選択してください',
    ];
}
}
