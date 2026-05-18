<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    /**
     * Campos que NUNCA se guardan en la bitácora.
     */
    protected array $auditExclude = [
        'password',
        'remember_token',
    ];

    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            static::writeLog('created', $model, [], $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes  = $model->getChanges();
            $original = array_intersect_key($model->getOriginal(), $changes);

            if (empty($changes)) {
                return;
            }

            static::writeLog('updated', $model, $original, $changes);
        });

        static::deleted(function ($model) {
            static::writeLog('deleted', $model, $model->getAttributes(), []);
        });
    }

    private static function writeLog(
        string $action,
        $model,
        array $old,
        array $new
    ): void {
        $exclude = (new static())->auditExclude;

        $cleanOld = static::sanitize($old, $exclude);
        $cleanNew = static::sanitize($new, $exclude);

        $user = Auth::user();

        AuditLog::create([
            'user_id'    => $user ? (string) $user->id : null,
            'user_name'  => $user?->name ?? 'system',
            'action'     => $action,
            'model'      => class_basename($model),
            'model_id'   => (string) $model->id,
            'old_values' => $cleanOld,
            'new_values' => $cleanNew,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'logged_at'  => now(),
        ]);
    }

    private static function sanitize(array $data, array $exclude): array
    {
        return array_diff_key($data, array_flip($exclude));
    }
}