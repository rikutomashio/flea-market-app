<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'テストユーザー1',
        'email' => 'test1@example.com',
        'password' => Hash::make('password'),
    ]);

    User::create([
        'name' => 'テストユーザー2',
        'email' => 'test2@example.com',
        'password' => Hash::make('password'),
    ]);
    }
}
