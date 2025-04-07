<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $currentUrl = url()->current();
        $request->session()->put('detailBackUrl', $currentUrl);

        $query = Shop::query();
        $shops = $this->getSearchQuery($request, $query)->get();
        $areas = Area::All();
        $genres = Genre::All();

        return view('index', compact('shops', 'areas', 'genres'));
    }

    private function getSearchQuery($request, $query)
    {
        if (!empty($request->keyword)) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }
        if (!empty($request->area)) {
            $query->where('area_id', '=', $request->area);
        }
        if (!empty($request->genre)) {
            $query->where('genre_id', '=', $request->genre);
        }

        return $query;
    }

    public function thanks()
    {
        return view('auth.thanks');
    }
}
