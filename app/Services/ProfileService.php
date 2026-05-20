<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
        $results = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $results->getCollection()->transform(function (Profile $profile) {
            $profile->users_count = $this->countUsers($profile->id);
            return $profile;
        });

        return $results;
    }

    public function getAll(): Collection
    {
        return Profile::orderBy('name')->get()->map(function (Profile $profile) {
            $profile->users_count = $this->countUsers($profile->id);
            return $profile;
        });
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
        $hasUsers = User::where('profile_id', $profile->id)
            ->whereNull('deleted_at')
            ->exists();

        if ($hasUsers) {
            throw new \DomainException(
                'No se puede eliminar un perfil con usuarios activos.'
            );
        }

        $profile->delete();
    }

    private function countUsers(string $profileId): int
    {
        return User::where('profile_id', $profileId)
            ->whereNull('deleted_at')
            ->count();
    }
}