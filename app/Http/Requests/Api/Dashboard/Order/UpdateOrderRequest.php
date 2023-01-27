<?php

namespace App\Http\Requests\Api\Dashboard\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'products.*' => ['filled', 'numeric', 'distinct', 'exists:products,id'],
            'status'     => ['filled', 'string', 'in:pending,processing,completed,cancelled'],
            'user_id'    => ['filled', 'numeric', 'exists:users,id'],
        ];
    }
}
