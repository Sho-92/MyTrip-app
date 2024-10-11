<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // 共通のユーザーを作成
        $this->user = User::factory()->create([
            'password' => bcrypt('password'), // パスワードを設定
        ]);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        // ログインリクエストを送信
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password', // 正しいパスワードを使用
        ]);

        // 認証されていることを確認
        $this->assertAuthenticated();
        $response->assertRedirect(route('home', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        // 無効なパスワードでログインリクエストを送信
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        // 認証されていないことを確認
        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        // ユーザーをアクティブにしてログアウトリクエストを送信
        $response = $this->actingAs($this->user)->post('/logout');

        // 認証されていないことを確認
        $this->assertGuest();
        $response->assertRedirect('/login');
    }
}