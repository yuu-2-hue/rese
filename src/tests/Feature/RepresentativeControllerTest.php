<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use App\Mail\NoticeMail;

use Database\Seeders\DatabaseSeeder;

use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;

class RepresentativeControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_representative_method()
    {
        $user = User::Find(2);
        $this->actingAs($user);

        $name = $user->name;
        $shops = Shop::All();
        $areas = Area::All();
        $genres = Genre::All();
        $reservations = Reservation::All();

        $response = $this->get('/representative');

        $response->assertViewIs('representative.index');

        $this->assertEquals($name, '山本');

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

        $this->assertEquals(
            $reservations->map->getAttributes()->all(),
            $response->viewData('reservations')->map->getAttributes()->all()
        );
    }

    public function test_representative_store_method()
    {
        $user = User::Find(2);
        $this->actingAs($user);

        $areas = Area::All();
        $genres = Genre::All();

        $response = $this->get('/representative/store');
        $response->assertViewIs('representative.store');

        $this->assertEquals(
            $areas->map->getAttributes()->all(),
            $response->viewData('areas')->map->getAttributes()->all()
        );

        $this->assertEquals(
            $genres->map->getAttributes()->all(),
            $response->viewData('genres')->map->getAttributes()->all()
        );
    }

    public function test_representative_create_method()
    {
        // Storageをfake（S3の代わり）
        Storage::fake('s3');

        // 代表者ユーザー
        $user = User::Find(2);
        $this->actingAs($user);

        // 画像ファイルを作成
        $file = UploadedFile::fake()->image('shop.jpg');

        // データ送信
        $response = $this->post(route('representative.create'), [
            'area' => 1,
            'genre' => 1,
            'name' => 'テストショップ',
            'overview' => 'これはテストのお店です',
            'image' => $file,
        ]);

        // 画像が保存されたか
        Storage::disk('s3')->assertExists('image/' . $file->getClientOriginalName());

        // DBに保存されてるか
        $this->assertDatabaseHas('shops', [
            'name' => 'テストショップ',
            'email' => $user->email,
        ]);

        // リダイレクト確認
        $response->assertRedirect(route('representative'));
    }

    public function test_representative_update_method()
    {
        Storage::fake('s3');

        $user = User::Find(2);
        $this->actingAs($user);

        $shop = Shop::Find(1);

        $file = UploadedFile::fake()->image('updated_shop.jpg');

        $response = $this->post(route('representative.update', ['id' => $shop->id]), [
            'id' => $shop->id,
            'area' => 1,
            'genre' => 1,
            'name' => '更新ショップ名',
            'overview' => '更新された概要です',
            'image' => $file,
        ]);

        // 画像が保存されていること
        Storage::disk('s3')->assertExists('image/' . $file->getClientOriginalName());

        // データベースが更新されたこと
        $this->assertDatabaseHas('shops', [
            'id' => $shop->id,
            'name' => '更新ショップ名',
            'overview' => '更新された概要です',
            'image' => 'image/' . $file->getClientOriginalName(),
            'email' => $user->email,
        ]);

        // リダイレクト確認
        $response->assertRedirect(route('representative'));
    }

    public function test_representative_send_method()
    {
        Mail::fake();

        // テストユーザーと代表者の作成（ここは状況に応じて変えてOK）
        $users = User::All();
        $repUser = User::Find(2);
        $shop = Shop::Find(1);

        $this->actingAs($repUser);

        $response = $this->post(route('representative.send'), [
            'id' => $shop->id,
            'subject' => 'お知らせテスト',
            'text' => 'これは通知の本文です',
        ]);

        // 検証（全員に送られているか）
        Mail::assertSent(NoticeMail::class, 3);

        foreach ($users as $user) {
            Mail::assertSent(NoticeMail::class, function ($mail) use ($user, $repUser) {
                $mail->build();
                return $mail->hasTo($user->email);
            });
        }

        $response->assertRedirect(route('representative'));
    }
}
