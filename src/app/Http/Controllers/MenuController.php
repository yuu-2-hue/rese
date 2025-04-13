<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // メニュー画面
    public function menu(Request $request)
    {
        $previousUrl = url()->previous();
        $request->session()->put('menuBackUrl', $previousUrl);

        $view = 'menu.menu-user';
        if(Auth::check() && Auth::user()->authority == '利用者') $view = 'menu.menu-user';
        else if(Auth::check() && Auth::user()->authority == '代表者') $view = 'menu.menu-representative';
        else if (Auth::check() && Auth::user()->authority == '管理者') $view = 'menu.menu-admin';
        else $view = 'menu.menu-logout';

        return view($view);
    }

    // 1つ前の画面に戻る
    public function back(Request $request)
    {
        $url = $request->session()->get('menuBackUrl');
        return redirect($url);
    }
}
