<?php

namespace App\Http\Requests\Api\Dashboard\Shipping;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingRequest extends FormRequest
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
            'name' => ['filled', 'string'],
            'description' => ['filled', 'string'],
            'fee' => ['filled', 'numeric'],
            'disabled' => ['filled', 'boolean'],
        ];
    }
}
