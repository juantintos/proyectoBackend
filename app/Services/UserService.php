<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly CodeGeneratorService $codeGenerator,
        private readonly AvatarService $avatarService,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = User::with('profile');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        if (! empty($filters['profile_id'])) {
            $query->where('profile_id', $filters['profile_id']);
        }

        $perPage = min((int) ($filters['per_page'] ?? 15), 100);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function create(array $data, ?UploadedFile $avatar): User
    {
        $this->assertProfileExists($data['profile_id']);

        $data['code']     = $this->codeGenerator->generate('USR');
        $data['password'] = Hash::make($data['password']);
        $data['avatar']   = $this->avatarService->store($avatar);
        $data['is_active'] = true;

        return User::create($data);
    }

    public function update(User $user, array $data, ?UploadedFile $avatar): User
    {
        if (! empty($data['profile_id'])) {
            $this->assertProfileExists($data['profile_id']);
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($avatar) {
            $data['avatar'] = $this->avatarService->replace($avatar, $user->avatar);
        }

        $user->update($data);

        return $user->fresh(['profile']);
    }

    public function delete(User $user): void
    {
        $this->avatarService->delete($user->avatar);
        $user->delete();
    }

    private function assertProfileExists(string $profileId): void
    {
        if (! Profile::find($profileId)) {
            throw new \DomainException('El perfil especificado no existe.');
        }
    }
}