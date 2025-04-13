<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Database\Seeders\DatabaseSeeder;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;

class DetailControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    // 店舗詳細画面表示テスト
    public function test_detail_method()
    {
        $user = User::find(3);
        $this->actingAs($user);

        $shop = Shop::find(1);
        $reservations = Reservation::where(['shop_id' => 1, 'user_id' => 3])->get();
        $reviews = Review::where('shop_id', 1)->get();

        $response = $this->get('/detail/1');

        $response->assertStatus(200);
        $response->assertViewHas('shop', fn($s) => $s->id === $shop->id);

        $this->assertEquals(
            $reservations->map->getAttributes()->all(),
            $response->viewData('reservations')->map->getAttributes()->all()
        );

        $this->assertEquals(
            $reviews->map->getAttributes()->all(),
            $response->viewData('reviews')->map->getAttributes()->all()
        );
    }

    // レビュー機能のテスト
    public function test_review_method()
    {
        $user = User::find(3);

        $this->actingAs($user);

        $response = $this->post(route('review'), [
            'id' => 1,
            'review0' => 'on',
            'comment' => 'テストコメント',
        ]);

        $response->assertRedirect(route('detail', 1));

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'shop_id' => 1,
            'evaluation' => 5,
            'comment' => 'テストコメント',
        ]);
    }

    // 1つ前の画面に戻るテスト
    public function test_back_method()
    {
        $url = '/detail/1';
        session(['detailBackUrl' => $url]);

        $response = $this->get('/detail/1/back');

        $response->assertRedirect($url);
    }

}
