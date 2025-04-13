<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class DoneController extends Controller
{
    // 予約完了画面
    public function done(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        Reservation::create($reservation);

        return view('done');
    }

    // 1つ前の画面に戻る
    public function back(Request $request)
    {
        $url = $request->session()->get('doneBackUrl');
        return redirect($url);
    }
}
