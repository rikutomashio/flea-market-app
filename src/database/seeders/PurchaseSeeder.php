<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $purchases = [
            [
                'user_id' => 2,
                'product_id' => 1,
                'address_id' => 1,
            ],
            [
                'user_id' => 2,
                'product_id' => 2,
                'address_id' => 1,
            ],
            [
                'user_id' => 1,
                'product_id' => 5,
                'address_id' => 2,
            ],
        ];

        foreach ($purchases as $purchase) {
            Purchase::create($purchase);
        }
    }
}
