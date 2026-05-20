<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use MongoDB\Laravel\Auth\User as Authenticatable;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes, Auditable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'code',
        'name',
        'email',
        'password',
        'phone',
        'phone_code',
        'avatar',
        'profile_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'profile_id'  => $this->profile_id,
            'permissions' => $this->profile?->permissions ?? [],
        ];
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}