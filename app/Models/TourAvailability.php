<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourAvailability extends Model
{
    protected $fillable = [
        'tour_id',
        'date',
        'available_spots',
    ];

    protected $casts = [
        'date' => 'date',
        'available_spots' => 'integer',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}

