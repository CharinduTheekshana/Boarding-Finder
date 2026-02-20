<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /** @var User|null $owner */
        $owner = Auth::user();
        abort_unless($owner, 403);

        $boardings = $owner->boardings()->with('reviews')->latest()->paginate(10);

        $stats = [
            'total' => $owner->boardings()->count(),
            'approved' => $owner->boardings()->where('approved_status', 'approved')->count(),
            'pending' => $owner->boardings()->where('approved_status', 'pending')->count(),
            'reviews' => $owner->boardings()->withCount('reviews')->get()->sum('reviews_count'),
        ];

        return view('owner.dashboard', compact('boardings', 'stats'));
    }
}
