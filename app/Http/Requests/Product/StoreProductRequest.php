<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:150'],
            'brand' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:999'],
        ];
    }
}