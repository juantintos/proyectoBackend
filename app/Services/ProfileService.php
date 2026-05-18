<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Profile;
use Illuminate\Pagination\LengthAwarePaginator;

class ProfileService
{
    public function __construct(
        private readonly CodeGeneratorService $codeGenerator,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = Profile::query();

        if (! empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%");
        }

        $perPage = min((int) ($filters['per_page'] ?? 15), 100);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function create(array $data): Profile
    {
        $data['code'] = $this->codeGenerator->generate('PRF');

        return Profile::create($data);
    }

    public function update(Profile $profile, array $data): Profile
    {
        $profile->update($data);

        return $profile->fresh();
    }

    public function delete(Profile $profile): void
    {
        // No eliminar si tiene usuarios activos
        if ($profile->users()->whereNull('deleted_at')->exists()) {
            throw new \DomainException(
                'No se puede eliminar un perfil con usuarios activos.'
            );
        }

        $profile->delete();
    }
}