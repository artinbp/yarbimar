<?php

namespace App\Http\Requests\Api\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'title' => ['filled', 'string'],
            'description' => ['filled', 'string'],
            'categories.*' => ['filled', 'numeric', 'distinct', 'exists:categories,id'],
            'price' => ['filled', 'numeric'],
            'media.*' => ['filled', 'distinct', 'exists:media,id'],
            'thumbnail_path' => ['filled', 'string', 'exists:media,path'],
            'stock' => ['filled', 'numeric'],
        ];
    }
}
