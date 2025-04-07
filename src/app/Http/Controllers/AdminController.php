<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AdminController extends Controller
{
    public function admin()
    {
        $representatives = User::where('authority', '代表者')->get();

        return view('admin.index', compact('representatives'));
    }

    public function store()
    {
        return view('admin.store');
    }

    public function create(RegisterRequest $request)
    {
        User::create([
            'authority' => '代表者',
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ]);

        return redirect()->route('admin');
    }
}
