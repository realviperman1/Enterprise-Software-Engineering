<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToTenant;
use Spatie\Translatable\HasTranslations;

class Reservation extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant, HasTranslations;

    protected $fillable = [
        'website_id',
        'reference_number',
        'customer_name',
        'customer_email',
        'total_amount',
        'status',
        'payment_status',
        'stripe_payment_intent_id',
        'check_in_date',
        'check_out_date',
        'special_requests',
    ];

    public array $translatable = [
        'special_requests',
    ];

    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}

