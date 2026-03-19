<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function プロフィール編集画面に過去の設定値が表示される()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー'
        ]);

        Address::factory()->create([
            'user_id' => $user->id,
            'postal_code' => '123-4567',
            'prefecture' => '東京都',
            'city' => '渋谷区',
            'street' => '神南1-1-1',
            'building' => 'テストビル',
            'is_default' => true
        ]);

        $response = $this->actingAs($user)
            ->get('/mypage/profile');

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('東京都');
        $response->assertSee('渋谷区');
        $response->assertSee('神南1-1-1');
    }

    /** @test */
    public function ユーザーはプロフィール情報を更新できる()
    {
    $user = User::factory()->create([
        'name' => 'テストユーザー'
    ]);

    Address::factory()->create([
        'user_id' => $user->id,
        'postal_code' => '123-4567',
        'prefecture' => '東京都',
        'city' => '渋谷区',
        'street' => '神南1-1-1',
        'building' => 'テストビル',
        'is_default' => true
    ]);

    $response = $this->actingAs($user)->patch('/mypage/profile', [
    'name' => '更新ユーザー',
    'email' => $user->email,
    'postal_code' => '999-9999',
    'prefecture' => '大阪府',
    'city' => '大阪市',
    'street' => '難波1-2-3',
    'building' => '更新ビル'
    ]);

    $response->assertRedirect('/mypage');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => '更新ユーザー'
    ]);

    $this->assertDatabaseHas('addresses', [
        'user_id' => $user->id,
        'postal_code' => '999-9999',
        'prefecture' => '大阪府',
        'city' => '大阪市',
        'street' => '難波1-2-3',
        'building' => '更新ビル'
    ]);
    }
}