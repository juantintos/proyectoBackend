<?php

declare(strict_types=1);

namespace App\Exports;

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

class UsersExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    public function collection()
    {
        return User::with('profile')->orderBy('created_at', 'desc')->get();
    }

    public function title(): string
    {
        return 'Usuarios';
    }

    public function headings(): array
    {
        return [
            '#',
            'Código',
            'Nombre',
            'Email',
            'Teléfono',
            'Perfil',
            'Estado',
            'Fecha de registro',
        ];
    }

    public function map($user): array
    {
        static $index = 0;
        $index++;

        $phone = trim(($user->phone_code ?? '') . ' ' . ($user->phone ?? '')) ?: '—';

        return [
            $index,
            $user->code,
            $user->name,
            $user->email,
            $phone,
            $user->profile?->name ?? 'Sin perfil',
            $user->is_active ? 'Activo' : 'Inactivo',
            $user->created_at?->format('d/m/Y H:i'),
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 22,
            'C' => 28,
            'D' => 30,
            'E' => 18,
            'F' => 18,
            'G' => 12,
            'H' => 20,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0F3460'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}