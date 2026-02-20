<?php

use App\Http\Controllers\Admin\BoardingModerationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReviewModerationController;
use App\Http\Controllers\BoardingController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Owner\BoardingController as OwnerBoardingController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Models\Boarding;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/districts/{district}/cities', [HomeController::class, 'citiesByDistrict'])->name('districts.cities');
Route::get('/ads', [BoardingController::class, 'index'])->name('ads.index');
Route::get('/ads/{boarding}', [BoardingController::class, 'show'])->name('ads.show');

Route::get('/dashboard', function () {
    /** @var User|null $user */
    $user = Auth::user();

    if ($user?->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->hasRole('owner')) {
        return redirect()->route('owner.dashboard');
    }

    $latestBoardings = Boarding::query()
        ->approved()
        ->with(['images', 'reviews'])
        ->latest()
        ->take(4)
        ->get();

    $recentFavourites = $user
        ->favouriteBoardings()
        ->with(['images', 'reviews'])
        ->latest('favourites.created_at')
        ->take(6)
        ->get();

    $recentReviews = $user
        ->reviews()
        ->with(['boarding.images', 'boarding.reviews'])
        ->latest()
        ->take(4)
        ->get();

    $newAdsCount = Boarding::query()
        ->approved()
        ->where('created_at', '>=', now()->subDays(7))
        ->count();

    $avgRating = $user
        ->reviews()
        ->selectRaw('AVG((safety + cleanliness + facilities) / 3) as avg_rating')
        ->value('avg_rating');

    $stats = [
        'favourites' => $user->favouriteBoardings()->count(),
        'reviews' => $user->reviews()->count(),
        'new_ads' => $newAdsCount,
        'avg_rating' => round((float) ($avgRating ?? 0), 1),
    ];

    return view('dashboard', compact('stats', 'latestBoardings', 'recentFavourites', 'recentReviews'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/favourites', [FavouriteController::class, 'index'])->middleware('role:student')->name('favourites.index');
    Route::post('/ads/{boarding}/reviews', [ReviewController::class, 'store'])->middleware('role:student')->name('reviews.store');
    Route::post('/ads/{boarding}/favourite', [FavouriteController::class, 'store'])->middleware('role:student')->name('favourites.store');
    Route::delete('/ads/{boarding}/favourite', [FavouriteController::class, 'destroy'])->middleware('role:student')->name('favourites.destroy');
});

Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/boardings/{boarding}/pending', [OwnerBoardingController::class, 'pending'])->name('boardings.pending');
    Route::resource('boardings', OwnerBoardingController::class)->except(['show']);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/boardings', [BoardingModerationController::class, 'index'])->name('boardings.index');
    Route::patch('/boardings/{boarding}/approve', [BoardingModerationController::class, 'approve'])->name('boardings.approve');
    Route::patch('/boardings/{boarding}/reject', [BoardingModerationController::class, 'reject'])->name('boardings.reject');

    Route::get('/reviews', [ReviewModerationController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewModerationController::class, 'destroy'])->name('reviews.destroy');
});

require __DIR__.'/auth.php';
