<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boarding;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavouriteController extends Controller
{
    public function index(Request $request): View
    {
        $favourites = $request->user()
            ->favouriteBoardings()
            ->with(['images', 'reviews'])
            ->latest('favourites.created_at')
            ->paginate(12);

        return view('favourites.index', compact('favourites'));
    }

    public function store(Request $request, Boarding $boarding): RedirectResponse
    {
        Favourite::query()->firstOrCreate([
            'user_id' => $request->user()->id,
            'boarding_id' => $boarding->id,
        ]);

        return back()->with('status', 'Added to favourites.');
    }

    public function destroy(Request $request, Boarding $boarding): RedirectResponse
    {
        Favourite::query()
            ->where('user_id', $request->user()->id)
            ->where('boarding_id', $boarding->id)
            ->delete();

        return back()->with('status', 'Removed from favourites.');
    }
}
