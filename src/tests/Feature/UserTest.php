<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;

use App\Models\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    //会員情報登録
    public function test_register_user()
    {
        $response = $this->post('/register', [
            'name' => "テストユーザ",
            'email' => "test@gmail.com",
            'password' => "password",
            'password_confirmation' => "password",
        ]);

        $response->assertRedirect('/thanks');
        $this->assertDatabaseHas(User::class, [
            'name' => "テストユーザ",
            'email' => "test@gmail.com",
        ]);
    }

    //ログイン機能
    public function test_login_user()
    {
        // Arrange: 必ず存在するユーザーをテスト中に作る
        $user = User::Find(3);

        // Act: ログイン処理を実行
        $response = $this->post('/login', [
            'email' => "nakagawa@example.com",
            'password' => "nakagawa", // 平文でOK
        ]);

        // Assert: 成功してるか？
        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    //ログアウト機能
    public function test_logout_user()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    // 会員登録ありがとう画面
    public function test_thanks_method()
    {
        $user = User::Find(3);
        $this->actingAs($user);

        $response = $this->get('/thanks');
        $response->assertStatus(200);
        $response->assertViewIs('auth.thanks');
    }
}
