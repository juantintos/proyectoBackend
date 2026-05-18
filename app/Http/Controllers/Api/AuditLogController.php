<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use App\Services\AuditLogService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuditLogService $auditLogService,
    ) {}

   
    public function index(Request $request): JsonResponse
    {
        $logs = $this->auditLogService->paginate($request->all());

        return $this->success([
            'items'        => AuditLogResource::collection($logs->items()),
            'total'        => $logs->total(),
            'per_page'     => $logs->perPage(),
            'current_page' => $logs->currentPage(),
            'last_page'    => $logs->lastPage(),
        ]);
    }

    public function history(string $model, string $modelId): JsonResponse
    {
        try {
            $logs = $this->auditLogService->getHistory($model, $modelId);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 400);
        }

        return $this->success(
            AuditLogResource::collection($logs)
        );
    }

    public function stats(): JsonResponse
    {
        $stats = $this->auditLogService->getStats();

        return $this->success($stats);
    }
}