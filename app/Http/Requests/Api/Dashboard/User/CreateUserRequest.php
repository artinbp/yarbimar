<?php

namespace App\Http\Requests\Api\Dashboard\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'filled', 'string', 'unique:users,username'],
            'first_name' => ['required', 'filled', 'string'],
            'last_name' => ['required', 'filled', 'string'],
            'email' => ['required', 'filled', 'email', 'unique:users,email'],
            'password' => ['required', 'filled', 'confirmed'],
            'role' => ['required', 'filled', 'distinct', 'exists:roles,id'],
            'addresses' => ['array'],
            'addresses.*.address' => ['required', 'filled', 'string'],
            'addresses.*.state' => ['required', 'filled', 'string'],
            'addresses.*.city' => ['required', 'filled', 'string'],
            'addresses.*.building_number' => ['required', 'filled', 'numeric'],
            'addresses.*.unit_number' => ['filled', 'numeric'],
            'addresses.*.zip_code' => ['required', 'filled', 'string'],
            'addresses.*.receiver_first_name' => ['required', 'filled', 'string'],
            'addresses.*.receiver_last_name' => ['required', 'filled', 'string'],
            'addresses.*.receiver_phone' => ['required', 'filled', 'string'],
        ];
    }
}
