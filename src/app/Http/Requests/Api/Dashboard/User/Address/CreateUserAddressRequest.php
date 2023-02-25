<?php

namespace App\Http\Requests\Api\Dashboard\User\Address;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserAddressRequest extends FormRequest
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
    public function rules()
    {
        return [
            'address' => ['required', 'filled', 'string'],
            'state' => ['required', 'filled', 'string'],
            'city' => ['required', 'filled', 'string'],
            'building_number' => ['required', 'filled', 'numeric'],
            'unit_number' => ['filled', 'numeric'],
            'zip_code' => ['required', 'filled', 'string'],
            'receiver_first_name' => ['required', 'filled', 'string'],
            'receiver_last_name' => ['required', 'filled', 'string'],
            'receiver_phone' => ['required', 'filled', 'string'],
        ];
    }
}
