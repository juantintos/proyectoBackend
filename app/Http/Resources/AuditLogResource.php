<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => (string) $this->id,
            'user_id'    => $this->user_id,
            'user_name'  => $this->user_name,
            'action'     => $this->action,
            'action_label' => $this->resolveActionLabel($this->action),
            'model'      => $this->model,
            'model_id'   => $this->model_id,
            'old_values' => $this->old_values ?? [],
            'new_values' => $this->new_values ?? [],
            'changes'    => $this->resolveChanges(
                $this->old_values ?? [],
                $this->new_values ?? []
            ),
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'logged_at'  => $this->logged_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Genera un diff legible entre valores anteriores y nuevos.
     */
    private function resolveChanges(array $old, array $new): array
    {
        if (empty($old) || empty($new)) {
            return [];
        }

        $changes = [];

        foreach ($new as $field => $newValue) {
            $oldValue = $old[$field] ?? null;

            if ($oldValue !== $newValue) {
                $changes[$field] = [
                    'from' => $oldValue,
                    'to'   => $newValue,
                ];
            }
        }

        return $changes;
    }

    private function resolveActionLabel(string $action): string
    {
        return match ($action) {
            'created' => 'Creación',
            'updated' => 'Actualización',
            'deleted' => 'Eliminación',
            default   => $action,
        };
    }
}