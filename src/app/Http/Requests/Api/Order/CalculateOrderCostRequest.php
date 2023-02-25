<?php

namespace App\Http\Requests\Api\Order;

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
            'address_id'         => ['required', 'filled', 'numeric', 'exists:addresses,id'],
            'shipping_method_id' => ['required', 'filled', 'numeric', 'exists:shipping_methods,id'],
        ];
    }
}
