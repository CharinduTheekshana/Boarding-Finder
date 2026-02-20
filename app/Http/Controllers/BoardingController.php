<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boarding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BoardingController extends Controller
{
    public function index(Request $request): View
    {
        $query = Boarding::query()->approved()->with(['images', 'reviews']);

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search): void {
                $builder
                    ->where('city', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $filters = [
            'city' => $request->string('city')->toString(),
            'district' => $request->string('district')->toString(),
            'price_min' => $request->input('price_min'),
            'price_max' => $request->input('price_max'),
            'boarding_type' => $request->string('boarding_type')->toString(),
            'listed_for' => $request->string('listed_for')->toString(),
            'furnishing_status' => $request->string('furnishing_status')->toString(),
        ];

        foreach (['city', 'district', 'boarding_type', 'listed_for', 'furnishing_status'] as $field) {
            if (! empty($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        if (is_numeric($filters['price_min'])) {
            $query->where('price', '>=', (float) $filters['price_min']);
        }

        if (is_numeric($filters['price_max'])) {
            $query->where('price', '<=', (float) $filters['price_max']);
        }

        $boardings = $query->latest()->paginate(12)->withQueryString();

        $cities = Boarding::query()->approved()->select('city')->distinct()->orderBy('city')->pluck('city');
        $districts = Boarding::query()->approved()->whereNotNull('district')->select('district')->distinct()->orderBy('district')->pluck('district');

        return view('ads.index', compact('boardings', 'filters', 'cities', 'districts'));
    }

    public function show(Boarding $boarding): View
    {
        /** @var User|null $user */
        $user = Auth::user();
        $canPreviewUnapproved = $user && ($user->id === $boarding->user_id || $user->hasRole('admin'));

        if ($boarding->approved_status !== 'approved' && ! $canPreviewUnapproved) {
            abort(404);
        }

        $boarding->load(['images', 'owner.role', 'reviews.user']);

        $distanceFromUniversity = null;
        $universityLat = (float) config('boarding.university_lat');
        $universityLng = (float) config('boarding.university_lng');

        if ($boarding->latitude && $boarding->longitude && $universityLat && $universityLng) {
            $distanceFromUniversity = round(
                $this->haversineDistance(
                    $universityLat,
                    $universityLng,
                    (float) $boarding->latitude,
                    (float) $boarding->longitude
                ),
                2
            );
        }

        $ratingBreakdown = [
            'safety' => round((float) $boarding->reviews->avg('safety'), 1),
            'cleanliness' => round((float) $boarding->reviews->avg('cleanliness'), 1),
            'facilities' => round((float) $boarding->reviews->avg('facilities'), 1),
        ];

        $relatedBoardings = Boarding::query()
            ->approved()
            ->where('city', $boarding->city)
            ->where('id', '!=', $boarding->id)
            ->with(['images', 'reviews'])
            ->latest()
            ->limit(4)
            ->get();

        return view('ads.show', compact('boarding', 'distanceFromUniversity', 'ratingBreakdown', 'relatedBoardings'));
    }

    private function haversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadiusKm = 6371;

        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lngDelta / 2) ** 2;

        return 2 * $earthRadiusKm * asin(sqrt($a));
    }
}
