<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Profile;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfilesExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    public function collection()
    {
        return Profile::orderBy('created_at', 'desc')->get()->map(function (Profile $profile) {
            $profile->users_count = User::where('profile_id', $profile->id)
                ->whereNull('deleted_at')
                ->count();
            return $profile;
        });
    }

    public function title(): string
    {
        return 'Perfiles';
    }

    public function headings(): array
    {
        return ['#', 'Código', 'Nombre', 'Permisos', 'Usuarios asignados', 'Fecha de creación'];
    }

    public function map($profile): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $profile->code,
            $profile->name,
            implode(', ', $profile->permissions ?? []) ?: '—',
            $profile->users_count ?? 0,
            $profile->created_at?->format('d/m/Y H:i'),
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 6, 'B' => 22, 'C' => 25, 'D' => 30, 'E' => 20, 'F' => 20];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1B5E20']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}