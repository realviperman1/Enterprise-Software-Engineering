<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SharedContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'shared_contents';

    protected $fillable = [
        'type',
        'body',
    ];

    public function websites(): BelongsToMany
    {
        return $this->belongsToMany(Website::class, 'website_content')
            ->withTimestamps();
    }
}

