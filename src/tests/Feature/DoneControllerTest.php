<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Database\Seeders\DatabaseSeeder;

use App\Models\User;

class DoneControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_done_method()
    {
        $user = User::find(3);
        $this->actingAs($user);

        // 1. テスト用の予約データを用意
        $reservationData = [
            'user_id' => 3,
            'shop_id' => 1,
            'date' => '2025-04-15',
            'time' => '10:00:00',
            'number' => 2,
        ];

        // 2. セッションにデータを設定して、doneメソッドにアクセス
        $response = $this->withSession(['reservation' => $reservationData])->get('/done'); // ルートが POST /done の場合

        // 3. データベースに保存されていることを確認
        $this->assertDatabaseHas('reservations', [
            'user_id' => 3,
            'shop_id' => 1,
            'date' => '2025-04-15',
            'time' => '10:00:00',
            'number' => 2,
        ]);

        // 4. 正しいビューが返ることを確認
        $response->assertViewIs('done');
        $response->assertStatus(200);
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
