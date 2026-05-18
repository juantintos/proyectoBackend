<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:150'],
            'email'      => ['required', 'email', 'unique:mongodb.users,email'],
            'password'   => ['required', 'string', 'min:8'],
            'phone'      => ['nullable', 'string', 'max:15'],
            'phone_code' => ['nullable', 'string', 'max:5'],
            'profile_id' => ['required', 'string'],
            'avatar'     => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}