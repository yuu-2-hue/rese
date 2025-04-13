<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    // お気に入り機能
    public function create($shop_id)
    {
        if(Auth::check()) {
            Favorite::Create([
                'user_id' => Auth::id(),
                'shop_id' => $shop_id,
            ]);
        }

        return back();
    }

    // お気に入り解除機能
    public function destroy($shop_id)
    {
        if (Auth::check()) {
            Favorite::where(['user_id' => Auth::id(), 'shop_id' => $shop_id])->delete();
        }

        return back();
    }
}
