<?php

namespace App\Http\Controllers;

class ThanksController extends Controller
{
    // 会員登録完了画面
    public function thanks()
    {
        return view('auth.thanks');
    }
}
