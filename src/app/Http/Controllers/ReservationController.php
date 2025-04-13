<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Models\Shop;

class ReservationController extends Controller
{
    // 予約と決済
    public function create(ReservationRequest $request, $shop_id)
    {
        $reservation = [
            'user_id' => Auth::id(),
            'shop_id' => $shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number
        ];
        $request->session()->put('reservation', $reservation);

        $url = url()->previous();
        $request->session()->put('url', $url);

        $payment = 'card';

        $shop = Shop::Find($shop_id);
        $line_item = [
            'price_data' => [
                'currency' => 'jpy',
                'unit_amount' => 1000,
                'product_data' => [
                    'name' => $shop->name,
                    'description' => $shop->overview,
                ],
            ],
            'quantity'    => 1,
        ];

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => [$payment],
            'line_items'           => [$line_item],
            'success_url'          => route('done'),
            'cancel_url'           => route('detail', $shop_id),
            'mode'                 => 'payment',
        ]);

        return view('checkout', ['session' => $session, 'publicKey' => env('STRIPE_PUBLIC_KEY')]);
    }

    // 予約削除機能
    public function destroy(Request $request)
    {
        Reservation::Find($request->id)->delete();

        return redirect()->route('mypage');
    }
}
