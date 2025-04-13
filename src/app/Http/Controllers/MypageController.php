<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Http\Requests\ReservationRequest;

use App\Models\Shop;
use App\Models\Reservation;

class MypageController extends Controller
{
    // マイページ
    public function mypage(Request $request)
    {
        $currentUrl = url()->current();
        $request->session()->put('detailBackUrl', $currentUrl);

        $query = Shop::query();
        $query->whereIn('id', function ($query) {
            $query->from('favorites')->select('shop_id')->where('user_id', Auth::id());
        });
        $favoriteShops = $query->get();

        $reservations = Reservation::where('user_id', Auth::id())->get();

        return view('mypage', compact('favoriteShops', 'reservations'));
    }

    // 予約情報更新機能
    public function update(ReservationRequest $request)
    {
        Reservation::Find($request->id)->update([
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);

        return back();
    }

    // qrコード作成機能
    public function qr($id)
    {
        $reservation = Reservation::findOrFail($id);
        $qrCode = QrCode::size(200)->generate($reservation);
        return view('qr', compact('qrCode'));
    }
}
