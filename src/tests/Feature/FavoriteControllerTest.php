<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Database\Seeders\DatabaseSeeder;

use App\Models\User;
use App\Models\Favorite;

class FavoriteControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_favorite_create_method()
    {
        $user = User::Find(3);

        $response = $this->actingAs($user)->post("/favorite/1");

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'shop_id' => 1,
        ]);

        $response->assertRedirect();
    }

    public function test_favorite_destroy_method()
    {
        $user = User::Find(3);
        $this->actingAs($user);

        Favorite::create([
            'user_id' => $user->id,
            'shop_id' => 1,
        ]);

        $response = $this->post("/favorite/1");
        Favorite::where(['user_id' => $user->id, 'shop_id' => 1])->delete();

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'shop_id' => 1,
        ]);

        $response->assertRedirect();
    }

    public function test_favorite_uncertified()
    {
        $response = $this->post("/favorite/1");

        $this->assertDatabaseMissing('favorites', [
            'shop_id' => 1,
        ]);

        $response->assertRedirect();
    }
}
