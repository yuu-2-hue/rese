<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\ReviewRequest;

use App\Models\Shop;
use App\Models\Review;
use App\Models\Reservation;

class DetailController extends Controller
{
    // 店舗詳細画面
    public function detail(Request $request, $shop_id)
    {
        $shop = Shop::Find($shop_id);
        $reservations = Reservation::where(['shop_id'=>$shop_id, 'user_id'=>Auth::id()])->get();
        $reviews = Review::where('shop_id', $shop_id)->get();

        $currentUrl = url()->current();
        $request->session()->put('doneBackUrl', $currentUrl);

        return view('detail', compact('shop', 'reservations', 'reviews'));
    }

    // 評価機能
    public function review(ReviewRequest $request)
    {
        $evaluationMaxCount = 5;
        $evaluationCount = 0;
        for($i = 0; $i < 5; $i++)
        {
            if($request->input("review{$i}") == 'on') $evaluationCount = $evaluationMaxCount-$i;
        }

        Review::Create([
            'user_id' => Auth::id(),
            'shop_id' => $request->id,
            'evaluation'=> $evaluationCount,
            'comment' => $request->comment,
        ]);

        return redirect()->route('detail', $request->id);
    }

    // 1つ前の画面に戻る
    public function back(Request $request)
    {
        $url = $request->session()->get('detailBackUrl');
        return redirect($url);
    }
}
