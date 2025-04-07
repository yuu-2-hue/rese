<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
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

    public function destroy($shop_id)
    {
        if (Auth::check()) {
            Favorite::where(['user_id' => Auth::id(), 'shop_id' => $shop_id])->delete();
        }

        return back();
    }
}
