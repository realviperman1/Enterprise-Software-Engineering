<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
use App\Models\Tour;

class Website extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'domain',
        'name',
        'description',
        'seo_title',
        'slug',
        'default_locale',
        'branding_details',
        'status',
    ];

    /**
     * The attributes that are translatable.
     */
    public array $translatable = [
        'name',
        'description',
        'seo_title',
        'slug',
    ];

    protected $casts = [
        'branding_details' => 'array',
    ];

    public function sharedContents(): BelongsToMany
    {
        return $this->belongsToMany(SharedContent::class, 'website_content')
            ->withTimestamps();
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the tours associated with the website.
     */
    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}

