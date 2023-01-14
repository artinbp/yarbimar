<?php

namespace App\Http\Requests\Api\Dashboard\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeliveryRequest extends FormRequest
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
            'name' => ['required', 'filled', 'string'],
            'description' => ['required', 'filled', 'string'],
            'fee' => ['required', 'filled', 'numeric'],
            'boolean' => ['filled', 'boolean'],
        ];
    }
}
