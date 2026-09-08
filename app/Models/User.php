<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use Notifiable, BelongsToTenant;

    protected $fillable = [
        'name',
        'email',
        'password',
        'website_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
