<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boarding;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function store(Request $request, Boarding $boarding): RedirectResponse
    {
        $validated = $request->validate([
            'safety' => ['required', 'integer', 'min:1', 'max:5'],
            'cleanliness' => ['required', 'integer', 'min:1', 'max:5'],
            'facilities' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1200'],
        ]);

        Review::query()->updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'boarding_id' => $boarding->id,
            ],
            $validated
        );

        return back()->with('status', 'Your review has been saved.');
    }
}
