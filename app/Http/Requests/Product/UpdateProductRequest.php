<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['sometimes', 'string', 'max:150'],
            'brand' => ['sometimes', 'string', 'max:100'],
            'price' => ['sometimes', 'numeric', 'min:0', 'max:999'],
        ];
    }
}