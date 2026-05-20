<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes, Auditable;

    protected $connection = 'mongodb';
    protected $collection = 'profiles';

    protected $fillable = [
        'code',
        'name',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    // Usuarios que tienen este perfil
    public function users()
    {
        return $this->hasMany(User::class, 'profile_id');
    }
}