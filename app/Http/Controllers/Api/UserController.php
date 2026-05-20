<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ExportService;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly UserService   $userService,
        private readonly ExportService $exportService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->paginate($request->all());

        return $this->success([
            'items'        => UserResource::collection($users->items()),
            'total'        => $users->total(),
            'per_page'     => $users->perPage(),
            'current_page' => $users->currentPage(),
            'last_page'    => $users->lastPage(),
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->create(
                $request->validated(),
                $request->file('avatar')
            );
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->created(new UserResource($user->load('profile')));
    }

    public function show(string $id): JsonResponse
    {
        $user = User::with('profile')->find($id);

        if (! $user) {
            return $this->notFound('Usuario no encontrado.');
        }

        return $this->success(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = User::find($id);

        if (! $user) {
            return $this->notFound('Usuario no encontrado.');
        }

        try {
            $updated = $this->userService->update(
                $user,
                $request->validated(),
                $request->file('avatar')
            );
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(new UserResource($updated), 'Usuario actualizado.');
    }

    public function destroy(string $id): JsonResponse
    {
        if ((string) auth()->id() === $id) {
            return $this->error('No puedes eliminar tu propio usuario.', 403);
        }

        $user = User::find($id);

        if (! $user) {
            return $this->notFound('Usuario no encontrado.');
        }

        $this->userService->delete($user);

        return $this->success(null, 'Usuario eliminado.');
    }

    public function exportPdf(): Response
    {
        return $this->exportService->usersPdf();
    }

    public function exportExcel(): Response
    {
        return $this->exportService->usersExcel();
    }
}