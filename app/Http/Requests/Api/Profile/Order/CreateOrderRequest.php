<?php

namespace App\Http\Requests\Api\Profile\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'products.*' => ['required', 'filled', 'array'],
            'products.*.id' => ['required', 'filled', 'numeric', 'distinct', 'exists:products,id'],
            'products.*.quantity' => ['required', 'filled', 'numeric'],
//            'address_id' => ['required', 'filled', 'numeric', 'exists:addresses,id'],
//            'delivery_id' => ['required', 'filled', 'numeric', 'exists:delivery_methods,id'],
        ];
    }
}
