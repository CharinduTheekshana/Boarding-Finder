<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boarding;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $districts = [
            ['name' => 'Ampara', 'image' => asset('images/districts/Ampara.jpg')],
            ['name' => 'Anuradhapura', 'image' => asset('images/districts/Anuradhapura.webp')],
            ['name' => 'Badulla', 'image' => asset('images/districts/Badulla.jpg')],
            ['name' => 'Batticaloa', 'image' => asset('images/districts/Batticaloa.webp')],
            ['name' => 'Colombo', 'image' => asset('images/districts/Colombo.jpg')],
            ['name' => 'Galle', 'image' => asset('images/districts/galle.jpg')],
            ['name' => 'Gampaha', 'image' => asset('images/districts/Gampaha.webp')],
            ['name' => 'Hambantota', 'image' => 'https://images.unsplash.com/photo-1426604966848-d7adac402bff?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Jaffna', 'image' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Kalutara', 'image' => asset('images/districts/Kaluthara.jpg')],
            ['name' => 'Kandy', 'image' => asset('images/districts/kandy.JPG')],
            ['name' => 'Kegalle', 'image' => asset('images/districts/Kegalle.jpg')],
            ['name' => 'Kilinochchi', 'image' => 'https://images.unsplash.com/photo-1465146633011-14f8e0781093?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Kurunegala', 'image' => asset('images/districts/Kurunagala.jpg')],
            ['name' => 'Mannar', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Matale', 'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Matara', 'image' => asset('images/districts/Matara.jpg')],
            ['name' => 'Monaragala', 'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Mullaitivu', 'image' => 'https://images.unsplash.com/photo-1542281286-9e0a16bb7366?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Nuwara Eliya', 'image' => asset('images/districts/Nuwaraeliya.jpg')],
            ['name' => 'Polonnaruwa', 'image' => asset('images/districts/Polonnaruwa.avif')],
            ['name' => 'Puttalam', 'image' => 'https://images.unsplash.com/photo-1426604966848-d7adac402bff?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Ratnapura', 'image' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Trincomalee', 'image' => asset('images/districts/Trincomalee.jpg')],
            ['name' => 'Vavuniya', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=600&q=80'],
        ];

        $popularCities = [
            ['name' => 'Kundasale', 'image' => 'https://images.unsplash.com/photo-1484318571209-661cf29a69c3?auto=format&fit=crop&w=600&q=80'],
            ['name' => 'Peradeniya', 'image' => asset('images/cities/peradeniya.webp')],
            ['name' => 'Kandy', 'image' => asset('images/cities/kandy.jpg')],
            ['name' => 'Gampola', 'image' => asset('images/cities/gampola.webp')],
            ['name' => 'Thannekubura', 'image' => 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=600&q=80'],
        ];

        $nearYouBoardings = collect();
        $latestBoardings = collect();

        if (Schema::hasTable('boardings')) {
            /** @var Collection<int, Boarding> $nearYouBoardings */
            $nearYouBoardings = Boarding::query()
                ->approved()
                ->with(['images', 'reviews'])
                ->orderBy('price')
                ->limit(10)
                ->get();

            /** @var Collection<int, Boarding> $latestBoardings */
            $latestBoardings = Boarding::query()
                ->approved()
                ->with(['images', 'reviews'])
                ->latest()
                ->limit(8)
                ->get();
        }

        return view('welcome', compact('districts', 'popularCities', 'nearYouBoardings', 'latestBoardings'));
    }

    public function citiesByDistrict(string $district): View
    {
        $cityImageOverrides = [
            'Peradeniya' => asset('images/cities/peradeniya.webp'),
            'Gampola' => asset('images/cities/gampola.webp'),
            'Thannekubura' => 'https://images.unsplash.com/photo-1433086966358-54859d0ed716?auto=format&fit=crop&w=600&q=80',
        ];

        $cities = collect();

        if (Schema::hasTable('boardings')) {
            $cities = Boarding::query()
                ->where('district', $district)
                ->approved()
                ->whereNotNull('city')
                ->where('city', '!=', '')
                ->select('city')
                ->distinct()
                ->orderBy('city')
                ->pluck('city')
                ->map(fn (string $city) => [
                    'name' => $city,
                    'image' => $cityImageOverrides[$city]
                        ?? 'https://images.unsplash.com/photo-1484318571209-661cf29a69c3?auto=format&fit=crop&w=600&q=80',
                ])
                ->values();

            if ($district === 'Kandy') {
                $kandyFallbackCities = ['Gampola', 'Thannekubura'];

                foreach ($kandyFallbackCities as $fallbackCity) {
                    if (!$cities->contains(fn (array $city) => $city['name'] === $fallbackCity)) {
                        $cities->push([
                            'name' => $fallbackCity,
                            'image' => $cityImageOverrides[$fallbackCity]
                                ?? 'https://images.unsplash.com/photo-1484318571209-661cf29a69c3?auto=format&fit=crop&w=600&q=80',
                        ]);
                    }
                }
            }
        }

        return view('cities-by-district', compact('district', 'cities'));
    }
}
