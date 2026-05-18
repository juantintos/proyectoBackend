<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvatarService
{
    private const DISK      = 'public';
    private const DIRECTORY = 'avatars';

    public function store(UploadedFile $file): string
    {
        $filename  = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs(self::DIRECTORY, $filename, self::DISK);

        return self::DIRECTORY . '/' . $filename;
    }

    public function replace(UploadedFile $file, ?string $oldPath): string
    {
        $this->delete($oldPath);

        return $this->store($file);
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }
    }
}