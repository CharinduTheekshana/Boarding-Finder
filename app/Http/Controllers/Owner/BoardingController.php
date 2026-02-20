<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Boarding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BoardingController extends Controller
{
    public function index(): View
    {
        /** @var User|null $owner */
        $owner = Auth::user();
        abort_unless($owner, 403);

        $boardings = $owner->boardings()->with(['images', 'reviews'])->latest()->paginate(12);

        return view('owner.boardings.index', compact('boardings'));
    }

    public function create(): View
    {
        return view('owner.boardings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBoarding($request);
        /** @var User|null $owner */
        $owner = Auth::user();
        abort_unless($owner, 403);

        $boarding = $owner->boardings()->create([
            ...$validated,
            'approved_status' => 'pending',
        ]);

        $this->storeImages($request, $boarding);

        return redirect()->route('owner.boardings.index')
            ->with('status', 'Listing created and sent for admin approval.');
    }

    public function edit(Boarding $boarding): View
    {
        $this->authorizeBoarding($boarding);

        $boarding->load('images');

        return view('owner.boardings.edit', compact('boarding'));
    }

    public function update(Request $request, Boarding $boarding): RedirectResponse
    {
        $this->authorizeBoarding($boarding);

        $validated = $this->validateBoarding($request);

        $boarding->update([
            ...$validated,
            'approved_status' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            foreach ($boarding->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $boarding->images()->delete();
            $this->storeImages($request, $boarding);
        }

        return redirect()->route('owner.boardings.index')
            ->with('status', 'Listing updated and re-submitted for approval.');
    }

    public function pending(Boarding $boarding): View
    {
        $this->authorizeBoarding($boarding);

        return view('owner.boardings.pending', compact('boarding'));
    }

    public function destroy(Boarding $boarding): RedirectResponse
    {
        $this->authorizeBoarding($boarding);

        foreach ($boarding->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $boarding->delete();

        return redirect()->route('owner.boardings.index')->with('status', 'Listing deleted.');
    }

    private function authorizeBoarding(Boarding $boarding): void
    {
        abort_if($boarding->user_id !== Auth::id(), 403);
    }

    private function storeImages(Request $request, Boarding $boarding): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('boardings', 'public');
            $boarding->images()->create([
                'image_path' => $path,
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function validateBoarding(Request $request): array
    {
        $request->merge([
            'bedrooms' => is_numeric($request->input('bedrooms')) ? (int) $request->input('bedrooms') : $request->input('bedrooms'),
            'beds' => is_numeric($request->input('beds')) ? (int) $request->input('beds') : $request->input('beds'),
            'bathrooms' => is_numeric($request->input('bathrooms')) ? (int) $request->input('bathrooms') : $request->input('bathrooms'),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'listed_for' => ['required', 'in:boys,girls,both,couple,family'],
            'boarding_type' => ['required', 'in:annex,apartment,bungalow,business_space,co_working_space,double_room,full_house,guest_house,home_stay,hostel,house,shared_room,single_room'],
            'price' => ['required', 'numeric', 'min:0'],
            'payment_duration' => ['required', 'in:monthly,quarterly,yearly'],
            'owner_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:30'],
            'owner_email' => ['required', 'email', 'max:255'],
            'property_status' => ['required', 'in:available,not_available'],
            'furnishing_status' => ['required', 'in:furnished,not_furnished'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:120'],
            'district' => ['nullable', 'string', 'max:120'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:50'],
            'beds' => ['nullable', 'integer', 'min:0', 'max:50'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:50'],
            'kitchen' => ['nullable', 'boolean'],
            'wifi' => ['nullable', 'boolean'],
            'parking' => ['nullable', 'boolean'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $validated['kitchen'] = $request->boolean('kitchen');
        $validated['wifi'] = $request->boolean('wifi');
        $validated['parking'] = $request->boolean('parking');
        $validated['bedrooms'] = (int) ($validated['bedrooms'] ?? 0);
        $validated['beds'] = (int) ($validated['beds'] ?? 0);
        $validated['bathrooms'] = (int) ($validated['bathrooms'] ?? 0);

        return $validated;
    }
}
