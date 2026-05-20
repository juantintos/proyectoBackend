<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        private readonly CodeGeneratorService $codeGenerator,
    ) {}

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = Product::query();

        // Búsqueda por nombre o código
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Filtro por precio
        if (! empty($filters['price_min'])) {
            $query->where('price', '>=', (float) $filters['price_min']);
        }

        if (! empty($filters['price_max'])) {
            $query->where('price', '<=', (float) $filters['price_max']);
        }

        $perPage = min((int) ($filters['per_page'] ?? 15), 100);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function create(array $data): Product
    {
        $data['code'] = $this->codeGenerator->generate('PRD');

        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->fresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::orderBy('created_at', 'desc')->get();
    }
}