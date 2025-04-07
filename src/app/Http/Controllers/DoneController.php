<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class DoneController extends Controller
{
    public function done(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        Reservation::create($reservation);

        return view('done');
    }

    public function back(Request $request)
    {
        $url = $request->session()->get('doneBackUrl');
        return redirect($url);
    }
}
