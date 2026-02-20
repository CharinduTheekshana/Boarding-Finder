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

        return view('welcome', compact('popularCities', 'nearYouBoardings', 'latestBoardings'));
    }
}
