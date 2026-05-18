<?php

declare(strict_types=1);

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => ['sometimes', 'string', 'max:100'],
            'permissions'   => ['sometimes', 'array'],
            'permissions.*' => ['string', 'in:products,users,profiles'],
        ];
    }
}