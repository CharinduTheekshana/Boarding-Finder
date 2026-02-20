<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BoardingImage extends Model
{
    protected $fillable = [
        'boarding_id',
        'image_path',
        'sort_order',
    ];

    public function boarding(): BelongsTo
    {
        return $this->belongsTo(Boarding::class);
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->image_path);
    }
}
