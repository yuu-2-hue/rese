<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Database\Seeders\DatabaseSeeder;

use App\Models\User;

class MenuControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    // 利用者のメニュー画面表示
    public function test_user_menu_display()
    {
        $user = User::Find(3);

        $response = $this->withSession(['_previous' => ['url' => '/home']])
            ->actingAs($user)
            ->get('/menu');

        $response->assertViewIs('menu.menu-user');
        $response->assertSessionHas('menuBackUrl', '/home');
    }

    // 代表者のメニュー画面表示
    public function test_representative_menu_display()
    {
        $user = User::Find(2);

        $response = $this->withSession(['_previous' => ['url' => '/dashboard']])
            ->actingAs($user)
            ->get('/menu');

        $response->assertViewIs('menu.menu-representative');
        $response->assertSessionHas('menuBackUrl', '/dashboard');
    }

    // 管理者のメニュー画面表示
    public function test_admin_menu_display()
    {
        $user = User::Find(1);

        $response = $this->withSession(['_previous' => ['url' => '/admin']])
            ->actingAs($user)
            ->get('/menu');

        $response->assertViewIs('menu.menu-admin');
        $response->assertSessionHas('menuBackUrl', '/admin');
    }

    // 未ログイン時のメニュー画面表示
    public function test_uncertified_menu_display()
    {
        $response = $this->withSession(['_previous' => ['url' => '/top']])
            ->get('/menu');

        $response->assertViewIs('menu.menu-logout');
        $response->assertSessionHas('menuBackUrl', '/top');
    }

    // 1つ前の画面に戻るテスト
    public function test_back_method()
    {
        $url = '/';
        session(['menuBackUrl' => $url]);

        $response = $this->get('/menu/back');

        $response->assertRedirect($url);
    }

}
