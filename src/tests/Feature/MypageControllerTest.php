<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Support\Facades\Auth;
use Database\Seeders\DatabaseSeeder;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;

class MypageControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    // マイページ画面
    public function test_mypage_method()
    {
        $user = User::Find(3);
        $this->actingAs($user);

        $query = Shop::query();
        $query->whereIn('id', function ($query) {
            $query->from('favorites')->select('shop_id')->where('user_id', Auth::id());
        });
        $favoriteShops = $query->get();

        $reservations = Reservation::where('user_id', Auth::id())->get();

        $response = $this->get('/mypage');

        $response->assertViewIs('mypage');

        $this->assertEquals(
            $favoriteShops->map->getAttributes()->all(),
            $response->viewData('favoriteShops')->map->getAttributes()->all()
        );

        $this->assertEquals(
            $reservations->map->getAttributes()->all(),
            $response->viewData('reservations')->map->getAttributes()->all()
        );

        $response->assertSessionHas('detailBackUrl', url('/mypage'));
    }

    // 予約の更新機能
    public function test_mypage_update_method()
    {
        $user = User::Find(3);
        $this->actingAs($user);

        Reservation::Find(1)->update([
            'date' => '2025-05-01',
            'time' => '14:00:00',
            'number' => 4,
        ]);

        $this->assertDatabaseHas('reservations', [
            'id' => 1,
            'date' => '2025-05-01',
            'time' => '14:00:00',
            'number' => 4,
        ]);
    }

    // qrコードの作成機能
    public function test_qr_method()
    {
        $user = User::Find(3);
        $this->actingAs($user);

        $response = $this->get("/mypage/1/qr");

        $response->assertViewIs('qr');
        $response->assertViewHas('qrCode');
    }
}
