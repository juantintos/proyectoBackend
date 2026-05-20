<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => (string) $this->id,
            'code'        => $this->code,
            'name'        => $this->name,
            'permissions' => $this->permissions ?? [],
            'users_count' => $this->whenLoaded('users', fn() => $this->users->count(), 0),
            'users'       => UserResource::collection($this->whenLoaded('users')),
            'created_at'  => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'  => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}