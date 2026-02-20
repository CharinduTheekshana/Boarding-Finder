<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'boarding_id',
        'safety',
        'cleanliness',
        'facilities',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'safety' => 'integer',
            'cleanliness' => 'integer',
            'facilities' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function boarding(): BelongsTo
    {
        return $this->belongsTo(Boarding::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return round(($this->safety + $this->cleanliness + $this->facilities) / 3, 1);
    }
}
