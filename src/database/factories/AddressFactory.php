<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'postal_code' => '123-4567',
            'prefecture' => '東京都',
            'city' => '新宿区',
            'street' => '西新宿1-1-1',
            'building' => 'テストビル101',
            'is_default' => true,
        ];
    }
}