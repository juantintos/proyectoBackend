<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class CodeGeneratorService
{
    /**
     * Genera código único con prefijo + timestamp + random.
     * Ej: PRD-20250516-A3F2
     */
    public function generate(string $prefix): string
    {
        $date   = now()->format('Ymd');
        $random = strtoupper(Str::random(4));

        return "{$prefix}-{$date}-{$random}";
    }
}