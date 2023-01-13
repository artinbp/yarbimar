<?php

namespace App\Http\Requests\Api\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'categories.*' => ['required', 'numeric', 'distinct', 'exists:categories,id'],
            'price' => ['required', 'numeric'],
            'discount' => ['numeric', 'min:0', 'max:100'],
            'media.*' => ['filled', 'numeric', 'distinct', 'exists:media,id'],
            'thumbnail_path' => ['required', 'string', 'exists:media,path'],
            'stock' => ['required', 'numeric'],
        ];
    }
}
