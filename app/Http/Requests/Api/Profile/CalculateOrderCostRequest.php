<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class CalculateOrderCostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'products' => ['array'],
            'products.*' => ['required', 'filled', 'distinct', function($attribute, $value, $fail) {
                if (!is_numeric($value)) {
                    $fail('The product id should be numeric.');
                }
            }],
            'products.*.quantity' => ['required', 'filled', 'numeric'],
            'products.*.price'    => ['required', 'filled', 'numeric'],
            'address_id' => ['required', 'filled', 'numeric', 'exists:addresses,id'],
            'shipping_method_id' => ['required', 'filled', 'numeric', 'exists:shipping_methods,id'],
        ];
    }
}
