<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Auditable;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, Auditable;

    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'code',
        'name',
        'brand',
        'price',
    ];

    protected $casts = [
        'price'      => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}