<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boarding;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $ownerRoleId = Role::query()->where('name', 'owner')->value('id');

        $owners = User::query()
            ->where('role_id', $ownerRoleId)
            ->withCount('boardings')
            ->latest()
            ->paginate(12);

        $stats = [
            'total_users' => User::query()->where('role_id', $ownerRoleId)->count(),
            'total_listings' => Boarding::query()->count(),
            'total_reviews' => Review::query()->count(),
            'pending_ads' => Boarding::query()->where('approved_status', 'pending')->count(),
        ];

        $pendingBoardings = Boarding::query()
            ->where('approved_status', 'pending')
            ->with(['owner', 'images'])
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact('owners', 'stats', 'pendingBoardings'));
    }
}
