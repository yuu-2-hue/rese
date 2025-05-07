<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\RepresentativeRequest;

use App\Mail\NoticeMail;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\User;
use App\Models\Reservation;

class RepresentativeController extends Controller
{
    // 代表者画面
    public function representative()
    {
        $name = User::Find(Auth::id())->name;
        $shops = Shop::All();
        $areas = Area::All();
        $genres = Genre::All();
        $reservations = Reservation::All();

        return view('representative.index', compact('name', 'shops', 'areas', 'genres', 'reservations'));
    }

    // 店舗作成画面
    public function store()
    {
        $areas = Area::All();
        $genres = Genre::All();

        return view('representative.store', compact('areas', 'genres'));
    }

    // 店舗作成機能
    public function create(RepresentativeRequest $request)
    {
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/image', $file_name);

        Shop::create([
            'area_id' => $request->area,
            'genre_id' => $request->genre,
            'name' => $request->name,
            'overview' => $request->overview,
            'image' => 'image/' . $file_name,
            'email' => Auth::User()->email,
        ]);

        return redirect()->route('representative');
    }

    // 店舗情報更新機能
    public function update(RepresentativeRequest $request)
    {
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/image', $file_name);

        Shop::Find($request->id)->update([
            'area_id' => $request->area,
            'genre_id' => $request->genre,
            'name' => $request->name,
            'overview' => $request->overview,
            'image' => 'image/' . $file_name,
            'email' => Auth::User()->email,
        ]);

        return redirect()->route('representative');
    }

    // メール送信機能
    public function send(Request $request)
    {
        $users = User::all();
        $shop = Shop::find($request->id);

        $subject = $request->subject;
        $sender = $shop->email;
        $mainText = $request->text;

        foreach ($users as $user) {
            Mail::to($user->email)->send(
                new NoticeMail($subject, $sender, $mainText)
            );
        }

        return redirect()->route('representative');
    }
}
