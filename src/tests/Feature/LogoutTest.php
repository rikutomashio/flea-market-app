<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_logout()
    {
        // ユーザー作成
        $user = User::factory()->create();

        // ログイン状態にする
        $this->actingAs($user);

        // ログアウト処理
        $response = $this->post('/logout');

        // 未ログイン状態になっていること
        $this->assertGuest();
    }
}
