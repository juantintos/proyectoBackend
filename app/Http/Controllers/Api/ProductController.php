<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ExportService;
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ProductService $productService,
        private readonly ExportService  $exportService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $products = $this->productService->paginate($request->all());

        return $this->success([
            'items'        => ProductResource::collection($products->items()),
            'total'        => $products->total(),
            'per_page'     => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
        ]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->productService->create($request->validated());

        return $this->created(new ProductResource($product));
    }

    public function show(string $id): JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return $this->notFound('Producto no encontrado.');
        }

        return $this->success(new ProductResource($product));
    }

    public function update(UpdateProductRequest $request, string $id): JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return $this->notFound('Producto no encontrado.');
        }

        $updated = $this->productService->update($product, $request->validated());

        return $this->success(new ProductResource($updated), 'Producto actualizado.');
    }

    public function destroy(string $id): JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return $this->notFound('Producto no encontrado.');
        }

        $this->productService->delete($product);

        return $this->success(null, 'Producto eliminado.');
    }

    public function exportPdf(): Response
    {
        return $this->exportService->productsPdf();
    }

    public function exportExcel(): Response
    {
        return $this->exportService->productsExcel();
    }
}