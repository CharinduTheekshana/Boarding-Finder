<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boarding;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoardingModerationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $query = Boarding::query()->with(['owner', 'images', 'reviews'])->latest();

        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('approved_status', $status);
        }

        $boardings = $query->paginate(15)->withQueryString();

        return view('admin.boardings.index', compact('boardings', 'status'));
    }

    public function approve(Boarding $boarding): RedirectResponse
    {
        $boarding->update(['approved_status' => 'approved']);

        return back()->with('status', 'Listing approved.');
    }

    public function reject(Boarding $boarding): RedirectResponse
    {
        $boarding->update(['approved_status' => 'rejected']);

        return back()->with('status', 'Listing rejected.');
    }
}
