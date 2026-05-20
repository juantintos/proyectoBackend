<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id'); // viene del segmento /{id}

        return [
            'name'       => ['sometimes', 'string', 'max:150'],
            'email'      => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($id, '_id'),
            ],
            'password'   => ['sometimes', 'string', 'min:8'],
            'phone'      => ['nullable', 'string', 'max:15'],
            'phone_code' => ['nullable', 'string', 'max:5'],
            'profile_id' => ['sometimes', 'string'],
            'avatar'     => ['sometimes', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'is_active'  => ['sometimes', 'boolean'],
        ];
    }
}