<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Tests\TestCase;

class RegisterWithEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_sends_email_verification_notification()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        // 登録後に VerifyEmail 通知が送信されていることを確認
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /** @test */
    public function user_redirected_to_email_verification_screen_after_registration()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'verify@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // 登録直後は /email/verify にリダイレクト
        $response->assertRedirect('/email/verify');
    }

    /** @test */
    public function user_can_verify_email_and_redirect_to_profile()
    {
    $user = User::factory()->unverified()->create();

    // メール認証 URL を生成
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    // 認証リンクにアクセス
    $response = $this->actingAs($user)->get($verificationUrl);

    // リダイレクト先を固定値で確認
    $response->assertRedirect('/mypage/profile?verified=1');

    // ユーザーのメール認証が完了していることを確認
    $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
