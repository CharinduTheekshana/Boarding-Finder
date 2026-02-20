@php
    $listingFor = ['boys' => 'Boys', 'girls' => 'Girls', 'both' => 'Both', 'couple' => 'Couple', 'family' => 'Family'];
    $boardingTypes = [
        'annex' => 'Annex', 'apartment' => 'Apartment', 'bungalow' => 'Bungalow', 'business_space' => 'Business Space',
        'co_working_space' => 'Co-working Space', 'double_room' => 'Double Room', 'full_house' => 'Full House',
        'guest_house' => 'Guest House', 'home_stay' => 'Home Stay', 'hostel' => 'Hostel', 'house' => 'House',
        'shared_room' => 'Shared Room', 'single_room' => 'Single Room',
    ];
@endphp

<div class="grid gap-4 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="block text-sm mb-1">Title</label>
        <input type="text" name="title" value="{{ old('title', $boarding->title ?? '') }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300" required>{{ old('description', $boarding->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm mb-1">Listed For</label>
        <select name="listed_for" class="w-full rounded-lg border-gray-300" required>
            @foreach ($listingFor as $value => $label)
                <option value="{{ $value }}" @selected(old('listed_for', $boarding->listed_for ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm mb-1">Boarding Type</label>
        <select name="boarding_type" class="w-full rounded-lg border-gray-300" required>
            @foreach ($boardingTypes as $value => $label)
                <option value="{{ $value }}" @selected(old('boarding_type', $boarding->boarding_type ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm mb-1">Price (Rs)</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $boarding->price ?? '') }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Payment Duration</label>
        <select name="payment_duration" class="w-full rounded-lg border-gray-300" required>
            @foreach (['monthly' => 'Monthly', 'quarterly' => 'Quarterly', 'yearly' => 'Yearly'] as $value => $label)
                <option value="{{ $value }}" @selected(old('payment_duration', $boarding->payment_duration ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm mb-1">Owner Name</label>
        <input type="text" name="owner_name" value="{{ old('owner_name', $boarding->owner_name ?? auth()->user()->name) }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Phone Number</label>
        <input type="text" name="phone_number" value="{{ old('phone_number', $boarding->phone_number ?? '') }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Email</label>
        <input type="email" name="owner_email" value="{{ old('owner_email', $boarding->owner_email ?? auth()->user()->email) }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Property Status</label>
        <select name="property_status" class="w-full rounded-lg border-gray-300" required>
            <option value="available" @selected(old('property_status', $boarding->property_status ?? '') === 'available')>Available</option>
            <option value="not_available" @selected(old('property_status', $boarding->property_status ?? '') === 'not_available')>Not Available</option>
        </select>
    </div>

    <div>
        <label class="block text-sm mb-1">Furnishing Status</label>
        <select name="furnishing_status" class="w-full rounded-lg border-gray-300" required>
            <option value="furnished" @selected(old('furnishing_status', $boarding->furnishing_status ?? '') === 'furnished')>Furnished</option>
            <option value="not_furnished" @selected(old('furnishing_status', $boarding->furnishing_status ?? '') === 'not_furnished')>Not Furnished</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm mb-1">Address</label>
        <input type="text" name="address" value="{{ old('address', $boarding->address ?? '') }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm mb-1">City</label>
        <input type="text" name="city" value="{{ old('city', $boarding->city ?? '') }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm mb-1">District</label>
        <input type="text" name="district" value="{{ old('district', $boarding->district ?? '') }}" class="w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm mb-1">Bedrooms</label>
        <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', $boarding->bedrooms ?? 0) }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Beds</label>
        <input type="number" name="beds" min="0" value="{{ old('beds', $boarding->beds ?? 0) }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <div>
        <label class="block text-sm mb-1">Bathrooms</label>
        <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', $boarding->bathrooms ?? 0) }}" class="w-full rounded-lg border-gray-300" required>
    </div>

    <!-- <div>
        <label class="block text-sm mb-1">Latitude</label>
        <input type="number" step="0.0000001" name="latitude" value="{{ old('latitude', $boarding->latitude ?? '') }}" class="w-full rounded-lg border-gray-300">
    </div>

    <div>
        <label class="block text-sm mb-1">Longitude</label>
        <input type="number" step="0.0000001" name="longitude" value="{{ old('longitude', $boarding->longitude ?? '') }}" class="w-full rounded-lg border-gray-300">
    </div> -->

    <div class="md:col-span-2 grid grid-cols-3 gap-4">
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="kitchen" value="1" @checked(old('kitchen', $boarding->kitchen ?? false))> Kitchen</label>
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="wifi" value="1" @checked(old('wifi', $boarding->wifi ?? false))> WiFi</label>
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="parking" value="1" @checked(old('parking', $boarding->parking ?? false))> Parking</label>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm mb-1">Images (up to 5)</label>
        <input type="file" name="images[]" accept="image/*" multiple class="w-full rounded-lg border-gray-300">
    </div>
</div>
