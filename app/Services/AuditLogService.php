<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Pagination\LengthAwarePaginator;

class AuditLogService
{
    private const ALLOWED_MODELS = ['Product', 'User', 'Profile'];
    private const ALLOWED_ACTIONS = ['created', 'updated', 'deleted'];

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = AuditLog::query()->orderBy('logged_at', 'desc');

        // Filtro por modelo
        if (! empty($filters['model'])) {
            $model = ucfirst(strtolower($filters['model']));

            if (in_array($model, self::ALLOWED_MODELS, true)) {
                $query->byModel($model);
            }
        }

        // Filtro por acción
        if (! empty($filters['action'])) {
            $action = strtolower($filters['action']);

            if (in_array($action, self::ALLOWED_ACTIONS, true)) {
                $query->byAction($action);
            }
        }

        // Filtro por usuario
        if (! empty($filters['user_id'])) {
            $query->byUser($filters['user_id']);
        }

        // Filtro por rango de fechas
        if (! empty($filters['date_from']) && ! empty($filters['date_to'])) {
            try {
                $query->byDateRange($filters['date_from'], $filters['date_to']);
            } catch (\Exception) {
                // Fecha inválida: ignorar filtro
            }
        }

        // Filtro por model_id (historial de un registro específico)
        if (! empty($filters['model_id'])) {
            $query->where('model_id', $filters['model_id']);
        }

        $perPage = min((int) ($filters['per_page'] ?? 20), 100);

        return $query->paginate($perPage);
    }

    public function getHistory(string $model, string $modelId): \Illuminate\Database\Eloquent\Collection
    {
        $model = ucfirst(strtolower($model));

        if (! in_array($model, self::ALLOWED_MODELS, true)) {
            throw new \DomainException("Modelo no válido: {$model}");
        }

        return AuditLog::byModel($model)
            ->where('model_id', $modelId)
            ->orderBy('logged_at', 'desc')
            ->get();
    }

    public function getStats(): array
    {
        $pipeline = [
            [
                '$group' => [
                    '_id'   => ['model' => '$model', 'action' => '$action'],
                    'count' => ['$sum' => 1],
                ],
            ],
        ];

        $raw = AuditLog::raw(fn($col) => $col->aggregate($pipeline));

        $stats = [];
        foreach ($raw as $item) {
            $model  = $item['_id']['model'];
            $action = $item['_id']['action'];
            $stats[$model][$action] = $item['count'];
        }

        return $stats;
    }
}