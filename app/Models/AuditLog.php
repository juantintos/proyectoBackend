<?php

declare(strict_types=1);

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AuditLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'audit_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_name',
        'action',       // created | updated | deleted
        'model',        // Product | User | Profile
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'logged_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'logged_at'  => 'datetime',
    ];

    // ── Scopes ───────────────────────────────────────────
    public function scopeByModel($query, string $model)
    {
        return $query->where('model', $model);
    }

    public function scopeByUser($query, string $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByDateRange($query, string $from, string $to)
    {
        return $query
            ->where('logged_at', '>=', new \DateTime($from . ' 00:00:00'))
            ->where('logged_at', '<=', new \DateTime($to . ' 23:59:59'));
    }
}