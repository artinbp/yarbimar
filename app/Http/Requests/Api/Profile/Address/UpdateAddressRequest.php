<?php

namespace App\Http\Requests\Api\Profile\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'address' => ['filled', 'string'],
            'state' => ['filled', 'string'],
            'city' => ['filled', 'string'],
            'building_number' => ['filled', 'numeric'],
            'unit_number' => ['filled', 'numeric'],
            'zip_code' => ['filled', 'numeric'],
            'receiver_first_name' => ['filled', 'string'],
            'receiver_last_name' => ['filled', 'string'],
            'receiver_phone' => ['filled'],
        ];
    }
}
