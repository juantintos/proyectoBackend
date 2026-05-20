<?php

declare(strict_types=1);

namespace App\Services;

use App\Exports\ProductsExport;
use App\Exports\UsersExport;
use App\Exports\ProfilesExport;
use App\Models\Product;
use App\Models\Profile;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class ExportService
{
    // ── PDF ──────────────────────────────────────────────

    public function productsPdf(): Response
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('exports.products-pdf', compact('products'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('productos_' . now()->format('Ymd_His') . '.pdf');
    }

    public function usersPdf(): Response
    {
        $users = User::with('profile')->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('exports.users-pdf', compact('users'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('usuarios_' . now()->format('Ymd_His') . '.pdf');
    }

    public function profilesPdf(): Response
    {
        $profiles = Profile::withCount('users')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('exports.profiles-pdf', compact('profiles'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('perfiles_' . now()->format('Ymd_His') . '.pdf');
    }

    // ── Excel ────────────────────────────────────────────

    public function productsExcel(): BinaryFileResponse
    {
        $filename = 'productos_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new ProductsExport(), $filename);
    }

    public function usersExcel(): BinaryFileResponse
    {
        $filename = 'usuarios_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new UsersExport(), $filename);
    }

    public function profilesExcel(): BinaryFileResponse
    {
        $filename = 'perfiles_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new ProfilesExport(), $filename);
    }
}