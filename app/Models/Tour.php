<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToTenant;
use Spatie\Translatable\HasTranslations;

class Tour extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant, HasTranslations;

    protected $fillable = [
        'website_id',
        'parent_tour_id',
        'name',
        'description',
        'base_price',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    public function availabilities(): HasMany
    {
        return $this->hasMany(TourAvailability::class);
    }

    public function parentTour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'parent_tour_id');
    }

    public function overrides(): HasMany
    {
        return $this->hasMany(Tour::class, 'parent_tour_id');
    }
}
