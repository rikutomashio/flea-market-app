<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
            ],

            // 住所
            'postal_code' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'prefecture'  => ['required', 'string', 'max:50'],
            'city'        => ['required', 'string', 'max:100'],
            'street'      => ['required', 'string', 'max:255'],
            'building'    => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attributeは必須です。',
            'email'    => ':attributeの形式が正しくありません。',
            'max'      => ':attributeは:max文字以内で入力してください。',
            'image'    => ':attributeは画像ファイルを選択してください。',
            'mimes'    => ':attributeはjpeg, png形式でアップロードしてください。',
            'unique'   => 'この:attributeはすでに使用されています。',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'          => 'ユーザー名',
            'email'         => 'メールアドレス',
            'profile_image' => 'プロフィール画像',
            'postal_code'   => '郵便番号',
            'prefecture'    => '都道府県',
            'city'          => '市区町村',
            'street'        => '番地',
            'building'      => '建物名',
        ];
    }
}