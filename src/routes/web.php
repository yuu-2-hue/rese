<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\DoneController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ThanksController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('verified')->group(function () {
    Route::post('/favorite/{shop_id}', [FavoriteController::class, 'create']);
    Route::post('/unfavorite/{shop_id}', [FavoriteController::class, 'destroy']);

    Route::get('/thanks', [ThanksController::class, 'thanks'])->name('thanks');

    Route::get('/done', [DoneController::class, 'done'])->name('done');
    Route::get('/done/back', [DoneController::class, 'back']);

    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/{id}/qr', [MypageController::class, 'qr'])->name('qr');
    Route::patch('/mypage/update', [MypageController::class, 'update']);

    Route::post('/detail/reservation/{shop_id}', [ReservationController::class, 'create'])->name('reservation.create');
    Route::delete('/mypage/reservation/delete', [ReservationController::class, 'destroy'])->name('reservation.destroy');

    Route::get('/representative', [RepresentativeController::class, 'representative'])->name('representative');
    Route::get('/representative/store', [RepresentativeController::class, 'store'])->name('representative.store');
    Route::post('/representative/store/create', [RepresentativeController::class, 'create'])->name('representative.create');
    Route::post('/representative/update', [RepresentativeController::class, 'update'])->name('representative.update');
    Route::post('/representative/send', [RepresentativeController::class, 'send'])->name('representative.send');

    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
    Route::get('/admin/store', [AdminController::class, 'store'])->name('admin.store');
    Route::post('admin/store', [AdminController::class, 'create']);
});

Route::get('/', [ShopController::class, 'index'])->name('index');

Route::get('/detail/{shop_id}', [DetailController::class, 'detail'])->name('detail');
Route::post('/detail/review', [DetailController::class, 'review'])->name('review');
Route::get('/detail/{shop_id}/back', [DetailController::class, 'back'])->name('back');

Route::get('/menu', [MenuController::class, 'menu'])->name('menu');
Route::get('/menu/back', [MenuController::class, 'back']);




