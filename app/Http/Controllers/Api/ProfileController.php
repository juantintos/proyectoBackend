<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\StoreProfileRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Services\ExportService;
use App\Services\ProfileService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ProfileService $profileService,
        private readonly ExportService  $exportService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $profiles = $this->profileService->paginate($request->all());

        return $this->success([
            'items'        => ProfileResource::collection($profiles->items()),
            'total'        => $profiles->total(),
            'per_page'     => $profiles->perPage(),
            'current_page' => $profiles->currentPage(),
            'last_page'    => $profiles->lastPage(),
        ]);
    }

    public function store(StoreProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->create($request->validated());

        return $this->created(new ProfileResource($profile));
    }

    public function show(string $id): JsonResponse
    {
        $profile = Profile::with('users')->find($id);

        if (! $profile) {
            return $this->notFound('Perfil no encontrado.');
        }

        return $this->success(new ProfileResource($profile));
    }

    public function update(UpdateProfileRequest $request, string $id): JsonResponse
    {
        $profile = Profile::find($id);

        if (! $profile) {
            return $this->notFound('Perfil no encontrado.');
        }

        $updated = $this->profileService->update($profile, $request->validated());

        return $this->success(new ProfileResource($updated), 'Perfil actualizado.');
    }

    public function destroy(string $id): JsonResponse
    {
        $profile = Profile::find($id);

        if (! $profile) {
            return $this->notFound('Perfil no encontrado.');
        }

        try {
            $this->profileService->delete($profile);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 409);
        }

        return $this->success(null, 'Perfil eliminado.');
    }

    public function exportPdf(): Response
    {
        return $this->exportService->profilesPdf();
    }

    public function exportExcel(): Response
    {
        return $this->exportService->profilesExcel();
    }
}