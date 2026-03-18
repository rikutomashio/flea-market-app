<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $addresses = [
    [
        'user_id' => 1,
        'postal_code' => '100-0001',
        'prefecture' => '東京都',
        'city' => '千代田区',
        'street' => '1-1-1',
        'building' => 'テストビル101',
        'is_default' => true,
    ],
    [
        'user_id' => 2,
        'postal_code' => '150-0001',
        'prefecture' => '東京都',
        'city' => '渋谷区',
        'street' => '1-1-1',
        'building' => 'サンプルマンション202',
        'is_default' => true,
    ],
];

        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}
