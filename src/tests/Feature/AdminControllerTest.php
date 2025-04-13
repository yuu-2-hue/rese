<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Support\Facades\Hash;
use Database\Seeders\DatabaseSeeder;

use App\Models\User;

class AdminControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $user = User::Find(1);
        $this->actingAs($user);
    }

    // 管理者画面
    public function test_admin_method()
    {
        $representatives = User::where('authority', '代表者')->get();

        $response = $this->get('/admin');
        $response->assertStatus(200);
        $response->assertViewIs('admin.index');

        $this->assertEquals(
            $representatives->map->getAttributes()->all(),
            $response->viewData('representatives')->map->getAttributes()->all()
        );
    }

    // 代表者登録画面
    public function test_admin_store_method()
    {
        $response = $this->get('/admin/store');
        $response->assertStatus(200);
        $response->assertViewIs('admin.store');
    }

    // 代表者作成機能
    public function test_admin_create_method()
    {
        $formData = [
            'name' => '代表者 太郎',
            'email' => 'rep@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('admin.store'), $formData); // ←ルート名に合わせて修正してね

        $response->assertRedirect(route('admin'));

        $this->assertDatabaseHas('users', [
            'email' => 'rep@example.com',
            'authority' => '代表者',
        ]);

        $user = User::where('email', 'rep@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('password', $user->password));
    }
}
