<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use Database\Seeders\DatabaseSeeder;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class ShopControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    // 店舗一覧
    public function test_get_shop()
    {
        $shops = Shop::with('area')->with('genre')->get();
        $areas = Area::All();
        $genres = Genre::All();

        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertEquals(
            $shops->map->getAttributes()->all(),
            $response->viewData('shops')->map->getAttributes()->all()
        );

        $this->assertEquals(
            $areas->map->getAttributes()->all(),
            $response->viewData('areas')->map->getAttributes()->all()
        );

        $this->assertEquals(
            $genres->map->getAttributes()->all(),
            $response->viewData('genres')->map->getAttributes()->all()
        );
    }

    // 店名検索
    public function test_get_search_shop_name()
    {
        $response = $this->get('/?keyword=仙人');
        $expected_data = [
            'area_id' => 1,
            'genre_id' => 1,
            'name' => '仙人',
            'overview' => '料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。',
            'image' => 'image/sushi.jpg',
        ];

        $response->assertStatus(200);
        $response->assertViewHas('shops', function ($shops) use ($expected_data) {
            return $shops[0]->area_id === $expected_data['area_id']
                && $shops[0]->genre_id === $expected_data['genre_id']
                && $shops[0]->name === $expected_data['name']
                && $shops[0]->overview === $expected_data['overview']
                && $shops[0]->image === $expected_data['image'];
        });
    }

    // 地域検索
    public function test_get_search_shop_area()
    {
        $response = $this->get('/?area=1');
        $expected_data = [
            'area_id' => 1,
            'genre_id' => 1,
            'name' => '仙人',
            'overview' => '料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。',
            'image' => 'image/sushi.jpg',
        ];

        $response->assertStatus(200);
        $response->assertViewHas('shops', function ($shops) use ($expected_data) {
            return $shops[0]->area_id === $expected_data['area_id']
            && $shops[0]->genre_id === $expected_data['genre_id']
            && $shops[0]->name === $expected_data['name']
            && $shops[0]->overview === $expected_data['overview']
            && $shops[0]->image === $expected_data['image'];
        });
    }

    // ジャンル検索
    public function test_get_search_shop_genre()
    {
        $response = $this->get('/?genre=1');
        $expected_data = [
            'area_id' => 1,
            'genre_id' => 1,
            'name' => '仙人',
            'overview' => '料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。',
            'image' => 'image/sushi.jpg',
        ];

        $response->assertStatus(200);
        $response->assertViewHas('shops', function ($shops) use ($expected_data) {
            return $shops[0]->area_id === $expected_data['area_id']
            && $shops[0]->genre_id === $expected_data['genre_id']
            && $shops[0]->name === $expected_data['name']
            && $shops[0]->overview === $expected_data['overview']
            && $shops[0]->image === $expected_data['image'];
        });
    }
}
