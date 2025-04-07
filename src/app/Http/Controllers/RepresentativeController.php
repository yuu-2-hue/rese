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
    public function representative()
    {
        $shops = Shop::All();
        $areas = Area::All();
        $genres = Genre::All();
        $reservations = Reservation::All();

        $users = User::where('name', '山本')->get();
        foreach($users as $user)
        {
            $name = $user->name;
        }

        return view('representative.index', compact('name', 'shops', 'areas', 'genres', 'reservations'));
    }

    public function store()
    {
        $areas = Area::All();
        $genres = Genre::All();

        return view('representative.store', compact('areas', 'genres'));
    }

    public function create(RepresentativeRequest $request)
    {
        $file_name = $request->file('image')->getClientOriginalName();
        $imagePath = $request->file('image')->storeAs('/image', $file_name,'s3');
        Storage::disk('s3')->setVisibility($imagePath, 'private');

        Shop::create([
            'area_id' => $request->area,
            'genre_id' => $request->genre,
            'name' => $request->name,
            'overview' => $request->overview,
            'image' => $imagePath,
            'email' => Auth::User()->email,
        ]);

        return redirect()->route('representative');
    }

    public function update(RepresentativeRequest $request)
    {
        $file_name = $request->file('image')->getClientOriginalName();
        $imagePath = $request->file('image')->storeAs('/image', $file_name, 's3');
        Storage::disk('s3')->setVisibility($imagePath, 'private');

        Shop::Find($request->id)->update([
            'area_id' => $request->area,
            'genre_id' => $request->genre,
            'name' => $request->name,
            'overview' => $request->overview,
            'image' => $imagePath,
            'email' => Auth::User()->email,
        ]);

        return redirect()->route('representative');
    }

    public function send(Request $request)
    {
        $users = User::All();
        $shop = Shop::Find($request->id);

        $subject = $request->subject;
        $sender = $shop->email;
        $mainText = $request->text;

        foreach ($users as $user) {
            Mail::send(new NoticeMail($subject, $sender, $user->email, $mainText));
        }

        return redirect()->route('representative');
    }
}
