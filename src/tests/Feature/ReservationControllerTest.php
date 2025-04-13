<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Database\Seeders\DatabaseSeeder;

use App\Models\User;
use App\Models\Shop;
use App\Models\Reservation;
use Mockery;

class ReservationControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_reservation_create_method()
    {
        // テスト用ユーザーと店舗を作成
        $user = User::Find(3);
        $shop = Shop::Find(1);

        // Stripe セッションのモック
        $mockSession = (object)[
            'id' => 'cs_test_1234567890',
        ];

        // Stripe::Checkout\Session::create をモック
        $stripeMock = Mockery::mock('alias:\Stripe\Checkout\Session');
        $stripeMock->shouldReceive('create')
            ->once()
            ->andReturn($mockSession);

        // ログインしてリクエスト送信
        $this->actingAs($user);

        $response = $this->post(route('reservation.create', $shop->id), [
            'date' => '2025-04-15',
            'time' => '18:00',
            'number' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('checkout');
        $response->assertViewHas('session');
        $response->assertViewHas('publicKey', env('STRIPE_PUBLIC_KEY'));
    }

    public function test_reservation_delete()
    {
        $user = User::Find(3);
        $this->actingAs($user);

        $reservation = Reservation::Find(1);

        $response = $this->delete(route('reservation.destroy'), ['id' => $reservation->id]);

        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);

        $response->assertRedirect(route('mypage'));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
