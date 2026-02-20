<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Boarding extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'listed_for',
        'boarding_type',
        'price',
        'payment_duration',
        'owner_name',
        'phone_number',
        'owner_email',
        'property_status',
        'furnishing_status',
        'address',
        'city',
        'district',
        'bedrooms',
        'beds',
        'bathrooms',
        'kitchen',
        'wifi',
        'parking',
        'approved_status',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'kitchen' => 'boolean',
            'wifi' => 'boolean',
            'parking' => 'boolean',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(BoardingImage::class)->orderBy('sort_order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favouritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favourites')->withTimestamps();
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('approved_status', 'approved');
    }

    public function getAverageRatingAttribute(): float
    {
        if (! $this->relationLoaded('reviews')) {
            $this->load('reviews');
        }

        if ($this->reviews->isEmpty()) {
            return 0.0;
        }

        return round($this->reviews->avg(fn (Review $review) => $review->average_rating), 1);
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        if (! $this->relationLoaded('images')) {
            $this->load('images');
        }

        return $this->images->first()?->image_url;
    }
}
